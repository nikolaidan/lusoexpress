<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Query;

/**
 * Class Sorting
 */
class Sorting
{
    /**
     * @var array
     */
    protected $sortColumns = [];

    /**
     * @param $column
     * @param $direction
     */
    public function addSortColumn($column, $direction)
    {
        $this->sortColumns[$column] = $direction;
    }

    /**
     * @return array
     */
    public function getSortColumns()
    {
        return $this->sortColumns;
    }
}
