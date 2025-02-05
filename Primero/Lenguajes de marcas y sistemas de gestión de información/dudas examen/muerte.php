<?php

function muerte(){
	$palabrasprohibidas = [
			 // SQL Keywords
			 "SELECT", "DROP", "DELETE", "UPDATE", "INSERT", "ALTER", "GRANT", "CREATE",
			 "TRUNCATE", "REPLACE", "REVOKE", "MERGE", "EXEC", "EXECUTE", "UNION", "ALL",
			 "WHERE", "HAVING", "ORDER BY", "GROUP BY", "LIKE", "INTO", "FROM", "VALUES",
			 "JOIN", "INNER JOIN", "OUTER JOIN", "CROSS JOIN", "LEFT JOIN", "RIGHT JOIN",
			 "OR", "AND", "NOT", "NULL", "ISNULL", "IFNULL", "LOAD_FILE", "OUTFILE",

			 // SQL Comments
			 "--", "#", "/*", "*/",

			 // JavaScript/XSS
			 "<script>", "alert(", "onerror=", "onload=", "onclick=", "onmouseover=",
			 "onfocus=", "onblur=", "document.cookie", "document.write", "eval(",
			 "setTimeout(", "setInterval(", "XMLHttpRequest", "fetch(", "localStorage",
			 "sessionStorage", "console.log", "innerHTML", "outerHTML",

			 // Potentially dangerous HTML tags
			 "<iframe>", "<object>", "<embed>", "<applet>", "<meta>", "<form>",
			 "<input>", "<button>", "<textarea>", "<svg>", "<math>", "<link>", "<base>",

			 // PHP Injection
			 "<?php", "?>", "system(", "shell_exec(", "exec(", "passthru(", "proc_open(", "popen(",

			 // Encoding Variants
			 "0x", "0X", "char(", "concat(", "ascii(", "unhex(", "hex("
		];
	$datos_json = file_get_contents("php://input");
	if ($datos_json !== false && !empty($datos_json)) {
		$datos_json = file_get_contents("php://input");
		$datos = json_decode($datos_json, true);
		foreach($datos as $dato){
			foreach($palabrasprohibidas as $palabra){
				if(str_contains($dato,$palabra)){
					die("Operación prohibida");
				}
			}
		}
	}
	if(isset($_GET)){
		$datos = $_GET;
		foreach($datos as $dato){
			foreach($palabrasprohibidas as $palabra){
				if(str_contains($dato,$palabra)){
					die("Operación prohibida");
				}
			}
		}
	}
	if(isset($_POST)){
		$datos = $_POST;
		foreach($datos as $dato){
			foreach($palabrasprohibidas as $palabra){
				if(str_contains($dato,$palabra)){
					die("Operación prohibida");
				}
			}
		}
	}
}
