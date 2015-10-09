<?php
namespace kennysLabs\LusoExpress\Domain\User\Query;

use kennysLabs\LusoExpress\Domain\Shared\Query\Pagination;
use kennysLabs\LusoExpress\Domain\Shared\Query\Sorting;
use kennysLabs\LusoExpress\Domain\Shared\Query\QueryInterface;

/**
 * Class UserList
 */
final class UserList implements QueryInterface
{
    /**
     * Defines the default limit for the pagination
     */
    const DEFAULT_LIMIT = 20;

    /**
     * Defines the default offset for the pagination
     */
    const DEFAULT_OFFSET = 0;

    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * @var Sorting
     */
    protected $sorting;

    /**
     * @var null|string
     */
    private $sellerUuid;

    /**
     * @var array
     */
    private $allowedRoleIds;

    /**
     * @param Pagination $pagination
     * @param Sorting $sorting
     * @param array $allowedRoleIds
     */
    public function __construct(Pagination $pagination, Sorting $sorting, array $allowedRoleIds)
    {
        $this->pagination = $pagination;
        $this->sorting = $sorting;
        $this->allowedRoleIds = $allowedRoleIds;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return Sorting
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @return array
     */
    public function getAllowedRoleIds()
    {
        return $this->allowedRoleIds;
    }
}
