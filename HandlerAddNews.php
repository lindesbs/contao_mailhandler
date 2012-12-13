<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


class HandlerAddNews extends HandlerAbstractClass
{
    
    public function runItem($objItem,$objItemData,$objActor)
    {
        $strAlias = standardize(sprintf("actor%d_%s",$objActor['id'],$objItemData->messageID));
        
        print_a($objItemData);
        echo $strAlias;
        
        $objNews = new libContaoConnector("tl_news","alias",$strAlias);
        $objNews->headline = $objItemData->Subject;
        $objNews->text = $objItemData->Body;
        $objNews->pid = $objItem['ownNewsArchiveID'];
        $objNews->date = time();
        
        if (count($objItemData->Attachments)>0)
        {
            $objNews->addImage = 1;
            $objNews->singleSRC = $objItemData->Attachments[0];       
        
        }
        
        $objNews->published = 1;
        
        
        // dies noch setzen
        $objNews->pid = 1;
        $objNews->author = 1;
        $objNews->jumpTo = 13;
        $objNews->source = 13;
        $objNews->floating = 13;
        $objNews->fullsize = 1;
        
        
        
        $objNews->Sync();
           
    
    }

}
