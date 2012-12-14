<?php
if (!defined('TL_ROOT'))
	die('You can not access this file directly!');

/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_mailhandler_settings'] = array(
	// Config
	'config' => array(
		'dataContainer' => 'Memory',
		'closed' => true,
		'onload_callback' => array( array(
				'tl_mailhandler_settings_tool',
				'onload_callback'
			), ),
		'onsubmit_callback' => array( array(
				'tl_mailhandler_settings_tool',
				'onsubmit_callback'
			), ),
		'disableSubmit' => true,
		'dcMemory_show_callback' => array( array(
				'tl_mailhandler_settings_tool',
				'showAll'
			)),
		'dcMemory_showAll_callback' => array( array(
				'tl_mailhandler_settings_tool',
				'showAll'
			)),
	),

	// Palettes
	'palettes' => array(
		'__selector__' => array(''),
		'default' => '{areaTableCheck},storeincomingheader',
	),
	'subpalettes' => array(),

	// Fields
	'fields' => array(
	
        'storeincomingheader'  => array(
            'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_settings_tool']['storeincomingheader'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'addSubmit' => true
            
        ),
        
        
	)
);

class tl_mailhandler_settings_tool extends Backend
{

	public function __construct()
	{

		$this -> import("Config");
		$this -> import("Input");
		$this -> import("Database");
		$this -> import("BackendUser", "User");
		$this -> import("Session");
		include_once (TL_ROOT . "/system/drivers/DC_Table.php");

		//WOrkaround to for $GLOBALS['TL_HOOKS']['loadDataContainer'][] =
		// array('CatalogExt', 'addCatalogsToComments');
		// will break execution

		$arrHooks = $GLOBALS['TL_HOOKS']['loadDataContainer'];

		if (is_array($arrHooks))
		{
			foreach ($arrHooks as $key => $hook)
			{
				if ($hook[1] == 'addCatalogsToComments')
				{
					unset($GLOBALS['TL_HOOKS']['loadDataContainer'][$key]);
				}

				if ($hook[0] == 'EasyThemes')
				{
					unset($GLOBALS['TL_HOOKS']['loadDataContainer'][$key]);
				}
			}
		}

	}

	public function onload_callback(DataContainer $dc)
	{
		$dc -> setData("storeincomingheader", $GLOBALS['TL_CONFIG']['mailhandler_store_incomingmail']);

	}

	public function onsubmit_callback(DataContainer $dc)
	{

        if ($this -> Input -> post("submit_storeincomingheader"))
        {
          
			$this->Config->update("\$GLOBALS['TL_CONFIG']['mailhandler_store_incomingmail']", $dc -> getData("storeincomingheader"));
        }

     
	}

	public function showAll($dc, $strReturn)
	{
		return $strReturn . $dc -> edit();
	}

	public function listTables()
	{
		return $this -> Database -> listTables();
	}

}
?>