<?php

namespace Aeki;

use Aeki\Connection\Connector;
use Aeki\Loader\TemplateLoader;

require_once '../vendor/autoload.php';


function getAll(): array
{
    $sql = 'SELECT * FROM `catalog` ORDER BY id';
    return Connector::getInstance()->execute($sql)->fetchAll();
}

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('catalog.twig', array('catalog'=>getAll()));
