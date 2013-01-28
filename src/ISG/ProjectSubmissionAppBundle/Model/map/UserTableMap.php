<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'User' table.
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
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.UserTableMap';

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
        $this->setName('User');
        $this->setPhpName('User');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\User');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addPrimaryKey('USER_EMAIL', 'UserEmail', 'VARCHAR', true, 100, null);
        $this->getColumn('USER_EMAIL', false)->setPrimaryString(true);
        $this->addColumn('USER_FIRSTNAME', 'UserFirstname', 'VARCHAR', true, 100, null);
        $this->getColumn('USER_FIRSTNAME', false)->setPrimaryString(true);
        $this->addColumn('USER_LASTNAME', 'UserLastname', 'VARCHAR', true, 100, null);
        $this->getColumn('USER_LASTNAME', false)->setPrimaryString(true);
        $this->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 128, null);
        $this->getColumn('PASSWORD', false)->setPrimaryString(true);
        $this->addColumn('SALT', 'Salt', 'INTEGER', true, null, null);
        $this->addColumn('SUPERVISOR_QUOTA_1', 'SupervisorQuota1', 'INTEGER', false, null, 0);
        $this->addForeignKey('ROLE_ID', 'RoleId', 'INTEGER', 'Role', 'ID', false, null, null);
        $this->addColumn('STATUS', 'Status', 'VARCHAR', true, 50, null);
        $this->getColumn('STATUS', false)->setPrimaryString(true);
        $this->addColumn('PROJECT_YEAR', 'ProjectYear', 'VARCHAR', true, 4, null);
        $this->getColumn('PROJECT_YEAR', false)->setPrimaryString(true);
        $this->addColumn('DEPARTMENT', 'Department', 'VARCHAR', true, 50, null);
        $this->getColumn('DEPARTMENT', false)->setPrimaryString(true);
        $this->addColumn('CREATED_BY', 'CreatedBy', 'INTEGER', false, null, null);
        $this->addColumn('CREATED_ON', 'CreatedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('MODIFIED_BY', 'ModifiedBy', 'INTEGER', false, null, null);
        $this->addColumn('MODIFIED_ON', 'ModifiedOn', 'TIMESTAMP', false, null, null);
        $this->addColumn('SUPERVISOR_QUOTA_2', 'SupervisorQuota2', 'INTEGER', false, null, 0);
        $this->addColumn('QUOTA_USED_1', 'QuotaUsed1', 'INTEGER', false, null, 0);
        $this->addColumn('QUOTA_USED_2', 'QuotaUsed2', 'INTEGER', false, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Role', 'ISG\\ProjectSubmissionAppBundle\\Model\\Role', RelationMap::MANY_TO_ONE, array('role_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Profileuser', 'ISG\\ProjectSubmissionAppBundle\\Model\\Profileuser', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', null, 'Profileusers');
        $this->addRelation('Project', 'ISG\\ProjectSubmissionAppBundle\\Model\\Project', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', null, 'Projects');
        $this->addRelation('Email', 'ISG\\ProjectSubmissionAppBundle\\Model\\Email', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Emails');
        $this->addRelation('ProjectmarkRelatedByUserId', 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectmark', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'ProjectmarksRelatedByUserId');
        $this->addRelation('ProjectmarkRelatedByEvaluatorId', 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectmark', RelationMap::ONE_TO_MANY, array('id' => 'evaluator_id', ), null, null, 'ProjectmarksRelatedByEvaluatorId');
        $this->addRelation('Projectdocument', 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectdocument', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Projectdocuments');
    } // buildRelations()

} // UserTableMap
