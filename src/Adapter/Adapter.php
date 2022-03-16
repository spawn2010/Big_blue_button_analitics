<?php

namespace App\Adapter;

use App\Entity\Meeting;
use ReflectionClass;

class Adapter
{
    private $object;

    private array $excludeProperties;

    public function __construct($objectFromApi, $excludeProperties)
    {
        $this->object = $objectFromApi;
        $this->excludeProperties = $excludeProperties;
    }

    public function toEntity()
    {
        $reflect = new ReflectionClass($this->object);

        foreach ($reflect->getProperties() as $reflectProperty) {
            $name = $reflectProperty->getName();
            if (in_array($name, $this->excludeProperties)) {
                continue;
            }

            // Получаем значение свойства, по умолчанию
            $value = $name;

            // Если есть метод для этого свойства, обращаемся к нему
            $methodName = "get$name";
            if (method_exists($this->object, $methodName)) {
                $value = $this->object->$methodName();
            }

            $attributes[$name] = $value;
        }

        return Meeting::createFromArray($attributes);
    }
}