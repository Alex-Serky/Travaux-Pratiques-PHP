<?php

use App\URL;
use App\Connexion;
use App\Model\{Post, Category};
use App\Helpers\Text;
use App\PaginatedQuery;

$title = 'Mon Blog';
$pdo = Connexion::getPDO();

$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC", // Paramètres SQL permettant de générer les enregistrements.
    "SELECT COUNT(id) FROM post", // Paramètres permettant d compter les résultats.
);
$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach ($posts as $post) {
    $postsByID[$post->getID()] = $post;
}
dd($postsByID);
$categories = $pdo
    ->query('SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN (' . implode(',', $ids) . ')') // La fonction implode() est de prendre un tabeau et d'en faire une chaîne de caractères
    ->fetchAll(PDO::FETCH_CLASS, Category::class);

    // On parcourt les catégories
    // On trouve l'article $posts correspondant à la ligne
    // On ajoute la catégorie à la ligne

$link = $router->url('home');
?>

<h1>Mon Blog</h1>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link); ?>
    <?= $paginatedQuery->nextLink($link); ?>
</div>