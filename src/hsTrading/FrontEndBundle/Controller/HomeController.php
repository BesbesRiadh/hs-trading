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
     * @Route("/home", name="home")
     *
     */
    public function indexAction(Request $poRequest) {

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
        return $this->render('hsTradingFrontEndBundle:Home:products.html.twig', array('code' => $code));
    }

    /**
     * @Route("/contact", name="contact")
     * @Template("hsTradingFrontEndBundle:Contact:index.html.twig")
     */
    public function contactAction(Request $poRequest) {
        $oSession = $poRequest->getSession();
        if ($oSession->get('_security_secured_area')) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return array('ContactMessages' => $this->getMessages('messages.contact'));
    }

    /**
     * @Route("/addContact", name="add_contact")
     * @Template("hsTradingFrontEndBundle:Contact:contactForm.html.twig")
     */
    public function addContactAction(Request $poRequest) {
        $json = '[
            {
                "countryName": "Andorra"
            },
            {
                "countryName": "United Arab Emirates"
            },
            {
                "countryName": "Afghanistan"
            },
            {
                "countryName": "Antigua and Barbuda"
            },
            {
                "countryName": "Anguilla"
            },
            {
                "countryName": "Albania"
            },
            {
                "countryName": "Armenia"
            },
            {
                "countryName": "Angola"
            },
            {
                "countryName": "Antarctica"
            },
            {
                "countryName": "Argentina"
            },
            {
                "countryName": "American Samoa"
            },
            {
                "countryName": "Austria"
            },
            {
                "countryName": "Australia"
            },
            {
                "countryName": "Aruba"
            },
            {
                "countryName": "Åland"
            },
            {
                "countryName": "Azerbaijan"
            },
            {
                "countryName": "Bosnia and Herzegovina"
            },
            {
                "countryName": "Barbados"
            },
            {
                "countryName": "Bangladesh"
            },
            {
                "countryName": "Belgium"
            },
            {
                "countryName": "Burkina Faso"
            },
            {
                "countryName": "Bulgaria"
            },
            {
                "countryName": "Bahrain"
            },
            {
                "countryName": "Burundi"
            },
            {
                "countryName": "Benin"
            },
            {
                "countryName": "Saint Barthélemy"
            },
            {
                "countryName": "Bermuda"
            },
            {
                "countryName": "Brunei"
            },
            {
                "countryName": "Bolivia"
            },
            {
                "countryName": "Bonaire"
            },
            {
                "countryName": "Brazil"
            },
            {
                "countryName": "Bahamas"
            },
            {
                "countryName": "Bhutan"
            },
            {
                "countryName": "Bouvet Island"
            },
            {
                "countryName": "Botswana"
            },
            {
                "countryName": "Belarus"
            },
            {
                "countryName": "Belize"
            },
            {
                "countryName": "Canada"
            },
            {
                "countryName": "Cocos [Keeling] Islands"
            },
            {
                "countryName": "Democratic Republic of the Congo"
            },
            {
                "countryName": "Central African Republic"
            },
            {
                "countryName": "Republic of the Congo"
            },
            {
                "countryName": "Switzerland"
            },
            {
                "countryName": "Ivory Coast"
            },
            {
                "countryName": "Cook Islands"
            },
            {
                "countryName": "Chile"
            },
            {
                "countryName": "Cameroon"
            },
            {
                "countryName": "China"
            },
            {
                "countryName": "Colombia"
            },
            {
                "countryName": "Costa Rica"
            },
            {
                "countryName": "Cuba"
            },
            {
                "countryName": "Cape Verde"
            },
            {
                "countryName": "Curacao"
            },
            {
                "countryName": "Christmas Island"
            },
            {
                "countryName": "Cyprus"
            },
            {
                "countryName": "Czechia"
            },
            {
                "countryName": "Germany"
            },
            {
                "countryName": "Djibouti"
            },
            {
                "countryName": "Denmark"
            },
            {
                "countryName": "Dominica"
            },
            {
                "countryName": "Dominican Republic"
            },
            {
                "countryName": "Algeria"
            },
            {
                "countryName": "Ecuador"
            },
            {
                "countryName": "Estonia"
            },
            {
                "countryName": "Egypt"
            },
            {
                "countryName": "Western Sahara"
            },
            {
                "countryName": "Eritrea"
            },
            {
                "countryName": "Spain"
            },
            {
                "countryName": "Ethiopia"
            },
            {
                "countryName": "Finland"
            },
            {
                "countryName": "Fiji"
            },
            {
                "countryName": "Falkland Islands"
            },
            {
                "countryName": "Micronesia"
            },
            {
                "countryName": "Faroe Islands"
            },
            {
                "countryName": "France"
            },
            {
                "countryName": "Gabon"
            },
            {
                "countryName": "United Kingdom"
            },
            {
                "countryName": "Grenada"
            },
            {
                "countryName": "Georgia"
            },
            {
                "countryName": "French Guiana"
            },
            {
                "countryName": "Guernsey"
            },
            {
                "countryName": "Ghana"
            },
            {
                "countryName": "Gibraltar"
            },
            {
                "countryName": "Greenland"
            },
            {
                "countryName": "Gambia"
            },
            {
                "countryName": "Guinea"
            },
            {
                "countryName": "Guadeloupe"
            },
            {
                "countryName": "Equatorial Guinea"
            },
            {
                "countryName": "Greece"
            },
            {
                "countryName": "South Georgia and the South Sandwich Islands"
            },
            {
                "countryName": "Guatemala"
            },
            {
                "countryName": "Guam"
            },
            {
                "countryName": "Guinea-Bissau"
            },
            {
                "countryName": "Guyana"
            },
            {
                "countryName": "Hong Kong"
            },
            {
                "countryName": "Heard Island and McDonald Islands"
            },
            {
                "countryName": "Honduras"
            },
            {
                "countryName": "Croatia"
            },
            {
                "countryName": "Haiti"
            },
            {
                "countryName": "Hungary"
            },
            {
                "countryName": "Indonesia"
            },
            {
                "countryName": "Ireland"
            },
            {
                "countryName": "Israel"
            },
            {
                "countryName": "Isle of Man"
            },
            {
                "countryName": "India"
            },
            {
                "countryName": "British Indian Ocean Territory"
            },
            {
                "countryName": "Iraq"
            },
            {
                "countryName": "Iran"
            },
            {
                "countryName": "Iceland"
            },
            {
                "countryName": "Italy"
            },
            {
                "countryName": "Jersey"
            },
            {
                "countryName": "Jamaica"
            },
            {
                "countryName": "Jordan"
            },
            {
                "countryName": "Japan"
            },
            {
                "countryName": "Kenya"
            },
            {
                "countryName": "Kyrgyzstan"
            },
            {
                "countryName": "Cambodia"
            },
            {
                "countryName": "Kiribati"
            },
            {
                "countryName": "Comoros"
            },
            {
                "countryName": "Saint Kitts and Nevis"
            },
            {
                "countryName": "North Korea"
            },
            {
                "countryName": "South Korea"
            },
            {
                "countryName": "Kuwait"
            },
            {
                "countryName": "Cayman Islands"
            },
            {
                "countryName": "Kazakhstan"
            },
            {
                "countryName": "Laos"
            },
            {
                "countryName": "Lebanon"
            },
            {
                "countryName": "Saint Lucia"
            },
            {
                "countryName": "Liechtenstein"
            },
            {
                "countryName": "Sri Lanka"
            },
            {
                "countryName": "Liberia"
            },
            {
                "countryName": "Lesotho"
            },
            {
                "countryName": "Lithuania"
            },
            {
                "countryName": "Luxembourg"
            },
            {
                "countryName": "Latvia"
            },
            {
                "countryName": "Libya"
            },
            {
                "countryName": "Morocco"
            },
            {
                "countryName": "Monaco"
            },
            {
                "countryName": "Moldova"
            },
            {
                "countryName": "Montenegro"
            },
            {
                "countryName": "Saint Martin"
            },
            {
                "countryName": "Madagascar"
            },
            {
                "countryName": "Marshall Islands"
            },
            {
                "countryName": "Macedonia"
            },
            {
                "countryName": "Mali"
            },
            {
                "countryName": "Myanmar [Burma]"
            },
            {
                "countryName": "Mongolia"
            },
            {
                "countryName": "Macao"
            },
            {
                "countryName": "Northern Mariana Islands"
            },
            {
                "countryName": "Martinique"
            },
            {
                "countryName": "Mauritania"
            },
            {
                "countryName": "Montserrat"
            },
            {
                "countryName": "Malta"
            },
            {
                "countryName": "Mauritius"
            },
            {
                "countryName": "Maldives"
            },
            {
                "countryName": "Malawi"
            },
            {
                "countryName": "Mexico"
            },
            {
                "countryName": "Malaysia"
            },
            {
                "countryName": "Mozambique"
            },
            {
                "countryName": "Namibia"
            },
            {
                "countryName": "New Caledonia"
            },
            {
                "countryName": "Niger"
            },
            {
                "countryName": "Norfolk Island"
            },
            {
                "countryName": "Nigeria"
            },
            {
                "countryName": "Nicaragua"
            },
            {
                "countryName": "Netherlands"
            },
            {
                "countryName": "Norway"
            },
            {
                "countryName": "Nepal"
            },
            {
                "countryName": "Nauru"
            },
            {
                "countryName": "Niue"
            },
            {
                "countryName": "New Zealand"
            },
            {
                "countryName": "Oman"
            },
            {
                "countryName": "Panama"
            },
            {
                "countryName": "Peru"
            },
            {
                "countryName": "French Polynesia"
            },
            {
                "countryName": "Papua New Guinea"
            },
            {
                "countryName": "Philippines"
            },
            {
                "countryName": "Pakistan"
            },
            {
                "countryName": "Poland"
            },
            {
                "countryName": "Saint Pierre and Miquelon"
            },
            {
                "countryName": "Pitcairn Islands"
            },
            {
                "countryName": "Puerto Rico"
            },
            {
                "countryName": "Palestine"
            },
            {
                "countryName": "Portugal"
            },
            {
                "countryName": "Palau"
            },
            {
                "countryName": "Paraguay"
            },
            {
                "countryName": "Qatar"
            },
            {
                "countryName": "Réunion"
            },
            {
                "countryName": "Romania"
            },
            {
                "countryName": "Serbia"
            },
            {
                "countryName": "Russia"
            },
            {
                "countryName": "Rwanda"
            },
            {
                "countryName": "Saudi Arabia"
            },
            {
                "countryName": "Solomon Islands"
            },
            {
                "countryName": "Seychelles"
            },
            {
                "countryName": "Sudan"
            },
            {
                "countryName": "Sweden"
            },
            {
                "countryName": "Singapore"
            },
            {
                "countryName": "Saint Helena"
            },
            {
                "countryName": "Slovenia"
            },
            {
                "countryName": "Svalbard and Jan Mayen"
            },
            {
                "countryName": "Slovakia"
            },
            {
                "countryName": "Sierra Leone"
            },
            {
                "countryName": "San Marino"
            },
            {
                "countryName": "Senegal"
            },
            {
                "countryName": "Somalia"
            },
            {
                "countryName": "Suriname"
            },
            {
                "countryName": "South Sudan"
            },
            {
                "countryName": "São Tomé and Príncipe"
            },
            {
                "countryName": "El Salvador"
            },
            {
                "countryName": "Sint Maarten"
            },
            {
                "countryName": "Syria"
            },
            {
                "countryName": "Swaziland"
            },
            {
                "countryName": "Turks and Caicos Islands"
            },
            {
                "countryName": "Chad"
            },
            {
                "countryName": "French Southern Territories"
            },
            {
                "countryName": "Togo"
            },
            {
                "countryName": "Thailand"
            },
            {
                "countryName": "Tajikistan"
            },
            {
                "countryName": "Tokelau"
            },
            {
                "countryName": "East Timor"
            },
            {
                "countryName": "Turkmenistan"
            },
            {
                "countryName": "Tunisia"
            },
            {
                "countryName": "Tonga"
            },
            {
                "countryName": "Turkey"
            },
            {
                "countryName": "Trinidad and Tobago"
            },
            {
                "countryName": "Tuvalu"
            },
            {
                "countryName": "Taiwan"
            },
            {
                "countryName": "Tanzania"
            },
            {
                "countryName": "Ukraine"
            },
            {
                "countryName": "Uganda"
            },
            {
                "countryName": "U.S. Minor Outlying Islands"
            },
            {
                "countryName": "United States"
            },
            {
                "countryName": "Uruguay"
            },
            {
                "countryName": "Uzbekistan"
            },
            {
                "countryName": "Vatican City"
            },
            {
                "countryName": "Saint Vincent and the Grenadines"
            },
            {
                "countryName": "Venezuela"
            },
            {
                "countryName": "British Virgin Islands"
            },
            {
                "countryName": "U.S. Virgin Islands"
            },
            {
                "countryName": "Vietnam"
            },
            {
                "countryName": "Vanuatu"
            },
            {
                "countryName": "Wallis and Futuna"
            },
            {
                "countryName": "Samoa"
            },
            {
                "countryName": "Kosovo"
            },
            {
                "countryName": "Yemen"
            },
            {
                "countryName": "Mayotte"
            },
            {
                "countryName": "South Africa"
            },
            {
                "countryName": "Zambia"
            },
            {
                "countryName": "Zimbabwe"
            }
        ]';
        $array = json_decode($json, true);
        foreach ($array as $key => $val) {
           $array[$key] = array($val);
        }
        \hsTrading\FrontEndBundle\Utils\EchTools::pr($newarray);
        $list = array(
            'countries' => $array,
        );
        $oResponse = new Response();
        $oForm = $this->createForm(new ContactForm($list));
        $oForm->handleRequest($poRequest);

        if ('POST' == $poRequest->getMethod()) {
            if (!$poRequest->isXmlHttpRequest()) {
                return $this->redirect($this->generateUrl('contact'));
            }

            if ($oForm->isValid()) {
                $aResp ['success'] = false;
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
