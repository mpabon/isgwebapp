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
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\Projectmark;
use ISG\ProjectSubmissionAppBundle\Model\ProjectmarkPeer;
use ISG\ProjectSubmissionAppBundle\Model\ProjectmarkQuery;
use ISG\ProjectSubmissionAppBundle\Model\User;

/**
 * @method ProjectmarkQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectmarkQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method ProjectmarkQuery orderByEvaluatorId($order = Criteria::ASC) Order by the evaluator_id column
 * @method ProjectmarkQuery orderByProjectId($order = Criteria::ASC) Order by the project_id column
 * @method ProjectmarkQuery orderByTotalMarks($order = Criteria::ASC) Order by the total_marks column
 * @method ProjectmarkQuery orderByMark1($order = Criteria::ASC) Order by the mark_1 column
 * @method ProjectmarkQuery orderByMark2($order = Criteria::ASC) Order by the mark_2 column
 * @method ProjectmarkQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method ProjectmarkQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method ProjectmarkQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 * @method ProjectmarkQuery orderByModifiedOn($order = Criteria::ASC) Order by the modified_on column
 *
 * @method ProjectmarkQuery groupById() Group by the id column
 * @method ProjectmarkQuery groupByUserId() Group by the user_id column
 * @method ProjectmarkQuery groupByEvaluatorId() Group by the evaluator_id column
 * @method ProjectmarkQuery groupByProjectId() Group by the project_id column
 * @method ProjectmarkQuery groupByTotalMarks() Group by the total_marks column
 * @method ProjectmarkQuery groupByMark1() Group by the mark_1 column
 * @method ProjectmarkQuery groupByMark2() Group by the mark_2 column
 * @method ProjectmarkQuery groupByCreatedBy() Group by the created_by column
 * @method ProjectmarkQuery groupByCreatedOn() Group by the created_on column
 * @method ProjectmarkQuery groupByModifiedBy() Group by the modified_by column
 * @method ProjectmarkQuery groupByModifiedOn() Group by the modified_on column
 *
 * @method ProjectmarkQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectmarkQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectmarkQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectmarkQuery leftJoinUserRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUserId relation
 * @method ProjectmarkQuery rightJoinUserRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUserId relation
 * @method ProjectmarkQuery innerJoinUserRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUserId relation
 *
 * @method ProjectmarkQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectmarkQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectmarkQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method ProjectmarkQuery leftJoinUserRelatedByEvaluatorId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByEvaluatorId relation
 * @method ProjectmarkQuery rightJoinUserRelatedByEvaluatorId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByEvaluatorId relation
 * @method ProjectmarkQuery innerJoinUserRelatedByEvaluatorId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByEvaluatorId relation
 *
 * @method Projectmark findOne(PropelPDO $con = null) Return the first Projectmark matching the query
 * @method Projectmark findOneOrCreate(PropelPDO $con = null) Return the first Projectmark matching the query, or a new Projectmark object populated from the query conditions when no match is found
 *
 * @method Projectmark findOneById(int $id) Return the first Projectmark filtered by the id column
 * @method Projectmark findOneByUserId(int $user_id) Return the first Projectmark filtered by the user_id column
 * @method Projectmark findOneByEvaluatorId(int $evaluator_id) Return the first Projectmark filtered by the evaluator_id column
 * @method Projectmark findOneByProjectId(int $project_id) Return the first Projectmark filtered by the project_id column
 * @method Projectmark findOneByTotalMarks(int $total_marks) Return the first Projectmark filtered by the total_marks column
 * @method Projectmark findOneByMark1(int $mark_1) Return the first Projectmark filtered by the mark_1 column
 * @method Projectmark findOneByMark2(int $mark_2) Return the first Projectmark filtered by the mark_2 column
 * @method Projectmark findOneByCreatedBy(int $created_by) Return the first Projectmark filtered by the created_by column
 * @method Projectmark findOneByCreatedOn(string $created_on) Return the first Projectmark filtered by the created_on column
 * @method Projectmark findOneByModifiedBy(int $modified_by) Return the first Projectmark filtered by the modified_by column
 * @method Projectmark findOneByModifiedOn(string $modified_on) Return the first Projectmark filtered by the modified_on column
 *
 * @method array findById(int $id) Return Projectmark objects filtered by the id column
 * @method array findByUserId(int $user_id) Return Projectmark objects filtered by the user_id column
 * @method array findByEvaluatorId(int $evaluator_id) Return Projectmark objects filtered by the evaluator_id column
 * @method array findByProjectId(int $project_id) Return Projectmark objects filtered by the project_id column
 * @method array findByTotalMarks(int $total_marks) Return Projectmark objects filtered by the total_marks column
 * @method array findByMark1(int $mark_1) Return Projectmark objects filtered by the mark_1 column
 * @method array findByMark2(int $mark_2) Return Projectmark objects filtered by the mark_2 column
 * @method array findByCreatedBy(int $created_by) Return Projectmark objects filtered by the created_by column
 * @method array findByCreatedOn(string $created_on) Return Projectmark objects filtered by the created_on column
 * @method array findByModifiedBy(int $modified_by) Return Projectmark objects filtered by the modified_by column
 * @method array findByModifiedOn(string $modified_on) Return Projectmark objects filtered by the modified_on column
 */
abstract class BaseProjectmarkQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectmarkQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectmark', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectmarkQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     ProjectmarkQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectmarkQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectmarkQuery) {
            return $criteria;
        }
        $query = new ProjectmarkQuery();
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
     * $obj = $c->findPk(array(12, 34, 56, 78), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $user_id, $evaluator_id, $project_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Projectmark|Projectmark[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectmarkPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectmarkPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Projectmark A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `USER_ID`, `EVALUATOR_ID`, `PROJECT_ID`, `TOTAL_MARKS`, `MARK_1`, `MARK_2`, `CREATED_BY`, `CREATED_ON`, `MODIFIED_BY`, `MODIFIED_ON` FROM `ProjectMark` WHERE `ID` = :p0 AND `USER_ID` = :p1 AND `EVALUATOR_ID` = :p2 AND `PROJECT_ID` = :p3';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Projectmark();
            $obj->hydrate($row);
            ProjectmarkPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3])));
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
     * @return Projectmark|Projectmark[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Projectmark[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ProjectmarkPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ProjectmarkPeer::USER_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(ProjectmarkPeer::EVALUATOR_ID, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(ProjectmarkPeer::PROJECT_ID, $key[3], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ProjectmarkPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ProjectmarkPeer::USER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(ProjectmarkPeer::EVALUATOR_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(ProjectmarkPeer::PROJECT_ID, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectmarkPeer::ID, $id, $comparison);
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
     * @see       filterByUserRelatedByUserId()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectmarkPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the evaluator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEvaluatorId(1234); // WHERE evaluator_id = 1234
     * $query->filterByEvaluatorId(array(12, 34)); // WHERE evaluator_id IN (12, 34)
     * $query->filterByEvaluatorId(array('min' => 12)); // WHERE evaluator_id > 12
     * </code>
     *
     * @see       filterByUserRelatedByEvaluatorId()
     *
     * @param     mixed $evaluatorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByEvaluatorId($evaluatorId = null, $comparison = null)
    {
        if (is_array($evaluatorId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectmarkPeer::EVALUATOR_ID, $evaluatorId, $comparison);
    }

    /**
     * Filter the query on the project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectId(1234); // WHERE project_id = 1234
     * $query->filterByProjectId(array(12, 34)); // WHERE project_id IN (12, 34)
     * $query->filterByProjectId(array('min' => 12)); // WHERE project_id > 12
     * </code>
     *
     * @see       filterByProject()
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectmarkPeer::PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the total_marks column
     *
     * Example usage:
     * <code>
     * $query->filterByTotalMarks(1234); // WHERE total_marks = 1234
     * $query->filterByTotalMarks(array(12, 34)); // WHERE total_marks IN (12, 34)
     * $query->filterByTotalMarks(array('min' => 12)); // WHERE total_marks > 12
     * </code>
     *
     * @param     mixed $totalMarks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByTotalMarks($totalMarks = null, $comparison = null)
    {
        if (is_array($totalMarks)) {
            $useMinMax = false;
            if (isset($totalMarks['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::TOTAL_MARKS, $totalMarks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($totalMarks['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::TOTAL_MARKS, $totalMarks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::TOTAL_MARKS, $totalMarks, $comparison);
    }

    /**
     * Filter the query on the mark_1 column
     *
     * Example usage:
     * <code>
     * $query->filterByMark1(1234); // WHERE mark_1 = 1234
     * $query->filterByMark1(array(12, 34)); // WHERE mark_1 IN (12, 34)
     * $query->filterByMark1(array('min' => 12)); // WHERE mark_1 > 12
     * </code>
     *
     * @param     mixed $mark1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByMark1($mark1 = null, $comparison = null)
    {
        if (is_array($mark1)) {
            $useMinMax = false;
            if (isset($mark1['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::MARK_1, $mark1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mark1['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::MARK_1, $mark1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::MARK_1, $mark1, $comparison);
    }

    /**
     * Filter the query on the mark_2 column
     *
     * Example usage:
     * <code>
     * $query->filterByMark2(1234); // WHERE mark_2 = 1234
     * $query->filterByMark2(array(12, 34)); // WHERE mark_2 IN (12, 34)
     * $query->filterByMark2(array('min' => 12)); // WHERE mark_2 > 12
     * </code>
     *
     * @param     mixed $mark2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByMark2($mark2 = null, $comparison = null)
    {
        if (is_array($mark2)) {
            $useMinMax = false;
            if (isset($mark2['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::MARK_2, $mark2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mark2['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::MARK_2, $mark2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::MARK_2, $mark2, $comparison);
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::CREATED_BY, $createdBy, $comparison);
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::CREATED_ON, $createdOn, $comparison);
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::MODIFIED_BY, $modifiedBy, $comparison);
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
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function filterByModifiedOn($modifiedOn = null, $comparison = null)
    {
        if (is_array($modifiedOn)) {
            $useMinMax = false;
            if (isset($modifiedOn['min'])) {
                $this->addUsingAlias(ProjectmarkPeer::MODIFIED_ON, $modifiedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedOn['max'])) {
                $this->addUsingAlias(ProjectmarkPeer::MODIFIED_ON, $modifiedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectmarkPeer::MODIFIED_ON, $modifiedOn, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectmarkQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByUserId($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ProjectmarkPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectmarkPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByUserId() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function joinUserRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByUserId');

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
            $this->addJoinObject($join, 'UserRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByUserId relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUserId', '\ISG\ProjectSubmissionAppBundle\Model\UserQuery');
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectmarkQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectmarkPeer::PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectmarkPeer::PROJECT_ID, $project->toKeyValue('Id', 'Id'), $comparison);
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
     * @return ProjectmarkQuery The current query, for fluid interface
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
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectmarkQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByEvaluatorId($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ProjectmarkPeer::EVALUATOR_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectmarkPeer::EVALUATOR_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByEvaluatorId() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByEvaluatorId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function joinUserRelatedByEvaluatorId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByEvaluatorId');

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
            $this->addJoinObject($join, 'UserRelatedByEvaluatorId');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByEvaluatorId relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ISG\ProjectSubmissionAppBundle\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByEvaluatorIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByEvaluatorId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByEvaluatorId', '\ISG\ProjectSubmissionAppBundle\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Projectmark $projectmark Object to remove from the list of results
     *
     * @return ProjectmarkQuery The current query, for fluid interface
     */
    public function prune($projectmark = null)
    {
        if ($projectmark) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ProjectmarkPeer::ID), $projectmark->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ProjectmarkPeer::USER_ID), $projectmark->getUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(ProjectmarkPeer::EVALUATOR_ID), $projectmark->getEvaluatorId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(ProjectmarkPeer::PROJECT_ID), $projectmark->getProjectId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
