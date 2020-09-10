<?php

namespace App\Table;

use PDO;
use App\Model\{Post, Category};
use App\PaginatedQuery;

class PostTable extends Table
{
    public function findPaginated () {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC", // Paramètres SQL permettant de générer les enregistrements.
            "SELECT COUNT(id) FROM post", // Paramètres permettant d compter les résultats.
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory (int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.*
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id)
            FROM post_category
            WHERE category_id = {$categoryID}"
        );

        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }
}