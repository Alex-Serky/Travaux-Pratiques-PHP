<?php

use App\Auth;
use App\Connexion;
use App\HTML\Form;
use App\Validator;
use App\ObjectHelper;
use App\Table\{CategoryTable, PostTable};
use App\Validators\PostValidator;

Auth::check();

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;

$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $data = array_merge($_POST, $_FILES);
    $v = new PostValidator($data, $postTable, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $data, ['name', 'content', 'slug', 'created_at', 'image']);

    if ($v->validate()) {
        dd($post);
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if ($success) : ?>
    <div class="alert alert-success">
        L'article a bien été modifié.
    </div>
<?php endif ?>

<?php if (isset($_GET['created'])) : ?>
    <div class="alert alert-success">
        L'article a bien été créé
    </div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être modifié, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<?php require('_form.php'); ?>