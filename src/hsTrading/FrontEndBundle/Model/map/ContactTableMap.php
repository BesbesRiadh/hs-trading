<?php

namespace hsTrading\FrontEndBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'hs_contact' table.
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
class ContactTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.hsTrading.FrontEndBundle.Model.map.ContactTableMap';

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
        $this->setName('hs_contact');
        $this->setPhpName('Contact');
        $this->setClassname('hsTrading\\FrontEndBundle\\Model\\Contact');
        $this->setPackage('src.hsTrading.FrontEndBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('mail', 'Mail', 'VARCHAR', false, 256, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 256, null);
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', false, 256, null);
        $this->addColumn('lastname', 'Lastname', 'VARCHAR', false, 256, null);
        $this->addColumn('company', 'Company', 'VARCHAR', false, 256, null);
        $this->addColumn('company_function', 'CompanyFunction', 'VARCHAR', false, 256, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 256, null);
        $this->addColumn('message', 'Message', 'LONGVARCHAR', false, null, null);
        $this->addColumn('treated', 'Treated', 'BOOLEAN', false, 1, false);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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

} // ContactTableMap
