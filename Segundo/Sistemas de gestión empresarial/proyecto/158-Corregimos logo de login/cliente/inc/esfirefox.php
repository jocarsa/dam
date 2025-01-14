<?php
	function isFirefox() {
		 // Check the User-Agent string
		 return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false;
	}

	if (isFirefox()) {
		 $file = 'lock.txt';
		 
		 // Create the file if it doesn't exist
		 if (!file_exists($file)) {
		     $handle = fopen($file, 'w'); // Open the file for writing
		     if ($handle) {
		         fwrite($handle, "This file was created because the browser is Firefox.");
		         fclose($handle);
		         
		     } else {
		         
		     }
		 } else {
		    
		 }
	} else {
		
	}
?>

