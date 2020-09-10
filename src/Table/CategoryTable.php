<?php

namespace App\Table;

use PDO;
use App\Model\Category;

final class CategoryTable extends Table
{
    protected $table = "category";
    protected $class = Category::class;

    /**
     *
     * @param array App\Model\Post[] $posts : tableau d'article
     * @return void
     */
    public function hydratePosts (array $posts): void
    {
        $postsByID = [];
        foreach ($posts as $post) {
            $postsByID[$post->getID()] = $post;
        }

        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')') // La fonction implode() est de prendre un tabeau et d'en faire une chaîne de caractères
            ->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($categories as $category) {
            $postsByID[$category->getPostID()]->addCategory($category);
        }
    }
}