<?php

namespace ISG\ProjectSubmissionAppBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use ISG\ProjectSubmissionAppBundle\Model\Profile;
use ISG\ProjectSubmissionAppBundle\Model\ProfilePeer;
use ISG\ProjectSubmissionAppBundle\Model\ProfileQuery;
use ISG\ProjectSubmissionAppBundle\Model\Profileuser;
use ISG\ProjectSubmissionAppBundle\Model\ProfileuserQuery;

abstract class BaseProfile extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ISG\\ProjectSubmissionAppBundle\\Model\\ProfilePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProfilePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the created_by field.
     * @var        int
     */
    protected $created_by;

    /**
     * The value for the created_on field.
     * @var        string
     */
    protected $created_on;

    /**
     * The value for the modified_by field.
     * @var        int
     */
    protected $modified_by;

    /**
     * The value for the modified_on field.
     * @var        string
     */
    protected $modified_on;

    /**
     * @var        PropelObjectCollection|Profileuser[] Collection to store aggregation of Profileuser objects.
     */
    protected $collProfileusers;
    protected $collProfileusersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $profileusersScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [created_by] column value.
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get the [optionally formatted] temporal [created_on] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedOn($format = null)
    {
        if ($this->created_on === null) {
            return null;
        }

        if ($this->created_on === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->created_on);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_on, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Get the [modified_by] column value.
     *
     * @return int
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * Get the [optionally formatted] temporal [modified_on] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModifiedOn($format = null)
    {
        if ($this->modified_on === null) {
            return null;
        }

        if ($this->modified_on === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->modified_on);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->modified_on, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Profile The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ProfilePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Profile The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProfilePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Profile The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ProfilePeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return Profile The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[] = ProfilePeer::CREATED_BY;
        }


        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Profile The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            $currentDateAsString = ($this->created_on !== null && $tmpDt = new DateTime($this->created_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_on = $newDateAsString;
                $this->modifiedColumns[] = ProfilePeer::CREATED_ON;
            }
        } // if either are not null


        return $this;
    } // setCreatedOn()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return Profile The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[] = ProfilePeer::MODIFIED_BY;
        }


        return $this;
    } // setModifiedBy()

    /**
     * Sets the value of [modified_on] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Profile The current object (for fluent API support)
     */
    public function setModifiedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_on !== null || $dt !== null) {
            $currentDateAsString = ($this->modified_on !== null && $tmpDt = new DateTime($this->modified_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->modified_on = $newDateAsString;
                $this->modifiedColumns[] = ProfilePeer::MODIFIED_ON;
            }
        } // if either are not null


        return $this;
    } // setModifiedOn()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->created_by = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->created_on = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->modified_by = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->modified_on = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ProfilePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Profile object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProfilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProfilePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProfileusers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProfilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProfileQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProfilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProfilePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->profileusersScheduledForDeletion !== null) {
                if (!$this->profileusersScheduledForDeletion->isEmpty()) {
                    ProfileuserQuery::create()
                        ->filterByPrimaryKeys($this->profileusersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->profileusersScheduledForDeletion = null;
                }
            }

            if ($this->collProfileusers !== null) {
                foreach ($this->collProfileusers as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ProfilePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProfilePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProfilePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(ProfilePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`NAME`';
        }
        if ($this->isColumnModified(ProfilePeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`DESCRIPTION`';
        }
        if ($this->isColumnModified(ProfilePeer::CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_BY`';
        }
        if ($this->isColumnModified(ProfilePeer::CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_ON`';
        }
        if ($this->isColumnModified(ProfilePeer::MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_BY`';
        }
        if ($this->isColumnModified(ProfilePeer::MODIFIED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_ON`';
        }

        $sql = sprintf(
            'INSERT INTO `Profile` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`NAME`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`DESCRIPTION`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`CREATED_BY`':
                        $stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
                        break;
                    case '`CREATED_ON`':
                        $stmt->bindValue($identifier, $this->created_on, PDO::PARAM_STR);
                        break;
                    case '`MODIFIED_BY`':
                        $stmt->bindValue($identifier, $this->modified_by, PDO::PARAM_INT);
                        break;
                    case '`MODIFIED_ON`':
                        $stmt->bindValue($identifier, $this->modified_on, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        } else {
            $this->validationFailures = $res;

            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = ProfilePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collProfileusers !== null) {
                    foreach ($this->collProfileusers as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProfilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getCreatedBy();
                break;
            case 4:
                return $this->getCreatedOn();
                break;
            case 5:
                return $this->getModifiedBy();
                break;
            case 6:
                return $this->getModifiedOn();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Profile'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Profile'][$this->getPrimaryKey()] = true;
        $keys = ProfilePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getCreatedBy(),
            $keys[4] => $this->getCreatedOn(),
            $keys[5] => $this->getModifiedBy(),
            $keys[6] => $this->getModifiedOn(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collProfileusers) {
                $result['Profileusers'] = $this->collProfileusers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProfilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setCreatedBy($value);
                break;
            case 4:
                $this->setCreatedOn($value);
                break;
            case 5:
                $this->setModifiedBy($value);
                break;
            case 6:
                $this->setModifiedOn($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ProfilePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCreatedBy($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCreatedOn($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setModifiedBy($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setModifiedOn($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProfilePeer::DATABASE_NAME);

        if ($this->isColumnModified(ProfilePeer::ID)) $criteria->add(ProfilePeer::ID, $this->id);
        if ($this->isColumnModified(ProfilePeer::NAME)) $criteria->add(ProfilePeer::NAME, $this->name);
        if ($this->isColumnModified(ProfilePeer::DESCRIPTION)) $criteria->add(ProfilePeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(ProfilePeer::CREATED_BY)) $criteria->add(ProfilePeer::CREATED_BY, $this->created_by);
        if ($this->isColumnModified(ProfilePeer::CREATED_ON)) $criteria->add(ProfilePeer::CREATED_ON, $this->created_on);
        if ($this->isColumnModified(ProfilePeer::MODIFIED_BY)) $criteria->add(ProfilePeer::MODIFIED_BY, $this->modified_by);
        if ($this->isColumnModified(ProfilePeer::MODIFIED_ON)) $criteria->add(ProfilePeer::MODIFIED_ON, $this->modified_on);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ProfilePeer::DATABASE_NAME);
        $criteria->add(ProfilePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Profile (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setCreatedOn($this->getCreatedOn());
        $copyObj->setModifiedBy($this->getModifiedBy());
        $copyObj->setModifiedOn($this->getModifiedOn());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getProfileusers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProfileuser($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Profile Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return ProfilePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProfilePeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Profileuser' == $relationName) {
            $this->initProfileusers();
        }
    }

    /**
     * Clears out the collProfileusers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProfileusers()
     */
    public function clearProfileusers()
    {
        $this->collProfileusers = null; // important to set this to null since that means it is uninitialized
        $this->collProfileusersPartial = null;
    }

    /**
     * reset is the collProfileusers collection loaded partially
     *
     * @return void
     */
    public function resetPartialProfileusers($v = true)
    {
        $this->collProfileusersPartial = $v;
    }

    /**
     * Initializes the collProfileusers collection.
     *
     * By default this just sets the collProfileusers collection to an empty array (like clearcollProfileusers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProfileusers($overrideExisting = true)
    {
        if (null !== $this->collProfileusers && !$overrideExisting) {
            return;
        }
        $this->collProfileusers = new PropelObjectCollection();
        $this->collProfileusers->setModel('Profileuser');
    }

    /**
     * Gets an array of Profileuser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Profile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Profileuser[] List of Profileuser objects
     * @throws PropelException
     */
    public function getProfileusers($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProfileusersPartial && !$this->isNew();
        if (null === $this->collProfileusers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProfileusers) {
                // return empty collection
                $this->initProfileusers();
            } else {
                $collProfileusers = ProfileuserQuery::create(null, $criteria)
                    ->filterByProfile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProfileusersPartial && count($collProfileusers)) {
                      $this->initProfileusers(false);

                      foreach($collProfileusers as $obj) {
                        if (false == $this->collProfileusers->contains($obj)) {
                          $this->collProfileusers->append($obj);
                        }
                      }

                      $this->collProfileusersPartial = true;
                    }

                    return $collProfileusers;
                }

                if($partial && $this->collProfileusers) {
                    foreach($this->collProfileusers as $obj) {
                        if($obj->isNew()) {
                            $collProfileusers[] = $obj;
                        }
                    }
                }

                $this->collProfileusers = $collProfileusers;
                $this->collProfileusersPartial = false;
            }
        }

        return $this->collProfileusers;
    }

    /**
     * Sets a collection of Profileuser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $profileusers A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProfileusers(PropelCollection $profileusers, PropelPDO $con = null)
    {
        $this->profileusersScheduledForDeletion = $this->getProfileusers(new Criteria(), $con)->diff($profileusers);

        foreach ($this->profileusersScheduledForDeletion as $profileuserRemoved) {
            $profileuserRemoved->setProfile(null);
        }

        $this->collProfileusers = null;
        foreach ($profileusers as $profileuser) {
            $this->addProfileuser($profileuser);
        }

        $this->collProfileusers = $profileusers;
        $this->collProfileusersPartial = false;
    }

    /**
     * Returns the number of related Profileuser objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Profileuser objects.
     * @throws PropelException
     */
    public function countProfileusers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProfileusersPartial && !$this->isNew();
        if (null === $this->collProfileusers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProfileusers) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProfileusers());
                }
                $query = ProfileuserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProfile($this)
                    ->count($con);
            }
        } else {
            return count($this->collProfileusers);
        }
    }

    /**
     * Method called to associate a Profileuser object to this object
     * through the Profileuser foreign key attribute.
     *
     * @param    Profileuser $l Profileuser
     * @return Profile The current object (for fluent API support)
     */
    public function addProfileuser(Profileuser $l)
    {
        if ($this->collProfileusers === null) {
            $this->initProfileusers();
            $this->collProfileusersPartial = true;
        }
        if (!$this->collProfileusers->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProfileuser($l);
        }

        return $this;
    }

    /**
     * @param	Profileuser $profileuser The profileuser object to add.
     */
    protected function doAddProfileuser($profileuser)
    {
        $this->collProfileusers[]= $profileuser;
        $profileuser->setProfile($this);
    }

    /**
     * @param	Profileuser $profileuser The profileuser object to remove.
     */
    public function removeProfileuser($profileuser)
    {
        if ($this->getProfileusers()->contains($profileuser)) {
            $this->collProfileusers->remove($this->collProfileusers->search($profileuser));
            if (null === $this->profileusersScheduledForDeletion) {
                $this->profileusersScheduledForDeletion = clone $this->collProfileusers;
                $this->profileusersScheduledForDeletion->clear();
            }
            $this->profileusersScheduledForDeletion[]= $profileuser;
            $profileuser->setProfile(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Profile is new, it will return
     * an empty collection; or if this Profile has previously
     * been saved, it will retrieve related Profileusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Profile.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Profileuser[] List of Profileuser objects
     */
    public function getProfileusersJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProfileuserQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getProfileusers($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->description = null;
        $this->created_by = null;
        $this->created_on = null;
        $this->modified_by = null;
        $this->modified_on = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collProfileusers) {
                foreach ($this->collProfileusers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collProfileusers instanceof PropelCollection) {
            $this->collProfileusers->clearIterator();
        }
        $this->collProfileusers = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'name' column
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
