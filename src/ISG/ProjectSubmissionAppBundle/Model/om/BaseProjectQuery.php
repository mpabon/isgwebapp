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
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\ProjectPeer;
use ISG\ProjectSubmissionAppBundle\Model\ProjectQuery;
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\Projectmark;
use ISG\ProjectSubmissionAppBundle\Model\User;

/**
 * @method ProjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method ProjectQuery orderBySupervisorId($order = Criteria::ASC) Order by the supervisor_id column
 * @method ProjectQuery orderByPhysicalCopySubmitted($order = Criteria::ASC) Order by the physical_copy_submitted column
 * @method ProjectQuery orderByAlternateEmailId($order = Criteria::ASC) Order by the alternate_email_id column
 * @method ProjectQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method ProjectQuery orderByProblemStatement($order = Criteria::ASC) Order by the problem_statement column
 * @method ProjectQuery orderBySupervisorComments($order = Criteria::ASC) Order by the supervisor_comments column
 * @method ProjectQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method ProjectQuery orderBySecondMarkerId($order = Criteria::ASC) Order by the second_marker_id column
 * @method ProjectQuery orderByThirdMarkerId($order = Criteria::ASC) Order by the third_marker_id column
 * @method ProjectQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method ProjectQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method ProjectQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 * @method ProjectQuery orderByModifiedOn($order = Criteria::ASC) Order by the modified_on column
 *
 * @method ProjectQuery groupById() Group by the id column
 * @method ProjectQuery groupByUserId() Group by the user_id column
 * @method ProjectQuery groupBySupervisorId() Group by the supervisor_id column
 * @method ProjectQuery groupByPhysicalCopySubmitted() Group by the physical_copy_submitted column
 * @method ProjectQuery groupByAlternateEmailId() Group by the alternate_email_id column
 * @method ProjectQuery groupByTitle() Group by the title column
 * @method ProjectQuery groupByProblemStatement() Group by the problem_statement column
 * @method ProjectQuery groupBySupervisorComments() Group by the supervisor_comments column
 * @method ProjectQuery groupByStatus() Group by the status column
 * @method ProjectQuery groupBySecondMarkerId() Group by the second_marker_id column
 * @method ProjectQuery groupByThirdMarkerId() Group by the third_marker_id column
 * @method ProjectQuery groupByCreatedBy() Group by the created_by column
 * @method ProjectQuery groupByCreatedOn() Group by the created_on column
 * @method ProjectQuery groupByModifiedBy() Group by the modified_by column
 * @method ProjectQuery groupByModifiedOn() Group by the modified_on column
 *
 * @method ProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method ProjectQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method ProjectQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method ProjectQuery leftJoinEmail($relationAlias = null) Adds a LEFT JOIN clause to the query using the Email relation
 * @method ProjectQuery rightJoinEmail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Email relation
 * @method ProjectQuery innerJoinEmail($relationAlias = null) Adds a INNER JOIN clause to the query using the Email relation
 *
 * @method ProjectQuery leftJoinProjectmark($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projectmark relation
 * @method ProjectQuery rightJoinProjectmark($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projectmark relation
 * @method ProjectQuery innerJoinProjectmark($relationAlias = null) Adds a INNER JOIN clause to the query using the Projectmark relation
 *
 * @method ProjectQuery leftJoinProjectdocument($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projectdocument relation
 * @method ProjectQuery rightJoinProjectdocument($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projectdocument relation
 * @method ProjectQuery innerJoinProjectdocument($relationAlias = null) Adds a INNER JOIN clause to the query using the Projectdocument relation
 *
 * @method Project findOne(PropelPDO $con = null) Return the first Project matching the query
 * @method Project findOneOrCreate(PropelPDO $con = null) Return the first Project matching the query, or a new Project object populated from the query conditions when no match is found
 *
 * @method Project findOneById(int $id) Return the first Project filtered by the id column
 * @method Project findOneByUserId(int $user_id) Return the first Project filtered by the user_id column
 * @method Project findOneBySupervisorId(int $supervisor_id) Return the first Project filtered by the supervisor_id column
 * @method Project findOneByPhysicalCopySubmitted(int $physical_copy_submitted) Return the first Project filtered by the physical_copy_submitted column
 * @method Project findOneByAlternateEmailId(int $alternate_email_id) Return the first Project filtered by the alternate_email_id column
 * @method Project findOneByTitle(string $title) Return the first Project filtered by the title column
 * @method Project findOneByProblemStatement(string $problem_statement) Return the first Project filtered by the problem_statement column
 * @method Project findOneBySupervisorComments(string $supervisor_comments) Return the first Project filtered by the supervisor_comments column
 * @method Project findOneByStatus(string $status) Return the first Project filtered by the status column
 * @method Project findOneBySecondMarkerId(int $second_marker_id) Return the first Project filtered by the second_marker_id column
 * @method Project findOneByThirdMarkerId(int $third_marker_id) Return the first Project filtered by the third_marker_id column
 * @method Project findOneByCreatedBy(int $created_by) Return the first Project filtered by the created_by column
 * @method Project findOneByCreatedOn(string $created_on) Return the first Project filtered by the created_on column
 * @method Project findOneByModifiedBy(int $modified_by) Return the first Project filtered by the modified_by column
 * @method Project findOneByModifiedOn(string $modified_on) Return the first Project filtered by the modified_on column
 *
 * @method array findById(int $id) Return Project objects filtered by the id column
 * @method array findByUserId(int $user_id) Return Project objects filtered by the user_id column
 * @method array findBySupervisorId(int $supervisor_id) Return Project objects filtered by the supervisor_id column
 * @method array findByPhysicalCopySubmitted(int $physical_copy_submitted) Return Project objects filtered by the physical_copy_submitted column
 * @method array findByAlternateEmailId(int $alternate_email_id) Return Project objects filtered by the alternate_email_id column
 * @method array findByTitle(string $title) Return Project objects filtered by the title column
 * @method array findByProblemStatement(string $problem_statement) Return Project objects filtered by the problem_statement column
 * @method array findBySupervisorComments(string $supervisor_comments) Return Project objects filtered by the supervisor_comments column
 * @method array findByStatus(string $status) Return Project objects filtered by the status column
 * @method array findBySecondMarkerId(int $second_marker_id) Return Project objects filtered by the second_marker_id column
 * @method array findByThirdMarkerId(int $third_marker_id) Return Project objects filtered by the third_marker_id column
 * @method array findByCreatedBy(int $created_by) Return Project objects filtered by the created_by column
 * @method array findByCreatedOn(string $created_on) Return Project objects filtered by the created_on column
 * @method array findByModifiedBy(int $modified_by) Return Project objects filtered by the modified_by column
 * @method array findByModifiedOn(string $modified_on) Return Project objects filtered by the modified_on column
 */
abstract class BaseProjectQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\Project', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     ProjectQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectQuery) {
            return $criteria;
        }
        $query = new ProjectQuery();
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
                         A Primary key composition: [$id, $user_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Project|Project[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Project A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `USER_ID`, `SUPERVISOR_ID`, `PHYSICAL_COPY_SUBMITTED`, `ALTERNATE_EMAIL_ID`, `TITLE`, `PROBLEM_STATEMENT`, `SUPERVISOR_COMMENTS`, `STATUS`, `SECOND_MARKER_ID`, `THIRD_MARKER_ID`, `CREATED_BY`, `CREATED_ON`, `MODIFIED_BY`, `MODIFIED_ON` FROM `Project` WHERE `ID` = :p0 AND `USER_ID` = :p1';
        try {
            $stmt = $con->prepare($sql);			
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);			
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Project();
            $obj->hydrate($row);
            ProjectPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return Project|Project[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Project[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ProjectPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ProjectPeer::USER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ProjectPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ProjectPeer::USER_ID, $key[1], Criteria::EQUAL);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the supervisor_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySupervisorId(1234); // WHERE supervisor_id = 1234
     * $query->filterBySupervisorId(array(12, 34)); // WHERE supervisor_id IN (12, 34)
     * $query->filterBySupervisorId(array('min' => 12)); // WHERE supervisor_id > 12
     * </code>
     *
     * @param     mixed $supervisorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterBySupervisorId($supervisorId = null, $comparison = null)
    {
        if (is_array($supervisorId)) {
            $useMinMax = false;
            if (isset($supervisorId['min'])) {
                $this->addUsingAlias(ProjectPeer::SUPERVISOR_ID, $supervisorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supervisorId['max'])) {
                $this->addUsingAlias(ProjectPeer::SUPERVISOR_ID, $supervisorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::SUPERVISOR_ID, $supervisorId, $comparison);
    }

    /**
     * Filter the query on the physical_copy_submitted column
     *
     * Example usage:
     * <code>
     * $query->filterByPhysicalCopySubmitted(1234); // WHERE physical_copy_submitted = 1234
     * $query->filterByPhysicalCopySubmitted(array(12, 34)); // WHERE physical_copy_submitted IN (12, 34)
     * $query->filterByPhysicalCopySubmitted(array('min' => 12)); // WHERE physical_copy_submitted > 12
     * </code>
     *
     * @param     mixed $physicalCopySubmitted The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPhysicalCopySubmitted($physicalCopySubmitted = null, $comparison = null)
    {
        if (is_array($physicalCopySubmitted)) {
            $useMinMax = false;
            if (isset($physicalCopySubmitted['min'])) {
                $this->addUsingAlias(ProjectPeer::PHYSICAL_COPY_SUBMITTED, $physicalCopySubmitted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($physicalCopySubmitted['max'])) {
                $this->addUsingAlias(ProjectPeer::PHYSICAL_COPY_SUBMITTED, $physicalCopySubmitted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::PHYSICAL_COPY_SUBMITTED, $physicalCopySubmitted, $comparison);
    }

    /**
     * Filter the query on the alternate_email_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAlternateEmailId(1234); // WHERE alternate_email_id = 1234
     * $query->filterByAlternateEmailId(array(12, 34)); // WHERE alternate_email_id IN (12, 34)
     * $query->filterByAlternateEmailId(array('min' => 12)); // WHERE alternate_email_id > 12
     * </code>
     *
     * @param     mixed $alternateEmailId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByAlternateEmailId($alternateEmailId = null, $comparison = null)
    {
        if (is_array($alternateEmailId)) {
            $useMinMax = false;
            if (isset($alternateEmailId['min'])) {
                $this->addUsingAlias(ProjectPeer::ALTERNATE_EMAIL_ID, $alternateEmailId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alternateEmailId['max'])) {
                $this->addUsingAlias(ProjectPeer::ALTERNATE_EMAIL_ID, $alternateEmailId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::ALTERNATE_EMAIL_ID, $alternateEmailId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the problem_statement column
     *
     * Example usage:
     * <code>
     * $query->filterByProblemStatement('fooValue');   // WHERE problem_statement = 'fooValue'
     * $query->filterByProblemStatement('%fooValue%'); // WHERE problem_statement LIKE '%fooValue%'
     * </code>
     *
     * @param     string $problemStatement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByProblemStatement($problemStatement = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($problemStatement)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $problemStatement)) {
                $problemStatement = str_replace('*', '%', $problemStatement);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectPeer::PROBLEM_STATEMENT, $problemStatement, $comparison);
    }

    /**
     * Filter the query on the supervisor_comments column
     *
     * Example usage:
     * <code>
     * $query->filterBySupervisorComments('fooValue');   // WHERE supervisor_comments = 'fooValue'
     * $query->filterBySupervisorComments('%fooValue%'); // WHERE supervisor_comments LIKE '%fooValue%'
     * </code>
     *
     * @param     string $supervisorComments The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterBySupervisorComments($supervisorComments = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($supervisorComments)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $supervisorComments)) {
                $supervisorComments = str_replace('*', '%', $supervisorComments);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectPeer::SUPERVISOR_COMMENTS, $supervisorComments, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the second_marker_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySecondMarkerId(1234); // WHERE second_marker_id = 1234
     * $query->filterBySecondMarkerId(array(12, 34)); // WHERE second_marker_id IN (12, 34)
     * $query->filterBySecondMarkerId(array('min' => 12)); // WHERE second_marker_id > 12
     * </code>
     *
     * @param     mixed $secondMarkerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterBySecondMarkerId($secondMarkerId = null, $comparison = null)
    {
        if (is_array($secondMarkerId)) {
            $useMinMax = false;
            if (isset($secondMarkerId['min'])) {
                $this->addUsingAlias(ProjectPeer::SECOND_MARKER_ID, $secondMarkerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($secondMarkerId['max'])) {
                $this->addUsingAlias(ProjectPeer::SECOND_MARKER_ID, $secondMarkerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::SECOND_MARKER_ID, $secondMarkerId, $comparison);
    }

    /**
     * Filter the query on the third_marker_id column
     *
     * Example usage:
     * <code>
     * $query->filterByThirdMarkerId(1234); // WHERE third_marker_id = 1234
     * $query->filterByThirdMarkerId(array(12, 34)); // WHERE third_marker_id IN (12, 34)
     * $query->filterByThirdMarkerId(array('min' => 12)); // WHERE third_marker_id > 12
     * </code>
     *
     * @param     mixed $thirdMarkerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByThirdMarkerId($thirdMarkerId = null, $comparison = null)
    {
        if (is_array($thirdMarkerId)) {
            $useMinMax = false;
            if (isset($thirdMarkerId['min'])) {
                $this->addUsingAlias(ProjectPeer::THIRD_MARKER_ID, $thirdMarkerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($thirdMarkerId['max'])) {
                $this->addUsingAlias(ProjectPeer::THIRD_MARKER_ID, $thirdMarkerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::THIRD_MARKER_ID, $thirdMarkerId, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ProjectPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ProjectPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::CREATED_BY, $createdBy, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(ProjectPeer::CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(ProjectPeer::CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::CREATED_ON, $createdOn, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(ProjectPeer::MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(ProjectPeer::MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::MODIFIED_BY, $modifiedBy, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByModifiedOn($modifiedOn = null, $comparison = null)
    {
        if (is_array($modifiedOn)) {
            $useMinMax = false;
            if (isset($modifiedOn['min'])) {
                $this->addUsingAlias(ProjectPeer::MODIFIED_ON, $modifiedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedOn['max'])) {
                $this->addUsingAlias(ProjectPeer::MODIFIED_ON, $modifiedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::MODIFIED_ON, $modifiedOn, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ProjectPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectPeer::USER_ID, $user->toKeyValue('Id', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\ISG\ProjectSubmissionAppBundle\Model\UserQuery');
    }

    /**
     * Filter the query by a related Email object
     *
     * @param   Email|PropelObjectCollection $email  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByEmail($email, $comparison = null)
    {
        if ($email instanceof Email) {
            return $this
                ->addUsingAlias(ProjectPeer::ID, $email->getProjectId(), $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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
     * @return   ProjectQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProjectmark($projectmark, $comparison = null)
    {
        if ($projectmark instanceof Projectmark) {
            return $this
                ->addUsingAlias(ProjectPeer::ID, $projectmark->getProjectId(), $comparison);
        } elseif ($projectmark instanceof PropelObjectCollection) {
            return $this
                ->useProjectmarkQuery()
                ->filterByPrimaryKeys($projectmark->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectmark() only accepts arguments of type Projectmark or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projectmark relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectmark($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projectmark');

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
            $this->addJoinObject($join, 'Projectmark');
        }

        return $this;
    }

    /**
     * Use the Projectmark relation Projectmark object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery A secondary query class using the current class as primary query
     */
    public function useProjectmarkQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectmark($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projectmark', '\ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery');
    }

    /**
     * Filter the query by a related Projectdocument object
     *
     * @param   Projectdocument|PropelObjectCollection $projectdocument  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProjectdocument($projectdocument, $comparison = null)
    {
        if ($projectdocument instanceof Projectdocument) {
            return $this
                ->addUsingAlias(ProjectPeer::ID, $projectdocument->getProjectId(), $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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
     * @param   Project $project Object to remove from the list of results
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function prune($project = null)
    {
        if ($project) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ProjectPeer::ID), $project->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ProjectPeer::USER_ID), $project->getUserId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
