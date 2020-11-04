<?php

namespace Aeki;

use Aeki\Connection\Connector;
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
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    echo $hashedPassword;
    $connector = Connector::getInstance();
    $sql = 'INSERT INTO `user`(`login`, `password`) VALUES (?, ?)';

    $connector->execute(
        $sql, [$username, $hashedPassword]
    );

    $authenticatedUser = authenticateUser($username, $password);

    if (empty($authenticatedUser)) {
        header('Location: sign-in.php');
        return;
    }

    header('Location: profile.php');
    return;
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('sign-up.twig', ['isUserAuthorized' => false]);
