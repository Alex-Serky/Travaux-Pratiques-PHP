<?php

require '../vendor/autoload.php';
define('VIEW_PATH', dirname(__DIR__) . '/views');

$router = new AltoRouter();

$router->map('GET', '/blog', function() {
    require VIEW_PATH . '/post/index.php';
});
$router->map('GET', '/blog/category', function() {
    require VIEW_PATH . '/category/show.php';
});

/* On demande au router si l'url tapé correspond à l'une de ces routes */
$match = $router->match();
$match['target'](); // On récupère la clé target et ensuite et on appelle la fonction