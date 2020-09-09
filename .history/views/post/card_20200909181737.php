<?php

// Créer un tableau contenant la syntaxe HTML d'un lien
$categories = [];
foreach ($post->getCategories() as $category) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
        <a href="{$url}">{$category->getName()}</a>
HTML;
}
dd($categories);

?>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <p><?= $post->getExcerpt(); ?></p>
        <p class="text-muted">
            <?= $post->getCreatedAt()->format('d F Y H:i') ?> ::
            <?php foreach ($categories as $k => $category) :
                if ($k > 0) :
                    echo ', ';
                endif;
                $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
            ?><a href="<?= $category_url ?>"><?= e($category->getName()) ?></a>
            <?php endforeach ?>
        </p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>