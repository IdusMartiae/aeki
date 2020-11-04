<?php

namespace Aeki;

use Aeki\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

$user = authorizeUser();

if (!empty($user)) {
    header('Location: profile.php');
    return;
}

$username = trim($_POST['login']);
$password = trim($_POST['password']);

if (!empty($username) && !empty($password)) {
    $user = authenticateUser($username, $password);

    if (empty($user)){
        header('Location: sign-in.php');
        return;
    }

    header('Location: profile.php');
    return;
}


$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign-in.twig', ['isUserAuthorized' => false]);
