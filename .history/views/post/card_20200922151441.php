<?php

// Créer un tableau contenant la syntaxe HTML d'un lien

/** Première méthode */

// $categories = [];
// foreach ($post->getCategories() as $category) {
//     $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
//     $categories[] = <<<HTML
//         <a href="{$url}">{$category->getName()}</a>
// HTML;
// }

/**
 * Deuxième méthode
 *
 * Array_map permet d'appliquer une fonction sur les éléments d'un tableau
 */

$categories = array_map(function ($category) use ($router) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    return <<<HTML
        <a href="{$url}">{$category->getName()}</a>
HTML;
}, $post->getCategories());

?>
<div class="card mb-3">
    <?php if ($post->)
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