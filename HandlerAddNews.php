<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class HandlerAddNews extends HandlerAbstractClass
{
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        $strAlias = standardize(sprintf("actor%d_%s",$objActor['id'],$objItemData->messageID));
       
        $objNews = new libContaoConnector("tl_news","alias",$strAlias);
        $objNews->headline = $objItemData->Subject;
        $objNews->text = $objItemData->Body;
        $objNews->pid = $this->arrConfig['insertNewsArchive'];
        $objNews->date = time();
        
         foreach ($this->arrConfig as $configKey=>$configValue)
         {
             $objNews->$configKey = $configValue;      
            
         }
        
        
        print_a($this->arrConfig );
        
        if (count($objItemData->Attachments)>0)
        {
            $objNews->addImage = 1;
            $objNews->singleSRC = $objItemData->Attachments[0];       
        
        }
        
        
        $objNews->Sync();
           
    
    }



 	public function getConfigDCA()
    {
    	$this->import("Config");
		$this->loadDataContainer("tl_news");
		$this->loadLanguageFile("tl_news");
		
		$arrFields = array(
             'insertNewsArchive' => array(
                        'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['insertNewsArchive'],
                        'exclude'                 => false,
                        'inputType'               => 'select',
                        'options_callback'		=> array('HandlerAddNews','getAllANewsArchives'),
                        'eval'                    => array('tl_class'=>'w50')
            )
		);
           
		$arrFields = array_merge($arrFields,$GLOBALS['TL_DCA']['tl_news']['fields']);
		
		
		unset($arrFields['headline']);
		unset($arrFields['alias']);
		unset($arrFields['date']);
		unset($arrFields['time']);
		unset($arrFields['subheadline']);
		unset($arrFields['teaser']);
		unset($arrFields['text']);
		unset($arrFields['addImage']);
		unset($arrFields['singleSRC']);
		unset($arrFields['addEnclosure']);
		unset($arrFields['enclosure']);
		unset($arrFields['start']);
		unset($arrFields['stop']);
		unset($arrFields['articleId']);
		unset($arrFields['url']);
		unset($arrFields['target']);
		unset($arrFields['source']);
		
		
		foreach ($arrFields as $k=>$v)
		{
			$arrFields[$k]['exclude'] =false;
		
		}
		
		return $arrFields;
    }   
	
	
	public function getAllANewsArchives()
	{
		$this->import("Config");
		$this->loadDataContainer("tl_module");
		$objNewsModule = new tl_module_news();
		
		
		return $objNewsModule->getNewsArchives();	
	
	}
	

}
