<?php
/**
 * Fichier de configuration du module bfw-controller
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @package bfw-controller
 * @version 1.0
 */

//*** Controler ***
$bfwCtrConfig = new \stdClass;

//Si le système de controller utilisera des classes ou non.
$bfwCtrConfig->useClass = false;

//La méthode à appeler si aucune n'est définie dans l'url (pour tous les contrôleurs)
$bfwCtrConfig->defaultMethode = 'index';

//Le module utilisé pour le routage des fichiers
//Laisser vide pour utiliser le module intégrer à celui-ci
$bfwCtrConfig->routingModule = '';
//*** Controler *** 
