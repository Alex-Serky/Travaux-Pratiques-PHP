<?php

use App\Connexion;
use App\Table\PostTable;
use Valitron\Validator;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->labels(array(
        'name' => 'Titre',
        'content' => 'Contenu'
    ));
    $v->rule('required', 'name');
    $post->setName($_POST['name']);
    if ($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        L'article a bien été modifié.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas être modifié, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Titre</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''?>" name="name" value="<?= e($post->getName()) ?>">
        <?php if (isset($errors['name'])): ?>
            <div class="invalid-feedback">
                <?= implode('<br>', $errors['name']) ?>
            </div>
        <?php endif ?>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>