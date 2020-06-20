<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
   'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);


// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Chargement de la BDD des articles
$articles = require __DIR__.'/articles-data.php';

// Chargement de la fonction qui teste si l'article existe
require __DIR__.'/articles-lib.php';



if (!isset($_GET['id']) || empty($_GET['id'])) {
    $url = 'article-404.php';
    header("Location: {$url}", true, 302);
    exit(); 
} elseif (!articleExists($_GET['id'], $articles)) {
    $url = 'article-404.php';
    header("Location: {$url}", true, 302);
    exit(); 
}

$url = 'articles.php';
header("Location: {$url}", true, 302);
exit(); 
