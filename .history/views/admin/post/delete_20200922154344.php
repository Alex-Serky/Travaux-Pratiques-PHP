<?php

use App\Connexion;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$pdo = Connexion::getPDO();
$table = new PostTable($pdo);
PO
$table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');

