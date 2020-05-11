<?php

	header('Content-Type: application/json');

	require 'db_connect.php';
	
	$start_date = $_GET['start_date'];
	$end_date = $_GET['end_date'];
	$date = $dbh->query("SELECT * FROM literature left join resources 
								on literature.fid_resource=resources.id_resourse 
								left join book_authors on book_authors.fid_book = literature.id_book 
								left join authors on authors.id_author = book_authors.fid_author 
								WHERE (year > '$start_date' AND year < '$end_date') OR (date > '$start_date' AND date < '$end_date')");

	$result=$date->fetchAll(PDO::FETCH_ASSOC);	
	echo json_encode($result);  
?>
