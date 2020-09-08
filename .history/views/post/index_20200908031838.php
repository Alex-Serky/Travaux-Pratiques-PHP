<?php

use App\URL;
use App\Connexion;
use App\Model\Post;
use App\Helpers\Text;
use App\PaginatedQuery;

$title = 'Mon Blog';
$pdo = Connexion::getPDO();

$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC", // Paramètres SQL permettant de générer les enregistrements.
    "SELECT COUNT(id) FROM post", // Paramètres permettant d compter les résultats.
);
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url('home');
?>

<h1>Mon Blog</h1>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3 my-2">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>
