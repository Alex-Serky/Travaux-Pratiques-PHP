<?php

use App\Connexion;
use App\Helpers\Text;
use App\PaginatedQuery;
use App\Table\PostTable;
use App\Model\{Post, Category};

$title = 'Mon Blog';
$pdo = Connexion::getPDO();

$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC", // Paramètres SQL permettant de générer les enregistrements.
    "SELECT COUNT(id) FROM post", // Paramètres permettant d compter les résultats.
);
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
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>