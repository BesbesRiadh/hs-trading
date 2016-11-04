<?php

namespace hsTrading\FrontEndBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use hsTrading\FrontEndBundle\Controller\BaseIhmController;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Model\TestPeer;
use hsTrading\FrontEndBundle\Form\ContactForm;
use Symfony\Component\DependencyInjection\Container;

class HomeController extends BaseIhmController {

    /**
     * @Route("/", name="home")
     *
     */
    public function indexAction(Request $poRequest) {

        $poRequest->setDefaultLocale('fr');
        if (!$poRequest->getLocale() || !in_array($poRequest->getLocale(), array('fr', 'en'))) {
            $sLocal = $poRequest->cookies->get('_localeECH');
            if (empty($sLocal)) {
                $sLocal = $poRequest->getSession()->get('_locale', 'fr');
                $poRequest->cookies->set('_localeECH', $sLocal);
            }
            $poRequest->setDefaultLocale($sLocal);
            $poRequest->setLocale($sLocal);
            $this->get('session')->set('_locale', $sLocal);
        }
        return $this->render('hsTradingFrontEndBundle:Home:index.html.twig');
    }

    /**
     * @Route("/listProducts/{code}", name="list_products", defaults={"code"=null}, options={"expose"=true})
     *
     */
    public function listAction(Request $request, $code) {

        $aProducts = $this->get('dataService')
                ->getSimpleData(array('code' => $code), 'ProductPeer', 'getProductsByCode');
        $Cat = $this->get('dataService')
                ->getSimpleData(array('code' => $code), 'ProductCategoryDetailsPeer', 'getCategorydetailsByCode');
        return $this->render('hsTradingFrontEndBundle:Home:products.html.twig', array('products' => $aProducts, 'cat' => $Cat));
    }

    /**
     * @Route("/contact", name="contact")
     * @Template("hsTradingFrontEndBundle:Contact:index.html.twig")
     */
    public function contactAction(Request $poRequest) {
        return array('ContactMessages' => $this->getMessages('messages.contact'));
    }

    /**
     * @Route("/addContact", name="add_contact", options={"expose"=true})
     * @Template("hsTradingFrontEndBundle:Contact:contactForm.html.twig")
     */
    public function addContactAction(Request $poRequest) {

        $aResponse = $this->get('dataService')->getSimpleData(array(), 'CountriesPeer', 'getCountriesList');

        $list = array(
            'countries' => $aResponse,
        );
        $oResponse = new Response();
        $oForm = $this->createForm(new ContactForm($list));
        $oForm->handleRequest($poRequest);

        if ('POST' == $poRequest->getMethod()) {

            if ($oForm->isValid()) {
                $aResponse = array('status' => 'KO');

                try {

                    $oContact = new \hsTrading\FrontEndBundle\Model\Contact();
                    $oContact->fromArray($oForm->getData(), \BasePeer::TYPE_FIELDNAME);
                    $oContact->save();
                    $this->get('mailService')->sendMail($oContact);

                    $aResponse = array('status' => 'OK');
                } catch (\Exception $e) {
                    $aResponse['message'] = $e->getMessage();
                }
            } else {
                $oResponse = new Response('', 400);
            }
        }
        return $this->render('hsTradingFrontEndBundle:Contact:contactForm.html.twig', array(
                    'form' => $oForm->createView(),
                        ), $oResponse
        );
    }

    /**
     * @Route("/chgL/{locale}", name="changeLang", defaults={"locale"="fr"})
     * @Template()
     */
    public function chgLangAction($locale) {
        $sHomeURl = $this->generateUrl('home');
        if (!in_array($locale, array('fr', 'en'))) {
            return $this->redirect($sHomeURl);
        }
        $oRequest = $this->getRequest();
        $oRequest->cookies->set('_localeHS', $locale);
        $oRequest->getSession()->set('_locale', $locale);
        $this->get('session')->set('_locale', $locale);
        $oRequest->setDefaultLocale($locale);
        $oRequest->setLocale($locale);
        $referer = $oRequest->headers->get('referer');
//        \hsTrading\FrontEndBundle\Utils\EchTools::pr($referer);

        if (empty($referer)) {
            $referer = $sHomeURl;
        }
        return $this->redirect($referer);
    }

}
