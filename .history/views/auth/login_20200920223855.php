<?php

use App\HTML\Form;
use App\Model\User;

$user = new User();
$form = new Form($user, []);

?>


<h1>Se Connecter</h1>

<form action="" method="post">
    <?= $form->input('username', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
</form>