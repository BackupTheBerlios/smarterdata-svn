<?php

	// SmartTemplate mode
#	/* IDE-Workaround */ $require = "class.SmartTemplate.php";
#	$GLOBALS['_CONFIG']['extensionsDirectory']
#		= str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/../internal/smarttemplate_extensions";

	// SmarterTemplate mode
	/* IDE-Workaround */ $require = "class.SmarterTemplate.php";
	$GLOBALS['_CONFIG']['extensionsDirectory']
		= str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/../internal/extensions";

	require_once $require;
	
	if ( isset ( $_GET['doDebug'] ) ) $GLOBALS['_CONFIG']['doDebug'] = true;
		else $GLOBALS['_CONFIG']['doDebug']	= false;

	$GLOBALS['_CONFIG']['allowIncompatibleFeatures']
		= true;
	$GLOBALS['_CONFIG']['template_dir']
		= str_replace ( "\\", "/", dirname ( __FILE__ ) ); 
	$GLOBALS['_CONFIG']['smarttemplate_compiled']
		= str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/../internal/compiled";
	$GLOBALS['_CONFIG']['smarttemplate_cache']
		= str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/../internal/output";
	$GLOBALS['_CONFIG']['cache_lifetime']
		= 10; // sec
	$GLOBALS['_CONFIG']['compiledLifetime']
		= 10; // sec
	$GLOBALS['_CONFIG']['mtime']
		= true;
	if ( isset ( $_GET['lang'] ) ) $GLOBALS['_CONFIG']['lang']
		= $_GET['lang'];
	if ( isset ( $_POST['lang'] ) ) $GLOBALS['_CONFIG']['lang']
		= $_POST['lang'];
	$GLOBALS['_CONFIG']['enableXML']
		= true;
	$GLOBALS['_CONFIG']['enableExtension']
		= true;
	$GLOBALS['_CONFIG']['enablePHPExecution']
		= true;
	$GLOBALS['_CONFIG']['useCache']
		= false;
?>