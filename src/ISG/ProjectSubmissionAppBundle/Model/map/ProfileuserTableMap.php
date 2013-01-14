<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ProfileUser' table.
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
class ProfileuserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.ProfileuserTableMap';

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
        $this->setName('ProfileUser');
        $this->setPhpName('Profileuser');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Profileuser');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('PROFILE_ID', 'ProfileId', 'INTEGER' , 'Profile', 'ID', true, null, null);
        $this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addColumn('START_DATE', 'StartDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('END_DATE', 'EndDate', 'TIMESTAMP', true, null, null);
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
        $this->addRelation('User', 'ISG\\ProjectSubmissionAppBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Profile', 'ISG\\ProjectSubmissionAppBundle\\Model\\Profile', RelationMap::MANY_TO_ONE, array('profile_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // ProfileuserTableMap
