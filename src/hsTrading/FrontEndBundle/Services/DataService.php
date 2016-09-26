<?php

namespace hsTrading\FrontEndBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use hsTrading\FrontEndBundle\EchTools;

/**
 * Description of DataService
 *
 * @author Walid Saadaoui
 */
class DataService {

    private $oContainer;

    public function __construct(Container $oContainer) {
        $this->oContainer = $oContainer;
        $this->aModelNamespace = array(
            substr('\hsTrading\FrontEndBundle\Model\ ', 0, -1),
        );
    }

    public function getContainer() {
        return $this->oContainer;
    }

    /**
     * Recupere les données simple sans pagination
     *
     * @param string $psLog
     * @param string $psClassName
     * @return \Symfony\Component\HttpFoundation\Response JSON
     *
     * @throws Exception
     *
     * @author Walid Saadaoui 01/09/2014
     *
     */
    public function getSimpleData($paOptions, $psClassName, $psMethodName) {

        try {
            $sClassName = $this->getClassName($psClassName, $psMethodName);
            $aData = call_user_func_array(array($sClassName, $psMethodName), array($paOptions));
        } catch (\Exception $ex) {
            $aData = array();
        }

        return $aData;
    }

    /**
     * Recupere les données avec pagination
     *
     * @param string $psLog
     * @param string $psClassName
     * @return \Symfony\Component\HttpFoundation\Response JSON
     *
     * @throws Exception
     *      *
     * @author Walid Saadaoui 01/09/2014
     *
     */
    public function getPaginatedData($paOptions, $psClassName, $psMethodName, $paComplement = array()) {
        $aData = $paComplement;

        try {
            $sClassName = $this->getClassName($psClassName, $psMethodName);

            $oPager = call_user_func_array(array($sClassName, $psMethodName), array($paOptions));

            if (!$oPager instanceof \PropelPager) {
                return $aData = array_merge($paComplement, array(
                    'TotalRecordCount' => count($oPager),
                    'Records' => $oPager,
                    'Result' => 'OK'
                ));
            }

            $aData['TotalRecordCount'] = $oPager->getTotalRecordCount();
            $aData['Records'] = $oPager->getResult()->fetchAll(\Pdo::FETCH_ASSOC);
            $aData['Result'] = 'OK';
        } catch (\Exception $ex) {
            $aData = array_merge($paComplement, array(
                'TotalRecordCount' => 0,
                'Records' => array(),
                'Result' => 'ERROR',
                'Message' => 'Une erreur est survenue'
            ));
        }

        return $aData;
    }

    /**
     * Recupere les données avec pagination
     *
     * @param string $psLog
     * @param string $psClassName
     * @return \Symfony\Component\HttpFoundation\Response JSON
     *
     * @throws Exception
     *      *
     * @author Walid Saadaoui 19/12/2015
     *
     */
    public function getPaginated2Data($paOptions, $psClassName, $psMethodName, $paComplement = array()) {
        $aData = $paComplement;
        try {
            $sClassName = $this->getClassName($psClassName, $psMethodName);

            $oPager = call_user_func_array(array($sClassName, $psMethodName), array($paOptions));

            if (!$oPager instanceof \PropelPager) {
                return $aData = array_merge($paComplement, array(
                    'total' => count($oPager),
                    'rowCount' => count($oPager),
                    'current' => 1,
                    'rows' => $oPager,
                    'Result' => 'OK'
                ));
            } else {
                $aResult = $oPager->getResult()->fetchAll(\Pdo::FETCH_ASSOC);
                $aData['current'] = (int) $oPager->getPage();
                $aData['rowCount'] = min(array($oPager->getRowsPerPage(), count($aResult)));
                $aData['rows'] = $aResult;
                $aData['total'] = $oPager->getTotalRecordCount();
                $aData['Result'] = 'OK';
            }
        } catch (\Exception $ex) {
            $aData = array_merge($paComplement, array(
                'current' => 0,
                'total' => 0,
                'rowCount' => 0,
                'rows' => array(),
                'Result' => 'ERROR',
                'Message' => 'Une erreur est survenue'
            ));
        }

        return $aData;
    }

    /**
     * Execute une requte de selection  simple
     *
     * @param string $psClassName
     * @param string $psKey
     * @param string $psValue
     * @param string $psLog
     * @return array
     *
     * @author Walid Saadaoui 15/09/2014
     */
    public function getSimpleColumn($psClassName, $psKey, $psValue, $psLog) {
        $oLogger = $this->oContainer->get($psLog);

        try {
            $sClassName = $this->getClassName($psClassName);
            $aTypes = $sClassName::create()
                    ->select(array($psKey, $psValue))
                    ->find();
            $aData = EchTools::getColumnFromResultSet($aTypes, $psValue, $psKey);
        } catch (\Exception $ex) {
            $oLogger->error($ex->getMessage());
            $aData = array();
        }

        return $aData;
    }

    /**
     * Execute une requte de selection  simple
     *
     * @param string $psClassName
     * @param string $psColumn
     * @param string $psLog
     * @return array
     *
     * @author Walid Saadaoui 10/05/2015
     */
    public function getOneColumn($psClassName, $psColumn, $psLog = 'logger') {
        $oLogger = $this->oContainer->get($psLog);

        try {
            $sClassName = $this->getClassName($psClassName);
            $aData = $sClassName::create()
                    ->select($psColumn)
                    ->distinct()
                    ->orderBy($psColumn)
                    ->find()
                    ->getArrayCopy();
        } catch (\Exception $ex) {
            $oLogger->error($ex->getMessage());
            $aData = array();
        }

        return $aData;
    }

    /**
     * Execute une requte de selection  simple
     *
     * @param string $psClassName
     * @param string $psFct
     * @param string $psLog
     * @return array
     *
     * @author Walid Saadaoui 10/05/2015
     */
    public function getObjects($psClassName, $psFct, $psLog = 'logger', $pOptions = null) {
        $oLogger = $this->oContainer->get($psLog);

        try {
            $sClassName = $this->getClassName($psClassName);
            $aoData = $sClassName::create()->$psFct($pOptions);
        } catch (\Exception $ex) {
            $oLogger->error($ex->getMessage());
            $aoData = array();
        }

        return $aoData;
    }

    /**
     * Retrouve le nom de la classe
     *
     * @param string $psClassName
     * @param string $psMethodName
     * @return string
     * @throws \Exception
     *
     * @author Walid Saadaoui 15/09/2014
     */
    public function getClassName($psClassName, $psMethodName = null) {
        $psClassName = ucfirst($psClassName);
        $sClassName = null;
        foreach ($this->aModelNamespace as $sModelNamespace) {
            if (class_exists($sModelNamespace . $psClassName)) {
                $sClassName = $sModelNamespace . $psClassName;
            }
        }

        if (!$sClassName) {
            throw new \Exception('L\'object "' . $psClassName . '" n\'existe pas ');
        }
//        $sClassName = $this->sModelNamespace1 . $psClassName;
//        if ( !class_exists($sClassName) )
//        {
//            $sClassName = $this->sModelNamespace2 . $psClassName;
//            if ( !class_exists($sClassName) )
//            {
//                throw new \Exception('L\'object "' . $psClassName . '" n\'existe pas ');
//            }
//        }

        if (!$psMethodName) {
            return $sClassName;
        }

        if (!method_exists($sClassName, $psMethodName)) {
            throw new \Exception('La méthode "' . $psMethodName . '" n\'existe dans l\'objet ' . $psClassName);
        }
        return $sClassName;
    }

    public function notifyAction($oElement, $sType, $bNotify) {
        $sType = ucfirst($sType);
        if ($bNotify) {
            switch ($sType) {
                case 'PermanentOrderB2b':case 'PermanentOrderB2c':

                    $sTemplate = 'WsBundle:swiftmail:permanentOrderNotification.html.twig';
                    $sSubject = 'PermanentOrder.subject';
                    $sCpltSubject = $oElement->getCode();
                    $aData = array('code' => $oElement->getCode(), 'status' => $oElement->getStatus());

                    break;

                case 'Order':case 'B2bOrder':case 'B2bOrderDetails':case 'OrderDetails':

                    if (in_array($sType, array('B2bOrderDetails', 'OrderDetails'))) {
                        $oElement = $oElement->getOrder();
                    }
                    $sTemplate = 'WsBundle:swiftmail:orderNotification.html.twig';
                    $sSubject = 'Order.subject';
                    $sCpltSubject = $oElement->getCode();
                    $aData = array(
                        'code' => $sCpltSubject,
                        'status' => $oElement->getStatus(),
                    );

                    if ('DELIVERING3' == $oElement->getStatus()) {
                        $aData['address'] = $oElement->getDeliveryAddress();
                    }
                    break;

                case 'TicketMessageB2b':case 'TicketMessageB2c':

                    $oTicket = $oElement->getTicket();
                    $oProduct = $oTicket->getOrderDetails();
                    $sTemplate = 'WsBundle:swiftmail:ticketNotification.html.twig';
                    $sSubject = 'Ticket.subject';

                    $sCpltSubject = $oElement->getTicketCode();
                    $aData = array(
                        'code' => $sCpltSubject,
                        'product' => $oProduct->getCode() . ' - ' . $oProduct->getDesignation(),
                        'category' => $oTicket->getTicketCategory()->getLabel(),
                        'message' => $oElement->getMessage()
                    );

                    break;

                default :
                    break;
            }

            $sUserMail = $oElement->getUserMail();
            $sClientMail = $oElement->getClientMail();

            if ($sClientMail != $sUserMail) {
                $sUserMail = array($sUserMail, $sClientMail);
            }

            if (!empty(EchTools::trimArray($sUserMail))) {
                $this->oContainer->get('mailService')->sendMail($sUserMail, null, $sSubject, $aData, $sTemplate, 'fr', $sCpltSubject);
            }
        }
    }

}
