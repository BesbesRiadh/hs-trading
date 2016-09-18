<?php

namespace hsTrading\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use hsTrading\FrontEndBundle\Utils\EchTools;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseIhmController extends Controller
{

    protected function checkLimitOrder($bOrder = true)
    {
        $nRecordCount = $this->requestWSJson($bOrder ? 'count_orders' : 'count_permanent_orders', array(
            'status' => array('WAITING', 'TREATED', 'NOT_PAID'),
            'ignored' => false
        ));

        if (!is_integer($nRecordCount))
        {
            $nRecordCount = 0;
        }

        $oUser = $this->get('security.context')->getToken()->getUser();
        if ($oUser->getCountAuthorizedOrder() <= $nRecordCount)
        {
            return false;
        }
        return true;
    }

    protected function checkRights($paData, $pbStrict = true, $pbDebug = false)
    {
        $aCheck = $this->requestWSJson('check_right', $paData, true, $pbDebug);

        $bReturn = true;
        if (!isset($aCheck['authorized']) || !$aCheck['authorized'])
        {
            $bReturn = false;
            if ($pbStrict)
            {
                throw new AccessDeniedException();
            }
        }
        return $bReturn;
    }

    protected function setJtableTitle(&$aJTableColumns)
    {
        foreach ($aJTableColumns as $sColumn => &$aRow)
        {
            $aRow['code'] = $sColumn;
            if (!array_key_exists('title', $aRow))
            {
                $aRow['title'] = $sColumn;
            }
            $aRow['title'] = $this->container->get('translator')->trans($aRow['title']);

            if (isset($aRow['fields_class']) && !empty($aRow['fields_class']))
            {
                $aRow['fields'] = $this->getJtableColumns($aRow['fields_class']);
//                $aRow['jTableOptions'] = $this->getJtableColumnOptions($aRow['fields_class']);
                $this->setJtableTitle($aRow['fields']);
            }
        }
    }

    protected function getJtableColumns($psKey, $pbStrict = true)
    {
        $aConfig = $this->container->getParameter('JTable.columns');
        if (!isset($aConfig[$psKey]))
        {
            if ($pbStrict)
            {
                throw new \Exception("Type $psKey inconnu");
            }
            return array();
        }
        return $aConfig[$psKey]['fields'];
    }

    protected function getJtableParams($psKey)
    {
        $aJTableColumns = $this->getJtableColumns($psKey);

        $this->setJtableTitle($aJTableColumns);

        foreach ($aJTableColumns as $sColumn => &$aRow)
        {
            if (!array_key_exists('title', $aRow))
            {
                $aRow['title'] = $this->container->get('translator')->trans($sColumn);
            }
        }

        return array(
            'maxPerPage' => $this->container->getParameter('max_per_page'),
            'JTableFields' => json_encode($aJTableColumns),
//            'type' => $this->container->getParameter('type'),
//            'colors' => json_encode($this->container->getParameter('colors'))
        );
    }

    protected function formatRequestParams($paOptions)
    {
        $paOptions['max_per_page'] = $this->container->getParameter('wg_max_per_page');
        return $paOptions;
    }

    /**
     * recupérer et formater les paramètres (GET) BootGrid et les ajoutés dans le tableau $aOptions
     * @param type $aOptions tableau a mettre a jour
     * @param type $aParams tableau de parametre envoyé par BootGrid (GET)
     * @return void
     *
     * @author Walid Saadaoui
     */
    protected function formatBootGridParams($aOptions, $aParams)
    {
        if (!isset($aParams['current']))
        {
            $aParams['current'] = $this->container->getParameter('page');
        }
        if (!isset($aParams['rowCount']))
        {
            $aParams['rowCount'] = $this->container->getParameter('max_per_page');
        }
        $aOptions['max_per_page'] = $aParams['rowCount'];
        $aOptions['page']         = $aParams['current'];

        if (isset($aParams['sort']) && count($aParams['sort']))
        {
            reset($aParams['sort']);
            $aOptions['sort_column'] = key($aParams['sort']);
            $aOptions['sort_order']  = current($aParams['sort']);
        }
        return $aOptions;
    }

    /**
     * recupérer et formater les paramètres (GET) JTable et les ajoutés dans le tableau $aOptions
     * @param type $aOptions tableau a mettre a jour
     * @param type $aParams tableau de parametre envoyé par jtable (GET)
     * @return void
     *
     * @author Walid Saadaoui
     */
    protected function formatJtableParams($aOptions, $aParams)
    {
        if (!isset($aParams['jtStartIndex']))
        {
            $aParams['jtStartIndex'] = $this->container->getParameter('page') - 1;
        }
        if (!isset($aParams['jtPageSize']))
        {
            $aParams['jtPageSize'] = $this->container->getParameter('max_per_page');
        }
        $aOptions['max_per_page'] = $aParams['jtPageSize'];
        $aOptions['page']         = ( $aParams['jtStartIndex'] / $aOptions['max_per_page'] ) + 1;

        if (isset($aParams['jtSorting']))
        {
            $aJtShort                = explode(' ', $aParams['jtSorting']);
            $aOptions['sort_column'] = $aJtShort[0];
            $aOptions['sort_order']  = $aJtShort[1];
        }
        return $aOptions;
    }

    /**
     *
     * @param array $paData
     * @param array $aBlankValue
     * @param bool $bEncode
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @author Walid Saadaoui
     *
     */
    protected function renderJsonResponse($paData, $aBlankValue = array(), $bEncode = true)
    {
        if (count($aBlankValue))
        {
            $paData = array_merge($aBlankValue, $paData);
        }

        if ($bEncode)
        {
            $paData = json_encode($paData);
        }

        $oResponse = new Response($paData);

        $oResponse->headers->set('Content-Type', 'application/json');
        return $oResponse;
    }

    protected function requestWSJson($psParam, $paData = array(), $pbDecode = true, $pbDebug = false)
    {
        $sWsUrl = trim($this->container->getParameter('ws_host')) . '/' . trim($this->container->getParameter($psParam));

        if ($this->getRequest()->getSession()->get('_security_secured_area'))
        {
            $paData['id_client'] = $this->get('security.context')->getToken()->getUser()->getClientId();
            $paData['id_user']   = $this->get('security.context')->getToken()->getUser()->getUserId();
            $paData['type']      = $this->get('security.context')->getToken()->getUser()->getType();
        }

        $paData['ws']     = 1;
        $paData['locale'] = $this->getRequest()->getLocale();
//        $paData['uri']    = $this->getRequest()->getHttpHost() . $this->getRequest()->getBaseUrl();

        $this->container->get('ws_logger')->info(
                $sWsUrl . '==>' . json_encode($paData));
        $oResponseWs = $this->container->get('restClient')->post($sWsUrl, json_encode($paData), 'application/json');

        if ($pbDebug)
        {
            EchTools::pr(json_encode($paData), 0);
            EchTools::pr($oResponseWs->getResponse(), 0);
            EchTools::pr($oResponseWs);
        }

        if (!$pbDecode)
        {
            return $oResponseWs->getResponse();
        }

        return json_decode($oResponseWs->getResponse(), true);
    }

    protected function getMessages($paKey)
    {
        $aData = array();
        if (!is_array($paKey))
        {
            $paKey = array($paKey);
        }
        $aData = array();
        foreach ($paKey as $sKey)
        {
            if ($this->container->hasParameter($sKey))
            {
                $aData = array_merge($aData, $this->container->getParameter($sKey));
            }
        }
        $this->translate($aData);
        return json_encode($aData);
    }

    private function translate(&$aData)
    {

        if (count($aData))
        {
            foreach ($aData as &$value)
            {
                if (is_array($value))
                {
                    $this->translate($value);
                }
                else
                {
                    $value = $this->container->get('translator')->trans($value);
                }
            }
        }
    }

//    protected function getOrderMessages()
//    {
//        return json_encode($this->container->getParameter('messages.orders'));
//    }
}
