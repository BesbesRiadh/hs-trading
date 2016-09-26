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
        
        if ($sSortColumn && $sSortOrder)
        {
            call_user_func(array($oCriteria, 'add' . ucfirst($sSortOrder) . 'endingOrderByColumn'), $sSortColumn);
        }
        
        $oCriteria->addSelectColumn(self::ID)
                ->addSelectColumn(self::CODE)
                ->addSelectColumn(self::CATEGORY)
                ->addSelectColumn(self::DESCRIPTION)
                ->addSelectColumn(self::DESIGNATION)
                ->addSelectColumn(self::PRICE)
                ->addSelectColumn(self::IMG)
                ->addSelectColumn(self::CREATED_AT)
                ->addSelectColumn(self::UPDATED_AT)
        ;
        
        return new \PropelPager($oCriteria, get_class(), 'doSelectStmt', $nPage, $nMaxPerPage);
    }
}
