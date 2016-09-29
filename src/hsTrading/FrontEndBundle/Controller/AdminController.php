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
        $oForm = $this->createForm(new AddProductForm());

        if ($poRequest->isMethod('POST')) {
            $oForm->handleRequest($poRequest);
            if ($oForm->isValid()) {

                $aResponse = array('status' => 'KO');

                try {
                    $aData = $oForm->getData();
                    $aData['code'] = $aData['category'];

                    $oProduct = new \hsTrading\FrontEndBundle\Model\Product();
                    $oProduct->fromArray($aData, \BasePeer::TYPE_FIELDNAME);
                    $oProduct->save();
                    $aResponse = array('status' => 'OK');
                } catch (\Exception $e) {
                    $aResponse['message'] = $e->getMessage();
                    $this->get($this->sLogger)->error($e->getMessage());
                }

                if ('OK' == $aResponse['status']) {
                    $oResponse->setStatusCode(200);
                }
                if ('KO' == $aResponse['status']) {
                    $oResponse->setStatusCode(400);
                    $sMessage = $this->container->get('translator')->trans('error');
                    $oForm['category']->addError(new \Symfony\Component\Form\FormError($sMessage));
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
        $oForm = $this->createForm(new EditProductForm($aProduct['0']));

        if ($poRequest->isMethod('POST')) {

            $oForm->handleRequest($poRequest);

            if ($oForm->isValid()) {
                $oProduct = $this->get('dataService')
                        ->getSimpleData($code, 'ProductPeer', 'getProductById');

                $oProduct->fromArray($oForm->getData(), \BasePeer::TYPE_FIELDNAME);

                if ($oProduct->save()) {
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
                ->getSimpleData(10, 'ProductPeer', 'deleteProductById');

        if ($aResponse === 'true') {
            return $oResponse->setStatusCode(200);
        }

        return $oResponse->setStatusCode(400);
    }

}
