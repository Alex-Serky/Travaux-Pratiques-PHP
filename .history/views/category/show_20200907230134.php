<?php

use PDO;
use App\URL;
use Exception;
use App\Connexion;
use App\PaginatedQuery;
use App\Model\{Post, Category};

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);

/** @var Category|false */
$category = $query->fetch();

if ($category === false) {
    throw new Exception ('Aucune catégorie ne correspond à cet ID');
}
/**
 * Si le slug ne correspond pas à ce que nous avons dans l'url, on fait une redirection.
 */
if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
};

$title = "Catégorie {$category->getName()}";

$paginatedQuery = new PaginatedQuery(
    "SELECT p.*
    FROM post p
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$category->getID()}
    ORDER BY created_at DESC",
    "SELECT COUNT(category_id)
    FROM post_category
    WHERE category_id = ' {$category->getID()}",
    Post::class
);

/**
 * @var Post[]
 * On va récupérer un tableau d'article
 */
$posts = $paginatedQuery->getItems();
$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
?>

<h1><?= e($title) ?></h1>

<div class="row">
    <?php foreach ($posts as $post): ?>
    <div class="col-md-3 my-2">
        <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1): ?>
        <?php
        $l = $link;
        if ($currentPage > 2) $l = $link . '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $l ?>" class="btn btn-primary">&laquo; Page précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $link ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante &raquo;</a>
    <?php endif ?>
</div>