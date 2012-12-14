<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');



abstract class HandlerAbstractClass extends Controller
{
	public $stopAction=false;
	
    public function __construct()
    {   
    }
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        // $objItem : actual item in actions row
        // $objItemData : source Mail info object
        // $objActor : Infos about the ActorConfiguration 
    
    }

 	 public function getConfigDCA()
    {
        
    
    }


	public function getLegend()
	{
		
	
	}
    
    public function setDCAConfig($arrConfig)
    {
        $this->arrConfig = deserialize($arrConfig);
        
    }
}
