<?php
//phpinfo();
echo "RAW BODY:\n";
echo file_get_contents("php://input");

echo "\n\n_POST:\n";
print_r($_POST);

echo "\n\n_GET:\n";
print_r($_GET);
?>
