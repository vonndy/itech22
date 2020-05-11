<?php

	require 'db_connect.php';
	
	$publisher = $_GET['publisher'];
	$publisher2 = $dbh->prepare("select literature.name, literature.isbn, literature.year, literature.quantity, resources.title, authors.author_name 
								from literature left join resources 
								on literature.fid_resource=resources.id_resourse 
								join book_authors on book_authors.fid_book = literature.id_book 
								join authors on authors.id_author = book_authors.fid_author 
								WHERE publisher = :publisher");
	$publisher2->bindParam(':publisher', $publisher, PDO::PARAM_STR);
	
	$publisher2->execute();
	$result=$publisher2->fetchAll();	

?>

<table border = 1>

	<tr>
		<td>Publisher</td>
		<td>Name</td>
		<td>ISBN</td>
		<td>Year</td>
		<td>Number of pages</td>
		<td>Resource</td>
		<td>Authors</td>
	</tr>
	
	<?php foreach ($result as $row){?>
		<tr>
			<td><?php echo $publisher; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['isbn']; ?></td>
			<td><?php echo $row['year']; ?></td>
			<td><?php echo $row['quantity']; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['author_name']; ?></td>
		</tr>
	<?php } ?>
	
</table>