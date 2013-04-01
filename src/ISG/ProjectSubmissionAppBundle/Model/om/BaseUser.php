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
use ISG\ProjectSubmissionAppBundle\Model\Profileuser;
use ISG\ProjectSubmissionAppBundle\Model\ProfileuserQuery;
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\ProjectQuery;
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentQuery;
use ISG\ProjectSubmissionAppBundle\Model\Projectmark;
use ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery;
use ISG\ProjectSubmissionAppBundle\Model\Role;
use ISG\ProjectSubmissionAppBundle\Model\RoleQuery;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserPeer;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;

abstract class BaseUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ISG\\ProjectSubmissionAppBundle\\Model\\UserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UserPeer
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
     * The value for the user_email field.
     * @var        string
     */
    protected $user_email;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the user_firstname field.
     * @var        string
     */
    protected $user_firstname;

    /**
     * The value for the user_lastname field.
     * @var        string
     */
    protected $user_lastname;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the salt field.
     * @var        int
     */
    protected $salt;

    /**
     * The value for the phone_number field.
     * @var        int
     */
    protected $phone_number;

    /**
     * The value for the supervisor_quota_1 field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $supervisor_quota_1;

    /**
     * The value for the role_id field.
     * @var        int
     */
    protected $role_id;

    /**
     * The value for the status field.
     * @var        string
     */
    protected $status;

    /**
     * The value for the project_year field.
     * @var        string
     */
    protected $project_year;

    /**
     * The value for the department field.
     * @var        string
     */
    protected $department;

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
     * The value for the supervisor_quota_2 field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $supervisor_quota_2;

    /**
     * The value for the quota_used_1 field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $quota_used_1;

    /**
     * The value for the quota_used_2 field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $quota_used_2;

    /**
     * @var        Role
     */
    protected $aRole;

    /**
     * @var        PropelObjectCollection|Profileuser[] Collection to store aggregation of Profileuser objects.
     */
    protected $collProfileusers;
    protected $collProfileusersPartial;

    /**
     * @var        PropelObjectCollection|Project[] Collection to store aggregation of Project objects.
     */
    protected $collProjects;
    protected $collProjectsPartial;

    /**
     * @var        PropelObjectCollection|Email[] Collection to store aggregation of Email objects.
     */
    protected $collEmails;
    protected $collEmailsPartial;

    /**
     * @var        PropelObjectCollection|Projectmark[] Collection to store aggregation of Projectmark objects.
     */
    protected $collProjectmarksRelatedByUserId;
    protected $collProjectmarksRelatedByUserIdPartial;

    /**
     * @var        PropelObjectCollection|Projectmark[] Collection to store aggregation of Projectmark objects.
     */
    protected $collProjectmarksRelatedByEvaluatorId;
    protected $collProjectmarksRelatedByEvaluatorIdPartial;

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
    protected $profileusersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $emailsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectmarksRelatedByUserIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectmarksRelatedByEvaluatorIdScheduledForDeletion = null;

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
        $this->supervisor_quota_1 = 0;
        $this->supervisor_quota_2 = 0;
        $this->quota_used_1 = 0;
        $this->quota_used_2 = 0;
    }

    /**
     * Initializes internal state of BaseUser object.
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
     * Get the [user_email] column value.
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [user_firstname] column value.
     *
     * @return string
     */
    public function getUserFirstname()
    {
        return $this->user_firstname;
    }

    /**
     * Get the [user_lastname] column value.
     *
     * @return string
     */
    public function getUserLastname()
    {
        return $this->user_lastname;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [salt] column value.
     *
     * @return int
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get the [phone_number] column value.
     *
     * @return int
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Get the [supervisor_quota_1] column value.
     *
     * @return int
     */
    public function getSupervisorQuota1()
    {
        return $this->supervisor_quota_1;
    }

    /**
     * Get the [role_id] column value.
     *
     * @return int
     */
    public function getRoleId()
    {
        return $this->role_id;
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
     * Get the [project_year] column value.
     *
     * @return string
     */
    public function getProjectYear()
    {
        return $this->project_year;
    }

    /**
     * Get the [department] column value.
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
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
     * Get the [supervisor_quota_2] column value.
     *
     * @return int
     */
    public function getSupervisorQuota2()
    {
        return $this->supervisor_quota_2;
    }

    /**
     * Get the [quota_used_1] column value.
     *
     * @return int
     */
    public function getQuotaUsed1()
    {
        return $this->quota_used_1;
    }

    /**
     * Get the [quota_used_2] column value.
     *
     * @return int
     */
    public function getQuotaUsed2()
    {
        return $this->quota_used_2;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = UserPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [user_email] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_email !== $v) {
            $this->user_email = $v;
            $this->modifiedColumns[] = UserPeer::USER_EMAIL;
        }


        return $this;
    } // setUserEmail()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = UserPeer::USERNAME;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [user_firstname] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_firstname !== $v) {
            $this->user_firstname = $v;
            $this->modifiedColumns[] = UserPeer::USER_FIRSTNAME;
        }


        return $this;
    } // setUserFirstname()

    /**
     * Set the value of [user_lastname] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUserLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_lastname !== $v) {
            $this->user_lastname = $v;
            $this->modifiedColumns[] = UserPeer::USER_LASTNAME;
        }


        return $this;
    } // setUserLastname()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[] = UserPeer::PASSWORD;
        }


        return $this;
    } // setPassword()

    /**
     * Set the value of [salt] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setSalt($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->salt !== $v) {
            $this->salt = $v;
            $this->modifiedColumns[] = UserPeer::SALT;
        }


        return $this;
    } // setSalt()

    /**
     * Set the value of [phone_number] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setPhoneNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->phone_number !== $v) {
            $this->phone_number = $v;
            $this->modifiedColumns[] = UserPeer::PHONE_NUMBER;
        }


        return $this;
    } // setPhoneNumber()

    /**
     * Set the value of [supervisor_quota_1] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setSupervisorQuota1($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supervisor_quota_1 !== $v) {
            $this->supervisor_quota_1 = $v;
            $this->modifiedColumns[] = UserPeer::SUPERVISOR_QUOTA_1;
        }


        return $this;
    } // setSupervisorQuota1()

    /**
     * Set the value of [role_id] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setRoleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role_id !== $v) {
            $this->role_id = $v;
            $this->modifiedColumns[] = UserPeer::ROLE_ID;
        }

        if ($this->aRole !== null && $this->aRole->getId() !== $v) {
            $this->aRole = null;
        }


        return $this;
    } // setRoleId()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = UserPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Set the value of [project_year] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setProjectYear($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->project_year !== $v) {
            $this->project_year = $v;
            $this->modifiedColumns[] = UserPeer::PROJECT_YEAR;
        }


        return $this;
    } // setProjectYear()

    /**
     * Set the value of [department] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setDepartment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->department !== $v) {
            $this->department = $v;
            $this->modifiedColumns[] = UserPeer::DEPARTMENT;
        }


        return $this;
    } // setDepartment()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[] = UserPeer::CREATED_BY;
        }


        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [created_on] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setCreatedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_on !== null || $dt !== null) {
            $currentDateAsString = ($this->created_on !== null && $tmpDt = new DateTime($this->created_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_on = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::CREATED_ON;
            }
        } // if either are not null


        return $this;
    } // setCreatedOn()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[] = UserPeer::MODIFIED_BY;
        }


        return $this;
    } // setModifiedBy()

    /**
     * Sets the value of [modified_on] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setModifiedOn($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_on !== null || $dt !== null) {
            $currentDateAsString = ($this->modified_on !== null && $tmpDt = new DateTime($this->modified_on)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->modified_on = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::MODIFIED_ON;
            }
        } // if either are not null


        return $this;
    } // setModifiedOn()

    /**
     * Set the value of [supervisor_quota_2] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setSupervisorQuota2($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->supervisor_quota_2 !== $v) {
            $this->supervisor_quota_2 = $v;
            $this->modifiedColumns[] = UserPeer::SUPERVISOR_QUOTA_2;
        }


        return $this;
    } // setSupervisorQuota2()

    /**
     * Set the value of [quota_used_1] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setQuotaUsed1($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quota_used_1 !== $v) {
            $this->quota_used_1 = $v;
            $this->modifiedColumns[] = UserPeer::QUOTA_USED_1;
        }


        return $this;
    } // setQuotaUsed1()

    /**
     * Set the value of [quota_used_2] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setQuotaUsed2($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quota_used_2 !== $v) {
            $this->quota_used_2 = $v;
            $this->modifiedColumns[] = UserPeer::QUOTA_USED_2;
        }


        return $this;
    } // setQuotaUsed2()

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
            if ($this->supervisor_quota_1 !== 0) {
                return false;
            }

            if ($this->supervisor_quota_2 !== 0) {
                return false;
            }

            if ($this->quota_used_1 !== 0) {
                return false;
            }

            if ($this->quota_used_2 !== 0) {
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
            $this->user_email = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->username = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->user_firstname = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->user_lastname = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->password = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->salt = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->phone_number = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->supervisor_quota_1 = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->role_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->status = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->project_year = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->department = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->created_by = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->created_on = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->modified_by = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->modified_on = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->supervisor_quota_2 = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->quota_used_1 = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
            $this->quota_used_2 = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 20; // 20 = UserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating User object", $e);
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

        if ($this->aRole !== null && $this->role_id !== $this->aRole->getId()) {
            $this->aRole = null;
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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRole = null;
            $this->collProfileusers = null;

            $this->collProjects = null;

            $this->collEmails = null;

            $this->collProjectmarksRelatedByUserId = null;

            $this->collProjectmarksRelatedByEvaluatorId = null;

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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UserQuery::create()
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
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                UserPeer::addInstanceToPool($this);
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

            if ($this->aRole !== null) {
                if ($this->aRole->isModified() || $this->aRole->isNew()) {
                    $affectedRows += $this->aRole->save($con);
                }
                $this->setRole($this->aRole);
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

            if ($this->projectsScheduledForDeletion !== null) {
                if (!$this->projectsScheduledForDeletion->isEmpty()) {
                    ProjectQuery::create()
                        ->filterByPrimaryKeys($this->projectsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectsScheduledForDeletion = null;
                }
            }

            if ($this->collProjects !== null) {
                foreach ($this->collProjects as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->projectmarksRelatedByUserIdScheduledForDeletion !== null) {
                if (!$this->projectmarksRelatedByUserIdScheduledForDeletion->isEmpty()) {
                    ProjectmarkQuery::create()
                        ->filterByPrimaryKeys($this->projectmarksRelatedByUserIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectmarksRelatedByUserIdScheduledForDeletion = null;
                }
            }

            if ($this->collProjectmarksRelatedByUserId !== null) {
                foreach ($this->collProjectmarksRelatedByUserId as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectmarksRelatedByEvaluatorIdScheduledForDeletion !== null) {
                if (!$this->projectmarksRelatedByEvaluatorIdScheduledForDeletion->isEmpty()) {
                    ProjectmarkQuery::create()
                        ->filterByPrimaryKeys($this->projectmarksRelatedByEvaluatorIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion = null;
                }
            }

            if ($this->collProjectmarksRelatedByEvaluatorId !== null) {
                foreach ($this->collProjectmarksRelatedByEvaluatorId as $referrerFK) {
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

        $this->modifiedColumns[] = UserPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(UserPeer::USER_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`USER_EMAIL`';
        }
        if ($this->isColumnModified(UserPeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`USERNAME`';
        }
        if ($this->isColumnModified(UserPeer::USER_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`USER_FIRSTNAME`';
        }
        if ($this->isColumnModified(UserPeer::USER_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`USER_LASTNAME`';
        }
        if ($this->isColumnModified(UserPeer::PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`PASSWORD`';
        }
        if ($this->isColumnModified(UserPeer::SALT)) {
            $modifiedColumns[':p' . $index++]  = '`SALT`';
        }
        if ($this->isColumnModified(UserPeer::PHONE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = '`PHONE_NUMBER`';
        }
        if ($this->isColumnModified(UserPeer::SUPERVISOR_QUOTA_1)) {
            $modifiedColumns[':p' . $index++]  = '`SUPERVISOR_QUOTA_1`';
        }
        if ($this->isColumnModified(UserPeer::ROLE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ROLE_ID`';
        }
        if ($this->isColumnModified(UserPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`STATUS`';
        }
        if ($this->isColumnModified(UserPeer::PROJECT_YEAR)) {
            $modifiedColumns[':p' . $index++]  = '`PROJECT_YEAR`';
        }
        if ($this->isColumnModified(UserPeer::DEPARTMENT)) {
            $modifiedColumns[':p' . $index++]  = '`DEPARTMENT`';
        }
        if ($this->isColumnModified(UserPeer::CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_BY`';
        }
        if ($this->isColumnModified(UserPeer::CREATED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_ON`';
        }
        if ($this->isColumnModified(UserPeer::MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_BY`';
        }
        if ($this->isColumnModified(UserPeer::MODIFIED_ON)) {
            $modifiedColumns[':p' . $index++]  = '`MODIFIED_ON`';
        }
        if ($this->isColumnModified(UserPeer::SUPERVISOR_QUOTA_2)) {
            $modifiedColumns[':p' . $index++]  = '`SUPERVISOR_QUOTA_2`';
        }
        if ($this->isColumnModified(UserPeer::QUOTA_USED_1)) {
            $modifiedColumns[':p' . $index++]  = '`QUOTA_USED_1`';
        }
        if ($this->isColumnModified(UserPeer::QUOTA_USED_2)) {
            $modifiedColumns[':p' . $index++]  = '`QUOTA_USED_2`';
        }

        $sql = sprintf(
            'INSERT INTO `User` (%s) VALUES (%s)',
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
                    case '`USER_EMAIL`':
                        $stmt->bindValue($identifier, $this->user_email, PDO::PARAM_STR);
                        break;
                    case '`USERNAME`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`USER_FIRSTNAME`':
                        $stmt->bindValue($identifier, $this->user_firstname, PDO::PARAM_STR);
                        break;
                    case '`USER_LASTNAME`':
                        $stmt->bindValue($identifier, $this->user_lastname, PDO::PARAM_STR);
                        break;
                    case '`PASSWORD`':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case '`SALT`':
                        $stmt->bindValue($identifier, $this->salt, PDO::PARAM_INT);
                        break;
                    case '`PHONE_NUMBER`':
                        $stmt->bindValue($identifier, $this->phone_number, PDO::PARAM_INT);
                        break;
                    case '`SUPERVISOR_QUOTA_1`':
                        $stmt->bindValue($identifier, $this->supervisor_quota_1, PDO::PARAM_INT);
                        break;
                    case '`ROLE_ID`':
                        $stmt->bindValue($identifier, $this->role_id, PDO::PARAM_INT);
                        break;
                    case '`STATUS`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case '`PROJECT_YEAR`':
                        $stmt->bindValue($identifier, $this->project_year, PDO::PARAM_STR);
                        break;
                    case '`DEPARTMENT`':
                        $stmt->bindValue($identifier, $this->department, PDO::PARAM_STR);
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
                    case '`SUPERVISOR_QUOTA_2`':
                        $stmt->bindValue($identifier, $this->supervisor_quota_2, PDO::PARAM_INT);
                        break;
                    case '`QUOTA_USED_1`':
                        $stmt->bindValue($identifier, $this->quota_used_1, PDO::PARAM_INT);
                        break;
                    case '`QUOTA_USED_2`':
                        $stmt->bindValue($identifier, $this->quota_used_2, PDO::PARAM_INT);
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

            if ($this->aRole !== null) {
                if (!$this->aRole->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aRole->getValidationFailures());
                }
            }


            if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collProfileusers !== null) {
                    foreach ($this->collProfileusers as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjects !== null) {
                    foreach ($this->collProjects as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collEmails !== null) {
                    foreach ($this->collEmails as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectmarksRelatedByUserId !== null) {
                    foreach ($this->collProjectmarksRelatedByUserId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectmarksRelatedByEvaluatorId !== null) {
                    foreach ($this->collProjectmarksRelatedByEvaluatorId as $referrerFK) {
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
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getUserEmail();
                break;
            case 2:
                return $this->getUsername();
                break;
            case 3:
                return $this->getUserFirstname();
                break;
            case 4:
                return $this->getUserLastname();
                break;
            case 5:
                return $this->getPassword();
                break;
            case 6:
                return $this->getSalt();
                break;
            case 7:
                return $this->getPhoneNumber();
                break;
            case 8:
                return $this->getSupervisorQuota1();
                break;
            case 9:
                return $this->getRoleId();
                break;
            case 10:
                return $this->getStatus();
                break;
            case 11:
                return $this->getProjectYear();
                break;
            case 12:
                return $this->getDepartment();
                break;
            case 13:
                return $this->getCreatedBy();
                break;
            case 14:
                return $this->getCreatedOn();
                break;
            case 15:
                return $this->getModifiedBy();
                break;
            case 16:
                return $this->getModifiedOn();
                break;
            case 17:
                return $this->getSupervisorQuota2();
                break;
            case 18:
                return $this->getQuotaUsed1();
                break;
            case 19:
                return $this->getQuotaUsed2();
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
        if (isset($alreadyDumpedObjects['User'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][serialize($this->getPrimaryKey())] = true;
        $keys = UserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserEmail(),
            $keys[2] => $this->getUsername(),
            $keys[3] => $this->getUserFirstname(),
            $keys[4] => $this->getUserLastname(),
            $keys[5] => $this->getPassword(),
            $keys[6] => $this->getSalt(),
            $keys[7] => $this->getPhoneNumber(),
            $keys[8] => $this->getSupervisorQuota1(),
            $keys[9] => $this->getRoleId(),
            $keys[10] => $this->getStatus(),
            $keys[11] => $this->getProjectYear(),
            $keys[12] => $this->getDepartment(),
            $keys[13] => $this->getCreatedBy(),
            $keys[14] => $this->getCreatedOn(),
            $keys[15] => $this->getModifiedBy(),
            $keys[16] => $this->getModifiedOn(),
            $keys[17] => $this->getSupervisorQuota2(),
            $keys[18] => $this->getQuotaUsed1(),
            $keys[19] => $this->getQuotaUsed2(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aRole) {
                $result['Role'] = $this->aRole->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collProfileusers) {
                $result['Profileusers'] = $this->collProfileusers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjects) {
                $result['Projects'] = $this->collProjects->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEmails) {
                $result['Emails'] = $this->collEmails->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectmarksRelatedByUserId) {
                $result['ProjectmarksRelatedByUserId'] = $this->collProjectmarksRelatedByUserId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectmarksRelatedByEvaluatorId) {
                $result['ProjectmarksRelatedByEvaluatorId'] = $this->collProjectmarksRelatedByEvaluatorId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setUserEmail($value);
                break;
            case 2:
                $this->setUsername($value);
                break;
            case 3:
                $this->setUserFirstname($value);
                break;
            case 4:
                $this->setUserLastname($value);
                break;
            case 5:
                $this->setPassword($value);
                break;
            case 6:
                $this->setSalt($value);
                break;
            case 7:
                $this->setPhoneNumber($value);
                break;
            case 8:
                $this->setSupervisorQuota1($value);
                break;
            case 9:
                $this->setRoleId($value);
                break;
            case 10:
                $this->setStatus($value);
                break;
            case 11:
                $this->setProjectYear($value);
                break;
            case 12:
                $this->setDepartment($value);
                break;
            case 13:
                $this->setCreatedBy($value);
                break;
            case 14:
                $this->setCreatedOn($value);
                break;
            case 15:
                $this->setModifiedBy($value);
                break;
            case 16:
                $this->setModifiedOn($value);
                break;
            case 17:
                $this->setSupervisorQuota2($value);
                break;
            case 18:
                $this->setQuotaUsed1($value);
                break;
            case 19:
                $this->setQuotaUsed2($value);
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
        $keys = UserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserEmail($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUsername($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUserFirstname($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUserLastname($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPassword($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSalt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPhoneNumber($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setSupervisorQuota1($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setRoleId($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setStatus($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setProjectYear($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setDepartment($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setCreatedBy($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setCreatedOn($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setModifiedBy($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setModifiedOn($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setSupervisorQuota2($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setQuotaUsed1($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setQuotaUsed2($arr[$keys[19]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);

        if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
        if ($this->isColumnModified(UserPeer::USER_EMAIL)) $criteria->add(UserPeer::USER_EMAIL, $this->user_email);
        if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
        if ($this->isColumnModified(UserPeer::USER_FIRSTNAME)) $criteria->add(UserPeer::USER_FIRSTNAME, $this->user_firstname);
        if ($this->isColumnModified(UserPeer::USER_LASTNAME)) $criteria->add(UserPeer::USER_LASTNAME, $this->user_lastname);
        if ($this->isColumnModified(UserPeer::PASSWORD)) $criteria->add(UserPeer::PASSWORD, $this->password);
        if ($this->isColumnModified(UserPeer::SALT)) $criteria->add(UserPeer::SALT, $this->salt);
        if ($this->isColumnModified(UserPeer::PHONE_NUMBER)) $criteria->add(UserPeer::PHONE_NUMBER, $this->phone_number);
        if ($this->isColumnModified(UserPeer::SUPERVISOR_QUOTA_1)) $criteria->add(UserPeer::SUPERVISOR_QUOTA_1, $this->supervisor_quota_1);
        if ($this->isColumnModified(UserPeer::ROLE_ID)) $criteria->add(UserPeer::ROLE_ID, $this->role_id);
        if ($this->isColumnModified(UserPeer::STATUS)) $criteria->add(UserPeer::STATUS, $this->status);
        if ($this->isColumnModified(UserPeer::PROJECT_YEAR)) $criteria->add(UserPeer::PROJECT_YEAR, $this->project_year);
        if ($this->isColumnModified(UserPeer::DEPARTMENT)) $criteria->add(UserPeer::DEPARTMENT, $this->department);
        if ($this->isColumnModified(UserPeer::CREATED_BY)) $criteria->add(UserPeer::CREATED_BY, $this->created_by);
        if ($this->isColumnModified(UserPeer::CREATED_ON)) $criteria->add(UserPeer::CREATED_ON, $this->created_on);
        if ($this->isColumnModified(UserPeer::MODIFIED_BY)) $criteria->add(UserPeer::MODIFIED_BY, $this->modified_by);
        if ($this->isColumnModified(UserPeer::MODIFIED_ON)) $criteria->add(UserPeer::MODIFIED_ON, $this->modified_on);
        if ($this->isColumnModified(UserPeer::SUPERVISOR_QUOTA_2)) $criteria->add(UserPeer::SUPERVISOR_QUOTA_2, $this->supervisor_quota_2);
        if ($this->isColumnModified(UserPeer::QUOTA_USED_1)) $criteria->add(UserPeer::QUOTA_USED_1, $this->quota_used_1);
        if ($this->isColumnModified(UserPeer::QUOTA_USED_2)) $criteria->add(UserPeer::QUOTA_USED_2, $this->quota_used_2);

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
        $criteria = new Criteria(UserPeer::DATABASE_NAME);
        $criteria->add(UserPeer::ID, $this->id);
        $criteria->add(UserPeer::USER_EMAIL, $this->user_email);

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
        $pks[1] = $this->getUserEmail();

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
        $this->setUserEmail($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getId()) && (null === $this->getUserEmail());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of User (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserEmail($this->getUserEmail());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setUserFirstname($this->getUserFirstname());
        $copyObj->setUserLastname($this->getUserLastname());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setSalt($this->getSalt());
        $copyObj->setPhoneNumber($this->getPhoneNumber());
        $copyObj->setSupervisorQuota1($this->getSupervisorQuota1());
        $copyObj->setRoleId($this->getRoleId());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setProjectYear($this->getProjectYear());
        $copyObj->setDepartment($this->getDepartment());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setCreatedOn($this->getCreatedOn());
        $copyObj->setModifiedBy($this->getModifiedBy());
        $copyObj->setModifiedOn($this->getModifiedOn());
        $copyObj->setSupervisorQuota2($this->getSupervisorQuota2());
        $copyObj->setQuotaUsed1($this->getQuotaUsed1());
        $copyObj->setQuotaUsed2($this->getQuotaUsed2());

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

            foreach ($this->getProjects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProject($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEmails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEmail($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectmarksRelatedByUserId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectmarkRelatedByUserId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectmarksRelatedByEvaluatorId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectmarkRelatedByEvaluatorId($relObj->copy($deepCopy));
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
     * @return User Clone of current object.
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
     * @return UserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UserPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Role object.
     *
     * @param             Role $v
     * @return User The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRole(Role $v = null)
    {
        if ($v === null) {
            $this->setRoleId(NULL);
        } else {
            $this->setRoleId($v->getId());
        }

        $this->aRole = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Role object, it will not be re-added.
        if ($v !== null) {
            $v->addUser($this);
        }


        return $this;
    }


    /**
     * Get the associated Role object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Role The associated Role object.
     * @throws PropelException
     */
    public function getRole(PropelPDO $con = null)
    {
        if ($this->aRole === null && ($this->role_id !== null)) {
            $this->aRole = RoleQuery::create()->findPk($this->role_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRole->addUsers($this);
             */
        }

        return $this->aRole;
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
        if ('Project' == $relationName) {
            $this->initProjects();
        }
        if ('Email' == $relationName) {
            $this->initEmails();
        }
        if ('ProjectmarkRelatedByUserId' == $relationName) {
            $this->initProjectmarksRelatedByUserId();
        }
        if ('ProjectmarkRelatedByEvaluatorId' == $relationName) {
            $this->initProjectmarksRelatedByEvaluatorId();
        }
        if ('Projectdocument' == $relationName) {
            $this->initProjectdocuments();
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
     * If this User is new, it will return
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
                    ->filterByUser($this)
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
            $profileuserRemoved->setUser(null);
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
                    ->filterByUser($this)
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
     * @return User The current object (for fluent API support)
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
        $profileuser->setUser($this);
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
            $profileuser->setUser(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Profileusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Profileuser[] List of Profileuser objects
     */
    public function getProfileusersJoinProfile($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProfileuserQuery::create(null, $criteria);
        $query->joinWith('Profile', $join_behavior);

        return $this->getProfileusers($query, $con);
    }

    /**
     * Clears out the collProjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjects()
     */
    public function clearProjects()
    {
        $this->collProjects = null; // important to set this to null since that means it is uninitialized
        $this->collProjectsPartial = null;
    }

    /**
     * reset is the collProjects collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjects($v = true)
    {
        $this->collProjectsPartial = $v;
    }

    /**
     * Initializes the collProjects collection.
     *
     * By default this just sets the collProjects collection to an empty array (like clearcollProjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjects($overrideExisting = true)
    {
        if (null !== $this->collProjects && !$overrideExisting) {
            return;
        }
        $this->collProjects = new PropelObjectCollection();
        $this->collProjects->setModel('Project');
    }

    /**
     * Gets an array of Project objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Project[] List of Project objects
     * @throws PropelException
     */
    public function getProjects($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectsPartial && !$this->isNew();
        if (null === $this->collProjects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjects) {
                // return empty collection
                $this->initProjects();
            } else {
                $collProjects = ProjectQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectsPartial && count($collProjects)) {
                      $this->initProjects(false);

                      foreach($collProjects as $obj) {
                        if (false == $this->collProjects->contains($obj)) {
                          $this->collProjects->append($obj);
                        }
                      }

                      $this->collProjectsPartial = true;
                    }

                    return $collProjects;
                }

                if($partial && $this->collProjects) {
                    foreach($this->collProjects as $obj) {
                        if($obj->isNew()) {
                            $collProjects[] = $obj;
                        }
                    }
                }

                $this->collProjects = $collProjects;
                $this->collProjectsPartial = false;
            }
        }

        return $this->collProjects;
    }

    /**
     * Sets a collection of Project objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projects A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProjects(PropelCollection $projects, PropelPDO $con = null)
    {
        $this->projectsScheduledForDeletion = $this->getProjects(new Criteria(), $con)->diff($projects);

        foreach ($this->projectsScheduledForDeletion as $projectRemoved) {
            $projectRemoved->setUser(null);
        }

        $this->collProjects = null;
        foreach ($projects as $project) {
            $this->addProject($project);
        }

        $this->collProjects = $projects;
        $this->collProjectsPartial = false;
    }

    /**
     * Returns the number of related Project objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Project objects.
     * @throws PropelException
     */
    public function countProjects(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectsPartial && !$this->isNew();
        if (null === $this->collProjects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjects) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProjects());
                }
                $query = ProjectQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collProjects);
        }
    }

    /**
     * Method called to associate a Project object to this object
     * through the Project foreign key attribute.
     *
     * @param    Project $l Project
     * @return User The current object (for fluent API support)
     */
    public function addProject(Project $l)
    {
        if ($this->collProjects === null) {
            $this->initProjects();
            $this->collProjectsPartial = true;
        }
        if (!$this->collProjects->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProject($l);
        }

        return $this;
    }

    /**
     * @param	Project $project The project object to add.
     */
    protected function doAddProject($project)
    {
        $this->collProjects[]= $project;
        $project->setUser($this);
    }

    /**
     * @param	Project $project The project object to remove.
     */
    public function removeProject($project)
    {
        if ($this->getProjects()->contains($project)) {
            $this->collProjects->remove($this->collProjects->search($project));
            if (null === $this->projectsScheduledForDeletion) {
                $this->projectsScheduledForDeletion = clone $this->collProjects;
                $this->projectsScheduledForDeletion->clear();
            }
            $this->projectsScheduledForDeletion[]= $project;
            $project->setUser(null);
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
     * If this User is new, it will return
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
                    ->filterByUser($this)
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
            $emailRemoved->setUser(null);
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
                    ->filterByUser($this)
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
     * @return User The current object (for fluent API support)
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
        $email->setUser($this);
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
            $email->setUser(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Emails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Email[] List of Email objects
     */
    public function getEmailsJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = EmailQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getEmails($query, $con);
    }

    /**
     * Clears out the collProjectmarksRelatedByUserId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjectmarksRelatedByUserId()
     */
    public function clearProjectmarksRelatedByUserId()
    {
        $this->collProjectmarksRelatedByUserId = null; // important to set this to null since that means it is uninitialized
        $this->collProjectmarksRelatedByUserIdPartial = null;
    }

    /**
     * reset is the collProjectmarksRelatedByUserId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectmarksRelatedByUserId($v = true)
    {
        $this->collProjectmarksRelatedByUserIdPartial = $v;
    }

    /**
     * Initializes the collProjectmarksRelatedByUserId collection.
     *
     * By default this just sets the collProjectmarksRelatedByUserId collection to an empty array (like clearcollProjectmarksRelatedByUserId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectmarksRelatedByUserId($overrideExisting = true)
    {
        if (null !== $this->collProjectmarksRelatedByUserId && !$overrideExisting) {
            return;
        }
        $this->collProjectmarksRelatedByUserId = new PropelObjectCollection();
        $this->collProjectmarksRelatedByUserId->setModel('Projectmark');
    }

    /**
     * Gets an array of Projectmark objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     * @throws PropelException
     */
    public function getProjectmarksRelatedByUserId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksRelatedByUserIdPartial && !$this->isNew();
        if (null === $this->collProjectmarksRelatedByUserId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectmarksRelatedByUserId) {
                // return empty collection
                $this->initProjectmarksRelatedByUserId();
            } else {
                $collProjectmarksRelatedByUserId = ProjectmarkQuery::create(null, $criteria)
                    ->filterByUserRelatedByUserId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectmarksRelatedByUserIdPartial && count($collProjectmarksRelatedByUserId)) {
                      $this->initProjectmarksRelatedByUserId(false);

                      foreach($collProjectmarksRelatedByUserId as $obj) {
                        if (false == $this->collProjectmarksRelatedByUserId->contains($obj)) {
                          $this->collProjectmarksRelatedByUserId->append($obj);
                        }
                      }

                      $this->collProjectmarksRelatedByUserIdPartial = true;
                    }

                    return $collProjectmarksRelatedByUserId;
                }

                if($partial && $this->collProjectmarksRelatedByUserId) {
                    foreach($this->collProjectmarksRelatedByUserId as $obj) {
                        if($obj->isNew()) {
                            $collProjectmarksRelatedByUserId[] = $obj;
                        }
                    }
                }

                $this->collProjectmarksRelatedByUserId = $collProjectmarksRelatedByUserId;
                $this->collProjectmarksRelatedByUserIdPartial = false;
            }
        }

        return $this->collProjectmarksRelatedByUserId;
    }

    /**
     * Sets a collection of ProjectmarkRelatedByUserId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectmarksRelatedByUserId A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProjectmarksRelatedByUserId(PropelCollection $projectmarksRelatedByUserId, PropelPDO $con = null)
    {
        $this->projectmarksRelatedByUserIdScheduledForDeletion = $this->getProjectmarksRelatedByUserId(new Criteria(), $con)->diff($projectmarksRelatedByUserId);

        foreach ($this->projectmarksRelatedByUserIdScheduledForDeletion as $projectmarkRelatedByUserIdRemoved) {
            $projectmarkRelatedByUserIdRemoved->setUserRelatedByUserId(null);
        }

        $this->collProjectmarksRelatedByUserId = null;
        foreach ($projectmarksRelatedByUserId as $projectmarkRelatedByUserId) {
            $this->addProjectmarkRelatedByUserId($projectmarkRelatedByUserId);
        }

        $this->collProjectmarksRelatedByUserId = $projectmarksRelatedByUserId;
        $this->collProjectmarksRelatedByUserIdPartial = false;
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
    public function countProjectmarksRelatedByUserId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksRelatedByUserIdPartial && !$this->isNew();
        if (null === $this->collProjectmarksRelatedByUserId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectmarksRelatedByUserId) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProjectmarksRelatedByUserId());
                }
                $query = ProjectmarkQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUserRelatedByUserId($this)
                    ->count($con);
            }
        } else {
            return count($this->collProjectmarksRelatedByUserId);
        }
    }

    /**
     * Method called to associate a Projectmark object to this object
     * through the Projectmark foreign key attribute.
     *
     * @param    Projectmark $l Projectmark
     * @return User The current object (for fluent API support)
     */
    public function addProjectmarkRelatedByUserId(Projectmark $l)
    {
        if ($this->collProjectmarksRelatedByUserId === null) {
            $this->initProjectmarksRelatedByUserId();
            $this->collProjectmarksRelatedByUserIdPartial = true;
        }
        if (!$this->collProjectmarksRelatedByUserId->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProjectmarkRelatedByUserId($l);
        }

        return $this;
    }

    /**
     * @param	ProjectmarkRelatedByUserId $projectmarkRelatedByUserId The projectmarkRelatedByUserId object to add.
     */
    protected function doAddProjectmarkRelatedByUserId($projectmarkRelatedByUserId)
    {
        $this->collProjectmarksRelatedByUserId[]= $projectmarkRelatedByUserId;
        $projectmarkRelatedByUserId->setUserRelatedByUserId($this);
    }

    /**
     * @param	ProjectmarkRelatedByUserId $projectmarkRelatedByUserId The projectmarkRelatedByUserId object to remove.
     */
    public function removeProjectmarkRelatedByUserId($projectmarkRelatedByUserId)
    {
        if ($this->getProjectmarksRelatedByUserId()->contains($projectmarkRelatedByUserId)) {
            $this->collProjectmarksRelatedByUserId->remove($this->collProjectmarksRelatedByUserId->search($projectmarkRelatedByUserId));
            if (null === $this->projectmarksRelatedByUserIdScheduledForDeletion) {
                $this->projectmarksRelatedByUserIdScheduledForDeletion = clone $this->collProjectmarksRelatedByUserId;
                $this->projectmarksRelatedByUserIdScheduledForDeletion->clear();
            }
            $this->projectmarksRelatedByUserIdScheduledForDeletion[]= $projectmarkRelatedByUserId;
            $projectmarkRelatedByUserId->setUserRelatedByUserId(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ProjectmarksRelatedByUserId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     */
    public function getProjectmarksRelatedByUserIdJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectmarkQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectmarksRelatedByUserId($query, $con);
    }

    /**
     * Clears out the collProjectmarksRelatedByEvaluatorId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProjectmarksRelatedByEvaluatorId()
     */
    public function clearProjectmarksRelatedByEvaluatorId()
    {
        $this->collProjectmarksRelatedByEvaluatorId = null; // important to set this to null since that means it is uninitialized
        $this->collProjectmarksRelatedByEvaluatorIdPartial = null;
    }

    /**
     * reset is the collProjectmarksRelatedByEvaluatorId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectmarksRelatedByEvaluatorId($v = true)
    {
        $this->collProjectmarksRelatedByEvaluatorIdPartial = $v;
    }

    /**
     * Initializes the collProjectmarksRelatedByEvaluatorId collection.
     *
     * By default this just sets the collProjectmarksRelatedByEvaluatorId collection to an empty array (like clearcollProjectmarksRelatedByEvaluatorId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectmarksRelatedByEvaluatorId($overrideExisting = true)
    {
        if (null !== $this->collProjectmarksRelatedByEvaluatorId && !$overrideExisting) {
            return;
        }
        $this->collProjectmarksRelatedByEvaluatorId = new PropelObjectCollection();
        $this->collProjectmarksRelatedByEvaluatorId->setModel('Projectmark');
    }

    /**
     * Gets an array of Projectmark objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     * @throws PropelException
     */
    public function getProjectmarksRelatedByEvaluatorId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksRelatedByEvaluatorIdPartial && !$this->isNew();
        if (null === $this->collProjectmarksRelatedByEvaluatorId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectmarksRelatedByEvaluatorId) {
                // return empty collection
                $this->initProjectmarksRelatedByEvaluatorId();
            } else {
                $collProjectmarksRelatedByEvaluatorId = ProjectmarkQuery::create(null, $criteria)
                    ->filterByUserRelatedByEvaluatorId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectmarksRelatedByEvaluatorIdPartial && count($collProjectmarksRelatedByEvaluatorId)) {
                      $this->initProjectmarksRelatedByEvaluatorId(false);

                      foreach($collProjectmarksRelatedByEvaluatorId as $obj) {
                        if (false == $this->collProjectmarksRelatedByEvaluatorId->contains($obj)) {
                          $this->collProjectmarksRelatedByEvaluatorId->append($obj);
                        }
                      }

                      $this->collProjectmarksRelatedByEvaluatorIdPartial = true;
                    }

                    return $collProjectmarksRelatedByEvaluatorId;
                }

                if($partial && $this->collProjectmarksRelatedByEvaluatorId) {
                    foreach($this->collProjectmarksRelatedByEvaluatorId as $obj) {
                        if($obj->isNew()) {
                            $collProjectmarksRelatedByEvaluatorId[] = $obj;
                        }
                    }
                }

                $this->collProjectmarksRelatedByEvaluatorId = $collProjectmarksRelatedByEvaluatorId;
                $this->collProjectmarksRelatedByEvaluatorIdPartial = false;
            }
        }

        return $this->collProjectmarksRelatedByEvaluatorId;
    }

    /**
     * Sets a collection of ProjectmarkRelatedByEvaluatorId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectmarksRelatedByEvaluatorId A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setProjectmarksRelatedByEvaluatorId(PropelCollection $projectmarksRelatedByEvaluatorId, PropelPDO $con = null)
    {
        $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion = $this->getProjectmarksRelatedByEvaluatorId(new Criteria(), $con)->diff($projectmarksRelatedByEvaluatorId);

        foreach ($this->projectmarksRelatedByEvaluatorIdScheduledForDeletion as $projectmarkRelatedByEvaluatorIdRemoved) {
            $projectmarkRelatedByEvaluatorIdRemoved->setUserRelatedByEvaluatorId(null);
        }

        $this->collProjectmarksRelatedByEvaluatorId = null;
        foreach ($projectmarksRelatedByEvaluatorId as $projectmarkRelatedByEvaluatorId) {
            $this->addProjectmarkRelatedByEvaluatorId($projectmarkRelatedByEvaluatorId);
        }

        $this->collProjectmarksRelatedByEvaluatorId = $projectmarksRelatedByEvaluatorId;
        $this->collProjectmarksRelatedByEvaluatorIdPartial = false;
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
    public function countProjectmarksRelatedByEvaluatorId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectmarksRelatedByEvaluatorIdPartial && !$this->isNew();
        if (null === $this->collProjectmarksRelatedByEvaluatorId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectmarksRelatedByEvaluatorId) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getProjectmarksRelatedByEvaluatorId());
                }
                $query = ProjectmarkQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUserRelatedByEvaluatorId($this)
                    ->count($con);
            }
        } else {
            return count($this->collProjectmarksRelatedByEvaluatorId);
        }
    }

    /**
     * Method called to associate a Projectmark object to this object
     * through the Projectmark foreign key attribute.
     *
     * @param    Projectmark $l Projectmark
     * @return User The current object (for fluent API support)
     */
    public function addProjectmarkRelatedByEvaluatorId(Projectmark $l)
    {
        if ($this->collProjectmarksRelatedByEvaluatorId === null) {
            $this->initProjectmarksRelatedByEvaluatorId();
            $this->collProjectmarksRelatedByEvaluatorIdPartial = true;
        }
        if (!$this->collProjectmarksRelatedByEvaluatorId->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddProjectmarkRelatedByEvaluatorId($l);
        }

        return $this;
    }

    /**
     * @param	ProjectmarkRelatedByEvaluatorId $projectmarkRelatedByEvaluatorId The projectmarkRelatedByEvaluatorId object to add.
     */
    protected function doAddProjectmarkRelatedByEvaluatorId($projectmarkRelatedByEvaluatorId)
    {
        $this->collProjectmarksRelatedByEvaluatorId[]= $projectmarkRelatedByEvaluatorId;
        $projectmarkRelatedByEvaluatorId->setUserRelatedByEvaluatorId($this);
    }

    /**
     * @param	ProjectmarkRelatedByEvaluatorId $projectmarkRelatedByEvaluatorId The projectmarkRelatedByEvaluatorId object to remove.
     */
    public function removeProjectmarkRelatedByEvaluatorId($projectmarkRelatedByEvaluatorId)
    {
        if ($this->getProjectmarksRelatedByEvaluatorId()->contains($projectmarkRelatedByEvaluatorId)) {
            $this->collProjectmarksRelatedByEvaluatorId->remove($this->collProjectmarksRelatedByEvaluatorId->search($projectmarkRelatedByEvaluatorId));
            if (null === $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion) {
                $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion = clone $this->collProjectmarksRelatedByEvaluatorId;
                $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion->clear();
            }
            $this->projectmarksRelatedByEvaluatorIdScheduledForDeletion[]= $projectmarkRelatedByEvaluatorId;
            $projectmarkRelatedByEvaluatorId->setUserRelatedByEvaluatorId(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ProjectmarksRelatedByEvaluatorId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectmark[] List of Projectmark objects
     */
    public function getProjectmarksRelatedByEvaluatorIdJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectmarkQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectmarksRelatedByEvaluatorId($query, $con);
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
     * If this User is new, it will return
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
                    ->filterByUser($this)
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
            $projectdocumentRemoved->setUser(null);
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
                    ->filterByUser($this)
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
     * @return User The current object (for fluent API support)
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
        $projectdocument->setUser($this);
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
            $projectdocument->setUser(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Projectdocuments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectdocument[] List of Projectdocument objects
     */
    public function getProjectdocumentsJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectdocumentQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectdocuments($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->user_email = null;
        $this->username = null;
        $this->user_firstname = null;
        $this->user_lastname = null;
        $this->password = null;
        $this->salt = null;
        $this->phone_number = null;
        $this->supervisor_quota_1 = null;
        $this->role_id = null;
        $this->status = null;
        $this->project_year = null;
        $this->department = null;
        $this->created_by = null;
        $this->created_on = null;
        $this->modified_by = null;
        $this->modified_on = null;
        $this->supervisor_quota_2 = null;
        $this->quota_used_1 = null;
        $this->quota_used_2 = null;
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
            if ($this->collProfileusers) {
                foreach ($this->collProfileusers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjects) {
                foreach ($this->collProjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEmails) {
                foreach ($this->collEmails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectmarksRelatedByUserId) {
                foreach ($this->collProjectmarksRelatedByUserId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectmarksRelatedByEvaluatorId) {
                foreach ($this->collProjectmarksRelatedByEvaluatorId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectdocuments) {
                foreach ($this->collProjectdocuments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collProfileusers instanceof PropelCollection) {
            $this->collProfileusers->clearIterator();
        }
        $this->collProfileusers = null;
        if ($this->collProjects instanceof PropelCollection) {
            $this->collProjects->clearIterator();
        }
        $this->collProjects = null;
        if ($this->collEmails instanceof PropelCollection) {
            $this->collEmails->clearIterator();
        }
        $this->collEmails = null;
        if ($this->collProjectmarksRelatedByUserId instanceof PropelCollection) {
            $this->collProjectmarksRelatedByUserId->clearIterator();
        }
        $this->collProjectmarksRelatedByUserId = null;
        if ($this->collProjectmarksRelatedByEvaluatorId instanceof PropelCollection) {
            $this->collProjectmarksRelatedByEvaluatorId->clearIterator();
        }
        $this->collProjectmarksRelatedByEvaluatorId = null;
        if ($this->collProjectdocuments instanceof PropelCollection) {
            $this->collProjectdocuments->clearIterator();
        }
        $this->collProjectdocuments = null;
        $this->aRole = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'user_email' column
     */
    public function __toString()
    {
        return (string) $this->getUserEmail();
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
