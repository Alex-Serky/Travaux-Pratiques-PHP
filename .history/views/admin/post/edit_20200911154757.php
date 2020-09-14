<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;

if (!empty($_POST)) {
    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content']);
    $postTable->update($post);
    $success = true;
}
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        L'article a bien été modifié.
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Titre</label>
        <input type="text" class="form-control" name="name" value="<?= e($post->getName()) ?>">
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>