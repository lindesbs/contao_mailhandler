<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_mailhandler_action_item'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_mailhandler_action',
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
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title','actors','active'),
			'panelLayout'             => 'filter;limit',
			'child_record_callback'   => array('tl_mailhandler_action_item', 'listActionItems')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(),
		'default'                     => '{title_legend},title,type,active'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'maxlength'=>128, 'tl_class'=>'w50')
		),
		'active' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['active'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'checkbox',
			
		),
		'type' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_mailhandler_action_item']['type'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                => $GLOBALS['TL_MAILHANDLER_HANDLER'],
            'eval'                    => array('submitOnChange'=>true,'chosen'=>true,'tl_class'=>"w50"),
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
		$this->import('BackendUser', 'User');
	}
public function listActionItems($arrRow)
    {
        return '
<div class="cte_type ' . (($arrRow['active']) ? 'published' : 'unpublished') . '">
    <strong>' . $arrRow['title'] . '</strong> 
</div>
' . $arrRow['type'];
    }
}

?>