<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

// **** FIXME ***** This is very ugly and needs to be removed
if (isset($_POST['presentation_info']) ){

	$temp = explode( "`",  $_POST['presentation_info'] );

	$title = $temp[0];
	$slideNumber = $temp[1];

	if( isset($_POST['selectPage']) ) 	$slideNumber = $_POST['selectPage'];
	if( isset($_POST['slideBack']) ) 	$slideNumber = $temp[1] -1;
	if( isset($_POST['slideForward']) ) $slideNumber = $temp[1] +1;

	$cookie_name = str_replace(" ", "_" , "wiki_presentation_$title");
	setcookie($cookie_name, trim($slideNumber));

	header("Location: " . $_SERVER['REQUEST_URI']);
}

/**
 * Presentation extension
 *
 * For more info see http://mediawiki.org/wiki/Extension:Presentation
 *
 * @file
 * @ingroup Extensions
 * @author Eric Fortin, 2009
 * @author Mark A. Hershberger, 2014
 * @license GNU General Public License 3.0 or later
 */
$GLOBALS['wgPresentationVersion'] = '0.5.0';
$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path' => __FILE__,
	'name' => 'Presentation',
	'author' => array(
		'[[mw:User:Kenyu73|Eric Fortin]]',
		'[[mw:User:MarkAHershberger|Mark A. Hershberger]]'
	),
	'version'  => $GLOBALS['wgPresentationVersion'],
	'url' => 'https://www.mediawiki.org/wiki/Extension:Presentation',
	'descriptionmsg' => 'presentation-desc',
);

/* Setup */

// Register files
$GLOBALS['wgAutoloadClasses']['Presentation'] = __DIR__ . '/Presentation.body.php';
$GLOBALS['wgAutoloadClasses']['PresentationHooks'] = __DIR__ . '/Presentation.hooks.php';
$GLOBALS['wgAutoloadClasses']['SpecialPresentation'] = __DIR__ . '/specials/SpecialPresentation.php';
$GLOBALS['wgMessagesDirs']['Presentation'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['PresentationAlias'] = __DIR__ . '/Presentation.i18n.alias.php';

// Register special pages
$GLOBALS['wgSpecialPages']['Presentation'] = 'SpecialPresentation';
$GLOBALS['wgSpecialPageGroups']['Presentation'] = 'other';

// Register modules
$GLOBALS['wgResourceModules']['ext.Presentation.slide'] = array(
	'scripts' => array(
		'modules/ext.Presentation.slide.js',
	),
	'styles' => array(
		'modules/ext.Presentation.slide.css',
	),
	'messages' => array(
	),
	'dependencies' => array(
	),

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Presentation',
);

$GLOBALS['wgExtensionFunctions'][] = "PresentationHooks::initialize";

/* Configuration */
