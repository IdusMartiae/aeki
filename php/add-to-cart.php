<?php

namespace Aeki;

use Aeki\Connection\Connector;

require_once '../vendor/autoload.php';

$product_id = $_GET['id'];

if (isset($product_id)) {
    $user = authorizeUser();

    if (empty($user)) {
        header('Location: sign-in.php');
        return;
    }

    $connector = Connector::getInstance();
    $sql = 'INSERT INTO `cart`(`user_id`, `product_id`) VALUES (?, ?)';

    $connector->execute(
        $sql, [$user['user_id'], $product_id]
    );

    header('Location: catalog.php');
}
