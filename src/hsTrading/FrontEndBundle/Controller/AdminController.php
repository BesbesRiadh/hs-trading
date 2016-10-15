<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Utils\EchTools;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hsTrading\FrontEndBundle\Form\AddProductForm;
use hsTrading\FrontEndBundle\Form\EditProductForm;

class AdminController extends BaseIhmController {

    /**
     * @Route("/admin_panel", name="admin_panel")
     * @Template("hsTradingFrontEndBundle:AdminPanel:index.html.twig")
     */
    public function indexAction() {
        $aData = $this->getJtableParams('products');
        $aData['Messages'] = $this->getMessages(array('messages.products', 'messages.bootgrid'));
        $aColumns = json_decode($aData['JTableFields']);
        EchTools::TransformToArray($aColumns);
        return array_merge($aData, array('aColumns' => $aColumns));
    }

    /**
     * @Route("/products", name="products", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function listProductsAction(Request $poRequest) {
        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $aResponse = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ProductPeer', 'getPagniatedProducts');

        return $this->renderJsonResponse($aResponse);
    }

    /**
     * @Route("/add_product", name="add_product", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function addProductAction(Request $poRequest) {
        $oResponse = new Response();

        $list = array(
            'cat' => $this->get('dataService')
                    ->getSimpleData(array(), 'ProductCategoryPeer', 'getCategoriesList'),
            'subcat' => $this->get('dataService')
                    ->getSimpleData(array(), 'ProductCategoryDetailsPeer', 'getSubCategoriesList'),
        );

        $oForm = $this->createForm(new AddProductForm($list));

        if ($poRequest->isMethod('POST')) {
            $oForm->handleRequest($poRequest);
            if ($oForm->isValid()) {

                $aResponse = array('status' => 'KO');

                try {
                    $aData = $oForm->getData();
                    $Category = $this->get('dataService')
                            ->getSimpleData(array('id' => $aData['id_category']), 'ProductCategoryPeer', 'getCategoryById');
                    $aData['code'] = $Category[0]['code'];
                    $aData['img'] = $poRequest->getSession()->get('image_base64');


                    $oProduct = new \hsTrading\FrontEndBundle\Model\Product();
                    $oProduct->fromArray($aData, \BasePeer::TYPE_FIELDNAME);

                    if ($oProduct->save()) {
                        $poRequest->getSession()->remove('image_base64');
                        $aResponse = array('status' => 'OK');
                    }
                } catch (\Exception $e) {
                    $aResponse['message'] = $e->getMessage();
                }

                if ('OK' == $aResponse['status']) {
                    $oResponse->setStatusCode(200);
                }
                if ('KO' == $aResponse['status']) {
                    $oResponse->setStatusCode(400);
                    $sMessage = $this->container->get('translator')->trans('error');
                    $oForm['id_category']->addError(new \Symfony\Component\Form\FormError($sMessage));
                }
            } else {
                $oResponse->setStatusCode(400);
            }
        }

        return $this->render('hsTradingFrontEndBundle:AdminPanel:addProduct.html.twig', array('form' => $oForm->createView()), $oResponse);
    }

    /**
     * @Route("/edit_product/{code}", name="edit_product", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function editProductsAction(Request $poRequest, $code) {

        $oResponse = new Response();

        $aProduct = $this->get('dataService')
                ->getSimpleData($code, 'ProductPeer', 'getProductsById');
        $list = array(
            'cat' => $this->get('dataService')
                    ->getSimpleData(array(), 'ProductCategoryPeer', 'getCategoriesList'),
            'subcat' => $this->get('dataService')
                    ->getSimpleData(array(), 'ProductCategoryDetailsPeer', 'getSubCategoriesList'),
        );
        $oForm = $this->createForm(new EditProductForm($aProduct['0'], $list));
        if ($poRequest->isMethod('POST')) {

            $oForm->handleRequest($poRequest);

            if ($oForm->isValid()) {
                $oProduct = $this->get('dataService')
                        ->getSimpleData($code, 'ProductPeer', 'getProductById');
                $aData = $oForm->getData();
                if (!isset($aData['img'])) {
                    $aData['img'] = $poRequest->getSession()->get('image_base64');
                }
                $oProduct->fromArray($aData, \BasePeer::TYPE_FIELDNAME);

                if ($oProduct->save()) {
                    $poRequest->getSession()->remove('image_base64');
                    $aResponse = array('status' => 'OK');
                } else {
                    $aResponse = array('status' => 'KO');
                }

                if ('OK' == $aResponse['status']) {
                    return $this->listProductsAction($poRequest);
                }
            } else {
                $oResponse->setStatusCode(400);
            }
        }

        return $this->render('hsTradingFrontEndBundle:AdminPanel:editProduct.html.twig', array('form' => $oForm->createView()), $oResponse);
    }

    /**
     * @Route("/delete_product/{code}", name="delete_product", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function deleteProductsAction(Request $poRequest, $code) {

        $oResponse = new Response();
        $aResponse = $this->get('dataService')
                ->getSimpleData($code, 'ProductPeer', 'deleteProductById');

        if ($aResponse === 1) {
            return $oResponse->setStatusCode(200);
        }

        return $oResponse->setStatusCode(400);
    }

    /**
     * Import les trad
     * @Route("/uploadImg", name="upload_img", options={"expose"=true})
     * @param Request $oRequest
     *
     * @author Walid Saadaoui
     */
    public function uploadImgAction(Request $oRequest) {
        try {

            $aFiles = $oRequest->files->all();
            $oFile = $aFiles['file'];
            $aAllowdExtention = $this->container->getParameter('file.img_extensions');

            $sExtension = $oFile->guessClientExtension();
            if (!$sExtension) {
                list($sFileName, $sExtension) = explode('.', $oFile->getClientOriginalName());
            }

            if (!in_array($sExtension, $aAllowdExtention)) {
                throw new \Exception("L'extension $sExtension n'est pas autorisée");
            }
            $data = $this->get('IEService')->importImg($oFile);
            $oRequest->getSession()->set('image_base64', $data);
        } catch (\Exception $e) {
            $sSuccess = 'Une erreur est survenue';
        }
        $sSuccess = 1;
        return new Response($sSuccess);
    }

}
