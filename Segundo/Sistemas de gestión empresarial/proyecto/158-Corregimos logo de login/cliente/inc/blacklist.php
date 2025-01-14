<?php
// Path to the text file containing IP addresses
$filePath = 'inc/blacklist.txt';

// Get the user's IP address
$userIP = $_SERVER['REMOTE_ADDR'];

// Open the file for reading
if (file_exists($filePath) && is_readable($filePath)) {
    $file = fopen($filePath, 'r');

    if ($file) {
        $found = false;

        // Read the file line by line
        while (($line = fgets($file)) !== false) {
            // Remove whitespace and newlines from the line
            $ipFromFile = trim($line);

            // Check if the IP matches
            if ($ipFromFile === $userIP) {
                $found = true;
                break;
            }
        }

        // Close the file
        fclose($file);

        // If IP is found, create lock.txt
        if ($found) {
            $lockFile = 'lock.txt';
            if (file_put_contents($lockFile, "IP matched: $userIP") !== false) {
               // echo "Your IP ($userIP) is in the list. 'lock.txt' has been created.";
            } else {
               // echo "Your IP ($userIP) is in the list, but 'lock.txt' could not be created.";
            }
        } else {
          //  echo "Your IP ($userIP) is not in the list.";
        }
    } else {
       // echo "Could not open the file.";
    }
} else {
   // echo "File does not exist or is not readable.";
}
?>

