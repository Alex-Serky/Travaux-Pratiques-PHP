<?php

use App\Connexion;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Table\Table;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$query = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}
?>

<h1 class="card-title"><?= e($post->getName()) ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y H:i') ?></p>
<?php foreach ($post->getCategories() as $k => $category):
    if ($k > 0):
        echo ', ';
    endif;
    $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    ?><a href="<?= $category_url ?>"><?= e($category->getName())?></a><?php
endforeach ?>
<p><?= $post->getFormattedContent() ?></p>
