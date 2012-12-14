<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class HandlerLogging extends HandlerAbstractClass
{
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        
        /*
         * print_a($objItem);
        
        print_a($objItemData);
        print_a($objActor);
        */
        $this->log(sprintf("%s - %s - %s",$objItemData->Subject,$objItem['title'],$objActor['provider']),"HandlerLogging::runItem","MAILHANDLER");
    
    }
	
	
	public function getLegend()
	{
		
	
	}
	
	
 	public function getConfigDCA()
    {
		return array(
             'logInfo' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['logInfo'],
                        'exclude'                 => false,
                        'inputType'               => 'text',
                        'eval'                    => array('maxlength'=>255)
            )      
        ); 
        }   

}
