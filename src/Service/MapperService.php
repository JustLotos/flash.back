<?php

declare(strict_types=1);

namespace App\Service;

use AutoMapperPlus\AutoMapperInterface;

class MapperService
{
    /**
     * @var AutoMapperInterface
     */
    private $mapper;

    public function __construct(AutoMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function map($sourceObject, $destinationClassName)
    {
        return $this->mapper->map($sourceObject, $destinationClassName);
    }

    public function mapToObject($sourceObject, $destinationObject)
    {
        return $this->mapper->mapToObject($sourceObject, $destinationObject);
    }
}