<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\Validator;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$pdo = Connexion::getPDO();
$table = new CategoryTable($pdo);
$item = $table->find($params['id']);
$success = false;
$errors = [];
$fields = ['name', 'content', 'slug', 'created_at'];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table, $item->getID());
    ObjectHelper::hydrate($item, $_POST, $fields);

    if ($v->validate()) {
        $table->update([
            'name' => $item->getName(),
            'slug' => $item->getSlug(),
        ], $item->getID());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);
?>

<?php if ($success) : ?>
    <div class="alert alert-success">
        La catégorie a bien été modifiée.
    </div>
<?php endif ?>

<?php if (isset($_GET['created'])) : ?>
    <div class="alert alert-success">
        La catégorie a bien été créée
    </div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu être modifié, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Editer la catégorie <?= e($item->getName()) ?></h1>

<?php require('_form.php'); ?>