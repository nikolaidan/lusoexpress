<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Query;

/**
 * Class Pagination
 */
class Pagination
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var int
     */
    protected $totalCount;

    /**
     * @param int $limit
     * @param int $offset
     */
    public function __construct($limit, $offset = 0)
    {
        $this->setLimit($limit);
        $this->setOffset($offset);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @throws \RuntimeException
     *
     * @return int
     */
    public function getTotalCount()
    {
        if (null === $this->totalCount) {
            throw new \RuntimeException('Total Count has to be set before it\'s going to be used.');
        }

        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     *
     * @throws \RuntimeException
     *
     * @return int
     */
    public function setTotalCount($totalCount)
    {
        if ($totalCount < $this->getOffset()) {
            throw new \RuntimeException('Total Count has to be bigger than offset.');
        }

        $this->totalCount = (int) $totalCount;
    }

    /**
     * @param int $limit
     */
    protected function setLimit($limit)
    {
        $this->limit = (int) $limit;
    }

    /**
     * @param int $offset
     */
    protected function setOffset($offset)
    {
        $this->offset = (int) $offset;
    }
}
