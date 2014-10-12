<?php
/**
 * Fichier de test pour une class
 */

namespace BFWCtr\test\unit;
use \atoum;

require_once(__DIR__.'/../common.php');

/**
 * Test de la class Controller
 */
class Controller extends atoum
{
    /**
     * @var $class : Instance de la class Controller
     */
    protected $class;

    /**
     * @var $mock : Instance du mock pour la class Controller
     */
    protected $mock;

    /**
     * Instanciation de la class avant chaque méthode de test
     */
    public function beforeTestMethod($testMethod)
    {
        //$this->class = new \BFWCtr\Controller();
        //$this->mock  = new MockController();
    }

    /**
     * Test du constructeur : Controller($default_page=)
     */
    public function testController()
    {
        
    }

    /**
     * Test de la méthode getFileArbo()
     */
    public function testGetFileArbo()
    {
        
    }

    /**
     * Test de la méthode setDefaultPage($name)
     */
    public function testSetDefaultPage()
    {
        
    }

    /**
     * Test de la méthode getNameCtr()
     */
    public function testGetNameCtr()
    {
        
    }

    /**
     * Test de la méthode getMethode()
     */
    public function testGetMethode()
    {
        
    }

}

/**
 * Mock pour la classe Controller
 */
class MockController extends \BFWCtr\Controller
{
    /**
     * Accesseur get
     */
    public function __get($name) {return $this->$name;}
}
