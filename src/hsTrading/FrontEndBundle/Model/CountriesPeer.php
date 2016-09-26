<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseCountriesPeer;
use hsTrading\FrontEndBundle\Utils\EchTools;

class CountriesPeer extends BaseCountriesPeer
{
     /**
     * Select Countries List
     * 
     */
    public static function getCountriesList()
    {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
        $oCriteria->addAsColumn('countries', self::COUNTRYNAME);
        $oCriteria->setDistinct();
        $oCriteria->addAscendingOrderByColumn(self::COUNTRYNAME);
        return EchTools::getColumnFromResultSet(self::doSelectStmt($oCriteria), 'countries', 'countries');
    }
}
