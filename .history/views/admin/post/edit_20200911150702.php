<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

if (!empty($_post)) {
    dd('Traiter les données !');
}

?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Titre</label>
        <input type="text" class="form-control" name="name" value="<?= e($post->getName()) ?>">
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>