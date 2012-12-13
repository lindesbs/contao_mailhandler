<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_mailhandler_action'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_mailhandler_action_item'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['edit'],
				'href'                => 'table=tl_mailhandler_action_item',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},title,actors,active'
	),

	// Subpalettes
	'subpalettes' => array
	(
		
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['title'],
			'search'                  => true,
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>255)
		),
		'actors' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['actors'],
			'exclude'                 => true,
			'inputType'               => 'checkboxWizard',
			'options_callback'       => array('tl_mailhandler_action','getAllActors'),
			'eval'                    => array('multiple'=>true)
		),
		'active' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action']['active'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            
        ),
	)
);

class tl_mailhandler_action extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


    public function getAllActors(DataContainer $dc)
    {
        $arrReturn = array();
        
        $objActors = $this->Database->prepare("SELECT * FROM tl_mailhandler_actor")->execute();   
        
        while ($objActors->next())
        {
            $arrReturn[$objActors->id] = sprintf("%s [%s]",$objActors->title,$objActors->provider);
        }
        
        return $arrReturn;
    
    }

}

?>