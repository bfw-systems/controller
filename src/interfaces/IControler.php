<?php

namespace BFWCtrInterface;

interface IControler
{
    /**
     * Constructeur
     * 
     * @param string $default_page [opt] : La page par défaut du site (la page index du site)
     */
    public function __construct($default_page=null);
    
    /**
     * Retourne l'arborescence vers le fichier controler (inclus)
     * 
     * @return string
     */
    public function getFileArbo();
    
    /**
     * Modifie la page par défault
     * 
     * @param string $name : Le nom de la page index du site
     */
    public function setDefaultPage($name);
    
    /**
     * Retourne le nom du controler utilisé
     * 
     * @return string
     */
    public function getNameCtr();
    
    /**
     * Retourne la méthode à appeler
     * 
     * @return string
     */
    public function getMethode();
}
?>