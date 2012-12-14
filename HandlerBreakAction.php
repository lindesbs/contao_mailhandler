<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class HandlerBreakAction extends HandlerAbstractClass
{
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        
       	$this->log("break action queue","HandlerBreakAction","MAILHANDLER");
		$this->stopAction=true;
    }

}
