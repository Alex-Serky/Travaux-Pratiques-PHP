<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\Validator;
use App\Model\Category;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$success = false;

$errors = [];
$item = new Category();

if (!empty($_POST)) {
    $pdo = Connexion::getPDO();
    $table = new CategoryTable($pdo);

    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $table);
    ObjectHelper::hydrate($item, $_POST, ['name', 'content']);

    if ($v->validate()) {
        $table->create($item);
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($item, $errors);
?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu être enregistrée, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Créer une catégorie</h1>

<?php require('_form.php') ?>