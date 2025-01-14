<style>
	a{display:block;}
	body{
		font-family:sans-serif;
	}
	pre{
		color:white;
		background:black;
		padding:20px;
		border-radius:10px;
	}
</style>
<?php

function creaIndice($folderPath) {
    if (!is_dir($folderPath)) {
        //die("The folder does not exist: $folderPath");
    }

    // Helper function to recursively scan folders
    function scanDirRecursively2($path) {
        $items = scandir($path);
        foreach ($items as $item) {
            // Skip current and parent directory pointers
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $path . DIRECTORY_SEPARATOR . $item;
            if (is_dir($fullPath)) {
                echo "<a href='#".$fullPath."'>" . $item . PHP_EOL . "</a>";
                scanDirRecursively2($fullPath); // Recursive call
            } 
        }
    }

    // Start scanning from the root folder
    scanDirRecursively2($folderPath);
}

function parseFolderAndFiles($folderPath) {
    if (!is_dir($folderPath)) {
        //die("The folder does not exist: $folderPath");
    }

    // Helper function to recursively scan folders
    function scanDirRecursively($path) {
        $items = scandir($path);
        foreach ($items as $item) {
            // Skip current and parent directory pointers
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $path . DIRECTORY_SEPARATOR . $item;
            if (is_dir($fullPath)) {
                echo "<h3 id='".$fullPath."'>" . $item . PHP_EOL . "</h3>";
                scanDirRecursively($fullPath); // Recursive call
            } elseif (is_file($fullPath)) {
            	$extensiones = ['py','php'];
            	$explotado = explode(".",$item);
            	$extension = explode(".",$item)[count($explotado)-1];
            	
                echo "<strong>" . $item . PHP_EOL. "</strong><br>";
                $content = file_get_contents($fullPath);
						if($extension == "py"){
						echo "<pre>" . nl2br($content) .  PHP_EOL . "</pre>"; 
						}else{
                	echo "<p>" . nl2br($content) .  PHP_EOL . "</p>"; 
                }
                
            }
        }
    }

    // Start scanning from the root folder
    scanDirRecursively($folderPath);
}

// Example usage
$folderPath = 'materiales';
creaIndice($folderPath);
parseFolderAndFiles($folderPath);
?>

