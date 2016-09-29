<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Utils\EchTools;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ContactController extends BaseIhmController {

    /**
     * @Route("/contacts_history", name="contacts_history")
     * @Template("hsTradingFrontEndBundle:ContactHistory:index.html.twig")
     */
    public function indexAction() {
        $aData = $this->getJtableParams('contacts');
        $aData['Messages'] = $this->getMessages(array('messages.bootgrid'));
        $aColumns = json_decode($aData['JTableFields']);
        EchTools::TransformToArray($aColumns);
        return array_merge($aData, array('aColumns' => $aColumns));
    }

    /**
     * @Route("/list_contacts_history", name="list_contacts_history", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function listContactsHistoryAction(Request $poRequest) {

        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $paOptions['history'] = TRUE;
        $aContacts = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ContactPeer', 'getPagniatedContacts');
        foreach ($aContacts['rows'] as $key => $value) {
            $aContacts['rows'][$key]['treated'] = $this->container->get('translator')->trans($aContacts['rows'][$key]['treated']);
        }
        return $this->renderJsonResponse($aContacts);
    }

    /**
     * @Route("/contacts", name="contacts")
     * @Template("hsTradingFrontEndBundle:GestionContact:index.html.twig")
     */
    public function contactsAction() {
        $aData = $this->getJtableParams('contacts');
        $aData['Messages'] = $this->getMessages(array('messages.bootgrid'));
        $aColumns = json_decode($aData['JTableFields']);
        EchTools::TransformToArray($aColumns);
        return array_merge($aData, array('aColumns' => $aColumns));
    }

    /**
     * @Route("/list_contacts", name="list_contacts", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function listContactsAction(Request $poRequest) {

        $paOptions = $this->formatBootGridParams(array(), $poRequest->request->all());
        $paOptions['history'] = False;
        $aContacts = $this->get('dataService')
                ->getPaginated2Data($paOptions, 'ContactPeer', 'getPagniatedContacts');
        foreach ($aContacts['rows'] as $key => $value) {
            $aContacts['rows'][$key]['treated'] = $this->container->get('translator')->trans($aContacts['rows'][$key]['treated']);
        }
        return $this->renderJsonResponse($aContacts);
    }

    /**
     * @Route("/edit_contact/{code}", name="edit_contact", options={"expose"=true})
     *
     * @param Request $poRequest Objet requête
     *
     * @return Response
     */
    public function editContactAction(Request $poRequest, $code) {
        $aResponse = array('status' => 'KO');
        $oResponse = new Response();
        
        $oContact = $this->get('dataService')
                ->getSimpleData($code, 'ContactPeer', 'getContactByCode');

        $oContact->setTreated(TRUE);

        if (!$oContact->isModified() || $oContact->save()) {
            $aResponse = array('status' => 'OK');
        }
        
        if ($aResponse['status'] === 'OK') {
            return $oResponse->setStatusCode(200);
        }

        return $oResponse->setStatusCode(400);
    }

}
