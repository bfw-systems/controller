<?php
/**
 * Actions à effectuer lors de l'initialisation du module par le framework.
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @package bfw-sql
 * @version 1.0
 */

//Disons que nous somme à l'origine du projet
//Je déclare une variable $rootPath à ici pour me simplifier mes inclusions.
$rootPath = realpath(__DIR__.'/../').'/';

$loader = require($rootPath.'vendor/autoload.php');
$loaderAddPsr4 = 'addPsr4';

$loader->addPsr4('BFWCtr\\', __DIR__.'/../src/classes/');
$loader->addPsr4('BFWCtrInterface\\', __DIR__.'/../src/interfaces/');
$loader->addPsr4('BFWCtr\tests\units\\',  __DIR__.'/classes/');

$forceConfig = true;
require_once(__DIR__.'/../vendor/bulton-fr/bfw/install/skeleton/config.php');

//Modif de certaines config par défault
$base_url = 'http://test.bulton.fr/bfw-v2/';
$ctr_module = 'bfw-controller'; //suggest package: bfw-controller
$ctr_class = true;

require_once(__DIR__.'/../vendor/bulton-fr/bfw/src/BFW_init.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('html_errors', true);
?>