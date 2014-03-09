<?php
/**
 * Interfaces en rapport avec le système de controller
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @version 1.0
 */

namespace BFWCtrInterface;

/**
 * Interface de la classe controller
 * @package bfw-controller
 */
interface IController
{
    /**
     * Constructeur
     * 
     * @param string $default_page (default: null) La page par défaut du site (la page index du site)
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
     * @param string $name Le nom de la page index du site
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