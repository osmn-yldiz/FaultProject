<?php
error_reporting(0);
try {
	$db = new PDO("mysql:host=localhost; dbname=arizabildirimi; charest=utf8", 'osman', 'Oy621207.');
	$db->query("SET NAMES 'UTF8'");
	//echo 'Veritabanı Bağlantısı Başarılı';
} catch (Exception $e) {
	echo $e->getMessage(); 
}

?>