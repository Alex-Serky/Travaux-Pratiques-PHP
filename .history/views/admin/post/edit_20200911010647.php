<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>