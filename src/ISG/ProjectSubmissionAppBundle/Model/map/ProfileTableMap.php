<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'Profile' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.ISG.ProjectSubmissionAppBundle.Model.map
 */
class ProfileTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.ProfileTableMap';

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
        $this->setName('Profile');
        $this->setPhpName('Profile');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Profile');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
        $this->getColumn('NAME', false)->setPrimaryString(true);
        $this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 50, null);
        $this->getColumn('DESCRIPTION', false)->setPrimaryString(true);
        $this->addColumn('CREATED_BY', 'CreatedBy', 'INTEGER', false, null, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('MODIFIED_BY', 'ModifiedBy', 'INTEGER', false, null, null);
        $this->addColumn('MODIFIED_ON', 'ModifiedOn', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Profileuser', 'ISG\\ProjectSubmissionAppBundle\\Model\\Profileuser', RelationMap::ONE_TO_MANY, array('id' => 'profile_id', ), 'CASCADE', null, 'Profileusers');
    } // buildRelations()

} // ProfileTableMap
