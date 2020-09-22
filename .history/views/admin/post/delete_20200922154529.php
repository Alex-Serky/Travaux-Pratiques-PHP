<?php

use App\Attachment\PostAttachment;
use App\Connexion;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$pdo = Connexion::getPDO();
$table = new PostTable($pdo);
$post = $postTable->find($params['id']);
PostAttachment::detach($post);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');

