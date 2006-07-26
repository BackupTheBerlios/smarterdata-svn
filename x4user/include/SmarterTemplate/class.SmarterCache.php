<?php

	class SmarterCache
	{
		// Cachehandling
		private $cf				= "";
		private $currentCache	= "";
		private $lockchecks		= 5;
		public function __construct ()
		{
			$this->cf	= str_replace ( "\\", "/", dirname ( __FILE__ ) ) . "/internal/cache/cachefile";
		}
		/**
		 * Aktualisiert ein Element. Textdateibasierte Version
		 * @param $cachingId string
		 */
		public function setTimeTextfile ( $cachingId )
		{
			$lockchecks		= $this->timesToCheck;
			while ( file_exists ( $this->cf . ".locked" ) )
			{
				if ( $lockchecks == 0 ) break;
				sleep ( 1 );
				$lockchecks--;
			}
			fclose ( fopen( $this->cf . ".locked", "w" ) );
			if ( !is_file ( $this->cf ) )
			{
				fclose ( fopen ( $this->cf, "w" ) );
				chmod ( $this->cf, 0755 );
			}
			$times		= file ( $this->cf );
			$found		= false;
			/* IDE-Workaround*/ $result = array ();
			foreach ( $times as $timekey => $time )
			{
				if ( preg_match ( '/^([0-9]{1,})\;' . preg_quote ( $cachingId ) . '$/is', $time, $result ) )
				{
					$times[$timekey]	= time () . ";" . $cachingId . "\n";
					$found		= true;
					break;
				}
			}
			if ( $found !== true )
			{
				$times[]		= time () . ";" . $cachingId . "\n";
			}
			$times	= implode ( "", $times );
			$fh		= fopen ( $this->cf, "w" );
			fwrite ( $fh, $times );
			fclose ( $fh );
			@unlink ( $this->cf . ".locked" );
		}
		/**
		 * Prueft ob das Element zu alt ist und aktualisiert es bei Bedarf. Textdateibasierte Version
		 * @param $cachingId string
		 * @param $maxCachingTime int
		 * @param $autoupdate bool
		 * @return int
		 */
		public function isCacheOkTextfile ( $cachingId, $maxCachingTime, $autoupdate = true )
		{
			$cachingId		= sha1 ( $cachingId );
			if ( !is_file ( $this->cf ) )
			{
				if ( $autoupdate === true ) $this->setTimeTextfile ( $cachingId );
				return false;
			}
			$times		= file ( $this->cf );
			$result = array ();
			foreach ( $times as $timekey => $time )
			{
				if ( preg_match ( '/^([0-9]{1,})\;' . $cachingId . '$/is', $time, $result ) )
				{
					if ( ( $result[1] + $maxCachingTime ) > time () )
					{
						return $result[1];
					} else {
						if ( $autoupdate === true ) $this->setTimeTextfile ( $cachingId );
						return false;
					}
				}
			}
			if ( $autoupdate === true ) $this->setTimeTextfile ( $cachingId );
			return false;
		}
		/**
		 * Prueft ob die Datei zu alt ist loescht sie bei Bedarf
		 * @param $cachedFile string
		 * @param $maxCachingTime int 
		 * @param $autodelete bool
		 */
		public function isCacheOkFile ( $cachedFile, $maxCachingTime, $autodelete = true )
		{
			if ( ( @filemtime ( $cachedFile ) + $maxCachingTime ) < time () )
			{
				if ( $autodelete === true ) @unlink ( $cachedFile );
				return false;
			}
			return filemtime ( $cachedFile );
		}
	}
	
?>