	
<div>
	<a href="?rating=asc">Сортировка по рейтингу (Возрост)</a>
	<a href="?rating=desc">Сортировка по рейтингу (Убыв)</a>
</div>
<div>
	<a href="?date=asc">Сортировка по дате (Возрост)</a>
	<a href="?date=desc">Сортировка по дате (Убыв)</a>
</div>
<?

	$host = 'localhost';
    $db   = 'reviews';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
	$db = new PDO($dsn, $user, $pass, $opt);

	if ($_GET['page']) {
		$page = $_GET['page'];
	} else {
	  	$page = 1;
	}
	$limit = 2;
	$number = ($limit * $page) - $limit;
	$num_rows = $db->query('select count(*) from reviews')->fetchColumn(); 
	$str_page = ceil($num_rows/$limit);

	if($_GET['rating'] == 'desc'){
		$sql = "SELECT * from reviews ORDER BY rating DESC LIMIT $number, $limit";
	}
	if($_GET['rating'] == 'asc'){
		$sql = "SELECT * from reviews ORDER BY rating ASC LIMIT $number, $limit";
	}
	if($_GET['date'] == 'desc'){
		$sql = "SELECT * from reviews ORDER BY id DESC LIMIT $number, $limit";
	}
	if($_GET['date'] == 'asc'){
		$sql = "SELECT * from reviews ORDER BY id ASC LIMIT $number, $limit";
	}

	if(empty($_GET['rating']) && empty($_GET['date'])){
		$sql = "SELECT * from reviews LIMIT $number, $limit";
	}	


	foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
	 
	  echo "Имя: " . $row['name'] . "<br>";
	  echo "Описание: " . $row['description'] . "<br>";
	  echo "Рейтинг: " . $row['rating'] . "<br>";
	  echo "Фотография: " . $row['photo'] . "<br>";
	};
	for ($i=1; $i <= $str_page ; $i++) { 
	  echo "<a href='?page=$i'> $i </a>";
	}