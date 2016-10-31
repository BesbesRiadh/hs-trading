<?php

namespace hsTrading\FrontEndBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'hs_product' table.
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
class ProductTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.hsTrading.FrontEndBundle.Model.map.ProductTableMap';

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
        $this->setName('hs_product');
        $this->setPhpName('Product');
        $this->setClassname('hsTrading\\FrontEndBundle\\Model\\Product');
        $this->setPackage('src.hsTrading.FrontEndBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', false, 256, null);
        $this->addForeignKey('id_category', 'IdCategory', 'INTEGER', 'hs_product_category', 'id', false, null, null);
        $this->addForeignKey('id_category_details', 'IdCategoryDetails', 'INTEGER', 'hs_product_category_details', 'id', false, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('designation', 'Designation', 'VARCHAR', false, 500, null);
        $this->addColumn('desceng', 'Desceng', 'LONGVARCHAR', false, null, null);
        $this->addColumn('desigeng', 'Desigeng', 'VARCHAR', false, 500, null);
        $this->addColumn('price', 'Price', 'VARCHAR', false, 500, null);
        $this->addColumn('img', 'Img', 'LONGVARCHAR', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProductCategory', 'hsTrading\\FrontEndBundle\\Model\\ProductCategory', RelationMap::MANY_TO_ONE, array('id_category' => 'id', ), null, null);
        $this->addRelation('ProductCategoryDetails', 'hsTrading\\FrontEndBundle\\Model\\ProductCategoryDetails', RelationMap::MANY_TO_ONE, array('id_category_details' => 'id', ), null, null);
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

} // ProductTableMap
