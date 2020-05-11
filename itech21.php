
<html>

	<head></head>
	<body>
	<script>
		var ajax; 
		InitAjax();
		
		function InitAjax() {
			try { 
				ajax = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				try {
					ajax = new ActiveXObject("Msxml2.XMLHTTP"); 
				} catch (e) {
					try {
					ajax = new XMLHttpRequest(); 
					} catch(e) { 
					ajax = 0; 
					}
				}
			}
		}
		
		function sendAjaxGetRequest(request_string, response_handler){
			if (!ajax) {
				alert("Ajax не инициализирован");
				return;
			}
			ajax.onreadystatechange = response_handler;
			ajax.open( "GET", request_string, true );
			ajax.send(null);
		}
	
		function task1() {
			var value = document.getElementById("p").value;
			var params = 'publisher=' + encodeURIComponent(value);
			sendAjaxGetRequest("form1.php?"+params, onTask1Response );
		}

		function onTask1Response(){
			if (ajax.readyState == 4) {
				if (ajax.status == 200) {
					 document.getElementById('publisher').innerHTML = ajax.responseText; 
				} else {	
					alert(ajax.status + " - " + ajax.statusText);
					ajax.abort();
				}
			}
		}
		
		function task2() {
			var value = document.getElementById("a").value;
			var params = 'author=' + encodeURIComponent(value);
			sendAjaxGetRequest("form2.php?"+params, onTask2Response );
		}

		function onTask2Response(){
			if (ajax.readyState == 4) {
				if (ajax.status == 200) {
					var xml = ajax.responseXML;
					document.getElementById('author').innerHTML = "<table border = 1 id = 'authors_table'> <tr> <td>Author</td><td>Name</td><td>ISBN</td><td>Year</td><td>Number of pages</td><td>Publisher</td><td>Resource</td></tr>";
					var table = document.getElementById('authors_table'); 
					for (var i = 0; i < xml.getElementsByTagName("row").length; i++) {
						var result = document.createElement("tr");
						result.innerHTML += "<td>" + xml.getElementsByTagName("author")[i].childNodes[0].nodeValue+ "</td>";
						result.innerHTML  += "<td>" + xml.getElementsByTagName("name")[i].childNodes[0].nodeValue + "</td>";
						result.innerHTML  += "<td>" + xml.getElementsByTagName("isbn")[i].childNodes[0].nodeValue + "</td>";
						result.innerHTML += "<td>" + xml.getElementsByTagName("year")[i].childNodes[0].nodeValue+ "</td>";
						result.innerHTML  += "<td>" + xml.getElementsByTagName("quantity")[i].childNodes[0].nodeValue+ "</td>";
						result.innerHTML  += "<td>" + xml.getElementsByTagName("publisher")[i].childNodes[0].nodeValue+ "</td>";
						if (xml.getElementsByTagName("title")[i].hasChildNodes()){
							result.innerHTML  += "<td>" + xml.getElementsByTagName("title")[i].childNodes[0].nodeValue+ "</td>";
						}
						table.appendChild(result);
					}
					document.getElementById('author').innerHTML += "</table>";
				}else {
					alert(ajax.status + " - " + ajax.statusText);
					ajax.abort();
				}
			}	
		}
		
		function task3() {
			var start_date = document.getElementById("s").value;
			var end_date = document.getElementById("e").value;
			var params = 'start_date=' + encodeURIComponent(start_date)+'&end_date='+encodeURIComponent(end_date);
			sendAjaxGetRequest("form3.php?"+params, onTask3Response );
		}
		
		function onTask3Response(){
			if (ajax.readyState == 4) {
				if (ajax.status == 200) {
					var obj = JSON.parse(ajax.responseText);
					alert(ajax.responseText);
					document.getElementById('date').innerHTML = "<table border = 1 id = 'date_table'> <tr> <td>Name</td><td>ISBN</td><td>Year</td><td>Number of pages</td><td>Number</td><td>Date</td><td>Publisher</td><td>Resource</td><td>Author</td></tr>";
					var table = document.getElementById('date_table'); 
					for(var i in obj){	
						var tr = document.createElement("tr");
						tr.innerHTML = '<td>'+obj[i].name+'</td> <td>'+obj[i].isbn+'</td> <td>'+obj[i].year+'</td> <td>'+obj[i].quantity+'</td> <td>'+obj[i].number+ '</td> <td>'+obj[i].date +'</td> <td>'+obj[i].publisher+'</td> <td>'+obj[i].title+'</td> <td>'+obj[i].author_name+'</td>';
						table.appendChild(tr);
					}
					document.getElementById('date').innerHTML += "</table>";
				}
			}else {
				alert(ajax.readyState+ ' ' + ajax.status + " - " + ajax.statusText);
				//ajax.abort();
			}
		}
	</script>
	
		<form method = "get">
					<br>
					<a>издательство: 			 </a><input type = "text" name = "publisher" id = "p">
					<br>
					<p><input type="button" value="ввести"  onclick = "task1();"></p>
		</form>
		<div id = "publisher"></div>
		<form method = "get">
					<br>
					<a>автор книги:              </a><input type = "text" name = "author" id = "a">
					<br>
					<p><input type="button" value="ввести"  onclick = "task2();"></p>
		</form>
		<div id = "author"></div>
		<form method = "get">
					<br>
					<a>начальная дата: 			 </a><input type = "date" name = "start_date" id = "s"><br>
					<br>
					<a>конечная дата:            </a><input type = "date" name = "end_date" id = "e"><br>
					<br>
					<p><input type="button" value="ввести"  onclick = "task3();"></p>
		</form>
		<div id = "date"></div>
	</body>
</html>