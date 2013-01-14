<?php

namespace ISG\ProjectSubmissionAppBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'Email' table.
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
class EmailTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.ISG.ProjectSubmissionAppBundle.Model.map.EmailTableMap';

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
        $this->setName('Email');
        $this->setPhpName('Email');
        $this->setClassname('ISG\\ProjectSubmissionAppBundle\\Model\\Email');
        $this->setPackage('src.ISG.ProjectSubmissionAppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'User', 'ID', true, null, null);
        $this->addForeignPrimaryKey('PROJECT_ID', 'ProjectId', 'INTEGER' , 'Project', 'ID', true, null, null);
        $this->addColumn('FROM', 'From', 'VARCHAR', true, 100, null);
        $this->getColumn('FROM', false)->setPrimaryString(true);
        $this->addColumn('TO', 'To', 'VARCHAR', true, 100, null);
        $this->getColumn('TO', false)->setPrimaryString(true);
        $this->addColumn('SUBJECT', 'Subject', 'VARCHAR', true, 100, null);
        $this->getColumn('SUBJECT', false)->setPrimaryString(true);
        $this->addColumn('BODY', 'Body', 'VARCHAR', true, 100, null);
        $this->getColumn('BODY', false)->setPrimaryString(true);
        $this->addColumn('SENT_DATE', 'SentDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('RESENT_COUNT', 'ResentCount', 'INTEGER', false, null, 0);
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

} // EmailTableMap
