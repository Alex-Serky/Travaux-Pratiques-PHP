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
        $postsByID = [];
        foreach ($posts as $post) {
            $postsByID[$post->getID()] = $post;
        }

        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (' . implode(',', array_keys($postsByID)) . ')') // La fonction implode() est de prendre un tabeau et d'en faire une chaîne de caractères
            ->fetchAll(PDO::FETCH_CLASS, Category::class);

        /** Parcourir les catégories
         * Trouver l'article $posts correspondant à la ligne
         * Ajouter la catégorie à la ligne
         */
        foreach ($categories as $category) {
            $postsByID[$category->getPostID()]->addCategory($category);
        }
        return [$posts, $paginatedQuery];
    }
}