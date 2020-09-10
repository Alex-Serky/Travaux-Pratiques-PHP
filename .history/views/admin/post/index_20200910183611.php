<?php

use App\Connexion;
use App\Table\PostTable;

$title = "Administration";
$pdo = Connexion::getPDO();
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

?>

<table class="table">
    <thead>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= e($post->getName()) ?></td>
            <td></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>