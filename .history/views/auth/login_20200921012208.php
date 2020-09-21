<?php

use App\Connexion;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connexion::getPDO());
        try {
            $u = $table->findByUsername($_POST['username']);
            if (password_verify($_POST['password'], $u->getPassword())) {
                header('Location: ' . $router->url('admin_posts'));
            }
        } catch (NotFoundException $e) {
            // $errors['password'] = 'Identifiant ou mot de passe incorrect';
        }
    }
}

$form = new Form($user, $errors);

?>


<h1>Se Connecter</h1>

<form action="" method="post">
    <?= $form->input('username', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se Connecter</button>
</form>