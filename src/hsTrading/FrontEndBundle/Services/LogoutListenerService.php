<?php

namespace MY\StaticBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\Container;

class LogoutListenerService implements LogoutSuccessHandlerInterface
{

    private $security;
    private $oContainer;

    public function __construct(Container $oContainer, SecurityContext $security)
    {
        $this->security   = $security;
        $this->oContainer = $oContainer;
    }

    public function onLogoutSuccess(Request $request)
    {
        $user = $this->security->getToken()->getUser();

        //add code to handle $user here
        //...
        $request->getSession()->set('_locale', $request->getSession()->get('_locale'));
        $request->setDefaultLocale($request->getSession()->get('_locale'));
        $response = new RedirectResponse($this->oContainer->get('router')->generate('homepage'));

        return $response;
    }

}
