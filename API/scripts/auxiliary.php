<?php
function get_request_info(){
	
	
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

	return $_GET;
}
try {
        return json_decode(json: file_get_contents("php://input"), associative: true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        echo "JSON Request Error: " . $e->getMessage();
   	exit(); 
    }  
}

?>
