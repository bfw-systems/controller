<?php

/**
 * Classes gérant le routing
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @version 1.0
 */

namespace BFWCtr;

/**
 * Permet de gérer la vue et de savoir vers quel page envoyer
 * @package bfw-controller
 */
class Routing
{
    /**
     * @var $kernel L'instance du Kernel
     */
    protected $kernel;
    protected $controller;
    protected $getArgs = array();

    public function __construct(&$controller)
    {
        $this->kernel     = getKernel();
        $this->controller = $controller;
    }

    public function detectUri()
    {
        $returnObj = new \stdClass;

        $returnObj->fileArbo    = '';
        $returnObj->nameCtr     = '';
        $returnObj->nameMethode = '';

        $uriParse = parse_url($_SERVER['REQUEST_URI']);
        $request  = rawurldecode($uriParse['path']);

        if($request[0] === '/')
        {
            $request = substr($request, 1);
        }

        $exRequest = explode('/', $request);
        $link      = $exRequest[0];

        /*
          var_dump($request);
          var_dump($exRequest);
          var_dump($link);
          exit;
         */

        //S'il s'agit de la page index ou racine, on envoi vers la page par défault
        if($link == 'index.php' || $link == '')
        {
            $returnObj->fileArbo = $this->controller->getOptions()->defaultMethode;
            $returnObj->nameCtr  = $this->controller->getOptions()->defaultMethode;

            return $returnObj;
        }

        $file_find = false; //Indique si le fichier a été trouvé
        $dir_find  = false; //Indique si le dossier a été trouvé

        $dirArbo = '';
        $methode = '';

        foreach($exRequest as $query)
        {
            //Le fichier à été trouvé
            if($file_find)
            {
                $this->getArgs[] = $query;
                continue;
            }

            //Tant qu'on a pas trouvé le fichier

            if(!empty($dirArbo) && empty($methode))
            {
                $methode = $query;
            }

            //On rajoute un / à la fin du lien si on a commencé à mettre des choses dessus
            if($returnObj->fileArbo != '')
            {
                $returnObj->fileArbo .= '/';
            }

            $returnObj->fileArbo .= $query; //Et on y rajoute la valeur lu
            //Si le fichier existe dans le dossier controller. On passe la $file_find à true
            if(file_exists(path_controllers.'/'.$returnObj->fileArbo.'.php'))
            {
                $returnObj->nameCtr = $returnObj->fileArbo;
                $file_find          = true;
            }

            //Si un dossier existe pourtant le nom, on passe $dir_find à true
            if(file_exists(path_controllers.'/'.$returnObj->fileArbo))
            {
                $dir_find = true;
                $dirArbo  = $returnObj->fileArbo;
            }
        }

        if($file_find == true)
        {
            return $returnObj;
        }

        //Si rien a été trouvé, on rajoute "/index" à la fin du lien
        if($dir_find == true)
        {
            $returnObj->nameCtr     = $this->fileArbo;
            $returnObj->nameMethode = $methode;

            if(!(method_exists('\controller\\'.$dirArbo, $methode) && $this->controller->getOptions()->useClass))
            {
                $returnObj->fileArbo = $dirArbo.'/index';
                $returnObj->nameCtr  = $dirArbo.'\index';
            }

            return $returnObj;
        }

        $returnObj->nameMethode = $this->controller->getOptions()->defaultMethode;

        if(isset($exRequest[0]))
        {
            $returnObj->nameMethode = $exRequest[0];
        }

        return $returnObj;
    }

    public function detectGet()
    {
        global $_GET;

        $getId     = 0;
        $nbGetArgs = count($this->getArgs);

        foreach($this->getArgs as $getValue)
        {
            if($nbGetArgs === ($getId + 1) && trim($getValue) === '')
            {
                continue;
            }

            $_GET[$getId] = secure(trim($getValue));
            $getId++;
        }
    }
}
