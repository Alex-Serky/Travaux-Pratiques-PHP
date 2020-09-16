<?php

namespace App;

class ObjectHelper
{
    public static function hydrate ($object, array $data, string $fields): void
    {
        foreach ($fields as $field) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $fields)));
            $object->$method($data[$field]);
        }
    }
}