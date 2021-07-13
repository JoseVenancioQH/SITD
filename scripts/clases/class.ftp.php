<?php
# FTP Class for performing file downloads
class FTP { 
   /**
     * Download() performs an automatic syncing of files and folders from a remote location
     * preserving folder and file names and structure
     *
     * @param	$local_dir: The directory to put the files, must be in app path and be writeable
     * @param 	$remote_dir: The directory to start traversing from. Use "." for root dir
     *
     * @return 	null
     */
    public static function download($local_dir, $remote_dir, $ftp_conn)
    {
 
	    if ($remote_dir != ".") {
	        if (ftp_chdir($ftp_conn, $remote_dir) == false) {
	            echo ("Change Dir Failed: $dir<br />\r\n");
	            return;
	        }
	        if (!(is_dir($dir)))
	            mkdir($dir);
	        chdir ($dir);
	    }
 
	    $contents = ftp_nlist($ftp_conn, ".");
	    foreach ($contents as $file) {
 
	        if ($file == '.' || $file == '..')
	            continue;
 
	        if (@ftp_chdir($ftp_conn, $file)) {
	            ftp_chdir ($ftp_conn, "..");
	            FTP::download($local_dir, $file, $ftp_conn);
	        }
	        else
	            ftp_get($ftp_conn, "$local_dir/$file", $file, FTP_BINARY);
	    }
 
	    ftp_chdir ($ftp_conn, "..");
	    chdir ("..");
	} 
}
?>