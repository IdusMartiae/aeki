<?php

namespace Aeki;

use Aeki\Connection\Connector;

const COOKIE_ID = 'user_cookie';

function authenticateUser(string $login, string $password): array
{
    $connector = Connector::getInstance();
    $sql = 'SELECT * FROM `user` WHERE `login` = ? LIMIT 1';
    $resultRow = $connector->execute($sql, [$login])->fetch();

    if (empty($resultRow)) {
        return array();
    }
    if (!password_verify($password, $resultRow['password'])) {
        return array();
    }

    $loginCookieValue = sha1(
        time() . $_SERVER['REMOTE_ADDR'] . $resultRow['user_id']
    );

    $sql = 'UPDATE `user` SET `cookie` = ? WHERE `user_id` = ?';

    $connector->execute(
        $sql, [$loginCookieValue, $resultRow['user_id']]
    );

    setcookie(
        COOKIE_ID,
        $loginCookieValue,
        time() + 365 * 24 * 60 * 60
    );

    return $resultRow;
}

function authorizeUser(): array
{
    $loginCookieValue = $_COOKIE[COOKIE_ID];

    if (empty($loginCookieValue)) {
        return array();
    }

    $connector = Connector::getInstance();
    $sql = 'SELECT * FROM `user` WHERE `cookie` = ? LIMIT 1';
    return $connector->execute($sql, [$loginCookieValue])->fetch();
}