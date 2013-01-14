<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ProjectMark' table.
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
class ProjectmarkTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.ProjectmarkTableMap';

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
        $this->setName('ProjectMark');
        $this->setPhpName('Projectmark');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Projectmark');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addForeignPrimaryKey('EVALUATOR_ID', 'EvaluatorId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addForeignPrimaryKey('PROJECT_ID', 'ProjectId', 'INTEGER' , 'Project', 'ID', true, null, null);
        $this->addColumn('TOTAL_MARKS', 'TotalMarks', 'INTEGER', true, null, null);
        $this->addColumn('MARK_1', 'Mark1', 'INTEGER', true, null, null);
        $this->addColumn('MARK_2', 'Mark2', 'INTEGER', true, null, null);
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
        $this->addRelation('UserRelatedByUserId', 'ISG\\ProjectSubmissionAppBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
        $this->addRelation('Project', 'ISG\\ProjectSubmissionAppBundle\\Model\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'id', ), null, null);
        $this->addRelation('UserRelatedByEvaluatorId', 'ISG\\ProjectSubmissionAppBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('evaluator_id' => 'id', ), null, null);
    } // buildRelations()

} // ProjectmarkTableMap
