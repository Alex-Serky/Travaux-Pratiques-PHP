<?php

namespace App\Validators;

use App\Table\PostTable;
use App\Validator;

class PostValidator
{
    private $data;

    public function __construct(array $data, PostTable $table)
    {
        $this->data = $data;
        $v = new Validator($data);
        $v->rule('required', ['name', 'slug']);
        $v->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $v->rule('slug', 'slug');
        $v->rule(function ($field, $value) use ($table) {
            return !$table->exists($field, $value);
        }, 'slug', 'Ce slug est déjà utilisé');
        $this->validator = $v;
    }

    public function validate (): bool
    {
        return $this->validator->validate();
    }

    public function errors (): array
    {
        return $this->validator->errors();
    }
}