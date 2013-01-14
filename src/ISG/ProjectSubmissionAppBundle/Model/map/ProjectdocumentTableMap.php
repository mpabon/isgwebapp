<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ProjectDocument' table.
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
class ProjectdocumentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.ProjectdocumentTableMap';

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
        $this->setName('ProjectDocument');
        $this->setPhpName('Projectdocument');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Projectdocument');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addForeignPrimaryKey('PROJECT_ID', 'ProjectId', 'INTEGER' , 'Project', 'ID', true, null, null);
        $this->addColumn('VERSION', 'Version', 'VARCHAR', true, 20, null);
        $this->getColumn('VERSION', false)->setPrimaryString(true);
        $this->addColumn('TYPE', 'Type', 'VARCHAR', true, 20, null);
        $this->getColumn('TYPE', false)->setPrimaryString(true);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 100, null);
        $this->getColumn('NAME', false)->setPrimaryString(true);
        $this->addColumn('STATUS', 'Status', 'VARCHAR', true, 50, null);
        $this->getColumn('STATUS', false)->setPrimaryString(true);
        $this->addColumn('DOCUMENT', 'Document', 'VARCHAR', true, 100, null);
        $this->getColumn('DOCUMENT', false)->setPrimaryString(true);
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
        $this->addRelation('User', 'ISG\\ProjectSubmissionAppBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
        $this->addRelation('Project', 'ISG\\ProjectSubmissionAppBundle\\Model\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'id', ), null, null);
    } // buildRelations()

} // ProjectdocumentTableMap
