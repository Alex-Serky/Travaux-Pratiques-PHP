<?php

namespace App\Model;

use DateTime;
use App\Helpers\Text;

class Post
{
    private $id;
    private $name;
    private $slug;
    private $content;
    private $created_at;
    private $categories = [];
    private $image;
    private $oldImage;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(e($this->content));
    }

    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(e(Text::excerpt($this->content, 60)));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function setCreatedAt (string $date): self
    {
        $this->created_at = $date;
        return $this;
    }

    public function getSlug (): ?string
    {
        return $this->slug;
    }

    public function setSlug (string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getID (): ?int
    {
        return $this->id;
    }

    public function setID ($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     *
     * @return Category[]
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function getCategoriesIds (): array
    {
        $ids = [];
        foreach ($this->categories  as  $category) {
            $ids[] = $category->getID();
        }
        return $ids;
    }

    public function addCategory (Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    public function getImage (): ?string
    {
        return $this->image;
    }

    public function setImage ($image): self
    {
        if (is_array($image) && !empty($image['tmp_name'])) {
            if (!empty($this->image)) {
                $this->oldImage = $oldImage;
            }
            $this->image = $image['tmp_name'];
        }
        if (is_string($image) && !empty($image)) {
            $this->image = $image;
        }
        return $this;
    }

    /**
     * Get the value of oldImage
     */ 
    public function getOldImage(): ?string
    {
        return $this->oldImage;
    }

    /**
     * Set the value of oldImage
     *
     * @return  self
     */ 
    public function setOldImage($oldImage)
    {
        $this->oldImage = $oldImage;

        return $this;
    }
}