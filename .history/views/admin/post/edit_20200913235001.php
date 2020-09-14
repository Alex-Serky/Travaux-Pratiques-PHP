<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if (!empty($_POST)) {
    if (empty($_POST['name']))
    {
        $errors['name'] = "Le champ titre ne peut pas être vide";
    }
    if (mb_strlen($_POST['name']) <= 3) {
        $errors['name'][] = "Le titre doit contenir plus de 3 caractères";
    }
    dd($errors);


    $post->setName($_POST['name']);
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
        <input type="text" class="form-control" name="name" value="<?= e($post->getName()) ?>" required>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>