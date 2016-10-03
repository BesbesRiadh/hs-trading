<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Utils\EchTools;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hsTrading\FrontEndBundle\Form\EditCategoryForm;
use hsTrading\FrontEndBundle\Form\AddCategoryForm;
use hsTrading\FrontEndBundle\Form\AddSubCategoryForm;

class CategoriesController extends BaseIhmController {

    /**
     * @Route("/categories", name="categories")
     * @Template("hsTradingFrontEndBundle:Categories:index.html.twig")
     */
    public function indexAction() {
        $aData = $this->getJtableParams('categories');
        $aData['Messages'] = $this->getMessages(array('messages.bootgrid'));
        $aColumns = json_decode($aData['JTableFields']);
        EchTools::TransformToArray($aColumns);
        return array_merge($aData, array('aColumns' => $aColumns));
    }

    /**
     * @Route("/list_categories", name="list_categories", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function listCategoriesAction(Request $poRequest) {

        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $paOptions['paginated'] = TRUE;
        $aCategories = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ProductCategoryPeer', 'retrieveByFilters');
        return $this->renderJsonResponse($aCategories);
    }

    /**
     * @Route("/add_category", name="add_category", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function addCategoryAction(Request $poRequest) {
        $oResponse = new Response();
        $oForm = $this->createForm(new AddCategoryForm());

        if ($poRequest->isMethod('POST')) {
            $oForm->handleRequest($poRequest);
            if ($oForm->isValid()) {

                $aResponse = array('status' => 'KO');

                try {
                    $aData = $oForm->getData();

                    $oCategory = new \hsTrading\FrontEndBundle\Model\ProductCategory();
                    $oCategory->fromArray($aData, \BasePeer::TYPE_FIELDNAME);
                    $oCategory->save();
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
                    $oForm['code']->addError(new \Symfony\Component\Form\FormError($sMessage));
                }
            } else {
                $oResponse->setStatusCode(400);
            }
        }

        return $this->render('hsTradingFrontEndBundle:Categories:addCategory.html.twig', array('form' => $oForm->createView()), $oResponse);
    }

    /**
     * @Route("/edit_category/{code}", name="edit_category", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function editCategoryAction(Request $poRequest, $code) {

        $oResponse = new Response();

        $aCategory = $this->get('dataService')
                ->getSimpleData($code, 'ProductCategoryPeer', 'retrieveOne');

        $data = array('code' => $aCategory->getCode(), 'label' => $aCategory->getLabel());

        $oForm = $this->createForm(new EditCategoryForm($data));

        if ($poRequest->isMethod('POST')) {

            $oForm->handleRequest($poRequest);

            if ($oForm->isValid()) {
                $aCategory = $this->get('dataService')
                        ->getSimpleData($code, 'ProductCategoryPeer', 'retrieveOne');

                $aCategory->fromArray($oForm->getData(), \BasePeer::TYPE_FIELDNAME);

                if ($aCategory->save()) {
                    $aResponse = array('status' => 'OK');
                } else {
                    $aResponse = array('status' => 'KO');
                }

                if ('OK' == $aResponse['status']) {
                    return $this->listCategoriesAction($poRequest);
                }
            } else {
                $oResponse->setStatusCode(400);
            }
        }

        return $this->render('hsTradingFrontEndBundle:Categories:addCategory.html.twig', array('form' => $oForm->createView()), $oResponse);
    }

    /**
     * @Route("/delete_category/{code}", name="delete_category", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function deleteCategoryAction(Request $poRequest, $code) {

        $oResponse = new Response();

        $aResponse = $this->get('dataService')
                ->getSimpleData($code, 'ProductCategoryPeer', 'deleteCategoryByCode');

        if ($aResponse['status'] === 'OK') {
            return $oResponse->setStatusCode(200);
        }

        return $oResponse->setStatusCode(400);
    }

    /**
     * @Route("/sub_categories", name="sub_categories")
     * @Template("hsTradingFrontEndBundle:SubCategories:index.html.twig")
     */
    public function subCategorisAction() {
        $aData = $this->getJtableParams('sub_categories');
        $aData['Messages'] = $this->getMessages(array('messages.bootgrid'));
        $aColumns = json_decode($aData['JTableFields']);
        EchTools::TransformToArray($aColumns);
        return array_merge($aData, array('aColumns' => $aColumns));
    }

    /**
     * @Route("/list_sub_categories", name="list_sub_categories", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function listSubCategoriesAction(Request $poRequest) {

        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $paOptions['paginated'] = TRUE;

        $aCategories = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ProductCategoryDetailsPeer', 'retrieveByFilters');

        return $this->renderJsonResponse($aCategories);
    }

    /**
     * @Route("/add_sub_category", name="add_sub_category", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function addSubCategoryAction(Request $poRequest) {
        $oResponse = new Response();
        
        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $paOptions['paginated'] = false;
        $aCategories = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ProductCategoryPeer', 'retrieveByFilters');
        foreach ($aCategories['rows'] as $key => $value) {
           $aCategories['category'] =array($aCategories['rows'][$key]['code'] => $aCategories['rows'][$key]['code'] );
        }
        
        $oForm = $this->createForm(new AddSubCategoryForm($aCategories));
        
        if ($poRequest->isMethod('POST')) {
            $oForm->handleRequest($poRequest);
            if ($oForm->isValid()) {

                $aResponse = array('status' => 'KO');

                try {
                    $aData = $oForm->getData();
                    $oSubCategory = new \hsTrading\FrontEndBundle\Model\ProductCategoryDetails();
                    $oSubCategory->fromArray($aData, \BasePeer::TYPE_FIELDNAME);
                    EchTools::pr($oSubCategory);
                    $oSubCategory->save();
                    $aResponse = array('status' => 'OK');
                    
                } catch (\Exception $e) {
                    $aResponse['message'] = $e->getMessage();
                }

                if ('OK' == $aResponse['status']) {
                    $oResponse->setStatusCode(200);
                }
                if ('KO' == $aResponse['status']) {
                    $oResponse->setStatusCode(400);
                    $sMessage = $this->container->get('translator')->trans('error');
                    $oForm['code']->addError(new \Symfony\Component\Form\FormError($sMessage));
                }
            } else {
                $oResponse->setStatusCode(400);
            }
        }

        return $this->render('hsTradingFrontEndBundle:SubCategories:addSubCategory.html.twig', array('form' => $oForm->createView()), $oResponse);
    }

}
