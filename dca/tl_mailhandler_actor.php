<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_mailhandler_actor'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => ($this->Input->get("act")=="edit") ? 'Memory' : 'Table',		
		'enableVersioning'            => true,
		'onload_pre_callback' => array
		(
			array('tl_mailhandler_actor', 'loadActorConfig')
		),
		'onsubmit_callback' => array
		(
			array('tl_mailhandler_actor', 'submitActorConfig')
		),
        
        'dcMemory_show_callback' => array( array(
                'tl_mailhandler_actor',
                'showAll'
            )),
        'dcMemory_showAll_callback' => array( array(
                'tl_mailhandler_actor',
                'showAll'
            )),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter'
		),
		'label' => array
		(
			'fields'                  => array('title','provider'),
			'format'                  => '%s [%s]'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(		
		'default' => '{areaProviderConfig},title,provider,'
	),

    'subpalettes' => array(),
	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class'=>'w50')
		),
		'provider' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_actor']['provider'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                => $GLOBALS['TL_MAILHANDLER_ACTORS'],
			'eval'                    => array('submitOnChange'=>true,'chosen'=>true,'tl_class'=>"w50"),
		),
	)
);


class tl_mailhandler_actor extends Backend
{

	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
        
	}

    public function loadActorConfig(DataContainer $dc)
    {
         if ($this->Input->get("act")=="edit")
         {
            $objConfig = new libContaoConnector("tl_mailhandler_actor","id",$dc->id);
            
            $dc->setData("title",$objConfig->title);
            $dc->setData("provider",$objConfig->provider);
            
            
            $arrProviderConfig = deserialize($objConfig->provider_config);
            
            if ((count($arrProviderConfig)>0) && (is_array($arrProviderConfig)))
            {
                foreach ($arrProviderConfig as $k=>$v)
                {
                     $dc->setData($k,$v);        
                }
                
            }
         }
         
         
         
        if (array_key_exists($dc->getData("provider"), $GLOBALS['TL_MAILHANDLER_ACTORS']))
        {
           
            $objActor = new $GLOBALS['TL_MAILHANDLER_ACTORS'][$dc->getData("provider")]();
            
            $arrDCA = $objActor->getDCA();
            
            $GLOBALS['TL_DCA']['tl_mailhandler_actor']['palettes']['default'] .= $arrDCA['palettes'];
            
            $GLOBALS['TL_DCA']['tl_mailhandler_actor']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_mailhandler_actor']['fields'],$arrDCA['fields' ]);

           
            
        }
        
    }

    
    public function submitActorConfig(DataContainer $dc)
    {
        
        $objConfig = new libContaoConnector("tl_mailhandler_actor","id",$this->Input->get("id"));
        $objConfig->title = $dc->getData("title");            
        $objConfig->provider = $dc->getData("provider");
                        
            
        $arrData = $dc->getDataArray();
     
           unset($arrData['title']);
        unset($arrData['provider']);
        
        $objConfig->provider_config = $arrData; 
        $objConfig->Sync();
        
    }

    public function showAll($dc, $strReturn)
    {
        return $strReturn . $dc -> edit();
    }

}
?>