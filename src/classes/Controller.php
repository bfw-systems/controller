<?php

/**
 * Classes géant les pages
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @version 1.0
 */

namespace BFWCtr;

/**
 * Permet de gérer la vue et de savoir vers quel page envoyer
 * @package bfw-controller
 */
class Controller implements \BFWCtrInterface\IController
{
    /**
     * @var $kernel L'instance du Kernel
     */
    protected $kernel;
    protected $options;
    protected $routingSys;
    protected $routingSysName;

    /**
     * @var $nameCtr Le nom du controler appelé
     */
    protected $nameCtr = '';

    /**
     * @var $nameMethode Le nom de la méthode à appeler
     */
    protected $nameMethode = '';

    /**
     * @var $link_file L'arborescence interne dans les fichiers
     */
    protected $fileArbo = '';

    /**
     * @var $defaultPage La page par défault (celle qui sert de page index au site)
     */
    protected $defaultPage;

    /**
     * Constructeur
     * 
     * @param \stdClass $options : Les options du modules
     */
    public function __construct($options)
    {
        $this->kernel  = getKernel();
        $this->options = $options;

        $routingSysName = $options->routingModule;
        if($routingSysName === '')
        {
            $routingSysName = '\BFWCtr\Routing';
        }

        $this->routingSysName = $routingSysName;

        //Si la page par défaut a été indiqué, on la définie.
        if($options->defaultMethode !== null)
        {
            $this->setDefaultPage($options->defaultMethode);
        }

        $this->runRouting();
    }

    protected function runRouting()
    {
        $this->routingSys = new $this->routingSysName($this);

        $pageInfos = $this->routingSys->detectUri();
        $this->routingSys->detectGet();

        $this->fileArbo    = $pageInfos->fileArbo;
        $this->nameCtr     = $pageInfos->nameCtr;
        $this->nameMethode = $pageInfos->nameMethode;
    }

    /**
     * Retourne l'arborescence vers le fichier controler (inclus)
     * 
     * @return string
     */
    public function getFileArbo()
    {
        return $this->fileArbo;
    }

    /**
     * Modifie la page par défault
     * 
     * @param string $name Le nom de la page index du site
     */
    public function setDefaultPage($name)
    {
        $this->defaultPage = $name;
        $this->runRouting();
    }

    /**
     * Retourne le nom du controler utilisé
     * 
     * @return string
     */
    public function getNameCtr()
    {
        //return str_replace('/', '\\', $this->nameCtr);
        return $this->nameCtr;
    }

    /**
     * Retourne la méthode à appeler
     * 
     * @return string
     */
    public function getMethode()
    {
        return $this->nameMethode;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
