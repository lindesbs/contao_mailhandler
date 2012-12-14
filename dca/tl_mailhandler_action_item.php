<?php
if (!defined('TL_ROOT'))
	die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_mailhandler_action_item'] = array(

	// Config
	'config' => array(
		'dataContainer' => ($this -> Input -> get("act") == "edit") ? 'Memory' : 'Table',
		'ptable' => 'tl_mailhandler_action',
		'enableVersioning' => true,
		'onload_pre_callback' => array( array(
				'tl_mailhandler_action_item',
				'loadActorConfig'
			)),
		'onsubmit_callback' => array( array(
				'tl_mailhandler_action_item',
				'submitActorConfig'
			)),

		'dcMemory_show_callback' => array( array(
				'tl_mailhandler_action_item',
				'showAll'
			)),
		'dcMemory_showAll_callback' => array( array(
				'tl_mailhandler_action_item',
				'showAll'
			)),
	),

	// List
	'list' => array(
		'sorting' => array(
			'mode' => 4,
			'fields' => array('sorting'),
			'headerFields' => array(
				'title',
				'actors',
				'active'
			),
			'panelLayout' => 'filter;limit',
			'child_record_callback' => array(
				'tl_mailhandler_action_item',
				'listActionItems'
			)
		),
		'global_operations' => array('all' => array(
				'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href' => 'act=select',
				'class' => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)),
		'operations' => array(
			'edit' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['edit'],
				'href' => 'act=edit',
				'icon' => 'edit.gif'
			),
			'copy' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['copy'],
				'href' => 'act=paste&amp;mode=copy',
				'icon' => 'copy.gif'
			),
			'cut' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['cut'],
				'href' => 'act=paste&amp;mode=cut',
				'icon' => 'cut.gif'
			),
			'delete' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['delete'],
				'href' => 'act=delete',
				'icon' => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array(
				'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['show'],
				'href' => 'act=show',
				'icon' => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array(
		'__selector__' => array(),
		'default' => '{title_legend},title,type,active'
	),

	// Subpalettes
	'subpalettes' => array(),

	// Fields
	'fields' => array(
		'title' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['title'],
			'exclude' => true,
			'search' => true,
			'flag' => 1,
			'inputType' => 'text',
			'eval' => array(
				'mandatory' => true,
				'decodeEntities' => true,
				'maxlength' => 128,
				'tl_class' => 'w50'
			)
		),
		'active' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['active'],
			'exclude' => false,
			'search' => true,
			'inputType' => 'checkbox',
		),
		'type' => array(
			'label' => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['type'],
			'exclude' => true,
			'inputType' => 'select',
			'options' => $GLOBALS['TL_MAILHANDLER_HANDLER'],
			'eval' => array(
				'submitOnChange' => true,
				'chosen' => true,
				'tl_class' => "w50"
			),
		),
	)
);

class tl_mailhandler_action_item extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this -> import('BackendUser', 'User');
	}

	public function listActionItems($arrRow)
	{
		return '
<div class="cte_type ' . (($arrRow['active']) ? 'published' : 'unpublished') . '">
    <strong>' . $arrRow['title'] . '</strong> 
</div>
' . $arrRow['type'];
	}

	public function loadActorConfig(DataContainer $dc)
	{
		if ($this -> Input -> get("act") == "edit")
		{
			$objConfig = new libContaoConnector("tl_mailhandler_action_item", "id", $dc -> id);

			$dc -> setData("title", $objConfig -> title);
			$dc -> setData("active", $objConfig -> active);
			$dc -> setData("type", $objConfig -> type);

			$arrProviderConfig = deserialize($objConfig -> handler_config);

			if ((count($arrProviderConfig) > 0) && (is_array($arrProviderConfig)))
			{
				foreach ($arrProviderConfig as $k => $v)
				{
					$dc -> setData($k, $v);
				}

			}
		}

		if (array_key_exists($dc -> getData("type"), $GLOBALS['TL_MAILHANDLER_HANDLER']))
		{

			$objActor = new $GLOBALS['TL_MAILHANDLER_HANDLER'][$dc->getData("type")]();

			$arrDCA = $objActor -> getConfigDCA();

			if (is_array($arrDCA))
			{
				$GLOBALS['TL_DCA']['tl_mailhandler_action_item']['palettes']['default'] .= ';{areaHandleConfig},' . implode(",", array_keys($arrDCA));
	
				$GLOBALS['TL_DCA']['tl_mailhandler_action_item']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_mailhandler_action_item']['fields'], $arrDCA);
			}
		}

	}

	public function submitActorConfig(DataContainer $dc)
	{

		$objConfig = new libContaoConnector("tl_mailhandler_action_item", "id", $this -> Input -> get("id"));
		$objConfig -> title = $dc -> getData("title");
		$objConfig -> provider = $dc -> getData("type");
		$objConfig -> active = $dc -> getData("active");

		$arrData = $dc -> getDataArray();

		unset($arrData['title']);
		unset($arrData['type']);

		$objConfig -> handler_config = $arrData;
		$objConfig -> Sync();

	}

	public function showAll($dc, $strReturn)
	{
		return $strReturn . $dc -> edit();
	}

}
?>