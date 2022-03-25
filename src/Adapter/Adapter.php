<?php

namespace App\Adapter;

use App\Entity\Meeting;
use ReflectionClass;

class Adapter
{
    private $object;
    private $entity;
    private array $excludeProperties;

    public function __construct($objectFromApi, $excludeProperties, $entity)
    {
        $this->object = $objectFromApi;
        $this->excludeProperties = $excludeProperties;
        $this->entity = $entity;
    }

    public function toEntity()
    {
        $reflect = new ReflectionClass($this->object);

        foreach ($reflect->getProperties() as $reflectProperty) {
            $name = $reflectProperty->getName();
            if (in_array($name, $this->excludeProperties, true)) {
                continue;
            }

            $value = $name;

            $methodName = "get$name";
            if ((method_exists($this->object, $methodName))) {
                $value = $this->object->$methodName();
            }

            if ((method_exists($this->object, $name))) {
                $value = $this->object->$name();
            }

            $attributes[$name] = $value;
        }

        return $this->entity::createFromArray($attributes);
    }
}