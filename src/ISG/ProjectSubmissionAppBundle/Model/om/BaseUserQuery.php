<?php

namespace ISG\ProjectSubmissionAppBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use ISG\ProjectSubmissionAppBundle\Model\Email;
use ISG\ProjectSubmissionAppBundle\Model\Profileuser;
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\Projectmark;
use ISG\ProjectSubmissionAppBundle\Model\Role;
use ISG\ProjectSubmissionAppBundle\Model\User;
use ISG\ProjectSubmissionAppBundle\Model\UserPeer;
use ISG\ProjectSubmissionAppBundle\Model\UserQuery;

/**
 * @method UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UserQuery orderByUserEmail($order = Criteria::ASC) Order by the user_email column
 * @method UserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method UserQuery orderByUserFirstname($order = Criteria::ASC) Order by the user_firstname column
 * @method UserQuery orderByUserLastname($order = Criteria::ASC) Order by the user_lastname column
 * @method UserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method UserQuery orderBySalt($order = Criteria::ASC) Order by the salt column
 * @method UserQuery orderBySupervisorQuota1($order = Criteria::ASC) Order by the supervisor_quota_1 column
 * @method UserQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 * @method UserQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method UserQuery orderByProjectYear($order = Criteria::ASC) Order by the project_year column
 * @method UserQuery orderByDepartment($order = Criteria::ASC) Order by the department column
 * @method UserQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method UserQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method UserQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 * @method UserQuery orderByModifiedOn($order = Criteria::ASC) Order by the modified_on column
 * @method UserQuery orderBySupervisorQuota2($order = Criteria::ASC) Order by the supervisor_quota_2 column
 * @method UserQuery orderByQuotaUsed1($order = Criteria::ASC) Order by the quota_used_1 column
 * @method UserQuery orderByQuotaUsed2($order = Criteria::ASC) Order by the quota_used_2 column
 *
 * @method UserQuery groupById() Group by the id column
 * @method UserQuery groupByUserEmail() Group by the user_email column
 * @method UserQuery groupByUsername() Group by the username column
 * @method UserQuery groupByUserFirstname() Group by the user_firstname column
 * @method UserQuery groupByUserLastname() Group by the user_lastname column
 * @method UserQuery groupByPassword() Group by the password column
 * @method UserQuery groupBySalt() Group by the salt column
 * @method UserQuery groupBySupervisorQuota1() Group by the supervisor_quota_1 column
 * @method UserQuery groupByRoleId() Group by the role_id column
 * @method UserQuery groupByStatus() Group by the status column
 * @method UserQuery groupByProjectYear() Group by the project_year column
 * @method UserQuery groupByDepartment() Group by the department column
 * @method UserQuery groupByCreatedBy() Group by the created_by column
 * @method UserQuery groupByCreatedOn() Group by the created_on column
 * @method UserQuery groupByModifiedBy() Group by the modified_by column
 * @method UserQuery groupByModifiedOn() Group by the modified_on column
 * @method UserQuery groupBySupervisorQuota2() Group by the supervisor_quota_2 column
 * @method UserQuery groupByQuotaUsed1() Group by the quota_used_1 column
 * @method UserQuery groupByQuotaUsed2() Group by the quota_used_2 column
 *
 * @method UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserQuery leftJoinRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the Role relation
 * @method UserQuery rightJoinRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Role relation
 * @method UserQuery innerJoinRole($relationAlias = null) Adds a INNER JOIN clause to the query using the Role relation
 *
 * @method UserQuery leftJoinProfileuser($relationAlias = null) Adds a LEFT JOIN clause to the query using the Profileuser relation
 * @method UserQuery rightJoinProfileuser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Profileuser relation
 * @method UserQuery innerJoinProfileuser($relationAlias = null) Adds a INNER JOIN clause to the query using the Profileuser relation
 *
 * @method UserQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method UserQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method UserQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method UserQuery leftJoinEmail($relationAlias = null) Adds a LEFT JOIN clause to the query using the Email relation
 * @method UserQuery rightJoinEmail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Email relation
 * @method UserQuery innerJoinEmail($relationAlias = null) Adds a INNER JOIN clause to the query using the Email relation
 *
 * @method UserQuery leftJoinProjectmarkRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectmarkRelatedByUserId relation
 * @method UserQuery rightJoinProjectmarkRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectmarkRelatedByUserId relation
 * @method UserQuery innerJoinProjectmarkRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectmarkRelatedByUserId relation
 *
 * @method UserQuery leftJoinProjectmarkRelatedByEvaluatorId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectmarkRelatedByEvaluatorId relation
 * @method UserQuery rightJoinProjectmarkRelatedByEvaluatorId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectmarkRelatedByEvaluatorId relation
 * @method UserQuery innerJoinProjectmarkRelatedByEvaluatorId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectmarkRelatedByEvaluatorId relation
 *
 * @method UserQuery leftJoinProjectdocument($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projectdocument relation
 * @method UserQuery rightJoinProjectdocument($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projectdocument relation
 * @method UserQuery innerJoinProjectdocument($relationAlias = null) Adds a INNER JOIN clause to the query using the Projectdocument relation
 *
 * @method User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method User findOneById(int $id) Return the first User filtered by the id column
 * @method User findOneByUserEmail(string $user_email) Return the first User filtered by the user_email column
 * @method User findOneByUsername(string $username) Return the first User filtered by the username column
 * @method User findOneByUserFirstname(string $user_firstname) Return the first User filtered by the user_firstname column
 * @method User findOneByUserLastname(string $user_lastname) Return the first User filtered by the user_lastname column
 * @method User findOneByPassword(string $password) Return the first User filtered by the password column
 * @method User findOneBySalt(int $salt) Return the first User filtered by the salt column
 * @method User findOneBySupervisorQuota1(int $supervisor_quota_1) Return the first User filtered by the supervisor_quota_1 column
 * @method User findOneByRoleId(int $role_id) Return the first User filtered by the role_id column
 * @method User findOneByStatus(string $status) Return the first User filtered by the status column
 * @method User findOneByProjectYear(string $project_year) Return the first User filtered by the project_year column
 * @method User findOneByDepartment(string $department) Return the first User filtered by the department column
 * @method User findOneByCreatedBy(int $created_by) Return the first User filtered by the created_by column
 * @method User findOneByCreatedOn(string $created_on) Return the first User filtered by the created_on column
 * @method User findOneByModifiedBy(int $modified_by) Return the first User filtered by the modified_by column
 * @method User findOneByModifiedOn(string $modified_on) Return the first User filtered by the modified_on column
 * @method User findOneBySupervisorQuota2(int $supervisor_quota_2) Return the first User filtered by the supervisor_quota_2 column
 * @method User findOneByQuotaUsed1(int $quota_used_1) Return the first User filtered by the quota_used_1 column
 * @method User findOneByQuotaUsed2(int $quota_used_2) Return the first User filtered by the quota_used_2 column
 *
 * @method array findById(int $id) Return User objects filtered by the id column
 * @method array findByUserEmail(string $user_email) Return User objects filtered by the user_email column
 * @method array findByUsername(string $username) Return User objects filtered by the username column
 * @method array findByUserFirstname(string $user_firstname) Return User objects filtered by the user_firstname column
 * @method array findByUserLastname(string $user_lastname) Return User objects filtered by the user_lastname column
 * @method array findByPassword(string $password) Return User objects filtered by the password column
 * @method array findBySalt(int $salt) Return User objects filtered by the salt column
 * @method array findBySupervisorQuota1(int $supervisor_quota_1) Return User objects filtered by the supervisor_quota_1 column
 * @method array findByRoleId(int $role_id) Return User objects filtered by the role_id column
 * @method array findByStatus(string $status) Return User objects filtered by the status column
 * @method array findByProjectYear(string $project_year) Return User objects filtered by the project_year column
 * @method array findByDepartment(string $department) Return User objects filtered by the department column
 * @method array findByCreatedBy(int $created_by) Return User objects filtered by the created_by column
 * @method array findByCreatedOn(string $created_on) Return User objects filtered by the created_on column
 * @method array findByModifiedBy(int $modified_by) Return User objects filtered by the modified_by column
 * @method array findByModifiedOn(string $modified_on) Return User objects filtered by the modified_on column
 * @method array findBySupervisorQuota2(int $supervisor_quota_2) Return User objects filtered by the supervisor_quota_2 column
 * @method array findByQuotaUsed1(int $quota_used_1) Return User objects filtered by the quota_used_1 column
 * @method array findByQuotaUsed2(int $quota_used_2) Return User objects filtered by the quota_used_2 column
 */
abstract class BaseUserQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     UserQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserQuery) {
            return $criteria;
        }
        $query = new UserQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $user_email]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   User|User[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   User A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `USER_EMAIL`, `USERNAME`, `USER_FIRSTNAME`, `USER_LASTNAME`, `PASSWORD`, `SALT`, `SUPERVISOR_QUOTA_1`, `ROLE_ID`, `STATUS`, `PROJECT_YEAR`, `DEPARTMENT`, `CREATED_BY`, `CREATED_ON`, `MODIFIED_BY`, `MODIFIED_ON`, `SUPERVISOR_QUOTA_2`, `QUOTA_USED_1`, `QUOTA_USED_2` FROM `User` WHERE `ID` = :p0 AND `USER_EMAIL` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new User();
            $obj->hydrate($row);
            UserPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return User|User[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|User[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(UserPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(UserPeer::USER_EMAIL, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(UserPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(UserPeer::USER_EMAIL, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_email column
     *
     * Example usage:
     * <code>
     * $query->filterByUserEmail('fooValue');   // WHERE user_email = 'fooValue'
     * $query->filterByUserEmail('%fooValue%'); // WHERE user_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserEmail($userEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userEmail)) {
                $userEmail = str_replace('*', '%', $userEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_EMAIL, $userEmail, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the user_firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserFirstname('fooValue');   // WHERE user_firstname = 'fooValue'
     * $query->filterByUserFirstname('%fooValue%'); // WHERE user_firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userFirstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserFirstname($userFirstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userFirstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userFirstname)) {
                $userFirstname = str_replace('*', '%', $userFirstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_FIRSTNAME, $userFirstname, $comparison);
    }

    /**
     * Filter the query on the user_lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByUserLastname('fooValue');   // WHERE user_lastname = 'fooValue'
     * $query->filterByUserLastname('%fooValue%'); // WHERE user_lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userLastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUserLastname($userLastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userLastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userLastname)) {
                $userLastname = str_replace('*', '%', $userLastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USER_LASTNAME, $userLastname, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the salt column
     *
     * Example usage:
     * <code>
     * $query->filterBySalt(1234); // WHERE salt = 1234
     * $query->filterBySalt(array(12, 34)); // WHERE salt IN (12, 34)
     * $query->filterBySalt(array('min' => 12)); // WHERE salt > 12
     * </code>
     *
     * @param     mixed $salt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterBySalt($salt = null, $comparison = null)
    {
        if (is_array($salt)) {
            $useMinMax = false;
            if (isset($salt['min'])) {
                $this->addUsingAlias(UserPeer::SALT, $salt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($salt['max'])) {
                $this->addUsingAlias(UserPeer::SALT, $salt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::SALT, $salt, $comparison);
    }

    /**
     * Filter the query on the supervisor_quota_1 column
     *
     * Example usage:
     * <code>
     * $query->filterBySupervisorQuota1(1234); // WHERE supervisor_quota_1 = 1234
     * $query->filterBySupervisorQuota1(array(12, 34)); // WHERE supervisor_quota_1 IN (12, 34)
     * $query->filterBySupervisorQuota1(array('min' => 12)); // WHERE supervisor_quota_1 > 12
     * </code>
     *
     * @param     mixed $supervisorQuota1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterBySupervisorQuota1($supervisorQuota1 = null, $comparison = null)
    {
        if (is_array($supervisorQuota1)) {
            $useMinMax = false;
            if (isset($supervisorQuota1['min'])) {
                $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_1, $supervisorQuota1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supervisorQuota1['max'])) {
                $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_1, $supervisorQuota1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_1, $supervisorQuota1, $comparison);
    }

    /**
     * Filter the query on the role_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE role_id = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE role_id IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE role_id > 12
     * </code>
     *
     * @see       filterByRole()
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(UserPeer::ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(UserPeer::ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the project_year column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectYear('fooValue');   // WHERE project_year = 'fooValue'
     * $query->filterByProjectYear('%fooValue%'); // WHERE project_year LIKE '%fooValue%'
     * </code>
     *
     * @param     string $projectYear The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByProjectYear($projectYear = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($projectYear)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $projectYear)) {
                $projectYear = str_replace('*', '%', $projectYear);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::PROJECT_YEAR, $projectYear, $comparison);
    }

    /**
     * Filter the query on the department column
     *
     * Example usage:
     * <code>
     * $query->filterByDepartment('fooValue');   // WHERE department = 'fooValue'
     * $query->filterByDepartment('%fooValue%'); // WHERE department LIKE '%fooValue%'
     * </code>
     *
     * @param     string $department The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByDepartment($department = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($department)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $department)) {
                $department = str_replace('*', '%', $department);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::DEPARTMENT, $department, $comparison);
    }

    /**
     * Filter the query on the created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
     * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
     * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by > 12
     * </code>
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy, $comparison);
    }

    /**
     * Filter the query on the created_on column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedOn('2011-03-14'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn('now'); // WHERE created_on = '2011-03-14'
     * $query->filterByCreatedOn(array('max' => 'yesterday')); // WHERE created_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(UserPeer::CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(UserPeer::CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::CREATED_ON, $createdOn, $comparison);
    }

    /**
     * Filter the query on the modified_by column
     *
     * Example usage:
     * <code>
     * $query->filterByModifiedBy(1234); // WHERE modified_by = 1234
     * $query->filterByModifiedBy(array(12, 34)); // WHERE modified_by IN (12, 34)
     * $query->filterByModifiedBy(array('min' => 12)); // WHERE modified_by > 12
     * </code>
     *
     * @param     mixed $modifiedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(UserPeer::MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(UserPeer::MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query on the modified_on column
     *
     * Example usage:
     * <code>
     * $query->filterByModifiedOn('2011-03-14'); // WHERE modified_on = '2011-03-14'
     * $query->filterByModifiedOn('now'); // WHERE modified_on = '2011-03-14'
     * $query->filterByModifiedOn(array('max' => 'yesterday')); // WHERE modified_on > '2011-03-13'
     * </code>
     *
     * @param     mixed $modifiedOn The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByModifiedOn($modifiedOn = null, $comparison = null)
    {
        if (is_array($modifiedOn)) {
            $useMinMax = false;
            if (isset($modifiedOn['min'])) {
                $this->addUsingAlias(UserPeer::MODIFIED_ON, $modifiedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedOn['max'])) {
                $this->addUsingAlias(UserPeer::MODIFIED_ON, $modifiedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::MODIFIED_ON, $modifiedOn, $comparison);
    }

    /**
     * Filter the query on the supervisor_quota_2 column
     *
     * Example usage:
     * <code>
     * $query->filterBySupervisorQuota2(1234); // WHERE supervisor_quota_2 = 1234
     * $query->filterBySupervisorQuota2(array(12, 34)); // WHERE supervisor_quota_2 IN (12, 34)
     * $query->filterBySupervisorQuota2(array('min' => 12)); // WHERE supervisor_quota_2 > 12
     * </code>
     *
     * @param     mixed $supervisorQuota2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterBySupervisorQuota2($supervisorQuota2 = null, $comparison = null)
    {
        if (is_array($supervisorQuota2)) {
            $useMinMax = false;
            if (isset($supervisorQuota2['min'])) {
                $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_2, $supervisorQuota2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supervisorQuota2['max'])) {
                $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_2, $supervisorQuota2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::SUPERVISOR_QUOTA_2, $supervisorQuota2, $comparison);
    }

    /**
     * Filter the query on the quota_used_1 column
     *
     * Example usage:
     * <code>
     * $query->filterByQuotaUsed1(1234); // WHERE quota_used_1 = 1234
     * $query->filterByQuotaUsed1(array(12, 34)); // WHERE quota_used_1 IN (12, 34)
     * $query->filterByQuotaUsed1(array('min' => 12)); // WHERE quota_used_1 > 12
     * </code>
     *
     * @param     mixed $quotaUsed1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByQuotaUsed1($quotaUsed1 = null, $comparison = null)
    {
        if (is_array($quotaUsed1)) {
            $useMinMax = false;
            if (isset($quotaUsed1['min'])) {
                $this->addUsingAlias(UserPeer::QUOTA_USED_1, $quotaUsed1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quotaUsed1['max'])) {
                $this->addUsingAlias(UserPeer::QUOTA_USED_1, $quotaUsed1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::QUOTA_USED_1, $quotaUsed1, $comparison);
    }

    /**
     * Filter the query on the quota_used_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByQuotaUsed2(1234); // WHERE quota_used_2 = 1234
     * $query->filterByQuotaUsed2(array(12, 34)); // WHERE quota_used_2 IN (12, 34)
     * $query->filterByQuotaUsed2(array('min' => 12)); // WHERE quota_used_2 > 12
     * </code>
     *
     * @param     mixed $quotaUsed2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByQuotaUsed2($quotaUsed2 = null, $comparison = null)
    {
        if (is_array($quotaUsed2)) {
            $useMinMax = false;
            if (isset($quotaUsed2['min'])) {
                $this->addUsingAlias(UserPeer::QUOTA_USED_2, $quotaUsed2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quotaUsed2['max'])) {
                $this->addUsingAlias(UserPeer::QUOTA_USED_2, $quotaUsed2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::QUOTA_USED_2, $quotaUsed2, $comparison);
    }

    /**
     * Filter the query by a related Role object
     *
     * @param   Role|PropelObjectCollection $role The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByRole($role, $comparison = null)
    {
        if ($role instanceof Role) {
            return $this
                ->addUsingAlias(UserPeer::ROLE_ID, $role->getId(), $comparison);
        } elseif ($role instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserPeer::ROLE_ID, $role->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRole() only accepts arguments of type Role or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Role relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinRole($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Role');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Role');
        }

        return $this;
    }

    /**
     * Use the Role relation Role object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Role', '\ISG\ProjectSubmissionAppBundle\Model\RoleQuery');
    }

    /**
     * Filter the query by a related Profileuser object
     *
     * @param   Profileuser|PropelObjectCollection $profileuser  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProfileuser($profileuser, $comparison = null)
    {
        if ($profileuser instanceof Profileuser) {
            return $this
                ->addUsingAlias(UserPeer::ID, $profileuser->getUserId(), $comparison);
        } elseif ($profileuser instanceof PropelObjectCollection) {
            return $this
                ->useProfileuserQuery()
                ->filterByPrimaryKeys($profileuser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProfileuser() only accepts arguments of type Profileuser or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Profileuser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinProfileuser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Profileuser');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Profileuser');
        }

        return $this;
    }

    /**
     * Use the Profileuser relation Profileuser object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProfileuserQuery A secondary query class using the current class as primary query
     */
    public function useProfileuserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProfileuser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Profileuser', '\ISG\ProjectSubmissionAppBundle\Model\ProfileuserQuery');
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(UserPeer::ID, $project->getUserId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            return $this
                ->useProjectQuery()
                ->filterByPrimaryKeys($project->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type Project or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Project');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Project');
        }

        return $this;
    }

    /**
     * Use the Project relation Project object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\ISG\ProjectSubmissionAppBundle\Model\ProjectQuery');
    }

    /**
     * Filter the query by a related Email object
     *
     * @param   Email|PropelObjectCollection $email  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByEmail($email, $comparison = null)
    {
        if ($email instanceof Email) {
            return $this
                ->addUsingAlias(UserPeer::ID, $email->getUserId(), $comparison);
        } elseif ($email instanceof PropelObjectCollection) {
            return $this
                ->useEmailQuery()
                ->filterByPrimaryKeys($email->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEmail() only accepts arguments of type Email or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Email relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinEmail($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Email');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Email');
        }

        return $this;
    }

    /**
     * Use the Email relation Email object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\EmailQuery A secondary query class using the current class as primary query
     */
    public function useEmailQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEmail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Email', '\ISG\ProjectSubmissionAppBundle\Model\EmailQuery');
    }

    /**
     * Filter the query by a related Projectmark object
     *
     * @param   Projectmark|PropelObjectCollection $projectmark  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProjectmarkRelatedByUserId($projectmark, $comparison = null)
    {
        if ($projectmark instanceof Projectmark) {
            return $this
                ->addUsingAlias(UserPeer::ID, $projectmark->getUserId(), $comparison);
        } elseif ($projectmark instanceof PropelObjectCollection) {
            return $this
                ->useProjectmarkRelatedByUserIdQuery()
                ->filterByPrimaryKeys($projectmark->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectmarkRelatedByUserId() only accepts arguments of type Projectmark or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectmarkRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinProjectmarkRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectmarkRelatedByUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProjectmarkRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the ProjectmarkRelatedByUserId relation Projectmark object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery A secondary query class using the current class as primary query
     */
    public function useProjectmarkRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectmarkRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectmarkRelatedByUserId', '\ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery');
    }

    /**
     * Filter the query by a related Projectmark object
     *
     * @param   Projectmark|PropelObjectCollection $projectmark  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProjectmarkRelatedByEvaluatorId($projectmark, $comparison = null)
    {
        if ($projectmark instanceof Projectmark) {
            return $this
                ->addUsingAlias(UserPeer::ID, $projectmark->getEvaluatorId(), $comparison);
        } elseif ($projectmark instanceof PropelObjectCollection) {
            return $this
                ->useProjectmarkRelatedByEvaluatorIdQuery()
                ->filterByPrimaryKeys($projectmark->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectmarkRelatedByEvaluatorId() only accepts arguments of type Projectmark or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectmarkRelatedByEvaluatorId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinProjectmarkRelatedByEvaluatorId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectmarkRelatedByEvaluatorId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProjectmarkRelatedByEvaluatorId');
        }

        return $this;
    }

    /**
     * Use the ProjectmarkRelatedByEvaluatorId relation Projectmark object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery A secondary query class using the current class as primary query
     */
    public function useProjectmarkRelatedByEvaluatorIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectmarkRelatedByEvaluatorId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectmarkRelatedByEvaluatorId', '\ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery');
    }

    /**
     * Filter the query by a related Projectdocument object
     *
     * @param   Projectdocument|PropelObjectCollection $projectdocument  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   UserQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProjectdocument($projectdocument, $comparison = null)
    {
        if ($projectdocument instanceof Projectdocument) {
            return $this
                ->addUsingAlias(UserPeer::ID, $projectdocument->getUserId(), $comparison);
        } elseif ($projectdocument instanceof PropelObjectCollection) {
            return $this
                ->useProjectdocumentQuery()
                ->filterByPrimaryKeys($projectdocument->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectdocument() only accepts arguments of type Projectdocument or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projectdocument relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinProjectdocument($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projectdocument');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Projectdocument');
        }

        return $this;
    }

    /**
     * Use the Projectdocument relation Projectdocument object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentQuery A secondary query class using the current class as primary query
     */
    public function useProjectdocumentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectdocument($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projectdocument', '\ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   User $user Object to remove from the list of results
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addCond('pruneCond0', $this->getAliasedColName(UserPeer::ID), $user->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(UserPeer::USER_EMAIL), $user->getUserEmail(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
