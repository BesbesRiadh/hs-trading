<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseProductPeer;
use hsTrading\FrontEndBundle\Utils\EchTools;

class ProductPeer extends BaseProductPeer
{

    /**
     * Récupérer la liste des untilisateurs paginée par le cleint id
     *
     * @param integer $pnId
     * @return array
     */
    public static function getPagniatedProducts($paOptions)
    {
        $nPage       = EchTools::getOption($paOptions, 'page', 1);
        $nMaxPerPage = EchTools::getOption($paOptions, 'max_per_page', 50);
        $sSortColumn = EchTools::getOption($paOptions, 'sort_column', self::CREATED_AT);
        $sSortOrder  = EchTools::getOption($paOptions, 'sort_order', 'desc');

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::ID_CATEGORY, ProductCategoryPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria->addJoin(self::ID_CATEGORY_DETAILS, ProductCategoryDetailsPeer::ID, \Criteria::INNER_JOIN);

        if ($sSortColumn && $sSortOrder)
        {
            call_user_func(array($oCriteria, 'add' . ucfirst($sSortOrder) . 'endingOrderByColumn'), $sSortColumn);
        }

        $oCriteria->addSelectColumn(self::ID)
                ->addSelectColumn(self::CODE)
                ->addSelectColumn(self::ID_CATEGORY)
                ->addSelectColumn(self::ID_CATEGORY_DETAILS)
                ->addSelectColumn(self::DESCRIPTION)
                ->addSelectColumn(self::DESIGNATION)
                ->addSelectColumn(self::DESCENG)
                ->addSelectColumn(self::DESIGENG)
                ->addSelectColumn(self::IMG)
                ->addSelectColumn(self::CREATED_AT)
                ->addSelectColumn(self::UPDATED_AT)
                ->addAsColumn('category', ProductCategoryPeer::LABEL)
                ->addAsColumn('sub_category', ProductCategoryDetailsPeer::LABEL)
        ;

        return new \PropelPager($oCriteria, get_class(), 'doSelectStmt', $nPage, $nMaxPerPage);
    }

    /**
     *
     * @param integer $pnId
     * @return array
     */
    public static function getProductsById($nId)
    {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::ID_CATEGORY, ProductCategoryPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria->addJoin(self::ID_CATEGORY_DETAILS, ProductCategoryDetailsPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria
                ->addAsColumn('category', ProductCategoryPeer::ID)
                ->addAsColumn('sub_category', ProductCategoryDetailsPeer::ID)
                ->addAsColumn('description', self::DESCRIPTION)
                ->addAsColumn('designation', self::DESIGNATION)
                ->addAsColumn('desceng', self::DESCENG)
                ->addAsColumn('desigeng', self::DESIGENG)
                ->addAsColumn('price', self::PRICE)
                ->addAsColumn('img', self::IMG)
        ;
        $oCriteria->add(self::ID, $nId);
        return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param integer $pnId
     * @return array
     */
    public static function getProductsByCode($paOptions)
    {
        $code      = EchTools::getOption($paOptions, 'code');
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addJoin(self::ID_CATEGORY, ProductCategoryPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria->addJoin(self::ID_CATEGORY_DETAILS, ProductCategoryDetailsPeer::ID, \Criteria::INNER_JOIN);
        $oCriteria
                ->addAsColumn('category', ProductCategoryPeer::LABEL)
                ->addAsColumn('sub_category', ProductCategoryDetailsPeer::CODE)
                ->addAsColumn('description', self::DESCRIPTION)
                ->addAsColumn('designation', self::DESIGNATION)
                ->addAsColumn('desceng', self::DESCENG)
                ->addAsColumn('desigeng', self::DESIGENG)
                ->addAsColumn('price', self::PRICE)
                ->addAsColumn('img', self::IMG)
                ->addAscendingOrderByColumn(ProductCategoryDetailsPeer::CATEGORDER);
        ;
        $oCriteria->add(self::CODE, $code);
        return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un untilisateur par son code
     *
     * @param string $psCode
     * @return array
     */
    public static function getProductById($nId)
    {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->add(self::ID, $nId);

        return self::doSelectOne($oCriteria);
    }

    /**
     * Récupérer un untilisateur par son code
     *
     * @param string $psCode
     * @return array
     */
    public static function deleteProductById($nId)
    {
        $aResponse = array('status' => 'KO');

        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->add(self::ID, $nId);

//        if (self::doDelete($oCriteria)) {
//            $aResponse = array('status' => 'OK');
//        }
//        return $this->renderJsonResponse($aResponse);
        return self::doDelete($oCriteria);
    }

}
