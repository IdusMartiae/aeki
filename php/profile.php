<?php

namespace Aeki;

use Aeki\Loader\TemplateLoader;

require_once '../vendor/autoload.php';


$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('profile.twig');

function valid_email($str)
{
    return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str);
}

$full_name = $_POST['full-name'];
$address = $_POST['address'];
$email = $_POST['email'];

if (!empty($email) && !valid_email($email)) {
    echo '<script type="text/javascript">alert("Email is not valid!")</script>';
}

