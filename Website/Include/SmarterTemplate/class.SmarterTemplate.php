<?php

	class SmarterTemplate
	{
		private $lang					= "de";
		private $doDebug				= false;
		private $checkNonEmpty			= true;
		private $useCache				= true;
		private $currentLoop			= 0;
		private $parentLoop				= array ();
		private $pattern				= array ();
		private $templatedata			= "";
		private $templatefile			= "";
		private $replacedData			= array ();
		private $extensionDirectory		= "";
		private $requiredExtensions		= array ();
		private $templateDirectory		= "";
		private $compiledDirectory		= "";
		private $compiledLifetime		= 0;
		private $generatedStart			= 0;
		private $cfg					= array ();
		private $compileStart			= 0;
		private $SCRIPT_FILENAME		= "";
		private $SCRIPT_DIRNAME			= "";
		private $enableXML				= true;
		private $enableExtension		= true;
		private $enablePHPExecution		= true;
		private $replacedBefore			= array ();
		private $enableSql				= false;
		private $sql					= array ();
		private $compatibility			= false;
		private $thisdir				= "";
		private $templatefilenameEncoded	= "";
		private $allowIncompatibleFeatures = false;
		public function __construct ( $template_filename )
		{
			/**
			 * Creates a SmarterTemplate instance
			 * @param $template_filename string
			 */
			$this->thisdir	= str_replace ( "\\", "/", dirname ( __FILE__ ) );
			$this->compatibility = ( class_exists ( 'smarttemplate' ) ) ? true : false;
			$this->setSmartTemplateConfig ();
			$this->allowIncompatibleFeatures	
				= ( isset ( $GLOBALS['_CONFIG']['allowIncompatibleFeatures'] ) ) 
				? $GLOBALS['_CONFIG']['allowIncompatibleFeatures'] : false;
			$this->SCRIPT_DIRNAME	= dirname ( str_replace ( "\\", "/", getenv ( 'SCRIPT_FILENAME' ) ) );
			$this->SCRIPT_FILENAME	= basename ( str_replace ( "\\", "/", getenv ( 'SCRIPT_FILENAME' ) ) );

			if ( $this->compatibility === true 
				&& $this->allowIncompatibleFeatures !== true )
			{
				$this->lang = false;
			} else {
				if ( isset ( $GLOBALS['_CONFIG']['lang'] ) || $this->lang != "" )
				{
					$filenameLanguaged = preg_replace ( '/\.([a-z]{1,})$/i', '.' . $GLOBALS['_CONFIG']['lang'] . '.$1', $template_filename );
					if ( is_file ( $filenameLanguaged ) )
					{
						$this->lang		= $GLOBALS['_CONFIG']['lang'];
						$template_filename	= $filenameLanguaged;
					}
				}
			}

			$this->setTemplateFilename ( $template_filename );
		}
		public function assign ( $name, $value = '' )
		{
			/**
			* Assign Template Content
			*
			* Usage Example:
			*	$page->assign( 'TITLE', 'My Document Title' );
			*	$page->assign( 'userlist', array(
			*		array( 'ID' => 123, 'NAME' => 'John Doe' ),
			*		array( 'ID' => 124, 'NAME' => 'Jack Doe' ),
			*	);
			* @copyright Philipp v. Criegern (philipp@criegern.com)
			* @param string $name Parameter Name
			* @param mixed $value Parameter Value
			* @desc Assign Template Content
			*/
			if ( is_array ( $name ) )
			{
				foreach ( $name as $k => $v )
				{
					$this->replacedData[$k]	= $v;
				}
			} else {
				$this->replacedData[$name]	= $value;
			}
		}
		public function append ( $name, $value )
		{
			/**
			* Assign Template Content
			*
			* Usage Example:
			* $page->append( 'userlist', array( 'ID' => 123, 'NAME' => 'John Doe' ) );
			* $page->append( 'userlist', array( 'ID' => 124, 'NAME' => 'Jack Doe' ) );
			*
			* @copyright Philipp v. Criegern (philipp@criegern.com)
			* @param string $name Parameter Name
			* @param mixed $value Parameter Value
			* @desc Assign Template Content
			*/
			if ( is_array ( $value ) )
			{
				$this->replacedData[$name][]	= $value;
			} elseif ( !is_array ( $this->replacedData[$name] ) ) {
				$this->replacedData[$name]		.= $value;
			}
		}
		public function result ( $allReplacements = false )
		{
			/**
			 * Returns the compiled and executed template
			 * @param $allReplacements bool
			 */
			$this->generatedStart		= round(microtime(),4);
			if ( $allReplacements !== false )
			{
				$this->resetReplacements ();
				$this->assign ( $allReplacements );
			}
			$return	= $this->getTemplate ();
			return $return;
		}
		public function output ( $allReplacements = false )
		{
			/**
			 * Displays the compiled and executed template
			 * @param $allReplacements bool
			 */
			$this->generatedStart		= round(microtime(),4);
			if ( $allReplacements !== false )
			{
				$this->resetReplacements ();
				$this->assign ( $allReplacements );
			}
			$return		= $this->getTemplate ();
			echo $return;
		}
		public function debug ( $allReplacements = false )
		{
			/**
			 * Returns a debugging version of the compiled and executed template
			 * @param $allReplacements bool
			 */
			$this->generatedStart		= round(microtime(),4);
			if ( $allReplacements !== false )
			{
				$this->resetReplacements ();
				$this->assign ( $allReplacements );
			}
			$temp			= $this->doDebug;
			$this->doDebug	= true;
			$return	= $this->getTemplate ();
			$this->doDebug	= $temp;
			return $return;
		}
		/** PRIVATE **/
		private function setSmartTemplateConfig ()
		{
			if ( isset ( $GLOBALS['_CONFIG']['reuse_code'] ) )
			{
				$GLOBALS['_CONFIG']['useCache']	= $GLOBALS['_CONFIG']['reuse_code'];
			}
			if ( isset ( $GLOBALS['_CONFIG']['temp_dir'] ) )
			{
				$GLOBALS['_CONFIG']['smarttemplate_compiled']	= $GLOBALS['_CONFIG']['temp_dir'];
			}
		}
		private function resetReplacements ()
		{
			/** Unset all replacements
			 */
			$this->replacedData		= array ();
		}
		private function setFeatures ()
		{
			/**
			 * Enables or disables features (XML, Extensions, PHP, SQL)
			 */
			if ( isset ( $GLOBALS['_CONFIG']['enableXML'] )
				&& $GLOBALS['_CONFIG']['enableXML'] === false )
			{
				$this->enableXML	= false;
			}
			if ( $this->compatibility === true ) $this->enableXML = true;
			if ( isset ( $GLOBALS['_CONFIG']['enableExtension'] )
				&& $GLOBALS['_CONFIG']['enableExtension'] === false )
			{
				$this->enableExtension	= false;
			}
			if ( $this->compatibility === true ) $this->enableExtension = true;
			if ( isset ( $GLOBALS['_CONFIG']['enablePHPExecution'] ) )
			{
				$this->enablePHPExecution	= $GLOBALS['_CONFIG']['enablePHPExecution'];
			}
			if ( $this->compatibility === true ) $this->enablePHPExecution = true;
			if ( isset ( $GLOBALS['_CONFIG']['sqlDSN'] )
				&& isset ( $GLOBALS['_CONFIG']['sqlUsername'] )
				&& isset ( $GLOBALS['_CONFIG']['sqlPassword'] ) )
			{
				$this->enableSql			= true;
				$this->sql['dsn']			= $GLOBALS['_CONFIG']['sqlDSN'];
				$this->sql['username']		= $GLOBALS['_CONFIG']['sqlUsername'];
				$this->sql['password']		= $GLOBALS['_CONFIG']['sqlPassword'];
			} else {
				$this->enableSql		= false;
			}
			if ( $this->compatibility === true && $this->allowIncompatibleFeatures !== true ) $this->enableSql = false;
			if ( isset ( $GLOBALS['_CONFIG']['useCache'] ) && $GLOBALS['_CONFIG']['useCache'] )
			{
				$this->useCache		= $GLOBALS['_CONFIG']['useCache'];
			}
			if ( $this->compatibility === true )
			{
				$this->useCache = false;
				if ( !empty ( $GLOBALS['_CONFIG']['use_cache'] ) )
				{
					$this->useCache = true;
				}
			}
			if ( $this->useCache === true )
			{
				/* IDE-Workaround */ $require = "class.SmarterCache.php";
				require_once $require;
				$this->smarterCache		= new SmarterCache ();
			}
		}
		public function setTemplateFilename ( $template_filename )
		{
			/** Searching for the template on different locations
			 * @param $template_filename string
			 */
			$template_filename			= str_replace ( "\\", "/", $template_filename );
			$template_filename_nolang	= $template_filename;
#			if ( $this->lang != "" ) $template_filename = preg_replace ( '/\.([a-z]{1,})$/i', '.' . $this->lang . '.$1', $template_filename );
			$this->templatefile		= $template_filename;
			$this->templatefilenameEncoded	= preg_replace ( '/[:\/.\\\\]/', '_', $this->templatefile ) . '.php';
			$this->setPaths ();
			$this->setDebug ();
			$this->setPattern ();
			$this->setLifetime ();
			$this->setFeatures ();
		}
		private function setDebug ()
		{
			if ( isset ( $GLOBALS['_CONFIG']['doDebug'] )
				&& $GLOBALS['_CONFIG']['doDebug'] === true )
			{
				$this->doDebug	= true;
			} else {
				$this->doDebug	= false;
			}
			if ( $this->compatibility === true ) $this->doDebug = false;
		}
		private function setPaths ()
		{
			/** Does set paths and probe them
			 */
			// Template
			if ( !empty ( $GLOBALS['_CONFIG']['template_dir'] ) )
			{
				$this->templateDirectory = $GLOBALS['_CONFIG']['template_dir'];
			} else {
				$this->templateDirectory = $this->thisdir . "/internal/template_directory";
			}
			$this->templateDirectoryEncoded	
				= preg_replace ( '/[:\/.\\\\]/', '_', $this->templateDirectory );
			// Compiled
			if ( !empty ( $GLOBALS['_CONFIG']['smarttemplate_compiled'] ) )
			{
				$this->compiledDirectory = $GLOBALS['_CONFIG']['smarttemplate_compiled'] . "/";
			} else {
				$this->compiledDirectory 
					= $this->thisdir 
					. "/internal/compiled";
			}
			// Extensions
			if ( !empty ( $GLOBALS['_CONFIG']['extensionsDirectory'] ) )
			{
				$this->extensionDirectory = $GLOBALS['_CONFIG']['extensionsDirectory'];
			} else {
				if ( $this->compatibility === true )
				{
					$this->extensionDirectory
						= $this->thisdir 
						. "/internal/smarttemplate_extensions";
				} else {
					$this->extensionDirectory
						= $this->thisdir 
						. "/internal/extensions";
				}
			}
			if ( !is_dir ( $this->extensionDirectory ) )
			{
				if ( !mkdir ( $this->extensionDirectory, 0777 ) )
				{
					die ( "Verzeichnis fuer Erweiterungen existiert nicht. " . $this->extensionDirectory );
				}
			}
						
			// Cache
			if ( !empty ( $GLOBALS['_CONFIG']['smarttemplate_cache'] ) )
			{
				$this->cacheDirectory	= $GLOBALS['_CONFIG']['smarttemplate_cache'];
			} else {
				$this->cacheDirectory	= $this->thisdir . "/internal/cache";
			}				
			if ( !is_dir ( $this->cacheDirectory ) )
			{
				if ( !mkdir ( $this->cacheDirectory, 0777 ) )
				{
					die ( "Verzeichnis fuer Ausgabe existiert nicht. " . $this->cacheDirectory );
				}
			}
		}
		private function setLifetime ()
		{
			if ( is_numeric ( $GLOBALS['_CONFIG']['cache_lifetime'] ) )
			{
				$this->compiledLifetime		=  $GLOBALS['_CONFIG']['cache_lifetime'];
			}
		}
		private function compile ()
		{
			$this->compileStart		= round(microtime (), 4);
			$cachedDate	= false;
			if ( $this->useCache === true )
			{
				if ( isset ( $GLOBALS['_CONFIG']['mtime'] ) 
					&& $GLOBALS['_CONFIG']['mtime'] === true )
				{
					$cachedDate		= $this->smarterCache->isCacheOkFile ( $this->compiledDirectory . "/" . $this->templateDirectoryEncoded . $this->templatefilenameEncoded, $this->compiledLifetime );
				} else {
					$cachedDate		= $this->smarterCache->isCacheOkTextfile ( $this->compiledDirectory . "/" . $this->templateDirectoryEncoded . $this->templatefilenameEncoded, $this->compiledLifetime );
				}
			}
			if ( $this->useCache === false || $cachedDate === false )
			{
				$site = implode ( "", file ( $this->getTemplatefile () ) );
				if ( $this->enablePHPExecution === false ) $site = $this->replacePHPCode ( $site );
				$site	= $this->replaceForcePHPCode ( $site );
				$site	= "<?php \$TIME_GENERATED = round(microtime (), 4); ?>" . $site;
				$site	= $this->replaceTemplatecodePCRE ( $site );
				if ( $this->enableXML === true )
				{
					$site	= $this->replaceXML ( $site );
				}
				if ( $this->enableExtension === true )
				{
					$site	= $this->replaceExtension ( $site, 0, 0 );
					$site	= $this->addRequiredExtensions ( $site );
				}
				$site	= $this->replacereplacement ( $site, 0, 0 );
				$TIME_GENERATED		= 0;
				$generated	= time ();
				$fh		= fopen ( $this->compiledDirectory . "/" . $this->templateDirectoryEncoded . $this->templatefilenameEncoded, "w" );
				fputs ( $fh, $site );
				fclose ( $fh );
			} else {
				$generated	= $cachedDate;
			}
			return $generated;
		}
		private function getTemplatefile ()
		{
			// Relativer Pfad
			if ( substr ( $this->templatefile, 0, 2 ) == "./" )
			{
				$filename = $this->SCRIPT_DIRNAME . "/" . substr ( $this->templatefile, 2 );
			// Absoluter Pfad
			} elseif ( substr ( $this->templatefile, 1, 2 ) == ":/" ) {
				$filename = $this->templatefile;
			// Absoluter Pfad
			} elseif ( substr ( $this->templatefile, 0, 1 ) == "/" ) {
				$filename = $this->templatefile;
			// Standard-Templatepfad
			} else {
				$filename	= $this->templateDirectory . "/" . $this->templatefile;
			}
			if ( !is_file ( $filename ) )
			{
				die ( "Template $filename does not exist" );
			} else {
				return $filename;
			}
		}
		private function setPattern ( $beginStructure = '<!--', $endStructure = '-->', $beginExtension = '{', $endExtensions = '}', $beginReplacement = '{', $endReplacement = '}' )
		{
			$this->cfg['beginStructure']		= $beginStructure;
			$this->cfg['endStructure']			= $endStructure;
			$this->cfg['beginExtension']		= $beginExtension;
			$this->cfg['endExtensions']			= $endExtensions;
			$this->cfg['beginReplacement']		= $beginReplacement;
			$this->cfg['endReplacement']		= $endReplacement;

			$beginStructure		= preg_quote ( $beginStructure );
			$endStructure		= preg_quote ( $endStructure );
			$beginExtension		= preg_quote ( $beginExtension );
			$endExtensions		= preg_quote ( $endExtensions );
			$beginReplacement	= preg_quote ( $beginReplacement );
			$endReplacement		= preg_quote ( $endReplacement );
			$this->pattern		= array (
				'extension'				=> $beginExtension . '([A-Za-z_]{1,}):(.*?)' . $endExtensions,
				'replacement'			=> '([A-Za-z_0-9\.]{1,})',
				'replacementNoDot'		=> '([A-Za-z_0-9]{1,})',
				'replacementInTheWild'	=> $beginReplacement . '([A-Za-z_0-9\.]{1,})' . $endReplacement,
				'ifElseIf'				=> '/^ (ELSE)?IF ([a-zA-Z0-9_.]+)(.*?) ' . $this->cfg['endStructure'] . '/',
				'sql'					=> '/^ SQL ([a-zA-Z0-9_]+)="(.*?)" ' . $this->cfg['endStructure'] . '/'
			);
		}
		private function getTemplate ()
		{
			$this->currentLoop						= 0;
			$loop[0]['value']						= $this->replacedData;
			$loop[0]['value']['TIME_REFRESHED']		= $this->compile ();
			$loop[0]['value']['TIME_COMPILED']		= round(microtime (), 4) - $this->compileStart;
			$loop[0]['value']['CONFIG']				= $GLOBALS['_CONFIG'];
			$loop[0]['value']['SMARTER_CONFIG']		= $this->cfg;
			$loop[0]['value']['SERVER']				= $_SERVER;
			$loop[0]['value']['POST']				= $_POST;
			$loop[0]['value']['GET']				= $_GET;
			$loop[0]['value']['TEMPLATE_DIRECTORY']	= $this->templateDirectory;
			$loop[0]['value']['TEMPLATE_FILE']		= $this->templatefile;
			$loop[0]['value']['PHP_DIRECTORY']		= $this->SCRIPT_DIRNAME;
			$loop[0]['value']['PHP_FILE']			= $this->SCRIPT_FILENAME;
			$loop[0]['value']['CURRENT_TIME']		= time ();
			if ( $this->lang != "" )
			{
				$loop[0]['value']['LANG']			= $this->lang;
			} else {
				$loop[0]['value']['LANG']			= "";
			}
			$return		= "";
			if ( $this->doDebug === true ) $debug = $this->addDebug ();
			ob_clean ();
			ob_start ();
			$TIME_GENERATED		= 0;
			require $this->compiledDirectory . "/" . $this->templateDirectoryEncoded . $this->templatefilenameEncoded;
			$return		= ob_get_clean () . $return;
			if ( isset ( $GLOBALS['_CONFIG']['autoLink'] )
				&& $GLOBALS['_CONFIG']['autoLink'] == true )
			{
				$return	= $this->autoAddLanguage ( $return );
			}
			if ( $this->doDebug === true ) $return = str_replace ( 'CONTENT_HERE', $return, $debug );
			return $return;
		}
		private function addDebug ()
		{
			$code	= implode ( "", file ( $this->compiledDirectory . "/" . $this->templateDirectoryEncoded . $this->templatefilenameEncoded ) );
			$replacements	= print_r ( $this->replacedData, 1 );
			$replacements	= 
				str_replace ( "    ", "&nbsp;&nbsp;",
				htmlentities ( 
					$replacements  
				) )
			;
			$return	= "
				<table style=\"text-align: left; width: 100%;\" border=\"1\" cellpadding=\"2\" cellspacing=\"2\">
					<tr style=\"font-weight: bold;\">
						<td colspan=\"1\" rowspan=\"1\">Ausgabe</td>
					</tr>
					<tr>
						<td>CONTENT_HERE</td>
					</tr>
					<tr style=\"font-weight: bold;\">
						<td colspan=\"1\" rowspan=\"1\">Daten</td>
					</tr>
					<tr>
						<td><pre>$replacements</pre></td>
					</tr>
					<tr style=\"font-weight: bold;\">
						<td colspan=\"1\" rowspan=\"1\">Kompiliertes Template</td>
					</tr>
					<tr>
						<td>".
							highlight_string ( str_replace ( "\t", "  ", $code ), 1 )
						."</td>
					</tr>
				</table>"
			;
			$return	.= ob_get_flush();
			return $return;
		}
		private function autoAddLanguage ( $return )
		{
			$result = array ();
			if ( preg_match_all ( '/<a(.*?)href="([^"]{1,})"([^>]{0,})>/', $return, $result ) )
			{
				foreach ( $result[2] as $key => $value )
				{
					if ( !strstr ( $value, 'lang=' ) )
					{
						/* IDE-Workaroung */ $arguments = array ();
						if ( preg_match ( '/^([^\?]{0,})\?(.*)$/', $value, $arguments ) )
						{
							$value	= $arguments[1] . "?lang=" . $this->lang . "&" . $arguments[2];
						} else {
							$value	.= "?lang=" . $this->lang;
						}
					}
					$value	= "<a" . $result[1][$key] . "href=\"" . $value . "\"" . $result[3][$key] . ">";
					$return		= str_replace ( $result[0][$key], $value, $return );
				}
			}
			return $return;
		}
		private function replaceTemplatecodePCRE ( $site )
		{
			$currentLoop	= 0;
			$structures		= explode ( $this->cfg['beginStructure'], $site );
			/* IDE-Workaround */ $result = array ();
			/* IDE-Workaround */ $subresult = array ();
			foreach ( $structures as $structurekey => $structure )
			{
				/** ELSE **/
				if ( substr ( $structure, 0, 6 ) == ' ELSE ' ) {
					$substr		= substr ( strstr ( $structure, ' ' . $this->cfg['endStructure'] ), strlen ( ' ' . $this->cfg['endStructure'] ) );
					$structures[$structurekey]	= "<?php } else { ?>" . $substr;
				/** BEGIN **/
				} elseif ( substr ( $structure, 0, 7 ) == ' BEGIN ' ) {
					$substr				= substr ( $structure, 7 );
					$currentVariable	= str_replace ( strstr ( $substr, ' ' . $this->cfg['endStructure'] ), "", $substr );
/*INC LOOP*/		$currentLoop++;
					$code	= "<?php\n"
						. "if ( is_array ( " . $this->convertReplacement ( $currentVariable, $currentLoop-1 ) . " ) )\n"
						. "{\n"
							. "\$loop[" . $currentLoop . "]['ROWCNT'] = -1;\n"
							. "\$loop[" . $currentLoop . "]['ROWCNTHUMAN'] = 0;\n"
							. "foreach ( " . $this->convertReplacement ( $currentVariable, $currentLoop-1 ) . " as \$loop[" . $currentLoop . "]['key'] => \$loop[" . $currentLoop . "]['value'] )\n"
							. "{\n"
								. "	\$loop[" . $currentLoop . "]['ROWCNT']++;\n"
								. "	\$loop[" . $currentLoop . "]['ROWCNTHUMAN']++;\n"
								. "	\$loop[" . $currentLoop . "]['value']['ROWCNT']       = \$loop[" . $currentLoop . "]['ROWCNT'];\n"
								. "	\$loop[" . $currentLoop . "]['value']['ROWCNTHUMAN']  = \$loop[" . $currentLoop . "]['ROWCNTHUMAN'];\n"
								. "	\$loop[" . $currentLoop . "]['value']['ROWBIT']       = \$loop[" . $currentLoop . "]['ROWCNT']%2;\n"
								. "	\$loop[" . $currentLoop . "]['value']['ALTROW']       = \$loop[" . $currentLoop . "]['ROWCNTHUMAN']%2;\n"
								. "	\$loop[" . $currentLoop . "]['value']['CURRENTKEY']   = \$loop[" . $currentLoop . "]['key'];\n"
								. "?>"
					;
					$structures[$structurekey]	= str_replace ( ' BEGIN ' . $currentVariable . ' ' . $this->cfg['endStructure'], $code, $structure );
				/** END ENDIF **/
				} elseif ( substr ( $structure, 0, 4 ) == ' END' ) {
					$newStructure	= str_replace ( ' ' . $this->cfg['endStructure'], "", strstr ( $structure, ' ' . $this->cfg['endStructure'] ) );
					if ( substr ( $structure, 0, 7 ) != " ENDIF " )
					{
						$code	= "<?php } } ?>";
/*DEC LOOP*/			$currentLoop--;
					} else {
						$code	= "<?php } ?>";
					}
					$structures[$structurekey]	= $code . $newStructure;
				/** IF ELSEIF **/
				} elseif ( preg_match ( $this->pattern['ifElseIf'], $structure, $result ) ) {
					$result[1]	= strtolower ( $result[1] );
					$code		= "<?php ";
					if ( $result[1] == 'else' ) $code .= " } else";
					$code	.= "if ( ";
					if ( preg_match ( '/^([!=<>]+)"([^"]*)"$/', $result[3], $subresult ) )
					{
						$code		.= $this->convertReplacement ( $result[2], $currentLoop ) . " ";
						if ( $subresult[1] > "" )
						{
							if ( $subresult[1] == "=" ) $subresult[1] = "==";
							$code	.= $subresult[1] . " " . "\"" . $subresult[2] . "\" ";
						}
					} else {
						$code	.= "isset ( " . $this->convertReplacement ( $result[2], $currentLoop ) . " ) ";
					}
					$code		.= ") { ?>";
					$structures[$structurekey]	= str_replace ( $result[0], $code, $structure );
				/** * SQL * **/
				} elseif ( preg_match ( $this->pattern['sql'], $structure, $result ) ) {
					if ( $this->enableSql === true )
					{
						// 1 Variable
						// 2 SQL
						$sql	= $this->replaceReplacement ( $result[2], $currentLoop, true );
						$code	= "<?php\n"
							. "try {\n"
							. " \$loop[" . $currentLoop . "]['NOEXEC'] = false;\n"
							. "	\$loop[" . $currentLoop . "]['DB'] = new PDO ( \$this->sql['dsn'], \$this->sql['username'], \$this->sql['password'] );\n"
							. "} catch ( PDOException \$loop_" . $currentLoop . "_error ) {\n"
							. "	echo 'Connection failed: ' . \$loop_" . $currentLoop . "_error->getMessage();\n"
							. " \$loop[" . $currentLoop . "]['NOEXEC'] = true;\n"
							. "}\n"
							. "if ( \$loop[" . $currentLoop . "]['NOEXEC'] === false )\n"
							. "{\n"
							. "\$loop[" . $currentLoop . "]['DBRES'] = \$loop[" . $currentLoop . "]['DB']->prepare ( \"$sql\" );\n"
							. "\$loop[" . $currentLoop . "]['DBRES']->execute();\n"
							. "\$loop[" . $currentLoop . "]['value']['" . $result[1] . "'] = \$loop[" . $currentLoop . "]['DBRES']->fetchAll();\n"
							. "if ( sizeof ( \$loop[" . $currentLoop . "]['value']['" . $result[1] . "'] ) == 0 ) unset ( \$loop[" . $currentLoop . "]['value']['" . $result[1] . "'] );\n"
							. "}\n"
							. "?>\n"
						;
						$structures[$structurekey]	= str_replace ( $result[0], $code, $structure );
					} else {
						$structures[$structurekey]	= "<?php echo \"no sql allowed\"; ?>";
					}
				} else {
					if ( $structurekey > 0 )
					{
						$structures[$structurekey]	= $this->cfg['beginStructure'] . $structures[$structurekey];
					}
				}
				if ( $this->enableXML === true )
				{
					$structures[$structurekey]	= $this->replaceXML ( $structures[$structurekey] );
				}
				if ( $this->enableExtension === true )
				{
					$structures[$structurekey] = $this->replaceExtension ( $structures[$structurekey], $currentLoop );
				}
				$structures[$structurekey]	= $this->replaceReplacement ( $structures[$structurekey], $currentLoop );
			}
			return implode ( "", $structures );
		}
		private function getOperator ( $currentVariable )
		{
			$substr1 = substr ( $currentVariable, -1, 1 );
			$substr2 = substr ( $currentVariable, -2, 2 );
			if ( $substr1 == '==' )
			{
				$replace	= '==';
				$operator = '==';
			} elseif ( $substr1 == '>=' ) {
				$replace	= '>=';
				$operator = '>=';
			} elseif ( $substr1 == '=>' ) {
				$replace	= '=>';
				$operator = '>=';
			} elseif ( $substr1 == '<=' ) {
				$replace	= '<=';
				$operator = '<=';
			} elseif ( $substr1 == '=<' ) {
				$replace	= '=<';
				$operator = '<=';
			} elseif ( $substr1 == '!=' ) {
				$replace	= '!=';
				$operator = '!=';
			} elseif ( $substr1 == '=' ) {
				$replace	= '=';
				$operator = '==';
			} elseif ( $substr1 == '>' ) {
				$replace	= '>';
				$operator = '>';
			} elseif ( $substr1 == '<' ) {
				$replace	= '<';
				$operator = '<';
			} elseif ( $substr1 == '!' ) {
				$replace	= '!';
				$operator = '!=';
			} else {
				die ( $substr2 );
			}
			return array ( $replace, $operator );
		}
		// replacement
		private function replaceReplacement ( $site, $currentLoop, $noEcho = false )
		{
			$pattern	= '/' . $this->pattern['replacementInTheWild'] . '/';
			/* IDE-workaround */ $result = array ();
			if ( preg_match_all ( $pattern, $site, $result ) )
			{
				foreach ( $result[1] as $key => $replacement )
				{
					if ( $noEcho === true )
					{
						$site	= str_replace ( $result[0][$key], "\".".$this->convertReplacement ( $replacement, $currentLoop ).".\"", $site );
					} else {
						$site	= str_replace ( $result[0][$key], "<?php echo " . $this->convertReplacement ( $replacement, $currentLoop ) . "; ?>", $site );
					}
				}
			}
			return $site;
		}
		// extension:[[[.].].]
		private function replaceExtension ( $site, $currentLoop )
		{
			$pattern	= '/' . $this->pattern['extension'] . '/';
			/* IDE-workaround */ $result = array ();
			if ( preg_match_all ( $pattern, $site, $result ) )
			{
				foreach ( $result[1] as $key => $extension )
				{
					if ( $this->compatibility === true )
					{
						$functionname	= 'smarttemplate_extension_';
						$extensionprefix	= "smarttemplate_extension_";
					} else {
						$functionname	= 'ste';
						$extensionprefix	= "";
					}
					if ( !isset ( $this->requiredExtensions['smarttemplate'][$extension] ) )
					{
						$this->requiredExtensions['smarttemplate'][$extension]		= $this->extensionDirectory . "/".$extensionprefix.$extension . ".php";
					}
					$arguments		= $result[2][$key];
					if ( $arguments > "" )
					{
						if ( !strstr ( $arguments, ',' ) )
						{
							$arguments	= array ( $arguments );
						} else {
							$arguments	= explode ( ',', $arguments );
						}
						foreach ( $arguments as $argumentKey => $argument )
						{
							$firstChar		= substr ( $argument, 0, 1 );
							$lastChar		= substr ( $argument, -1 );
							$pattern		= '/^' . $this->pattern['replacement'] . '$/';
							if ( preg_match ( $pattern, $argument ) )
							{
								$argument	= $this->convertReplacement ( $argument, $currentLoop );
							} else {
								if ( !preg_match ( '/^(\'|"){1}.*\1$/', $argument ) )
								{
									$argument	= "\"$argument\"";
								}
							}
							$arguments[$argumentKey] = $argument;
						}
						$arguments	= implode ( ",", $arguments );
					}
					$site		= str_replace ( 
						$result[0][$key]
						, "<?php echo " . $functionname . $extension . " ( $arguments ); ?>"
						, $site
					);
				}
			}
			return $site;
		}
		// ENDIF
		private function replacePHPCode ( $site )
		{
			$site	= preg_replace ( '/<\?php(.*?)\?>/ims', '<?php highlight_string ( \'<?php $1 ?>\' ); ?>', $site );
			return $site;
		}
		private function replaceForcePHPCode ( $site )
		{
			$site	= preg_replace ( '/<!php(.*?)!>/ims', '<?php$1?>', $site );
			return $site;
		}
		/* <?xml ...?> */
		private function replaceXML ( $site )
		{
			$pattern		= "/<\?xml(.*?)\?>/";
			$replacement	= "\n<?php\n\tprint('<?xml\\1?>');\n?>\n";
			$site			= preg_replace ( $pattern, $replacement, $site );
			return $site;
		}
		// xxx[.xxx]
		private function convertReplacement ( $replacement, $currentLoop )
		{
			if ( $replacement == 'TOP.TIME_GENERATED' )
			{
				return "( round(microtime (), 4) - \$TIME_GENERATED)";
			}
			while ( substr ( $replacement, 0, 7 ) == 'parent.' )
			{
				if ( $currentLoop > 0 )
				{
					$currentLoop--;
				}
				$replacement	= substr ( $replacement, 7 );
			}
			if ( substr ( $replacement, 0, 4 ) == "top." 
				|| substr ( $replacement, 0, 4 ) == "TOP." )
			{
				$currentLoop	= 0;
				$replacement	= substr ( $replacement, 4 );
			}
			$insideArray		= "";
			while ( $substr = strstr ( $replacement, "." ) )
			{
				$substr			= substr ( $substr, 1 );
				$current		= str_replace ( ".".$substr, "", $replacement );
				$insideArray	.= "['" . $current . "']";
				$replacement	= $substr;
			}
			$return 	= "\$loop[" . $currentLoop . "]['value']" . $insideArray . "['" . $replacement . "']";
			return $return;
		}
		// + require_once ...
		private function addRequiredExtensions ( $site )
		{
			$extensions		= "";
			if ( isset ( $this->requiredExtensions['smarttemplate'] ) && is_array ( $this->requiredExtensions['smarttemplate']  ) )
			{
				foreach ( $this->requiredExtensions['smarttemplate'] as $extension )
				{
					$extensions		.= "require_once \"" . $extension . "\";\n";
				}
			}
			if ( isset ( $this->requiredExtensions['smartertemplate'] ) && is_array ( $this->requiredExtensions['smartertemplate']  ) )
			{
				foreach ( $this->requiredExtensions['smartertemplate'] as $extension )
				{
					$extensions		.= "require_once \"" . $extension . "\";\n";
				}
			}
			if ( $extensions > "" )
			{
				$site		= "<?php\n"
					. $extensions . "\n"
					. "?>"
					. $site
				;
			}
			return $site;
		}
	}
	
?>