<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Model\TestPeer;
use hsTrading\FrontEndBundle\Form\ContactForm;

class HomeController extends BaseIhmController
{
    /**
     * @Route("/home", name="home")
     *
     */
    public function indexAction()
    {
        $name = TestPeer::retreiveOne();
        return $this->render('hsTradingFrontEndBundle:Home:index.html.twig',array ('name' => $name[0]['name']));
    }
    
    
    /**
     * @Route("/contact", name="contact")
     * @Template("hsTradingFrontEndBundle:Contact:index.html.twig")
     */
    public function contactAction(Request $poRequest)
    {
        $oSession = $poRequest->getSession();
        if ($oSession->get('_security_secured_area'))
        {
            return $this->redirect($this->generateUrl('homepage'));
        }
        
        return array('ContactMessages' => $this->getMessages('messages.contact'));
    }

    /**
     * @Route("/addContact", name="add_contact")
     * @Template("hsTradingFrontEndBundle:Contact:contactForm.html.twig")
     */
    public function addContactAction(Request $poRequest)
    {
        $oResponse     = new Response();
        $oForm         = $this->createForm(new ContactForm());
        $oForm->handleRequest($poRequest);
        
        if ('POST' == $poRequest->getMethod())
        {
            if (!$poRequest->isXmlHttpRequest())
            {
                return $this->redirect($this->generateUrl('contact'));
            }
            
            if ($oForm->isValid() )
            {
                $aResp ['success'] = false;
            }
            else
            {
                $oResponse = new Response('', 400);
            }
        }
        return $this->render('hsTradingFrontEndBundle:Contact:contactForm.html.twig', array(
                    'form' => $oForm->createView(),
                        ), $oResponse
        );
    }
}
