<?php

	function steresetheader ( $currentRow, $maxRows, $newheader = false ) {
		if ( $currentRow > 0 ) {
			if ( $currentRow%$maxRows == 0 ) {
				return $newheader;
			}
		}
	}

?>