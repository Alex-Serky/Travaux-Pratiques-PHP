<?php

namespace App\Model;

class Category
{
    private $id;
    private $name;
    private $slug;
    private $post_id;

    public function getID (): ?string
    {
        return $this->id;
    }

    public function getName (): ?string
    {
        return $this->name;
    }

    public function getSlug (): ?string
    {
        return $this->slug;
    }

    public function postID(): ?string
    {
        return $this->post_id;
    }
}