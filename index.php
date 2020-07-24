<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>



<form method="post" enctype="multipart/form-data">
	<input type="name" name="name">
	<input type="number" name="rating">
	<textarea name="description"></textarea>
	<input type="file" name="file">
	<input type="submit" value="Загрузить файл!">
</form>

<?php
	function can_upload($file){
		if($file['name'] == '')
			return 'Вы не выбрали файл.';
		if($file['size'] == 0)
			return 'Файл слишком большой.';
		$getMime = explode('.', $file['name']);
		$mime = strtolower(end($getMime));
		$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

		if(!in_array($mime, $types))
			return 'Недопустимый тип файла.';
		return true;
	}
	  
	function make_upload($file){	
		$name = mt_rand(0, 10000) . $file['name'];
		copy($file['tmp_name'], 'photo/' . $name);
		return '/photo/' . $name;
	}
	if(isset($_FILES['file'])) {
		$check = can_upload($_FILES['file']);
		if($check === true){
			$filename = make_upload($_FILES['file']);
			echo "<strong>Файл успешно загружен11!</strong>";
		}
		else{
			echo "<strong>$check</strong>";  
		}
	}

	$name = $_REQUEST['name'];
	$rating = $_REQUEST['rating'];
	$description = $_REQUEST['description'];
	$filename;


	if(!empty($name) && !empty($rating) && !empty($description) && !empty($filename)){
		$servername = "localhost";
		$database = "reviews";
		$username = "root";
		$password = "root";
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
		      die("Connection failed: " . mysqli_connect_error());
		}
		 
		$sql = "INSERT INTO reviews (name, description, rating, photo) VALUES ('$name', '$description','$rating','$filename')";
		if (mysqli_query($conn, $sql)) {

		} 
		else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
	
?>