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


$formData = [
    'name' => '',
    'description' => '',
    'price' => '',
    'quantity' => ''
];


if($_POST){
    $errors = [];
    $messages = [];

    //Remplacement des données de l'utilisateur
    if (isset($_POST['name'])) {
        $formData['name'] = $_POST['name'];}
    if (isset($_POST['description'])) {
        $formData['description'] = $_POST['description'];}
    if (isset($_POST['price'])) {
        $formData['price'] = $_POST['price'];}
    if (isset($_POST['quantity'])) {
        $formData['quantity'] = $_POST['quantity'];}

    //Validation des données
    //Name : Ne doit pas être vide, entre 2 et 100 caractères
    if (!isset($_POST['name']) || empty($_POST['name'])){
        $errors['name'] = true;
        $messages['name'] = "Merci de renseigner le nom de l'article.";
    }
    if ((strlen($_POST['name'])<2) || (strlen($_POST['name'])>100)){
        $errors['name'] = true;
        $messages['name'] = "Le nom doit être compris entre 2 et 100 caractères.";
    }

    //Description : optionnel mais si non vide : pas de < > 
    if (isset($_POST['description'])){
        if(((strpos($_POST['description'], '<') || strpos($_POST['description'], '>')) == 0)
        || (strpos($_POST['description'], '<') || strpos($_POST['description'], '>'))) {
            $errors['description'] = true;
            $messages['description'] = "La description ne peut pas contenir les caractères : < ou >.";
        }    
    }
    
    //Price : Ne doit pas être vide, int ou float
    if (!isset($_POST['price']) || empty($_POST['price'])){
        $errors['price'] = true;
        $messages['price'] = "Merci de renseigner le prix de l'article.";
    }
    if (!is_numeric($_POST['price']) || $_POST['price']<0){
        $errors['price'] = true;
        $messages['price'] = "Merci d'entrer un prix correct.";
    }

    //Quantity : Ne doit pas etre vide, int positif
    if (!isset($_POST['quantity']) || empty($_POST['quantity'])){
        $errors['quantity'] = true;
        $messages['quantity'] = "Merci de renseigner la quantité d'articles.";
    }
    
    
    if (!is_int(($_POST['quantity'])+0) || ($_POST['quantity'])<0){
        $errors['quantity'] = true;
        $messages['quantity'] = "La quantité doit être supérieure ou égale à 0.";
    }

    if (!$errors){
        $url = 'articles.php';
        header("Location: {$url}", true, 302);
        exit();
    }
}



// affichage du rendu d'un template
echo $twig->render('article-new.html.twig', [
    //Envoi des données au template
    'messages' => $messages,
    'errors' => $errors,
    'formData' => $formData
]);