<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/home/{name}", name="home")
     *
     */
    public function indexAction($name)
    {
        return $this->render('hsTradingFrontEndBundle:Home:index.html.twig',array ('name' => $name));
    }
}
