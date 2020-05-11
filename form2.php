<?php

	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate");
	echo '<?xml version="1.0" encoding="utf8" ?>';
	echo "<root>";

	require 'db_connect.php';
	
	$author = $_GET['author'];
	$author2 = $dbh->prepare("select literature.name, literature.isbn, literature.year, literature.quantity, literature.publisher, resources.title from literature left join resources on literature.fid_resource=resources.id_resourse join book_authors on book_authors.fid_book = literature.id_book join authors on authors.id_author = book_authors.fid_author WHERE author_name = :author");
	$author2->bindParam(':author', $author, PDO::PARAM_STR);
	
	$author2->execute();
	$result=$author2->fetchAll(PDO::FETCH_ASSOC);	
	foreach ($result as $row){
		
		echo "<row><author>$author</author>
		<name>$row[name]</name>
		<isbn>$row[isbn]</isbn>
		<year>$row[year]</year>
		<quantity>$row[quantity]</quantity>
		<publisher>$row[publisher]</publisher>
		<title>$row[title]</title></row>";
	
	}
	
	echo "</root>";
?>
	
