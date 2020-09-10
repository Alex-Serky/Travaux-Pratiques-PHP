<?php

use App\Connexion;
use App\PaginatedQuery;
use App\Model\{Post, Category};
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);

if ($category === null) {
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
    WHERE category_id = {$category->getID()}"
);

/**
 * @var Post[]
 * On va récupérer un tableau d'article
 */
$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach ($posts as $post) {
    $postsByID[$post->getID()] = $post;
}

$categories = $pdo
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
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>