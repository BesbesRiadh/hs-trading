<?php

namespace hsTrading\FrontEndBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\DependencyInjection\Container;
use hsTrading\FrontEndBundle\Security\WebServiceUser;
use hsTrading\FrontEndBundle\Utils\EchTools;

class WebServiceUserProvider implements UserProviderInterface
{

    private $oContainer;

    /**
     *
     * @param \Symfony\Component\DependencyInjection\Container $oContainer
     */
    public function __construct(Container $oContainer)
    {
        $this->oContainer = $oContainer;
    }

    private function getUser($psUsername)
    {
        $aData = $this->oContainer->get('request')->request->get('login');

        $bRefresh = EchTools::getOption($aData, 'refresh', '0');
        $sType    = EchTools::getOption($aData, 'type', '1');
        $sType    = '0' == $sType ? 'b2c' : 'b2b';

        $sWsUrl = $this->oContainer->getParameter('ws_host') . '/' . $this->oContainer->getParameter('login');

        $aLoginData = array(
            'login' => $psUsername,
            'type' => $sType
        );

        if ($bRefresh == '0')
        {
            $aLoginData['ip'] = $this->oContainer->get('request')->getClientIp();
        }

        $oResponseWs = $this->oContainer->get('restClient')->post($sWsUrl, json_encode($aLoginData), 'application/json');

        return json_decode($oResponseWs->getResponse(), TRUE);
    }

    public function loadUserByUsername($psUsername)
    {
        $aUserData = $this->getUser($psUsername);

        if (!count($aUserData) || (isset($aUserData['status']) && 'KO' == $aUserData['status']))
        {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $psUsername));
        }

        return new WebServiceUser($aUserData['data']);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebServiceUser)
        {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $this->oContainer->get('request')->request->set('login', array(
            'login' => $user->getUsername(),
            'password' => $user->getPassword(),
            'type' => 'b2c' == $user->getType() ? '0' : '1',
            'refresh' => '1'
        ));

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'MY\StaticBundle\Security\WebServiceUser';
    }

}
