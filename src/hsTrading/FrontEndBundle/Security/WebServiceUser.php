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
        $this->aUserData = $paUserData;

        $this->aUserData['roles'] = substr($this->aUserData['roles'], 2, -2);

        $this->aRoles = explode(' | ', $this->aUserData['roles']);

        array_push($this->aRoles, 'ROLE_USER_' . strtoupper($this->getType()));
    }

    public function __toString()
    {
//        return $this->getUsername();
        return $this->getFirstName() . ' ' . $this->getSecondName();
    }

    public function getRoles()
    {
        return $this->aRoles;
    }

    public function setPassword($psPassword)
    {
        $this->aUserData['password'] = $psPassword;
    }

    public function getPassword()
    {
        return $this->aUserData['password'];
    }

    public function getCountAuthorizedOrder()
    {
        if (isset($this->aUserData['count_authorized_order']))
        {
            return $this->aUserData['count_authorized_order'];
        }
        return 4;
    }
    
    public function getCountAuthorizedProduct()
    {
        if (isset($this->aUserData['count_authorized_product']))
        {
            return $this->aUserData['count_authorized_product'];
        }
        return 4;
    }

    public function getSalt()
    {
        return $this->sSalt;
    }

    public function getType()
    {
        if (isset($this->aUserData['type']))
        {
            return $this->aUserData['type'];
        }

        return 'b2b';
    }

    public function getContactname()
    {
        if (isset($this->aUserData['contactname']))
        {
            return $this->aUserData['contactname'];
        }
        return null;
    }

    public function getCompanyname()
    {
        if (isset($this->aUserData['companyname']))
        {
            return $this->aUserData['companyname'];
        }
        return null;
    }

    public function getUsername()
    {
        return $this->aUserData['mail'];
    }

    public function getMail()
    {
        return $this->aUserData['mail'];
    }

    public function getClientMail()
    {
        return $this->aUserData['client_mail'];
    }

    public function getUserId()
    {
        return $this->aUserData['user_id'];
    }

    public function getFirstName()
    {
        return $this->aUserData['firstname'];
    }

    public function getSecondName()
    {
        return $this->aUserData['lastname'];
    }

    public function getClientId()
    {
        return $this->aUserData['client_id'];
    }

    public function getClientCode()
    {
        return $this->aUserData['client_code'];
    }

    public function getUserCode()
    {
        return $this->aUserData['user_code'];
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
