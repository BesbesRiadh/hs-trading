<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseContactPeer;
use hsTrading\FrontEndBundle\Utils\EchTools;

class ContactPeer extends BaseContactPeer {

    /**
     * Récupérer la liste des untilisateurs paginée par le cleint id
     *
     * @param integer $pnId
     * @return array
     */
    public static function getPagniatedContacts($paOptions) {
        $History = EchTools::getOption($paOptions, 'history', 1);
        $nPage = EchTools::getOption($paOptions, 'page', 1);
        $nMaxPerPage = EchTools::getOption($paOptions, 'max_per_page', 50);
        $sSortColumn = EchTools::getOption($paOptions, 'sort_column', self::CREATED_AT);
        $sSortOrder = EchTools::getOption($paOptions, 'sort_order', 'desc');

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);

        if ($sSortColumn && $sSortOrder) {
            call_user_func(array($oCriteria, 'add' . ucfirst($sSortOrder) . 'endingOrderByColumn'), $sSortColumn);
        }
        $oCriteria->add(self::TREATED, $History);

        return new \PropelPager($oCriteria, get_class(), 'doSelectStmt', $nPage, $nMaxPerPage);
    }

    /**
     * Récupérer un contact par son code
     *
     * @param string $psCode
     * @return array
     */
    public static function getContactByCode($psCode) {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);

        $oCriteria->add(self::ID, $psCode);

        return self::doSelectOne($oCriteria);
    }

}
