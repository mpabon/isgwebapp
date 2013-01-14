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
use ISG\ProjectSubmissionAppBundle\Model\Projectdocument;
use ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentPeer;
use ISG\ProjectSubmissionAppBundle\Model\ProjectdocumentQuery;
use ISG\ProjectSubmissionAppBundle\Model\User;

/**
 * @method ProjectdocumentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectdocumentQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method ProjectdocumentQuery orderByProjectId($order = Criteria::ASC) Order by the project_id column
 * @method ProjectdocumentQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method ProjectdocumentQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method ProjectdocumentQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProjectdocumentQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method ProjectdocumentQuery orderByDocument($order = Criteria::ASC) Order by the document column
 * @method ProjectdocumentQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method ProjectdocumentQuery orderByCreatedOn($order = Criteria::ASC) Order by the created_on column
 * @method ProjectdocumentQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 * @method ProjectdocumentQuery orderByModifiedOn($order = Criteria::ASC) Order by the modified_on column
 *
 * @method ProjectdocumentQuery groupById() Group by the id column
 * @method ProjectdocumentQuery groupByUserId() Group by the user_id column
 * @method ProjectdocumentQuery groupByProjectId() Group by the project_id column
 * @method ProjectdocumentQuery groupByVersion() Group by the version column
 * @method ProjectdocumentQuery groupByType() Group by the type column
 * @method ProjectdocumentQuery groupByName() Group by the name column
 * @method ProjectdocumentQuery groupByStatus() Group by the status column
 * @method ProjectdocumentQuery groupByDocument() Group by the document column
 * @method ProjectdocumentQuery groupByCreatedBy() Group by the created_by column
 * @method ProjectdocumentQuery groupByCreatedOn() Group by the created_on column
 * @method ProjectdocumentQuery groupByModifiedBy() Group by the modified_by column
 * @method ProjectdocumentQuery groupByModifiedOn() Group by the modified_on column
 *
 * @method ProjectdocumentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectdocumentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectdocumentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectdocumentQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method ProjectdocumentQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method ProjectdocumentQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method ProjectdocumentQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectdocumentQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectdocumentQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Projectdocument findOne(PropelPDO $con = null) Return the first Projectdocument matching the query
 * @method Projectdocument findOneOrCreate(PropelPDO $con = null) Return the first Projectdocument matching the query, or a new Projectdocument object populated from the query conditions when no match is found
 *
 * @method Projectdocument findOneById(int $id) Return the first Projectdocument filtered by the id column
 * @method Projectdocument findOneByUserId(int $user_id) Return the first Projectdocument filtered by the user_id column
 * @method Projectdocument findOneByProjectId(int $project_id) Return the first Projectdocument filtered by the project_id column
 * @method Projectdocument findOneByVersion(string $version) Return the first Projectdocument filtered by the version column
 * @method Projectdocument findOneByType(string $type) Return the first Projectdocument filtered by the type column
 * @method Projectdocument findOneByName(string $name) Return the first Projectdocument filtered by the name column
 * @method Projectdocument findOneByStatus(string $status) Return the first Projectdocument filtered by the status column
 * @method Projectdocument findOneByDocument(string $document) Return the first Projectdocument filtered by the document column
 * @method Projectdocument findOneByCreatedBy(int $created_by) Return the first Projectdocument filtered by the created_by column
 * @method Projectdocument findOneByCreatedOn(string $created_on) Return the first Projectdocument filtered by the created_on column
 * @method Projectdocument findOneByModifiedBy(int $modified_by) Return the first Projectdocument filtered by the modified_by column
 * @method Projectdocument findOneByModifiedOn(string $modified_on) Return the first Projectdocument filtered by the modified_on column
 *
 * @method array findById(int $id) Return Projectdocument objects filtered by the id column
 * @method array findByUserId(int $user_id) Return Projectdocument objects filtered by the user_id column
 * @method array findByProjectId(int $project_id) Return Projectdocument objects filtered by the project_id column
 * @method array findByVersion(string $version) Return Projectdocument objects filtered by the version column
 * @method array findByType(string $type) Return Projectdocument objects filtered by the type column
 * @method array findByName(string $name) Return Projectdocument objects filtered by the name column
 * @method array findByStatus(string $status) Return Projectdocument objects filtered by the status column
 * @method array findByDocument(string $document) Return Projectdocument objects filtered by the document column
 * @method array findByCreatedBy(int $created_by) Return Projectdocument objects filtered by the created_by column
 * @method array findByCreatedOn(string $created_on) Return Projectdocument objects filtered by the created_on column
 * @method array findByModifiedBy(int $modified_by) Return Projectdocument objects filtered by the modified_by column
 * @method array findByModifiedOn(string $modified_on) Return Projectdocument objects filtered by the modified_on column
 */
abstract class BaseProjectdocumentQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectdocumentQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\Projectdocument', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectdocumentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     ProjectdocumentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectdocumentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectdocumentQuery) {
            return $criteria;
        }
        $query = new ProjectdocumentQuery();
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
     * @return   Projectdocument|Projectdocument[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectdocumentPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectdocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Projectdocument A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `USER_ID`, `PROJECT_ID`, `VERSION`, `TYPE`, `NAME`, `STATUS`, `DOCUMENT`, `CREATED_BY`, `CREATED_ON`, `MODIFIED_BY`, `MODIFIED_ON` FROM `ProjectDocument` WHERE `ID` = :p0 AND `USER_ID` = :p1 AND `PROJECT_ID` = :p2';
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
            $obj = new Projectdocument();
            $obj->hydrate($row);
            ProjectdocumentPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return Projectdocument|Projectdocument[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Projectdocument[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ProjectdocumentPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ProjectdocumentPeer::USER_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(ProjectdocumentPeer::PROJECT_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ProjectdocumentPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ProjectdocumentPeer::USER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(ProjectdocumentPeer::PROJECT_ID, $key[2], Criteria::EQUAL);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectdocumentPeer::ID, $id, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectdocumentPeer::USER_ID, $userId, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(ProjectdocumentPeer::PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue');   // WHERE version = 'fooValue'
     * $query->filterByVersion('%fooValue%'); // WHERE version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $version The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($version)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $version)) {
                $version = str_replace('*', '%', $version);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::NAME, $name, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectdocumentPeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the document column
     *
     * Example usage:
     * <code>
     * $query->filterByDocument('fooValue');   // WHERE document = 'fooValue'
     * $query->filterByDocument('%fooValue%'); // WHERE document LIKE '%fooValue%'
     * </code>
     *
     * @param     string $document The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByDocument($document = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($document)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $document)) {
                $document = str_replace('*', '%', $document);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::DOCUMENT, $document, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ProjectdocumentPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ProjectdocumentPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::CREATED_BY, $createdBy, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByCreatedOn($createdOn = null, $comparison = null)
    {
        if (is_array($createdOn)) {
            $useMinMax = false;
            if (isset($createdOn['min'])) {
                $this->addUsingAlias(ProjectdocumentPeer::CREATED_ON, $createdOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdOn['max'])) {
                $this->addUsingAlias(ProjectdocumentPeer::CREATED_ON, $createdOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::CREATED_ON, $createdOn, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_BY, $modifiedBy, $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function filterByModifiedOn($modifiedOn = null, $comparison = null)
    {
        if (is_array($modifiedOn)) {
            $useMinMax = false;
            if (isset($modifiedOn['min'])) {
                $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_ON, $modifiedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedOn['max'])) {
                $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_ON, $modifiedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectdocumentPeer::MODIFIED_ON, $modifiedOn, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   ProjectdocumentQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ProjectdocumentPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectdocumentPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
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
     * @return   ProjectdocumentQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectdocumentPeer::PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectdocumentPeer::PROJECT_ID, $project->toKeyValue('Id', 'Id'), $comparison);
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
     * @return ProjectdocumentQuery The current query, for fluid interface
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
     * @param   Projectdocument $projectdocument Object to remove from the list of results
     *
     * @return ProjectdocumentQuery The current query, for fluid interface
     */
    public function prune($projectdocument = null)
    {
        if ($projectdocument) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ProjectdocumentPeer::ID), $projectdocument->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ProjectdocumentPeer::USER_ID), $projectdocument->getUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(ProjectdocumentPeer::PROJECT_ID), $projectdocument->getProjectId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
