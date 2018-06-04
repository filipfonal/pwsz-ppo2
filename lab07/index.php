<?php

require "./vendor/autoload.php";

use App\Controllers\Controller;
use Twig_Environment as TwigEnvironment;
use Twig_Loader_Filesystem as TwigLoaderFilesystem;

$twig = new TwigEnvironment(new TwigLoaderFilesystem("assets"), []);

$controller = new Controller();

echo $twig->render("index.twig", [
	"result" => $controller->getResult($_GET)
]);
