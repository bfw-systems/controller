<?php
$page_title = '';
$Ctr = new \BFWCtr\Controller();
$Ctr->setDefaultPage($DefaultController);

//La page
if(file_exists($rootPath.'cache/'.$Ctr->getFileArbo().'.phtml') && $tpl_module == 'bfw-template')
{
    //Cache de BFW_Template
    require_once($rootPath.'cache/'.$Ctr->getFileArbo().'.phtml');
}
elseif(file_exists($rootPath.'controllers/'.$Ctr->getFileArbo().'.php') && !$ctr_class)
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