<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Utils\EchTools;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends BaseIhmController {

    /**
     * @Route("/admin_panel", name="admin_panel")
     * @Template("hsTradingFrontEndBundle:AdminPanel:index.html.twig")
     */
    public function indexAction()
    {
        $aData             = $this->getJtableParams('products');
        $aColumns          = json_decode($aData['JTableFields']);
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
    public function listProductsAction(Request $poRequest)
    {
        $paOptions  = $this->formatBootGridParams(array(), $poRequest->request->all());
        $aResponse = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ProductPeer', 'getPagniatedProducts');

        return $this->renderJsonResponse($aResponse);
    }



}
