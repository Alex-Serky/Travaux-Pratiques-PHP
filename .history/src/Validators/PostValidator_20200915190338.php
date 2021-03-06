<?php

namespace App\Validators;

use Valitron\Validator;

class PostValidator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $v = new Validator($data);
        $v->rule('required', ['name', 'slug']);
        $v->rule('lengthBetween', ['name', 'slug'], 3, 200);
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