<?php

namespace hsTrading\FrontEndBundle\Model;

use hsTrading\FrontEndBundle\Model\om\BaseTestPeer;

class TestPeer extends BaseTestPeer
{
    public static function retreiveOne()
    {
        $oCriteria = new \Criteria();
        $oCriteria->setPrimaryTableName(self::TABLE_NAME);
//        return self::doSelectOne($oCriteria);
        return self::doSelectStmt($oCriteria)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
