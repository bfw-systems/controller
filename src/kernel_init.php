<?php
/**
 * Actions à effectuer lors de l'initialisation du module par le framework.
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 * @package bfw-controller
 * @version 1.0
 */

require_once($rootPath.'configs/bfw-controller/config.php');
 
$page_title = '';
$Ctr = new \BFWCtr\Controller();
$Ctr->setDefaultPage($ctr_defaultMethode);

//La page
if(file_exists($rootPath.'controllers/'.$Ctr->getFileArbo().'.php') && !$ctr_class)
{
    require_once($rootPath.'controllers/'.$Ctr->getFileArbo().'.php');
}
elseif($ctr_class)
{
    if(method_exists('\controller\\'.$Ctr->getNameCtr(), $Ctr->getMethode()) && $ctr_class)
    {
        $ctrName = '\controller\\'.$Ctr->getNameCtr();
        $methodeName = $Ctr->getMethode();
        
        call_user_func(array($ctrName, $methodeName));
    }
    elseif(method_exists('\controller\index', $Ctr->getMethode()) && $ctr_class)
    {
        call_user_func(array('\controller\index', $Ctr->getMethode()));
    }
    else
    {
        ErrorView(404);
    }
}
else
{
    ErrorView(404, false);
}
?>