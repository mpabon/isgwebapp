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
use ISG\ProjectSubmissionAppBundle\Model\Email;
use ISG\ProjectSubmissionAppBundle\Model\EmailQuery;
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\ProjectPeer;
use ISG\ProjectSubmissionAppBundle\Model\ProjectQuery;
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentQuery;
use ISG\ProjectSubmissionAppBundle\Model\Projectmark;
use ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;

abstract class BaseProject extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ISG\\ProjectSubmissionAppBundle\\Model\\ProjectPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProjectPeer
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
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the supervisor_id field.
     * @var        int
     */
    protected $supervisor_id;

    /**
     * The value for the physical_copy_submitted field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $physical_copy_submitted;

    /**
     * The value for the alternate_email_id field.
     * @var        int
     */
    protected $alternate_email_id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the problem_statement field.
     * @var        string
     */
    protected $problem_statement;

    /**
     * The value for the supervisor_comments field.
     * @var        string
     */
    protected $supervisor_comments;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * The value for the second_marker_id field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $second_marker_id;

    /**
     * The value for the third_marker_id field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $third_marker_id;

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
     * @var        User
     */
    protected $aUser;

    /**
     * @var        PropelObjectCollection|Email[] Collection to store aggregation of Email objects.
     */
    protected $collEmails;
    protected $collEmailsPartial;

    /**
     * @var        PropelObjectCollection|Projectmark[] Collection to store aggregation of Projectmark objects.
     */
    protected $collProjectmarks;
    protected $collProjectmarksPartial;

    /**
     * @var        PropelObjectCollection|Projectdocument[] Collection to store aggregation of Projectdocument objects.
     */
    protected $collProjectdocuments;
    protected $collProjectdocumentsPartial;

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
    protected $emailsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectmarksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectdocumentsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->physical_copy_submitted = 0;
        $this->second_marker_id = 0;
        $this->third_marker_id = 0;
    }

    /**
     * Initializes internal state of BaseProject object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

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
     * Get the [user_id] column value.
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [supervisor_id] column value.
     * 
     * @return int
     */
    public function getSupervisorId()
    {
        return $this->supervisor_id;
    }

    /**
     * Get the [physical_copy_submitted] column value.
     * 
     * @return int
     */
    public function getPhysicalCopySubmitted()
    {
        return $this->physical_copy_submitted;
    }

    /**
     * Get the [alternate_email_id] column value.
     * 
     * @return int
     */
    public function getAlternateEmailId()
    {
        return $this->alternate_email_id;
    }

    /**
     * Get the [title] column value.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [problem_statement] column value.
     * 
     * @return string
     */
    public function getProblemStatement()
    {
        return $this->problem_statement;
    }

    /**
     * Get the [supervisor_comments] column value.
     * 
     * @return string
     */
    public function getSupervisorComments()
    {
        return $this->supervisor_comments;
    }

    /**
     * Get the [status] column value.
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [second_marker_id] column value.
     * 
     * @return int
     */
    public function getSecondMarkerId()
    {
        return $this->second_marker_id;
    }

    /**
     * Get the [third_marker_id] column value.
     * 
     * @return int
     */
    public function getThirdMarkerId()
    {
        return $this->third_marker_id;
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
     * @return Project The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ProjectPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = ProjectPeer::USER_ID;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [supervisor_id] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setSupervisorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supervisor_id !== $v) {
            $this->supervisor_id = $v;
            $this->modifiedColumns[] = ProjectPeer::SUPERVISOR_ID;
        }


        return $this;
    } // setSupervisorId()

    /**
     * Set the value of [physical_copy_submitted] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setPhysicalCopySubmitted($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->physical_copy_submitted !== $v) {
            $this->physical_copy_submitted = $v;
            $this->modifiedColumns[] = ProjectPeer::PHYSICAL_COPY_SUBMITTED;
        }


        return $this;
    } // setPhysicalCopySubmitted()

    /**
     * Set the value of [alternate_email_id] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setAlternateEmailId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->alternate_email_id !== $v) {
            $this->alternate_email_id = $v;
            $this->modifiedColumns[] = ProjectPeer::ALTERNATE_EMAIL_ID;
        }


        return $this;
    } // setAlternateEmailId()

    /**
     * Set the value of [title] column.
     * 
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = ProjectPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [problem_statement] column.
     * 
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setProblemStatement($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->problem_statement !== $v) {
            $this->problem_statement = $v;
            $this->modifiedColumns[] = ProjectPeer::PROBLEM_STATEMENT;
        }


        return $this;
    } // setProblemStatement()

    /**
     * Set the value of [supervisor_comments] column.
     * 
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setSupervisorComments($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->supervisor_comments !== $v) {
            $this->supervisor_comments = $v;
            $this->modifiedColumns[] = ProjectPeer::SUPERVISOR_COMMENTS;
        }


        return $this;
    } // setSupervisorComments()

    /**
     * Set the value of [status] column.
     * 
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = ProjectPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [second_marker_id] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setSecondMarkerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->second_marker_id !== $v) {
            $this->second_marker_id = $v;
            $this->modifiedColumns[] = ProjectPeer::SECOND_MARKER_ID;
        }


        return $this;
    } // setSecondMarkerId()

    /**
     * Set the value of [third_marker_id] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setThirdMarkerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->third_marker_id !== $v) {
            $this->third_marker_id = $v;
            $this->modifiedColumns[] = ProjectPeer::THIRD_MARKER_ID;
        }


        return $this;
    } // setThirdMarkerId()

    /**
     * Set the value of [created_by] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[] = ProjectPeer::CREATED_BY;
        }


        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     * 
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Project The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            $currentDateAsString = ($this->created_on !== null && $tmpDt = new DateTime($this->created_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_on = $newDateAsString;
                $this->modifiedColumns[] = ProjectPeer::CREATED_ON;
            }
        } // if either are not null


        return $this;
    } // setCreatedOn()

    /**
     * Set the value of [modified_by] column.
     * 
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[] = ProjectPeer::MODIFIED_BY;
        }


        return $this;
    } // setModifiedBy()

    /**
     * Sets the value of [modified_on] column to a normalized version of the date/time value specified.
     * 
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Project The current object (for fluent API support)
     */
    public function setModifiedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_on !== null || $dt !== null) {
            $currentDateAsString = ($this->modified_on !== null && $tmpDt = new DateTime($this->modified_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->modified_on = $newDateAsString;
                $this->modifiedColumns[] = ProjectPeer::MODIFIED_ON;
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
            if ($this->physical_copy_submitted !== 0) {
                return false;
            }

            if ($this->second_marker_id !== 0) {
                return false;
            }

            if ($this->third_marker_id !== 0) {
                return false;
            }

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
            $this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->supervisor_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->physical_copy_submitted = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->alternate_email_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->title = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->problem_statement = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->supervisor_comments = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->status = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->second_marker_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->third_marker_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->created_by = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->created_on = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->modified_by = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->modified_on = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = ProjectPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Project object", $e);
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

        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProjectPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->collEmails = null;

            $this->collProjectmarks = null;

            $this->collProjectdocuments = null;

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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProjectQuery::create()
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProjectPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

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

            if ($this->emailsScheduledForDeletion !== null) {
                if (!$this->emailsScheduledForDeletion->isEmpty()) {
                    EmailQuery::create()
                        ->filterByPrimaryKeys($this->emailsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->emailsScheduledForDeletion = null;
                }
            }

            if ($this->collEmails !== null) {
                foreach ($this->collEmails as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectmarksScheduledForDeletion !== null) {
                if (!$this->projectmarksScheduledForDeletion->isEmpty()) {
                    ProjectmarkQuery::create()
                        ->filterByPrimaryKeys($this->projectmarksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectmarksScheduledForDeletion = null;
                }
            }

            if ($this->collProjectmarks !== null) {
                foreach ($this->collProjectmarks as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectdocumentsScheduledForDeletion !== null) {
                if (!$this->projectdocumentsScheduledForDeletion->isEmpty()) {
                    ProjectdocumentQuery::create()
                        ->filterByPrimaryKeys($this->projectdocumentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectdocumentsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectdocuments !== null) {
                foreach ($this->collProjectdocuments as $referrerFK) {
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

        $this->modifiedColumns[] = ProjectPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(ProjectPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`USER_ID`';
        }
        if ($this->isColumnModified(ProjectPeer::SUPERVISOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '`SUPERVISOR_ID`';
        }
        if ($this->isColumnModified(ProjectPeer::PHYSICAL_COPY_SUBMITTED)) {
            $modifiedColumns[':p' . $index++]  = '`PHYSICAL_COPY_SUBMITTED`';
        }
        if ($this->isColumnModified(ProjectPeer::ALTERNATE_EMAIL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ALTERNATE_EMAIL_ID`';
        }
        if ($this->isColumnModified(ProjectPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`TITLE`';
        }
        if ($this->isColumnModified(ProjectPeer::PROBLEM_STATEMENT)) {
            $modifiedColumns[':p' . $index++]  = '`PROBLEM_STATEMENT`';
        }
        if ($this->isColumnModified(ProjectPeer::SUPERVISOR_COMMENTS)) {
            $modifiedColumns[':p' . $index++]  = '`SUPERVISOR_COMMENTS`';
        }
        if ($this->isColumnModified(ProjectPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`STATUS`';
        }
        if ($this->isColumnModified(ProjectPeer::SECOND_MARKER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`SECOND_MARKER_ID`';
        }
        if ($this->isColumnModified(ProjectPeer::THIRD_MARKER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`THIRD_MARKER_ID`';
        }
        if ($this->isColumnModified(ProjectPeer::CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_BY`';
        }
        if ($this->isColumnModified(ProjectPeer::CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_ON`';
        }
        if ($this->isColumnModified(ProjectPeer::MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_BY`';
        }
        if ($this->isColumnModified(ProjectPeer::MODIFIED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_ON`';
        }

        $sql = sprintf(
            'INSERT INTO `Project` (%s) VALUES (%s)',
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
                    case '`USER_ID`':						
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case '`SUPERVISOR_ID`':						
                        $stmt->bindValue($identifier, $this->supervisor_id, PDO::PARAM_INT);
                        break;
                    case '`PHYSICAL_COPY_SUBMITTED`':						
                        $stmt->bindValue($identifier, $this->physical_copy_submitted, PDO::PARAM_INT);
                        break;
                    case '`ALTERNATE_EMAIL_ID`':						
                        $stmt->bindValue($identifier, $this->alternate_email_id, PDO::PARAM_INT);
                        break;
                    case '`TITLE`':						
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`PROBLEM_STATEMENT`':						
                        $stmt->bindValue($identifier, $this->problem_statement, PDO::PARAM_STR);
                        break;
                    case '`SUPERVISOR_COMMENTS`':						
                        $stmt->bindValue($identifier, $this->supervisor_comments, PDO::PARAM_STR);
                        break;
                    case '`STATUS`':						
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case '`SECOND_MARKER_ID`':						
                        $stmt->bindValue($identifier, $this->second_marker_id, PDO::PARAM_INT);
                        break;
                    case '`THIRD_MARKER_ID`':						
                        $stmt->bindValue($identifier, $this->third_marker_id, PDO::PARAM_INT);
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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }


            if (($retval = ProjectPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collEmails !== null) {
                    foreach ($this->collEmails as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectmarks !== null) {
                    foreach ($this->collProjectmarks as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectdocuments !== null) {
                    foreach ($this->collProjectdocuments as $referrerFK) {
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getUserId();
                break;
            case 2:
                return $this->getSupervisorId();
                break;
            case 3:
                return $this->getPhysicalCopySubmitted();
                break;
            case 4:
                return $this->getAlternateEmailId();
                break;
            case 5:
                return $this->getTitle();
                break;
            case 6:
                return $this->getProblemStatement();
                break;
            case 7:
                return $this->getSupervisorComments();
                break;
            case 8:
                return $this->getStatus();
                break;
            case 9:
                return $this->getSecondMarkerId();
                break;
            case 10:
                return $this->getThirdMarkerId();
                break;
            case 11:
                return $this->getCreatedBy();
                break;
            case 12:
                return $this->getCreatedOn();
                break;
            case 13:
                return $this->getModifiedBy();
                break;
            case 14:
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
        if (isset($alreadyDumpedObjects['Project'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Project'][serialize($this->getPrimaryKey())] = true;
        $keys = ProjectPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getSupervisorId(),
            $keys[3] => $this->getPhysicalCopySubmitted(),
            $keys[4] => $this->getAlternateEmailId(),
            $keys[5] => $this->getTitle(),
            $keys[6] => $this->getProblemStatement(),
            $keys[7] => $this->getSupervisorComments(),
            $keys[8] => $this->getStatus(),
            $keys[9] => $this->getSecondMarkerId(),
            $keys[10] => $this->getThirdMarkerId(),
            $keys[11] => $this->getCreatedBy(),
            $keys[12] => $this->getCreatedOn(),
            $keys[13] => $this->getModifiedBy(),
            $keys[14] => $this->getModifiedOn(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collEmails) {
                $result['Emails'] = $this->collEmails->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectmarks) {
                $result['Projectmarks'] = $this->collProjectmarks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectdocuments) {
                $result['Projectdocuments'] = $this->collProjectdocuments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setUserId($value);
                break;
            case 2:
                $this->setSupervisorId($value);
                break;
            case 3:
                $this->setPhysicalCopySubmitted($value);
                break;
            case 4:
                $this->setAlternateEmailId($value);
                break;
            case 5:
                $this->setTitle($value);
                break;
            case 6:
                $this->setProblemStatement($value);
                break;
            case 7:
                $this->setSupervisorComments($value);
                break;
            case 8:
                $this->setStatus($value);
                break;
            case 9:
                $this->setSecondMarkerId($value);
                break;
            case 10:
                $this->setThirdMarkerId($value);
                break;
            case 11:
                $this->setCreatedBy($value);
                break;
            case 12:
                $this->setCreatedOn($value);
                break;
            case 13:
                $this->setModifiedBy($value);
                break;
            case 14:
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
        $keys = ProjectPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setSupervisorId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPhysicalCopySubmitted($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAlternateEmailId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setTitle($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setProblemStatement($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setSupervisorComments($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setStatus($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setSecondMarkerId($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setThirdMarkerId($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setCreatedBy($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setCreatedOn($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setModifiedBy($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setModifiedOn($arr[$keys[14]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProjectPeer::ID)) $criteria->add(ProjectPeer::ID, $this->id);
        if ($this->isColumnModified(ProjectPeer::USER_ID)) $criteria->add(ProjectPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(ProjectPeer::SUPERVISOR_ID)) $criteria->add(ProjectPeer::SUPERVISOR_ID, $this->supervisor_id);
        if ($this->isColumnModified(ProjectPeer::PHYSICAL_COPY_SUBMITTED)) $criteria->add(ProjectPeer::PHYSICAL_COPY_SUBMITTED, $this->physical_copy_submitted);
        if ($this->isColumnModified(ProjectPeer::ALTERNATE_EMAIL_ID)) $criteria->add(ProjectPeer::ALTERNATE_EMAIL_ID, $this->alternate_email_id);
        if ($this->isColumnModified(ProjectPeer::TITLE)) $criteria->add(ProjectPeer::TITLE, $this->title);
        if ($this->isColumnModified(ProjectPeer::PROBLEM_STATEMENT)) $criteria->add(ProjectPeer::PROBLEM_STATEMENT, $this->problem_statement);
        if ($this->isColumnModified(ProjectPeer::SUPERVISOR_COMMENTS)) $criteria->add(ProjectPeer::SUPERVISOR_COMMENTS, $this->supervisor_comments);
        if ($this->isColumnModified(ProjectPeer::STATUS)) $criteria->add(ProjectPeer::STATUS, $this->status);
        if ($this->isColumnModified(ProjectPeer::SECOND_MARKER_ID)) $criteria->add(ProjectPeer::SECOND_MARKER_ID, $this->second_marker_id);
        if ($this->isColumnModified(ProjectPeer::THIRD_MARKER_ID)) $criteria->add(ProjectPeer::THIRD_MARKER_ID, $this->third_marker_id);
        if ($this->isColumnModified(ProjectPeer::CREATED_BY)) $criteria->add(ProjectPeer::CREATED_BY, $this->created_by);
        if ($this->isColumnModified(ProjectPeer::CREATED_ON)) $criteria->add(ProjectPeer::CREATED_ON, $this->created_on);
        if ($this->isColumnModified(ProjectPeer::MODIFIED_BY)) $criteria->add(ProjectPeer::MODIFIED_BY, $this->modified_by);
        if ($this->isColumnModified(ProjectPeer::MODIFIED_ON)) $criteria->add(ProjectPeer::MODIFIED_ON, $this->modified_on);

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
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);
        $criteria->add(ProjectPeer::ID, $this->id);
        $criteria->add(ProjectPeer::USER_ID, $this->user_id);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getUserId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setUserId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getUserId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Project (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setSupervisorId($this->getSupervisorId());
        $copyObj->setPhysicalCopySubmitted($this->getPhysicalCopySubmitted());
        $copyObj->setAlternateEmailId($this->getAlternateEmailId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setProblemStatement($this->getProblemStatement());
        $copyObj->setSupervisorComments($this->getSupervisorComments());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setSecondMarkerId($this->getSecondMarkerId());
        $copyObj->setThirdMarkerId($this->getThirdMarkerId());
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

            foreach ($this->getEmails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEmail($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectmarks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectmark($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectdocuments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectdocument($relObj->copy($deepCopy));
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
     * @return Project Clone of current object.
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
     * @return ProjectPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProjectPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Project The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addProject($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(PropelPDO $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = UserQuery::create()
                ->filterByProject($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addProjects($this);
             */
        }

        return $this->aUser;
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
        if ('Email' == $relationName) {
            $this->initEmails();
        }
        if ('Projectmark' == $relationName) {
            $this->initProjectmarks();
        }
        if ('Projectdocument' == $relationName) {
            $this->initProjectdocuments();
        }
    }

    /**
     * Clears out the collEmails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEmails()
     */
    public function clearEmails()
    {
        $this->collEmails = null; // important to set this to null since that means it is uninitialized
        $this->collEmailsPartial = null;
    }

    /**
     * reset is the collEmails collection loaded partially
     *
     * @return void
     */
    public function resetPartialEmails($v = true)
    {
        $this->collEmailsPartial = $v;
    }

    /**
     * Initializes the collEmails collection.
     *
     * By default this just sets the collEmails collection to an empty array (like clearcollEmails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEmails($overrideExisting = true)
    {
        if (null !== $this->collEmails && !$overrideExisting) {
            return;
        }
        $this->collEmails = new PropelObjectCollection();
        $this->collEmails->setModel('Email');
    }

    /**
     * Gets an array of Email objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Email[] List of Email objects
     * @throws PropelException
     */
    public function getEmails($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collEmailsPartial && !$this->isNew();
        if (null === $this->collEmails || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEmails) {
                // return empty collection
                $this->initEmails();
            } else {
                $collEmails = EmailQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collEmailsPartial && count($collEmails)) {
                      $this->initEmails(false);

                      foreach($collEmails as $obj) {
                        if (false == $this->collEmails->contains($obj)) {
                          $this->collEmails->append($obj);
                        }
                      }

                      $this->collEmailsPartial = true;
                    }

                    return $collEmails;
                }

                if($partial && $this->collEmails) {
                    foreach($this->collEmails as $obj) {
                        if($obj->isNew()) {
                            $collEmails[] = $obj;
                        }
                    }
                }

                $this->collEmails = $collEmails;
                $this->collEmailsPartial = false;
            }
        }

        return $this->collEmails;
    }

    /**
     * Sets a collection of Email objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $emails A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setEmails(PropelCollection $emails, PropelPDO $con = null)
    {
        $this->emailsScheduledForDeletion = $this->getEmails(new Criteria(), $con)->diff($emails);

        foreach ($this->emailsScheduledForDeletion as $emailRemoved) {
            $emailRemoved->setProject(null);
        }

        $this->collEmails = null;
        foreach ($emails as $email) {
            $this->addEmail($email);
        }

        $this->collEmails = $emails;
        $this->collEmailsPartial = false;
    }

    /**
     * Returns the number of related Email objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Email objects.
     * @throws PropelException
     */
    public function countEmails(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collEmailsPartial && !$this->isNew();
        if (null === $this->collEmails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEmails) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getEmails());
                }
                $query = EmailQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProject($this)
                    ->count($con);
            }
        } else {
            return count($this->collEmails);
        }
    }

    /**
     * Method called to associate a Email object to this object
     * through the Email foreign key attribute.
     *
     * @param    Email $l Email
     * @return Project The current object (for fluent API support)
     */
    public function addEmail(Email $l)
    {
        if ($this->collEmails === null) {
            $this->initEmails();
            $this->collEmailsPartial = true;
        }
        if (!$this->collEmails->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddEmail($l);
        }

        return $this;
    }

    /**
     * @param	Email $email The email object to add.
     */
    protected function doAddEmail($email)
    {
        $this->collEmails[]= $email;
        $email->setProject($this);
    }

    /**
     * @param	Email $email The email object to remove.
     */
    public function removeEmail($email)
    {
        if ($this->getEmails()->contains($email)) {
            $this->collEmails->remove($this->collEmails->search($email));
            if (null === $this->emailsScheduledForDeletion) {
                $this->emailsScheduledForDeletion = clone $this->collEmails;
                $this->emailsScheduledForDeletion->clear();
            }
            $this->emailsScheduledForDeletion[]= $email;
            $email->setProject(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Emails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Email[] List of Email objects
     */
    public function getEmailsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = EmailQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getEmails($query, $con);
    }

    /**
     * Clears out the collProjectmarks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjectmarks()
     */
    public function clearProjectmarks()
    {
        $this->collProjectmarks = null; // important to set this to null since that means it is uninitialized
        $this->collProjectmarksPartial = null;
    }

    /**
     * reset is the collProjectmarks collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectmarks($v = true)
    {
        $this->collProjectmarksPartial = $v;
    }

    /**
     * Initializes the collProjectmarks collection.
     *
     * By default this just sets the collProjectmarks collection to an empty array (like clearcollProjectmarks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectmarks($overrideExisting = true)
    {
        if (null !== $this->collProjectmarks && !$overrideExisting) {
            return;
        }
        $this->collProjectmarks = new PropelObjectCollection();
        $this->collProjectmarks->setModel('Projectmark');
    }

    /**
     * Gets an array of Projectmark objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     * @throws PropelException
     */
    public function getProjectmarks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksPartial && !$this->isNew();
        if (null === $this->collProjectmarks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectmarks) {
                // return empty collection
                $this->initProjectmarks();
            } else {
                $collProjectmarks = ProjectmarkQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectmarksPartial && count($collProjectmarks)) {
                      $this->initProjectmarks(false);

                      foreach($collProjectmarks as $obj) {
                        if (false == $this->collProjectmarks->contains($obj)) {
                          $this->collProjectmarks->append($obj);
                        }
                      }

                      $this->collProjectmarksPartial = true;
                    }

                    return $collProjectmarks;
                }

                if($partial && $this->collProjectmarks) {
                    foreach($this->collProjectmarks as $obj) {
                        if($obj->isNew()) {
                            $collProjectmarks[] = $obj;
                        }
                    }
                }

                $this->collProjectmarks = $collProjectmarks;
                $this->collProjectmarksPartial = false;
            }
        }

        return $this->collProjectmarks;
    }

    /**
     * Sets a collection of Projectmark objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectmarks A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProjectmarks(PropelCollection $projectmarks, PropelPDO $con = null)
    {
        $this->projectmarksScheduledForDeletion = $this->getProjectmarks(new Criteria(), $con)->diff($projectmarks);

        foreach ($this->projectmarksScheduledForDeletion as $projectmarkRemoved) {
            $projectmarkRemoved->setProject(null);
        }

        $this->collProjectmarks = null;
        foreach ($projectmarks as $projectmark) {
            $this->addProjectmark($projectmark);
        }

        $this->collProjectmarks = $projectmarks;
        $this->collProjectmarksPartial = false;
    }

    /**
     * Returns the number of related Projectmark objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Projectmark objects.
     * @throws PropelException
     */
    public function countProjectmarks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksPartial && !$this->isNew();
        if (null === $this->collProjectmarks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectmarks) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProjectmarks());
                }
                $query = ProjectmarkQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProject($this)
                    ->count($con);
            }
        } else {
            return count($this->collProjectmarks);
        }
    }

    /**
     * Method called to associate a Projectmark object to this object
     * through the Projectmark foreign key attribute.
     *
     * @param    Projectmark $l Projectmark
     * @return Project The current object (for fluent API support)
     */
    public function addProjectmark(Projectmark $l)
    {
        if ($this->collProjectmarks === null) {
            $this->initProjectmarks();
            $this->collProjectmarksPartial = true;
        }
        if (!$this->collProjectmarks->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProjectmark($l);
        }

        return $this;
    }

    /**
     * @param	Projectmark $projectmark The projectmark object to add.
     */
    protected function doAddProjectmark($projectmark)
    {
        $this->collProjectmarks[]= $projectmark;
        $projectmark->setProject($this);
    }

    /**
     * @param	Projectmark $projectmark The projectmark object to remove.
     */
    public function removeProjectmark($projectmark)
    {
        if ($this->getProjectmarks()->contains($projectmark)) {
            $this->collProjectmarks->remove($this->collProjectmarks->search($projectmark));
            if (null === $this->projectmarksScheduledForDeletion) {
                $this->projectmarksScheduledForDeletion = clone $this->collProjectmarks;
                $this->projectmarksScheduledForDeletion->clear();
            }
            $this->projectmarksScheduledForDeletion[]= $projectmark;
            $projectmark->setProject(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Projectmarks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     */
    public function getProjectmarksJoinUserRelatedByUserId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectmarkQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUserId', $join_behavior);

        return $this->getProjectmarks($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Projectmarks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     */
    public function getProjectmarksJoinUserRelatedByEvaluatorId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectmarkQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByEvaluatorId', $join_behavior);

        return $this->getProjectmarks($query, $con);
    }

    /**
     * Clears out the collProjectdocuments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjectdocuments()
     */
    public function clearProjectdocuments()
    {
        $this->collProjectdocuments = null; // important to set this to null since that means it is uninitialized
        $this->collProjectdocumentsPartial = null;
    }

    /**
     * reset is the collProjectdocuments collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectdocuments($v = true)
    {
        $this->collProjectdocumentsPartial = $v;
    }

    /**
     * Initializes the collProjectdocuments collection.
     *
     * By default this just sets the collProjectdocuments collection to an empty array (like clearcollProjectdocuments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectdocuments($overrideExisting = true)
    {
        if (null !== $this->collProjectdocuments && !$overrideExisting) {
            return;
        }
        $this->collProjectdocuments = new PropelObjectCollection();
        $this->collProjectdocuments->setModel('Projectdocument');
    }

    /**
     * Gets an array of Projectdocument objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectdocument[] List of Projectdocument objects
     * @throws PropelException
     */
    public function getProjectdocuments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectdocumentsPartial && !$this->isNew();
        if (null === $this->collProjectdocuments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectdocuments) {
                // return empty collection
                $this->initProjectdocuments();
            } else {
                $collProjectdocuments = ProjectdocumentQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectdocumentsPartial && count($collProjectdocuments)) {
                      $this->initProjectdocuments(false);

                      foreach($collProjectdocuments as $obj) {
                        if (false == $this->collProjectdocuments->contains($obj)) {
                          $this->collProjectdocuments->append($obj);
                        }
                      }

                      $this->collProjectdocumentsPartial = true;
                    }

                    return $collProjectdocuments;
                }

                if($partial && $this->collProjectdocuments) {
                    foreach($this->collProjectdocuments as $obj) {
                        if($obj->isNew()) {
                            $collProjectdocuments[] = $obj;
                        }
                    }
                }

                $this->collProjectdocuments = $collProjectdocuments;
                $this->collProjectdocumentsPartial = false;
            }
        }

        return $this->collProjectdocuments;
    }

    /**
     * Sets a collection of Projectdocument objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectdocuments A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProjectdocuments(PropelCollection $projectdocuments, PropelPDO $con = null)
    {
        $this->projectdocumentsScheduledForDeletion = $this->getProjectdocuments(new Criteria(), $con)->diff($projectdocuments);

        foreach ($this->projectdocumentsScheduledForDeletion as $projectdocumentRemoved) {
            $projectdocumentRemoved->setProject(null);
        }

        $this->collProjectdocuments = null;
        foreach ($projectdocuments as $projectdocument) {
            $this->addProjectdocument($projectdocument);
        }

        $this->collProjectdocuments = $projectdocuments;
        $this->collProjectdocumentsPartial = false;
    }

    /**
     * Returns the number of related Projectdocument objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Projectdocument objects.
     * @throws PropelException
     */
    public function countProjectdocuments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectdocumentsPartial && !$this->isNew();
        if (null === $this->collProjectdocuments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectdocuments) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProjectdocuments());
                }
                $query = ProjectdocumentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByProject($this)
                    ->count($con);
            }
        } else {
            return count($this->collProjectdocuments);
        }
    }

    /**
     * Method called to associate a Projectdocument object to this object
     * through the Projectdocument foreign key attribute.
     *
     * @param    Projectdocument $l Projectdocument
     * @return Project The current object (for fluent API support)
     */
    public function addProjectdocument(Projectdocument $l)
    {
        if ($this->collProjectdocuments === null) {
            $this->initProjectdocuments();
            $this->collProjectdocumentsPartial = true;
        }
        if (!$this->collProjectdocuments->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProjectdocument($l);
        }

        return $this;
    }

    /**
     * @param	Projectdocument $projectdocument The projectdocument object to add.
     */
    protected function doAddProjectdocument($projectdocument)
    {
        $this->collProjectdocuments[]= $projectdocument;
        $projectdocument->setProject($this);
    }

    /**
     * @param	Projectdocument $projectdocument The projectdocument object to remove.
     */
    public function removeProjectdocument($projectdocument)
    {
        if ($this->getProjectdocuments()->contains($projectdocument)) {
            $this->collProjectdocuments->remove($this->collProjectdocuments->search($projectdocument));
            if (null === $this->projectdocumentsScheduledForDeletion) {
                $this->projectdocumentsScheduledForDeletion = clone $this->collProjectdocuments;
                $this->projectdocumentsScheduledForDeletion->clear();
            }
            $this->projectdocumentsScheduledForDeletion[]= $projectdocument;
            $projectdocument->setProject(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Projectdocuments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectdocument[] List of Projectdocument objects
     */
    public function getProjectdocumentsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectdocumentQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getProjectdocuments($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->user_id = null;
        $this->supervisor_id = null;
        $this->physical_copy_submitted = null;
        $this->alternate_email_id = null;
        $this->title = null;
        $this->problem_statement = null;
        $this->supervisor_comments = null;
        $this->status = null;
        $this->second_marker_id = null;
        $this->third_marker_id = null;
        $this->created_by = null;
        $this->created_on = null;
        $this->modified_by = null;
        $this->modified_on = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collEmails) {
                foreach ($this->collEmails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectmarks) {
                foreach ($this->collProjectmarks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectdocuments) {
                foreach ($this->collProjectdocuments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collEmails instanceof PropelCollection) {
            $this->collEmails->clearIterator();
        }
        $this->collEmails = null;
        if ($this->collProjectmarks instanceof PropelCollection) {
            $this->collProjectmarks->clearIterator();
        }
        $this->collProjectmarks = null;
        if ($this->collProjectdocuments instanceof PropelCollection) {
            $this->collProjectdocuments->clearIterator();
        }
        $this->collProjectdocuments = null;
        $this->aUser = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'title' column
     */
    public function __toString()
    {
        return (string) $this->getTitle();
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
