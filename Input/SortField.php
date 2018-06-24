<?php
namespace Bywulf\Rfc14Bundle\Input;

use Bywulf\Rfc14Bundle\Annotation as Rfc14;
use Doctrine\ORM\QueryBuilder;

class SortField implements ApplyableToQueryBuilder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var Rfc14\Sort
     */
    private $sort;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SortField
     */
    public function setName(string $name): SortField
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     * @return SortField
     */
    public function setDirection(string $direction): SortField
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @return Rfc14\Sort
     */
    public function getSort(): Rfc14\Sort
    {
        return $this->sort;
    }

    /**
     * @param Rfc14\Sort $sort
     * @return SortField
     */
    public function setSort(Rfc14\Sort $sort): SortField
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return string
     */
    private function getQueryBuilderName(QueryBuilder $queryBuilder) {
        $queryBuilderName = $queryBuilder->getRootAliases()[0] . '.' . $this->getName();
        if ($this->sort->queryBuilderName) {
            $queryBuilderName = $this->sort->queryBuilderName;
        }

        return $queryBuilderName;
    }

    public function applyToQueryBuilder(QueryBuilder $queryBuilder)
    {
        switch ($this->getDirection()) {
            case Rfc14\Sort::ASCENDING:
                $queryBuilder->addOrderBy($this->getQueryBuilderName($queryBuilder), 'ASC');
                break;

            case Rfc14\Sort::DESCENDING:
                $queryBuilder->addOrderBy($this->getQueryBuilderName($queryBuilder), 'DESC');
                break;
        }
    }
}