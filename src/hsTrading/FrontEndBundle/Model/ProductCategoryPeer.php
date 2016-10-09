<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseProductCategoryPeer;
use hsTrading\FrontEndBundle\Utils\EchTools;

class ProductCategoryPeer extends BaseProductCategoryPeer {

    public static function getCategory() {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addSelectColumn(self::LABEL);
        $oCriteria->addSelectColumn(self::ID);
        return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'label', 'id');
    }

    /**
     * Récupérer un untilisateur par son code
     *
     * @param string $psCode
     * @return array
     */
    public static function deleteCategoryByCode($code) {
        $aResponse = array('status' => 'KO');

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->add(self::CODE, $code);

        if (self::doDelete($oCriteria)) {
            $aResponse = array('status' => 'OK');
        }
        return $aResponse;
    }

    /**
     * Retrouve une Categorie
     *
     * @param <array> $paOptions
     * @return <object> ProductCategory
     *
     * @author Walid Saadaoui
     */
    public static function retrieveOne($code) {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        if (!empty($code)) {
            $oCriteria->add(self::CODE, $code);
            return self::doSelectOne($oCriteria);
        }
        return null;
    }

    /**
     *
     * @param <array> $paOptions
     * @return \PropelPager
     */
    public static function retrieveByFilters($paOptions = array()) {
        $sCode = EchTools::getOption($paOptions, 'code');
        $sLabel = EchTools::getOption($paOptions, 'label');
        $nPage = EchTools::getOption($paOptions, 'page', 1);
        $nMaxPerPage = EchTools::getOption($paOptions, 'max_per_page', 50);
        $sSortColumn = EchTools::getOption($paOptions, 'sort_column', self::CREATED_AT);
        $sSortOrder = EchTools::getOption($paOptions, 'sort_order', 'desc');
        $bPaginated = EchTools::getOption($paOptions, 'paginated', true);

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
//        $oCriteria->addAsColumn(ProductCategoryPeer::ID, ProductCategoryPeer::LABEL);
        if (!empty($sCode)) {
            $oCriteria->addAnd(self::CODE, '%' . $sCode . '%', \Criteria::LIKE);
        }

        if (!empty($sLabel)) {
            $oCriteria->addAnd(self::LABEL, '%' . $sLabel . '%', \Criteria::LIKE);
        }

        if ($sSortColumn && $sSortOrder) {
            call_user_func(array($oCriteria, 'add' . ucfirst($sSortOrder) . 'endingOrderByColumn'), $sSortColumn);
        }

        if (!$bPaginated) {
            return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
        }
        return new \PropelPager($oCriteria, get_class(), 'doSelectStmt', $nPage, $nMaxPerPage);
    }

    /**
     * 
     */
    public static function getCategoriesList() {

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addSelectColumn(self::LABEL);
        $oCriteria->addSelectColumn(self::ID);
        return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'label', 'id');
    }

    public static function getCategoryById($paOptions = array()) {
        $id = EchTools::getOption($paOptions, 'id');
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addSelectColumn(self::CODE);
        $oCriteria->addSelectColumn(self::ID);
        $oCriteria->add(self::ID, $id);
       return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
    }

}
