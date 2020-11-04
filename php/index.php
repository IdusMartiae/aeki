<?php

namespace Aeki;

use Aeki\Loader\TemplateLoader;

require_once '../vendor/autoload.php';


$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('index.twig');
