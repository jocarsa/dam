<?php
$path = '../basededatos/'; 

if (is_dir($path)) {
    // Scan the directory
    $contents = scandir($path);

    // Filter only directories
    $folders = array_filter($contents, function($item) use ($path) {
        return is_dir($path . DIRECTORY_SEPARATOR . $item) && $item !== '.' && $item !== '..';
    });

    // Print the list of folders
    foreach ($folders as $folder) {
        echo "
        <li>
        		<a href='?carpeta=".$folder."'>
        			".$folder . "
        		</a>
        </li>";
    }
} else {
    echo "The specified path is not a directory.";
}
?>
