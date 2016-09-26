<?php

namespace hsTrading\FrontEndBundle\Controller;

use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use hsTrading\FrontEndBundle\Form\LoginForm;

class SecurityController extends BaseIhmController
{

    /**
     * @Route("/login", name="login")
     * @Template()
     *
     * Authentification du client
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(Request $pRequest)
    {
        $oSession = $pRequest->getSession();
        if ($oSession->get('_security_secured_area'))
        {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $oForm = $this->createForm(new LoginForm(), null, array(
            'action' => $this->generateUrl('login_check'))
        );
        if ($pRequest->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR))
        {
            $error = $pRequest->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $oSession->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $oSession->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return $this->render('hsTradingFrontEndBundle:Security:login.html.twig', array(
                    'last_username' => $oSession->get(SecurityContextInterface::LAST_USERNAME),
                    'error' => $error,
                    'form' => $oForm->createView(),
        ));
    }

    /**
     *
     * @Route("/logout", name="logout")
     * @Template()
     *
     *
     */
    public function logoutAction()
    {
        
    }

    /**
     *
     * @Route("/login_check", name="login_check")
     * @Template()
     *
     *
     */
    public function loginCheckAction()
    {
        
    }

}
