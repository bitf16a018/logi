<?php

/**
 * Collection of static functions dealing with file IO
 */
class Lc_File_Util {

	/**
	 * return the directory name where it is okay to store temporary files
	 */
	function getTempDir() {

		if ( function_exists('sys_get_temp_dir') ) {
			return sys_get_temp_dir();
		}

		// Try to get from environment variable
		if ( !empty($_ENV['GCONF_TMPDIR']) )
		{
					return $_ENV['GCONF_TMPDIR'];
		}
		if ( !empty($_ENV['TMP']) )
		{
			return realpath( $_ENV['TMP'] );
		}
		else if ( !empty($_ENV['TMPDIR']) )
		{
			return realpath( $_ENV['TMPDIR'] );
		}
		else if ( !empty($_ENV['TEMP']) )
		{
			return realpath( $_ENV['TEMP'] );
		}

		// Detect by creating a temporary file
		else {
			// Try to use system's temporary directory
			// as random name shouldn't exist
			$temp_file = tempnam( md5(uniqid(rand(), TRUE)), '' );
			if ( $temp_file ) {
				$temp_dir = realpath( dirname($temp_file) );
				unlink( $temp_file );
				return $temp_dir;
			}
			else {
				return FALSE;
			}
		}
	}
}
