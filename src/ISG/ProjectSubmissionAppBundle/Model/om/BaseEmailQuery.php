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
use ISG\ProjectSubmissionAppBundle\Model\EmailPeer;
use ISG\ProjectSubmissionAppBundle\Model\EmailQuery;
use ISG\ProjectSubmissionAppBundle\Model\Project;
use ISG\ProjectSubmissionAppBundle\Model\User;

/**
 * @method EmailQuery orderById($order = Criteria::ASC) Order by the id column
 * @method EmailQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method EmailQuery orderByProjectId($order = Criteria::ASC) Order by the project_id column
 * @method EmailQuery orderByFrom($order = Criteria::ASC) Order by the from column
 * @method EmailQuery orderByTo($order = Criteria::ASC) Order by the to column
 * @method EmailQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method EmailQuery orderByBody($order = Criteria::ASC) Order by the body column
 * @method EmailQuery orderBySentDate($order = Criteria::ASC) Order by the sent_date column
 * @method EmailQuery orderByResentCount($order = Criteria::ASC) Order by the resent_count column
 *
 * @method EmailQuery groupById() Group by the id column
 * @method EmailQuery groupByUserId() Group by the user_id column
 * @method EmailQuery groupByProjectId() Group by the project_id column
 * @method EmailQuery groupByFrom() Group by the from column
 * @method EmailQuery groupByTo() Group by the to column
 * @method EmailQuery groupBySubject() Group by the subject column
 * @method EmailQuery groupByBody() Group by the body column
 * @method EmailQuery groupBySentDate() Group by the sent_date column
 * @method EmailQuery groupByResentCount() Group by the resent_count column
 *
 * @method EmailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method EmailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method EmailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method EmailQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method EmailQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method EmailQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method EmailQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method EmailQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method EmailQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Email findOne(PropelPDO $con = null) Return the first Email matching the query
 * @method Email findOneOrCreate(PropelPDO $con = null) Return the first Email matching the query, or a new Email object populated from the query conditions when no match is found
 *
 * @method Email findOneById(int $id) Return the first Email filtered by the id column
 * @method Email findOneByUserId(int $user_id) Return the first Email filtered by the user_id column
 * @method Email findOneByProjectId(int $project_id) Return the first Email filtered by the project_id column
 * @method Email findOneByFrom(string $from) Return the first Email filtered by the from column
 * @method Email findOneByTo(string $to) Return the first Email filtered by the to column
 * @method Email findOneBySubject(string $subject) Return the first Email filtered by the subject column
 * @method Email findOneByBody(string $body) Return the first Email filtered by the body column
 * @method Email findOneBySentDate(string $sent_date) Return the first Email filtered by the sent_date column
 * @method Email findOneByResentCount(int $resent_count) Return the first Email filtered by the resent_count column
 *
 * @method array findById(int $id) Return Email objects filtered by the id column
 * @method array findByUserId(int $user_id) Return Email objects filtered by the user_id column
 * @method array findByProjectId(int $project_id) Return Email objects filtered by the project_id column
 * @method array findByFrom(string $from) Return Email objects filtered by the from column
 * @method array findByTo(string $to) Return Email objects filtered by the to column
 * @method array findBySubject(string $subject) Return Email objects filtered by the subject column
 * @method array findByBody(string $body) Return Email objects filtered by the body column
 * @method array findBySentDate(string $sent_date) Return Email objects filtered by the sent_date column
 * @method array findByResentCount(int $resent_count) Return Email objects filtered by the resent_count column
 */
abstract class BaseEmailQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseEmailQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\Email', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new EmailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     EmailQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return EmailQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof EmailQuery) {
            return $criteria;
        }
        $query = new EmailQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $user_id, $project_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Email|Email[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EmailPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(EmailPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Email A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `USER_ID`, `PROJECT_ID`, `FROM`, `TO`, `SUBJECT`, `BODY`, `SENT_DATE`, `RESENT_COUNT` FROM `Email` WHERE `ID` = :p0 AND `USER_ID` = :p1 AND `PROJECT_ID` = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Email();
            $obj->hydrate($row);
            EmailPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return Email|Email[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Email[]|mixed the list of results, formatted by the current formatter
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
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(EmailPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(EmailPeer::USER_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(EmailPeer::PROJECT_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(EmailPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(EmailPeer::USER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(EmailPeer::PROJECT_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(EmailPeer::ID, $id, $comparison);
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
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(EmailPeer::USER_ID, $userId, $comparison);
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
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(EmailPeer::PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the from column
     *
     * Example usage:
     * <code>
     * $query->filterByFrom('fooValue');   // WHERE from = 'fooValue'
     * $query->filterByFrom('%fooValue%'); // WHERE from LIKE '%fooValue%'
     * </code>
     *
     * @param     string $from The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByFrom($from = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($from)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $from)) {
                $from = str_replace('*', '%', $from);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmailPeer::FROM, $from, $comparison);
    }

    /**
     * Filter the query on the to column
     *
     * Example usage:
     * <code>
     * $query->filterByTo('fooValue');   // WHERE to = 'fooValue'
     * $query->filterByTo('%fooValue%'); // WHERE to LIKE '%fooValue%'
     * </code>
     *
     * @param     string $to The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByTo($to = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($to)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $to)) {
                $to = str_replace('*', '%', $to);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmailPeer::TO, $to, $comparison);
    }

    /**
     * Filter the query on the subject column
     *
     * Example usage:
     * <code>
     * $query->filterBySubject('fooValue');   // WHERE subject = 'fooValue'
     * $query->filterBySubject('%fooValue%'); // WHERE subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subject The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $subject)) {
                $subject = str_replace('*', '%', $subject);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmailPeer::SUBJECT, $subject, $comparison);
    }

    /**
     * Filter the query on the body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody('fooValue');   // WHERE body = 'fooValue'
     * $query->filterByBody('%fooValue%'); // WHERE body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $body The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByBody($body = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($body)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $body)) {
                $body = str_replace('*', '%', $body);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmailPeer::BODY, $body, $comparison);
    }

    /**
     * Filter the query on the sent_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySentDate('2011-03-14'); // WHERE sent_date = '2011-03-14'
     * $query->filterBySentDate('now'); // WHERE sent_date = '2011-03-14'
     * $query->filterBySentDate(array('max' => 'yesterday')); // WHERE sent_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $sentDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterBySentDate($sentDate = null, $comparison = null)
    {
        if (is_array($sentDate)) {
            $useMinMax = false;
            if (isset($sentDate['min'])) {
                $this->addUsingAlias(EmailPeer::SENT_DATE, $sentDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sentDate['max'])) {
                $this->addUsingAlias(EmailPeer::SENT_DATE, $sentDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmailPeer::SENT_DATE, $sentDate, $comparison);
    }

    /**
     * Filter the query on the resent_count column
     *
     * Example usage:
     * <code>
     * $query->filterByResentCount(1234); // WHERE resent_count = 1234
     * $query->filterByResentCount(array(12, 34)); // WHERE resent_count IN (12, 34)
     * $query->filterByResentCount(array('min' => 12)); // WHERE resent_count > 12
     * </code>
     *
     * @param     mixed $resentCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function filterByResentCount($resentCount = null, $comparison = null)
    {
        if (is_array($resentCount)) {
            $useMinMax = false;
            if (isset($resentCount['min'])) {
                $this->addUsingAlias(EmailPeer::RESENT_COUNT, $resentCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($resentCount['max'])) {
                $this->addUsingAlias(EmailPeer::RESENT_COUNT, $resentCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmailPeer::RESENT_COUNT, $resentCount, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   EmailQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(EmailPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EmailPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return EmailQuery The current query, for fluid interface
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
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   EmailQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(EmailPeer::PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EmailPeer::PROJECT_ID, $project->toKeyValue('Id', 'Id'), $comparison);
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
     * @return EmailQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Email $email Object to remove from the list of results
     *
     * @return EmailQuery The current query, for fluid interface
     */
    public function prune($email = null)
    {
        if ($email) {
            $this->addCond('pruneCond0', $this->getAliasedColName(EmailPeer::ID), $email->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(EmailPeer::USER_ID), $email->getUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(EmailPeer::PROJECT_ID), $email->getProjectId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
