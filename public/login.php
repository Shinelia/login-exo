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
$formData = [ 'login' => '','password' => '',];

// Appel à la "BDD"
$user = require __DIR__.'/user-data.php';

// démarrage de la session
session_start();

$formData = [
    'login' => '',
    'password'  => '',
];

if($_POST){
    $errors = [];
    $message = [];

    dump($_POST);
    dump($user['login']);


    // Remplacement des valeurs par défaut par celles de l'utilisateur
    if (isset($_POST['login'])) {
       $formData['login'] = $_POST['login'];}
    if (isset($_POST['password'])) {
       $formData['password'] = $_POST['password'];}



    //Validation des données envoyées par l'utilisateur

    //Validation du login
    if (!isset($_POST['login']) || empty($_POST['login']) 
    || strlen($_POST['login']<3) || strlen($_POST['login']>100) 
    || ($_POST['login'] != $user['login'])){
       $errors['auth'] = true;
       dump('login pas ok');

   } 

    //Validation du mot de passe
   if (!isset($_POST['password']) || empty($_POST['password']) 
    || strlen($_POST['password']<3) || strlen($_POST['password']>100)){
        if (!password_verify($_POST['password'], $user['passwrd_hash'])) {
            $errors['auth'] = true;
            dump('password pas ok');
       }
   } 

   if($errors['auth']){
        $message['auth'] = "Login ou mot de passe incorrect.";
    }

    if (!$errors) {
        dump('ok');
    }
    
}




// initialisation d'une donnée
$greeting = 'Page d\'authentification';

// affichage du rendu d'un template
echo $twig->render('login.html.twig', [
    // transmission de données au template
    'greeting' => $greeting,
    'message' => $message,
    'formData' => $formData,
    'errors' => $errors,
]);