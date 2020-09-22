<?php

namespace App;

use Valitron\Validator as ValitronValidator;

class Validator extends ValitronValidator
{
    protected static $_lang = "fr";
    
    public function __construct($data = array(), $fields = array(), $lang = null, $langDir = null)
    {
        parent::__construct($data, $fields, $lang, $langDir);
        self::addRule('image', function ($field, $value, array $params, array $fields) {
            return false;
        }, 'Le fichier n\'est pas une image valide');
    }
    protected function checkAndSetLabel($field, $message, $params)
    {
        return str_replace('{field}', '', $message);
    }
}