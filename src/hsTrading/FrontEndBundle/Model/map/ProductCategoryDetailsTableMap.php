<?php

namespace hsTrading\FrontEndBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'hs_product_category_details' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.hsTrading.FrontEndBundle.Model.map
 */
class ProductCategoryDetailsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.hsTrading.FrontEndBundle.Model.map.ProductCategoryDetailsTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('hs_product_category_details');
        $this->setPhpName('ProductCategoryDetails');
        $this->setClassname('hsTrading\\FrontEndBundle\\Model\\ProductCategoryDetails');
        $this->setPackage('src.hsTrading.FrontEndBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('productCategory_id', 'ProductcategoryId', 'INTEGER', 'hs_product_category', 'id', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 60, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 60, null);
        $this->addColumn('labeleng', 'Labeleng', 'VARCHAR', true, 60, null);
        $this->addColumn('categorder', 'Categorder', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProductCategory', 'hsTrading\\FrontEndBundle\\Model\\ProductCategory', RelationMap::MANY_TO_ONE, array('productCategory_id' => 'id', ), null, null);
        $this->addRelation('Product', 'hsTrading\\FrontEndBundle\\Model\\Product', RelationMap::ONE_TO_MANY, array('id' => 'id_category_details', ), null, null, 'Products');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // ProductCategoryDetailsTableMap
