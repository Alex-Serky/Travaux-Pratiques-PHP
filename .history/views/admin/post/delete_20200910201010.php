<?php

use App\Connexion;
use App\Table\PostTable;

$pdo = Connexion::getPDO();
$table = new PostTable($pdo);
// $table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');

