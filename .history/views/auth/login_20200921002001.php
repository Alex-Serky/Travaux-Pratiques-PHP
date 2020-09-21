<?php

use App\HTML\Form;
use App\Model\User;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $errors['password'] = 'Identifiant ou mot de passe incorrect';
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