<?php

namespace Aeki;

use Aeki\Connection\Connector;
use Aeki\Loader\TemplateLoader;

require_once '../vendor/autoload.php';

$user = authorizeUser();

if (empty($user)) {
    header('Location: sign-in.php');
    return;
}

function getAll($user): array
{
    $sql = 'SELECT `product_id` FROM `cart` WHERE `user_id` = ?';
    return Connector::getInstance()->execute($sql, [$user['user_id']])->fetchAll();
}



$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('cart.twig');
