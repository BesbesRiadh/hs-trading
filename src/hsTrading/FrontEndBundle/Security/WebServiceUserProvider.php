<?php

namespace hsTrading\FrontEndBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\DependencyInjection\Container;
use hsTrading\FrontEndBundle\Security\WebServiceUser;
use hsTrading\FrontEndBundle\Utils\EchTools;
use \hsTrading\FrontEndBundle\Model\om\BaseUserPeer;

class WebServiceUserProvider implements UserProviderInterface {

    private $oContainer;

    /**
     *
     * @param \Symfony\Component\DependencyInjection\Container $oContainer
     */
    public function __construct(Container $oContainer) {
        $this->oContainer = $oContainer;
    }

    private function getUser($psUsername) {

        $aLoginData = array(
            'login' => $psUsername,
        );

        try {
            $sLogin = EchTools::getOption($aLoginData, 'login');

            if (!$sLogin) {
                throw new \Exception('Login obligatoire');
            }

            $oCriteria = new \Criteria();
            $oCriteria->setPrimaryTableName('hs_user');

            $oCriteria->add(BaseUserPeer::MAIL, $sLogin);
            $oCriteria->add(BaseUserPeer::ACTIVE, true);

            $oCriteria->addSelectColumn(BaseUserPeer::MAIL);
                    $oCriteria->addSelectColumn(BaseUserPeer::PASSWORD);
                    $oCriteria->addSelectColumn(BaseUserPeer::ROLES);
                    $oCriteria->addSelectColumn(BaseUserPeer::FIRSTNAME);
                    $oCriteria->addSelectColumn(BaseUserPeer::LASTNAME);

            $aUserData = BaseUserPeer::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
           
            if (count($aUserData)) {
                $aUserData = array('status' => 'OK', 'data' => $aUserData);
            }
            else
            {
                $aUserData= array('status' => 'KO');
            }

            
        } catch (\Exception $e) {
            EchTools::pr('exeption');
        }

        return $aUserData;
    }

    public function loadUserByUsername($psUsername) {
        $aUserData = $this->getUser($psUsername);

        if (!count($aUserData) || (isset($aUserData['status']) && 'KO' == $aUserData['status'])) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $psUsername));
        }
        return new WebServiceUser($aUserData['data']);
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof WebServiceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $this->oContainer->get('request')->request->set('login', array(
            'login' => $user->getUsername(),
            'password' => $user->getPassword(),
        ));

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'hsTrading\FrontEndBundle\Security\WebServiceUser';
    }

}
