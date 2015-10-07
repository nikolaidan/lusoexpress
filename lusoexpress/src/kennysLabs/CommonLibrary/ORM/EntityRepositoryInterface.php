<?php

namespace kennysLabs\CommonLibrary\ORM;

interface EntityRepositoryInterface
{
    public function __construct(\FluentPDO $pdo);
}