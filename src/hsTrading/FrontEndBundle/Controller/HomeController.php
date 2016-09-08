<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use hsTrading\FrontEndBundle\Model\TestPeer;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     *
     */
    public function indexAction()
    {
//        $name = TestPeer::retreiveOne();
//        \hsTrading\FrontEndBundle\Utils\EchTools::pr($name);
        return $this->render('hsTradingFrontEndBundle:Home:index.html.twig',array ('name' => 'test'));
    }
}
