<?php

namespace hsTrading\FrontEndBundle\Model\om;

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
use hsTrading\FrontEndBundle\Model\Product;
use hsTrading\FrontEndBundle\Model\ProductCategory;
use hsTrading\FrontEndBundle\Model\ProductCategoryDetails;
use hsTrading\FrontEndBundle\Model\ProductCategoryDetailsPeer;
use hsTrading\FrontEndBundle\Model\ProductCategoryDetailsQuery;

/**
 * @method ProductCategoryDetailsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProductCategoryDetailsQuery orderByProductcategoryId($order = Criteria::ASC) Order by the productCategory_id column
 * @method ProductCategoryDetailsQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method ProductCategoryDetailsQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method ProductCategoryDetailsQuery orderByLabeleng($order = Criteria::ASC) Order by the labeleng column
 * @method ProductCategoryDetailsQuery orderByCategorder($order = Criteria::ASC) Order by the categorder column
 * @method ProductCategoryDetailsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method ProductCategoryDetailsQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method ProductCategoryDetailsQuery groupById() Group by the id column
 * @method ProductCategoryDetailsQuery groupByProductcategoryId() Group by the productCategory_id column
 * @method ProductCategoryDetailsQuery groupByCode() Group by the code column
 * @method ProductCategoryDetailsQuery groupByLabel() Group by the label column
 * @method ProductCategoryDetailsQuery groupByLabeleng() Group by the labeleng column
 * @method ProductCategoryDetailsQuery groupByCategorder() Group by the categorder column
 * @method ProductCategoryDetailsQuery groupByCreatedAt() Group by the created_at column
 * @method ProductCategoryDetailsQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method ProductCategoryDetailsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProductCategoryDetailsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProductCategoryDetailsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProductCategoryDetailsQuery leftJoinProductCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductCategory relation
 * @method ProductCategoryDetailsQuery rightJoinProductCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductCategory relation
 * @method ProductCategoryDetailsQuery innerJoinProductCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductCategory relation
 *
 * @method ProductCategoryDetailsQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method ProductCategoryDetailsQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method ProductCategoryDetailsQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method ProductCategoryDetails findOne(PropelPDO $con = null) Return the first ProductCategoryDetails matching the query
 * @method ProductCategoryDetails findOneOrCreate(PropelPDO $con = null) Return the first ProductCategoryDetails matching the query, or a new ProductCategoryDetails object populated from the query conditions when no match is found
 *
 * @method ProductCategoryDetails findOneByProductcategoryId(int $productCategory_id) Return the first ProductCategoryDetails filtered by the productCategory_id column
 * @method ProductCategoryDetails findOneByCode(string $code) Return the first ProductCategoryDetails filtered by the code column
 * @method ProductCategoryDetails findOneByLabel(string $label) Return the first ProductCategoryDetails filtered by the label column
 * @method ProductCategoryDetails findOneByLabeleng(string $labeleng) Return the first ProductCategoryDetails filtered by the labeleng column
 * @method ProductCategoryDetails findOneByCategorder(int $categorder) Return the first ProductCategoryDetails filtered by the categorder column
 * @method ProductCategoryDetails findOneByCreatedAt(string $created_at) Return the first ProductCategoryDetails filtered by the created_at column
 * @method ProductCategoryDetails findOneByUpdatedAt(string $updated_at) Return the first ProductCategoryDetails filtered by the updated_at column
 *
 * @method array findById(int $id) Return ProductCategoryDetails objects filtered by the id column
 * @method array findByProductcategoryId(int $productCategory_id) Return ProductCategoryDetails objects filtered by the productCategory_id column
 * @method array findByCode(string $code) Return ProductCategoryDetails objects filtered by the code column
 * @method array findByLabel(string $label) Return ProductCategoryDetails objects filtered by the label column
 * @method array findByLabeleng(string $labeleng) Return ProductCategoryDetails objects filtered by the labeleng column
 * @method array findByCategorder(int $categorder) Return ProductCategoryDetails objects filtered by the categorder column
 * @method array findByCreatedAt(string $created_at) Return ProductCategoryDetails objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return ProductCategoryDetails objects filtered by the updated_at column
 */
abstract class BaseProductCategoryDetailsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProductCategoryDetailsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'hsTrading\\FrontEndBundle\\Model\\ProductCategoryDetails';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProductCategoryDetailsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProductCategoryDetailsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProductCategoryDetailsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProductCategoryDetailsQuery) {
            return $criteria;
        }
        $query = new ProductCategoryDetailsQuery(null, null, $modelAlias);

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
     * @return   ProductCategoryDetails|ProductCategoryDetails[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductCategoryDetailsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProductCategoryDetailsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 ProductCategoryDetails A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 ProductCategoryDetails A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `productCategory_id`, `code`, `label`, `labeleng`, `categorder`, `created_at`, `updated_at` FROM `hs_product_category_details` WHERE `id` = :p0';
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
            $obj = new ProductCategoryDetails();
            $obj->hydrate($row);
            ProductCategoryDetailsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProductCategoryDetails|ProductCategoryDetails[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProductCategoryDetails[]|mixed the list of results, formatted by the current formatter
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
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the productCategory_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductcategoryId(1234); // WHERE productCategory_id = 1234
     * $query->filterByProductcategoryId(array(12, 34)); // WHERE productCategory_id IN (12, 34)
     * $query->filterByProductcategoryId(array('min' => 12)); // WHERE productCategory_id >= 12
     * $query->filterByProductcategoryId(array('max' => 12)); // WHERE productCategory_id <= 12
     * </code>
     *
     * @see       filterByProductCategory()
     *
     * @param     mixed $productcategoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByProductcategoryId($productcategoryId = null, $comparison = null)
    {
        if (is_array($productcategoryId)) {
            $useMinMax = false;
            if (isset($productcategoryId['min'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::PRODUCTCATEGORY_ID, $productcategoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productcategoryId['max'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::PRODUCTCATEGORY_ID, $productcategoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::PRODUCTCATEGORY_ID, $productcategoryId, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::CODE, $code, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%'); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $label)) {
                $label = str_replace('*', '%', $label);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the labeleng column
     *
     * Example usage:
     * <code>
     * $query->filterByLabeleng('fooValue');   // WHERE labeleng = 'fooValue'
     * $query->filterByLabeleng('%fooValue%'); // WHERE labeleng LIKE '%fooValue%'
     * </code>
     *
     * @param     string $labeleng The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByLabeleng($labeleng = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($labeleng)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $labeleng)) {
                $labeleng = str_replace('*', '%', $labeleng);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::LABELENG, $labeleng, $comparison);
    }

    /**
     * Filter the query on the categorder column
     *
     * Example usage:
     * <code>
     * $query->filterByCategorder(1234); // WHERE categorder = 1234
     * $query->filterByCategorder(array(12, 34)); // WHERE categorder IN (12, 34)
     * $query->filterByCategorder(array('min' => 12)); // WHERE categorder >= 12
     * $query->filterByCategorder(array('max' => 12)); // WHERE categorder <= 12
     * </code>
     *
     * @param     mixed $categorder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByCategorder($categorder = null, $comparison = null)
    {
        if (is_array($categorder)) {
            $useMinMax = false;
            if (isset($categorder['min'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::CATEGORDER, $categorder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categorder['max'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::CATEGORDER, $categorder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::CATEGORDER, $categorder, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ProductCategoryDetailsPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductCategoryDetailsPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related ProductCategory object
     *
     * @param   ProductCategory|PropelObjectCollection $productCategory The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProductCategoryDetailsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProductCategory($productCategory, $comparison = null)
    {
        if ($productCategory instanceof ProductCategory) {
            return $this
                ->addUsingAlias(ProductCategoryDetailsPeer::PRODUCTCATEGORY_ID, $productCategory->getId(), $comparison);
        } elseif ($productCategory instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductCategoryDetailsPeer::PRODUCTCATEGORY_ID, $productCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductCategory() only accepts arguments of type ProductCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function joinProductCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductCategory');

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
            $this->addJoinObject($join, 'ProductCategory');
        }

        return $this;
    }

    /**
     * Use the ProductCategory relation ProductCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \hsTrading\FrontEndBundle\Model\ProductCategoryQuery A secondary query class using the current class as primary query
     */
    public function useProductCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductCategory', '\hsTrading\FrontEndBundle\Model\ProductCategoryQuery');
    }

    /**
     * Filter the query by a related Product object
     *
     * @param   Product|PropelObjectCollection $product  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProductCategoryDetailsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof Product) {
            return $this
                ->addUsingAlias(ProductCategoryDetailsPeer::ID, $product->getIdCategoryDetails(), $comparison);
        } elseif ($product instanceof PropelObjectCollection) {
            return $this
                ->useProductQuery()
                ->filterByPrimaryKeys($product->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type Product or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \hsTrading\FrontEndBundle\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\hsTrading\FrontEndBundle\Model\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProductCategoryDetails $productCategoryDetails Object to remove from the list of results
     *
     * @return ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function prune($productCategoryDetails = null)
    {
        if ($productCategoryDetails) {
            $this->addUsingAlias(ProductCategoryDetailsPeer::ID, $productCategoryDetails->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ProductCategoryDetailsPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ProductCategoryDetailsPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ProductCategoryDetailsPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ProductCategoryDetailsPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ProductCategoryDetailsPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ProductCategoryDetailsQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ProductCategoryDetailsPeer::CREATED_AT);
    }
}
