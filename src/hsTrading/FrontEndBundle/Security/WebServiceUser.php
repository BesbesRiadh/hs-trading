<?php

namespace hsTrading\FrontEndBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class WebServiceUser implements UserInterface
{

    private $aUserData;
    private $sSalt;
    private $aRoles;

    public function __construct($paUserData)
    {
        $this->aUserData = $paUserData['0'];
        $this->aUserData['roles'] = substr($this->aUserData['roles'], 2, -2);
        $this->aRoles = $this->aRoles = explode(' | ', $this->aUserData['roles']);;
    }

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getSecondName();
    }

    public function getRoles()
    {
        return $this->aRoles;
    }

    public function getPassword()
    {
        return $this->aUserData['password'];
    }


    public function getSalt()
    {
        return $this->sSalt;
    }


    public function getUsername()
    {
        return $this->aUserData['mail'];
    }

    public function getMail()
    {
        return $this->aUserData['mail'];
    }

    public function getFirstName()
    {
        return $this->aUserData['firstname'];
    }

    public function getSecondName()
    {
        return $this->aUserData['lastname'];
    }

    public function eraseCredentials()
    {
        
    }

    public function equals(UserInterface $poUser)
    {
        if (!$poUser instanceof WebServiceUser)
        {
            return false;
        }

        if ($this->getUsername() !== $poUser->getUsername())
        {
            return false;
        }
        if ($this->getPassword() !== $poUser->getPassword())
        {
            return false;
        }

        if ($this->getSalt() !== $poUser->getSalt())
        {
            return false;
        }

        return true;
    }

}
