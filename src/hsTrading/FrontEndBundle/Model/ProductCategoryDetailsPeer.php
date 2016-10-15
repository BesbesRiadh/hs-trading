<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseProductCategoryDetailsPeer;
use hsTrading\FrontEndBundle\Utils\EchTools;

class ProductCategoryDetailsPeer extends BaseProductCategoryDetailsPeer
{

    public static function getCategorydetails($paOptions)
    {
        $Category  = EchTools::getOption($paOptions, 'category');
        $code      = EchTools::getOption($paOptions, 'code');
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::PRODUCTCATEGORY_ID, ProductCategoryPeer::ID, \Criteria::INNER_JOIN);

        if ($Category)
        {
            $oCriteria->add(ProductCategoryPeer::CODE, $Category);
        }
        if ($code)
        {
            $oCriteria->add(ProductCategoryPeer::CODE, $code);
            return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'label', 'code_label');
        }
        $oCriteria->addSelectColumn(self::CODE);
        $oCriteria->addSelectColumn(self::LABEL);
        return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'label', 'code');
    }

    /**
     * Retrouve un detail
     *
     * @param <array> $paOptions
     * @return <object>
     *
     * @author Walid Saadaoui
     */
    public static function retrieveOne($paOptions = array())
    {
        $nParent = EchTools::getOption($paOptions, 'id_category');
        $sCode   = EchTools::getOption($paOptions, 'code');
        $sLabel  = EchTools::getOption($paOptions, 'label');

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);

        if (!empty($sCode))
        {
            $oCriteria->add(self::PRODUCTCATEGORY_ID, $nParent);
            $oCriteria->add(self::CODE, $sCode);
            $oCriteria->addOr(self::LABEL, $sLabel);
            return self::doSelectOne($oCriteria);
        }

        return null;
    }

    /**
     * Retrouve les statuts selon des filtres
     *
     * @param <array> $paOptions
     * @return <Object> PropelPager
     * @author Walid Saadaoui
     */
    public static function retrieveByFilters($paOptions = array())
    {
        $nPage       = EchTools::getOption($paOptions, 'page', 1);
        $nMaxPerPage = EchTools::getOption($paOptions, 'max_per_page', 50);
        $sSortOrder  = EchTools::getOption($paOptions, 'sort_order', 'asc');
        $bPaginate   = EchTools::getOption($paOptions, 'paginate', true);

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::PRODUCTCATEGORY_ID, ProductCategoryPeer::ID, \Criteria::LEFT_JOIN);
        call_user_func(array($oCriteria, 'add' . ucfirst($sSortOrder) . 'endingOrderByColumn'), ProductCategoryPeer::LABEL);
        $oCriteria->addAsColumn('category_label', ProductCategoryPeer::LABEL)
                ->addAsColumn('productCategoy_Id', ProductCategoryPeer::ID);
        self::addSelectColumns($oCriteria);

        if (!$bPaginate)
        {
            return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
        }

        return new \PropelPager($oCriteria, get_class(), 'doSelectStmt', $nPage, $nMaxPerPage);
    }

    /**
     *
     */
    public static function getSubCategoriesList()
    {

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addSelectColumn(self::LABEL);
        $oCriteria->addSelectColumn(self::ID);
        return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'label', 'id');
    }

    /**
     *
     * @param integer $pnId
     * @return array
     */
    public static function getCategorydetailsByCode($paOptions)
    {
        $code      = EchTools::getOption($paOptions, 'code');
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::PRODUCTCATEGORY_ID, ProductCategoryPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria->add(ProductCategoryPeer::CODE, $code)
                ->addAscendingOrderByColumn(self::CATEGORDER);
        return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
    }

}
