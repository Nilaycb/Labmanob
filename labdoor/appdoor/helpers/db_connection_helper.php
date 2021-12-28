<?php 

require_once('def/def_db.php'); 

try { 
$dbconn_mysql_pdo = new PDO("mysql:host=$def_db__host;dbname=$def_db__name", $def_db__username, $def_db__password); 
$dbconn_mysql_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

} 

catch(PDOException $e) 
{ 
echo "Error: " . $e->getMessage(); 
} 

?>






