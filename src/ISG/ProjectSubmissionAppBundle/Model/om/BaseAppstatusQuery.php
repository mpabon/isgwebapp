<?php

namespace ISG\ProjectSubmissionAppBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use ISG\ProjectSubmissionAppBundle\Model\Appstatus;
use ISG\ProjectSubmissionAppBundle\Model\AppstatusPeer;
use ISG\ProjectSubmissionAppBundle\Model\AppstatusQuery;

/**
 * @method AppstatusQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AppstatusQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AppstatusQuery orderByActiveFrom($order = Criteria::ASC) Order by the active_from column
 * @method AppstatusQuery orderByActiveUntill($order = Criteria::ASC) Order by the active_untill column
 * @method AppstatusQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 * @method AppstatusQuery orderByModifiedOn($order = Criteria::ASC) Order by the modified_on column
 *
 * @method AppstatusQuery groupById() Group by the id column
 * @method AppstatusQuery groupByName() Group by the name column
 * @method AppstatusQuery groupByActiveFrom() Group by the active_from column
 * @method AppstatusQuery groupByActiveUntill() Group by the active_untill column
 * @method AppstatusQuery groupByModifiedBy() Group by the modified_by column
 * @method AppstatusQuery groupByModifiedOn() Group by the modified_on column
 *
 * @method AppstatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AppstatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AppstatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Appstatus findOne(PropelPDO $con = null) Return the first Appstatus matching the query
 * @method Appstatus findOneOrCreate(PropelPDO $con = null) Return the first Appstatus matching the query, or a new Appstatus object populated from the query conditions when no match is found
 *
 * @method Appstatus findOneById(int $id) Return the first Appstatus filtered by the id column
 * @method Appstatus findOneByName(string $name) Return the first Appstatus filtered by the name column
 * @method Appstatus findOneByActiveFrom(string $active_from) Return the first Appstatus filtered by the active_from column
 * @method Appstatus findOneByActiveUntill(string $active_untill) Return the first Appstatus filtered by the active_untill column
 * @method Appstatus findOneByModifiedBy(int $modified_by) Return the first Appstatus filtered by the modified_by column
 * @method Appstatus findOneByModifiedOn(string $modified_on) Return the first Appstatus filtered by the modified_on column
 *
 * @method array findById(int $id) Return Appstatus objects filtered by the id column
 * @method array findByName(string $name) Return Appstatus objects filtered by the name column
 * @method array findByActiveFrom(string $active_from) Return Appstatus objects filtered by the active_from column
 * @method array findByActiveUntill(string $active_untill) Return Appstatus objects filtered by the active_untill column
 * @method array findByModifiedBy(int $modified_by) Return Appstatus objects filtered by the modified_by column
 * @method array findByModifiedOn(string $modified_on) Return Appstatus objects filtered by the modified_on column
 */
abstract class BaseAppstatusQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAppstatusQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'ISG\\ProjectSubmissionAppBundle\\Model\\Appstatus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AppstatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     AppstatusQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AppstatusQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AppstatusQuery) {
            return $criteria;
        }
        $query = new AppstatusQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Appstatus|Appstatus[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AppstatusPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AppstatusPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   Appstatus A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `NAME`, `ACTIVE_FROM`, `ACTIVE_UNTILL`, `MODIFIED_BY`, `MODIFIED_ON` FROM `AppStatus` WHERE `ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Appstatus();
            $obj->hydrate($row);
            AppstatusPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Appstatus|Appstatus[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Appstatus[]|mixed the list of results, formatted by the current formatter
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
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AppstatusPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AppstatusPeer::ID, $keys, Criteria::IN);
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
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(AppstatusPeer::ID, $id, $comparison);
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
     * @return AppstatusQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AppstatusPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the active_from column
     *
     * Example usage:
     * <code>
     * $query->filterByActiveFrom('2011-03-14'); // WHERE active_from = '2011-03-14'
     * $query->filterByActiveFrom('now'); // WHERE active_from = '2011-03-14'
     * $query->filterByActiveFrom(array('max' => 'yesterday')); // WHERE active_from > '2011-03-13'
     * </code>
     *
     * @param     mixed $activeFrom The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByActiveFrom($activeFrom = null, $comparison = null)
    {
        if (is_array($activeFrom)) {
            $useMinMax = false;
            if (isset($activeFrom['min'])) {
                $this->addUsingAlias(AppstatusPeer::ACTIVE_FROM, $activeFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activeFrom['max'])) {
                $this->addUsingAlias(AppstatusPeer::ACTIVE_FROM, $activeFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppstatusPeer::ACTIVE_FROM, $activeFrom, $comparison);
    }

    /**
     * Filter the query on the active_untill column
     *
     * Example usage:
     * <code>
     * $query->filterByActiveUntill('2011-03-14'); // WHERE active_untill = '2011-03-14'
     * $query->filterByActiveUntill('now'); // WHERE active_untill = '2011-03-14'
     * $query->filterByActiveUntill(array('max' => 'yesterday')); // WHERE active_untill > '2011-03-13'
     * </code>
     *
     * @param     mixed $activeUntill The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByActiveUntill($activeUntill = null, $comparison = null)
    {
        if (is_array($activeUntill)) {
            $useMinMax = false;
            if (isset($activeUntill['min'])) {
                $this->addUsingAlias(AppstatusPeer::ACTIVE_UNTILL, $activeUntill['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activeUntill['max'])) {
                $this->addUsingAlias(AppstatusPeer::ACTIVE_UNTILL, $activeUntill['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppstatusPeer::ACTIVE_UNTILL, $activeUntill, $comparison);
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
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(AppstatusPeer::MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(AppstatusPeer::MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppstatusPeer::MODIFIED_BY, $modifiedBy, $comparison);
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
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function filterByModifiedOn($modifiedOn = null, $comparison = null)
    {
        if (is_array($modifiedOn)) {
            $useMinMax = false;
            if (isset($modifiedOn['min'])) {
                $this->addUsingAlias(AppstatusPeer::MODIFIED_ON, $modifiedOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedOn['max'])) {
                $this->addUsingAlias(AppstatusPeer::MODIFIED_ON, $modifiedOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppstatusPeer::MODIFIED_ON, $modifiedOn, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Appstatus $appstatus Object to remove from the list of results
     *
     * @return AppstatusQuery The current query, for fluid interface
     */
    public function prune($appstatus = null)
    {
        if ($appstatus) {
            $this->addUsingAlias(AppstatusPeer::ID, $appstatus->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
