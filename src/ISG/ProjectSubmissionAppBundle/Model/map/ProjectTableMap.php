<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'Project' table.
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
class ProjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.ProjectTableMap';

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
        $this->setName('Project');
        $this->setPhpName('Project');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Project');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addColumn('SUPERVISOR_ID', 'SupervisorId', 'INTEGER', true, null, null);
        $this->addColumn('PHYSICAL_COPY_SUBMITTED', 'PhysicalCopySubmitted', 'TINYINT', false, null, 0);
        $this->addColumn('ALTERNATE_EMAIL_ID', 'AlternateEmailId', 'INTEGER', false, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 100, null);
        $this->getColumn('TITLE', false)->setPrimaryString(true);
        $this->addColumn('PROBLEM_STATEMENT', 'ProblemStatement', 'LONGVARCHAR', true, null, null);
        $this->getColumn('PROBLEM_STATEMENT', false)->setPrimaryString(true);
        $this->addColumn('SUPERVISOR_COMMENTS', 'SupervisorComments', 'LONGVARCHAR', true, null, null);
        $this->getColumn('SUPERVISOR_COMMENTS', false)->setPrimaryString(true);
        $this->addColumn('STATUS', 'Status', 'VARCHAR', true, 50, null);
        $this->getColumn('STATUS', false)->setPrimaryString(true);
        $this->addColumn('SECOND_MARKER_ID', 'SecondMarkerId', 'INTEGER', false, null, 0);
        $this->addColumn('THIRD_MARKER_ID', 'ThirdMarkerId', 'INTEGER', false, null, 0);
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
        $this->addRelation('Email', 'ISG\\ProjectSubmissionAppBundle\\Model\\Email', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), null, null, 'Emails');
        $this->addRelation('Projectmark', 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectmark', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), null, null, 'Projectmarks');
        $this->addRelation('Projectdocument', 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectdocument', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), null, null, 'Projectdocuments');
    } // buildRelations()

} // ProjectTableMap
