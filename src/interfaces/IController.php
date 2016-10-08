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
     * Retourne l'arborescence vers le fichier controler (inclus)
     * 
     * @return string
     */
    public function getFileArbo();
    
    /**
     * Modifie la page par défault
     * 
     * @param string $name Le nom de la page index du site
     * @return void
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
