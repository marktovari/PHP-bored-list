<?php

	//DB connect
	define('__ROOT__', dirname(__FILE__));
	//define('__ROOT__', dirname(dirname(__FILE__))); This is a file outside of the webroot with sensitive info to keep the info secure,
	require_once(__ROOT__.'\dbConnect.php'); //Delete this and use the line above in actual application

	//Write Queries in SQL and put it in a string
	$queryParmeter =  "SELECT * FROM `boredtable`";

	//Apply query through the PDO (PHP Data Object) using the built-in method, recording it in a variable
	$stmt = $pdo->query($queryParmeter);
	//Fetch the resulting columns as an associative array
	$queryArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div>

	<!-- Display the data with the help of a PHP foreach loop, to echo it onto the page-->
	<div>
		<!-- These values correspond to he field names inside of the DB -->
		<?php foreach($queryArray as $data => $value): ?>
				<div class="containerFlex">
					<div class="articleImage">
						<img src="images/<?=$value['articleImage']?>">
					</div>
					<div class="articleBody">
						<div class="articleTitle"><?php echo htmlspecialchars($value['title']); ?></div>
						<div class="article-item"><?php echo htmlspecialchars($value['body']); ?></div>
						<div class="article-item"><?php echo htmlspecialchars($value['pitch']); ?></div>
						<a href="<?=$value['link']?>">
							<button class="article-item articleButton" type="button" name="button"><?php echo htmlspecialchars($value['buttonName']); ?></button>
						</a>
					</div>
				</div>
		<?php endforeach ?>
	</div>

</div>
