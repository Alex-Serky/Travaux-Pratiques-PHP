<?php

use App\Connexion;
use App\HTML\Form;
use App\Validator;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\PostTable;
use App\Validators\PostValidator;

$success = false;

$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if (!empty($_POST)) {
    $pdo = Connexion::getPDO();
    $postTable = new PostTable($pdo);
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID());
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);

    if ($v->validate()) {
        $postTable->update($post);
        header('Location: ' . $router->url('admin_post', ['id' => $post->getID()]) . '?$success=1');
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if ($success) : ?>
    <div class="alert alert-success">
        L'article a bien été enregistré.
    </div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        L'article n'a pas pu être enregistré, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Créer un article</h1>

<?php require('_form.php'); ?>
