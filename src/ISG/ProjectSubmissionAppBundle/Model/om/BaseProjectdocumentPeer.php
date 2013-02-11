<?php

namespace ISG\ProjectSubmissionAppBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use ISG\ProjectSubmissionAppBundle\Model\ProjectPeer;
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentPeer;
use ISG\ProjectSubmissionAppBundle\Model\UserPeer;
use ISG\ProjectSubmissionAppBundle\Model\map\ProjectdocumentTableMap;

abstract class BaseProjectdocumentPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'ProjectDocument';

    /** the related Propel class for this table */
    const OM_CLASS = 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectdocument';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ProjectdocumentTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 12;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 12;

    /** the column name for the ID field */
    const ID = 'ProjectDocument.ID';

    /** the column name for the USER_ID field */
    const USER_ID = 'ProjectDocument.USER_ID';

    /** the column name for the PROJECT_ID field */
    const PROJECT_ID = 'ProjectDocument.PROJECT_ID';

    /** the column name for the VERSION field */
    const VERSION = 'ProjectDocument.VERSION';

    /** the column name for the TYPE field */
    const TYPE = 'ProjectDocument.TYPE';

    /** the column name for the NAME field */
    const NAME = 'ProjectDocument.NAME';

    /** the column name for the STATUS field */
    const STATUS = 'ProjectDocument.STATUS';

    /** the column name for the DOCUMENT field */
    const DOCUMENT = 'ProjectDocument.DOCUMENT';

    /** the column name for the CREATED_BY field */
    const CREATED_BY = 'ProjectDocument.CREATED_BY';

    /** the column name for the CREATED_ON field */
    const CREATED_ON = 'ProjectDocument.CREATED_ON';

    /** the column name for the MODIFIED_BY field */
    const MODIFIED_BY = 'ProjectDocument.MODIFIED_BY';

    /** the column name for the MODIFIED_ON field */
    const MODIFIED_ON = 'ProjectDocument.MODIFIED_ON';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Projectdocument objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Projectdocument[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ProjectdocumentPeer::$fieldNames[ProjectdocumentPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'UserId', 'ProjectId', 'Version', 'Type', 'Name', 'Status', 'Document', 'CreatedBy', 'CreatedOn', 'ModifiedBy', 'ModifiedOn', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'userId', 'projectId', 'version', 'type', 'name', 'status', 'document', 'createdBy', 'createdOn', 'modifiedBy', 'modifiedOn', ),
        BasePeer::TYPE_COLNAME => array (ProjectdocumentPeer::ID, ProjectdocumentPeer::USER_ID, ProjectdocumentPeer::PROJECT_ID, ProjectdocumentPeer::VERSION, ProjectdocumentPeer::TYPE, ProjectdocumentPeer::NAME, ProjectdocumentPeer::STATUS, ProjectdocumentPeer::DOCUMENT, ProjectdocumentPeer::CREATED_BY, ProjectdocumentPeer::CREATED_ON, ProjectdocumentPeer::MODIFIED_BY, ProjectdocumentPeer::MODIFIED_ON, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'USER_ID', 'PROJECT_ID', 'VERSION', 'TYPE', 'NAME', 'STATUS', 'DOCUMENT', 'CREATED_BY', 'CREATED_ON', 'MODIFIED_BY', 'MODIFIED_ON', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'user_id', 'project_id', 'version', 'type', 'name', 'status', 'document', 'created_by', 'created_on', 'modified_by', 'modified_on', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ProjectdocumentPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'UserId' => 1, 'ProjectId' => 2, 'Version' => 3, 'Type' => 4, 'Name' => 5, 'Status' => 6, 'Document' => 7, 'CreatedBy' => 8, 'CreatedOn' => 9, 'ModifiedBy' => 10, 'ModifiedOn' => 11, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'userId' => 1, 'projectId' => 2, 'version' => 3, 'type' => 4, 'name' => 5, 'status' => 6, 'document' => 7, 'createdBy' => 8, 'createdOn' => 9, 'modifiedBy' => 10, 'modifiedOn' => 11, ),
        BasePeer::TYPE_COLNAME => array (ProjectdocumentPeer::ID => 0, ProjectdocumentPeer::USER_ID => 1, ProjectdocumentPeer::PROJECT_ID => 2, ProjectdocumentPeer::VERSION => 3, ProjectdocumentPeer::TYPE => 4, ProjectdocumentPeer::NAME => 5, ProjectdocumentPeer::STATUS => 6, ProjectdocumentPeer::DOCUMENT => 7, ProjectdocumentPeer::CREATED_BY => 8, ProjectdocumentPeer::CREATED_ON => 9, ProjectdocumentPeer::MODIFIED_BY => 10, ProjectdocumentPeer::MODIFIED_ON => 11, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'USER_ID' => 1, 'PROJECT_ID' => 2, 'VERSION' => 3, 'TYPE' => 4, 'NAME' => 5, 'STATUS' => 6, 'DOCUMENT' => 7, 'CREATED_BY' => 8, 'CREATED_ON' => 9, 'MODIFIED_BY' => 10, 'MODIFIED_ON' => 11, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'user_id' => 1, 'project_id' => 2, 'version' => 3, 'type' => 4, 'name' => 5, 'status' => 6, 'document' => 7, 'created_by' => 8, 'created_on' => 9, 'modified_by' => 10, 'modified_on' => 11, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = ProjectdocumentPeer::getFieldNames($toType);
        $key = isset(ProjectdocumentPeer::$fieldKeys[$fromType][$name]) ? ProjectdocumentPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ProjectdocumentPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, ProjectdocumentPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ProjectdocumentPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. ProjectdocumentPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ProjectdocumentPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ProjectdocumentPeer::ID);
            $criteria->addSelectColumn(ProjectdocumentPeer::USER_ID);
            $criteria->addSelectColumn(ProjectdocumentPeer::PROJECT_ID);
            $criteria->addSelectColumn(ProjectdocumentPeer::VERSION);
            $criteria->addSelectColumn(ProjectdocumentPeer::TYPE);
            $criteria->addSelectColumn(ProjectdocumentPeer::NAME);
            $criteria->addSelectColumn(ProjectdocumentPeer::STATUS);
            $criteria->addSelectColumn(ProjectdocumentPeer::DOCUMENT);
            $criteria->addSelectColumn(ProjectdocumentPeer::CREATED_BY);
            $criteria->addSelectColumn(ProjectdocumentPeer::CREATED_ON);
            $criteria->addSelectColumn(ProjectdocumentPeer::MODIFIED_BY);
            $criteria->addSelectColumn(ProjectdocumentPeer::MODIFIED_ON);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.PROJECT_ID');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.TYPE');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.STATUS');
            $criteria->addSelectColumn($alias . '.DOCUMENT');
            $criteria->addSelectColumn($alias . '.CREATED_BY');
            $criteria->addSelectColumn($alias . '.CREATED_ON');
            $criteria->addSelectColumn($alias . '.MODIFIED_BY');
            $criteria->addSelectColumn($alias . '.MODIFIED_ON');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return                 Projectdocument
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ProjectdocumentPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ProjectdocumentPeer::populateObjects(ProjectdocumentPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement durirectly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param      Projectdocument $obj A Projectdocument object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getUserId(), (string) $obj->getProjectId()));
            } // if key === null
            ProjectdocumentPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Projectdocument object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Projectdocument) {
                $key = serialize(array((string) $value->getId(), (string) $value->getUserId(), (string) $value->getProjectId()));
            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key
                $key = serialize(array((string) $value[0], (string) $value[1], (string) $value[2]));
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Projectdocument object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ProjectdocumentPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Projectdocument Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ProjectdocumentPeer::$instances[$key])) {
                return ProjectdocumentPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }
    
    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool()
    {
        ProjectdocumentPeer::$instances = array();
    }
    
    /**
     * Method to invalidate the instance pool of all tables related to ProjectDocument
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null && $row[$startcol + 1] === null && $row[$startcol + 2] === null) {
            return null;
        }

        return serialize(array((string) $row[$startcol], (string) $row[$startcol + 1], (string) $row[$startcol + 2]));
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return array((int) $row[$startcol], (int) $row[$startcol + 1], (int) $row[$startcol + 2]);
    }
    
    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = ProjectdocumentPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ProjectdocumentPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProjectdocumentPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Projectdocument object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ProjectdocumentPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProjectdocumentPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ProjectdocumentPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Project table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinProject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Projectdocument objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Projectdocument objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);
        }

        ProjectdocumentPeer::addSelectColumns($criteria);
        $startcol = ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProjectdocumentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ProjectdocumentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProjectdocumentPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Projectdocument) to $obj2 (User)
                $obj2->addProjectdocument($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Projectdocument objects pre-filled with their Project objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Projectdocument objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinProject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);
        }

        ProjectdocumentPeer::addSelectColumns($criteria);
        $startcol = ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;
        ProjectPeer::addSelectColumns($criteria);

        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProjectdocumentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ProjectdocumentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProjectdocumentPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ProjectPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ProjectPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ProjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ProjectPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Projectdocument) to $obj2 (Project)
                $obj2->addProjectdocument($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Projectdocument objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Projectdocument objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);
        }

        ProjectdocumentPeer::addSelectColumns($criteria);
        $startcol2 = ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + UserPeer::NUM_HYDRATE_COLUMNS;

        ProjectPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ProjectPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProjectdocumentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ProjectdocumentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProjectdocumentPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined User rows

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Projectdocument) to the collection in $obj2 (User)
                $obj2->addProjectdocument($obj1);
            } // if joined row not null

            // Add objects for joined Project rows

            $key3 = ProjectPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = ProjectPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = ProjectPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ProjectPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Projectdocument) to the collection in $obj3 (Project)
                $obj3->addProjectdocument($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
    
        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Project table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptProject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ProjectdocumentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
    
        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Projectdocument objects pre-filled with all related objects except User.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Projectdocument objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);
        }

        ProjectdocumentPeer::addSelectColumns($criteria);
        $startcol2 = ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;

        ProjectPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ProjectPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ProjectdocumentPeer::PROJECT_ID, ProjectPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProjectdocumentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ProjectdocumentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProjectdocumentPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Project rows

                $key2 = ProjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ProjectPeer::getInstanceFromPool($key2);
                    if (!$obj2) {
    
                        $cls = ProjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ProjectPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Projectdocument) to the collection in $obj2 (Project)
                $obj2->addProjectdocument($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Projectdocument objects pre-filled with all related objects except Project.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Projectdocument objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptProject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);
        }

        ProjectdocumentPeer::addSelectColumns($criteria);
        $startcol2 = ProjectdocumentPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ProjectdocumentPeer::USER_ID, UserPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ProjectdocumentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ProjectdocumentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ProjectdocumentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ProjectdocumentPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined User rows

                $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = UserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {
    
                        $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Projectdocument) to the collection in $obj2 (User)
                $obj2->addProjectdocument($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(ProjectdocumentPeer::DATABASE_NAME)->getTable(ProjectdocumentPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseProjectdocumentPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseProjectdocumentPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new ProjectdocumentTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass()
    {
        return ProjectdocumentPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Projectdocument or Criteria object.
     *
     * @param      mixed $values Criteria or Projectdocument object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Projectdocument object
        }

        if ($criteria->containsKey(ProjectdocumentPeer::ID) && $criteria->keyContainsValue(ProjectdocumentPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ProjectdocumentPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Projectdocument or Criteria object.
     *
     * @param      mixed $values Criteria or Projectdocument object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ProjectdocumentPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ProjectdocumentPeer::ID);
            $value = $criteria->remove(ProjectdocumentPeer::ID);
            if ($value) {
                $selectCriteria->add(ProjectdocumentPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(ProjectdocumentPeer::USER_ID);
            $value = $criteria->remove(ProjectdocumentPeer::USER_ID);
            if ($value) {
                $selectCriteria->add(ProjectdocumentPeer::USER_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(ProjectdocumentPeer::PROJECT_ID);
            $value = $criteria->remove(ProjectdocumentPeer::PROJECT_ID);
            if ($value) {
                $selectCriteria->add(ProjectdocumentPeer::PROJECT_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ProjectdocumentPeer::TABLE_NAME);
            }

        } else { // $values is Projectdocument object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the ProjectDocument table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ProjectdocumentPeer::TABLE_NAME, $con, ProjectdocumentPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProjectdocumentPeer::clearInstancePool();
            ProjectdocumentPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Projectdocument or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Projectdocument object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ProjectdocumentPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Projectdocument) { // it's a model object
            // invalidate the cache for this single object
            ProjectdocumentPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProjectdocumentPeer::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(ProjectdocumentPeer::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(ProjectdocumentPeer::USER_ID, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(ProjectdocumentPeer::PROJECT_ID, $value[2]));
                $criteria->addOr($criterion);
                // we can invalidate the cache for this single PK
                ProjectdocumentPeer::removeInstanceFromPool($value);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ProjectdocumentPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            
            $affectedRows += BasePeer::doDelete($criteria, $con);
            ProjectdocumentPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Projectdocument object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Projectdocument $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ProjectdocumentPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ProjectdocumentPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(ProjectdocumentPeer::DATABASE_NAME, ProjectdocumentPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve object using using composite pkey values.
     * @param   int $id
     * @param   int $user_id
     * @param   int $project_id
     * @param      PropelPDO $con
     * @return   Projectdocument
     */
    public static function retrieveByPK($id, $user_id, $project_id, PropelPDO $con = null) {
        $_instancePoolKey = serialize(array((string) $id, (string) $user_id, (string) $project_id));
         if (null !== ($obj = ProjectdocumentPeer::getInstanceFromPool($_instancePoolKey))) {
             return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $criteria = new Criteria(ProjectdocumentPeer::DATABASE_NAME);
        $criteria->add(ProjectdocumentPeer::ID, $id);
        $criteria->add(ProjectdocumentPeer::USER_ID, $user_id);
        $criteria->add(ProjectdocumentPeer::PROJECT_ID, $project_id);
        $v = ProjectdocumentPeer::doSelect($criteria, $con);

        return !empty($v) ? $v[0] : null;
    }
} // BaseProjectdocumentPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseProjectdocumentPeer::buildTableMap();

