<?php

// Créer un tableau contenant la syntaxe HTML d'un lien
// $categories = [];
// foreach ($post->getCategories() as $category) {
//     $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
//     $categories[] = <<<HTML
//         <a href="{$url}">{$category->getName()}</a>
// HTML;
// }

// Deuxième méthode
$categories = array_map(function($category) use ($router) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
        <a href="{$url}">{$category->getName()}</a>
HTML;
}, $post->getCategories());

?>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p><?= $post->getExcerpt(); ?></p>
        <p class="text-muted">
            <?= $post->getCreatedAt()->format('d F Y H:i') ?>
            <?php if (!empty($post->getCategories())): ?>
            ::
            <?= implode(', ', $categories) ?>
            <?php endif ?>
        </p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>