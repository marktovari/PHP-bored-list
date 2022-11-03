<?php

	//Errors Array
	$errors = [
		'title' => '',
		'body' => '',
		'pitch' => '',
		'link' => '',
		'buttonName' => '',
	];

	if(isset($_POST['submit'])) {
// //FORM VALIDATION
	//Initializing Variables from the POST request
	$title = $_POST['title'];
	$body = $_POST['body'];
	$pitch = $_POST['pitch'];
	$link = $_POST['link'];
	$buttonName = $_POST['buttonName'];

	$pictureFilename = 		$_FILES['articleImage']['name'];
	$pictureSize = 			$_FILES['articleImage']['size'];
	$pictureError = 		$_FILES['articleImage']['error'];
	$pictureTemporaryName = $_FILES['articleImage']['tmp_name'];

	//Function to prepare input
	function inputPrepare($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	//Image Validation
	if ($pictureError != 0) { //Use the built-in error functionality of the PHP $_FILE global
        $errors["articleImage"] = "Error with picture: {$pictureError}";
    } else if ($pictureSize > 2000000) {
		$errors["articleImage"] = "Image bigger than recommended";
    } else {
		//If there are no errors begin the uploading of the file itself
		//First separate the extension from the filename and check if they are really pictures
		$pictureExtension = pathinfo($pictureFilename, PATHINFO_EXTENSION);
		$pictureExtension= strtolower($pictureExtension);
		$acceptedExtensions = ["jpg", "jpeg", "png", "gif"];

		if (in_array($pictureExtension, $acceptedExtensions)) {
			$pictureFilename = uniqid("IMG-", true).'.'.$pictureExtension; //Give it a new name, with the extension it had
			$uploadPath = 'images/'.$pictureFilename;
			move_uploaded_file($pictureTemporaryName, $uploadPath); //Move the file into the upload path
		}
	}

	//Checking if there is no errors at all
	foreach ($errors as $key => $value) {
		if ($value == '') {
			$uploadReady = true;
		} else {
			$uploadReady = false;
			echo "{$key} has an error value of {$value}";
			break;
		}
	}

//DATABASE UPLOAD
	if ($uploadReady) {
		// SQL query to add the data.
		$sql = "INSERT INTO boredtable(title, body, pitch, link, articleImage, buttonName) VALUES (:title, :body, :pitch, :link, :pictureFilename, :buttonName);";
		// Apply the SQL Command via a PDO (PHP Data Object)
		$stmt = $pdo->prepare($sql);
		// Adding the values to the prepared statement
		$stmt->execute(['title'=>$title, 'body'=>$body, 'pitch'=>$pitch, 'link'=>$link, 'pictureFilename'=>$pictureFilename, 'buttonName'=>$buttonName]);
	}
}

?>

<section class="container">
	<form class="" action="index.php" method="POST" enctype="multipart/form-data">

		<label>Title</label>
		<input type="text" name="title" value="">
		<div class="red-text"><?php echo $errors['title']; ?></div>

		<label>Description</label>
		<textarea name="body" rows="8" cols="80"></textarea>
		<div class="red-text"><?php echo $errors['body']; ?></div>

		<label>Sales Pitch</label>
		<textarea name="pitch" rows="8" cols="80"></textarea>
		<div class="red-text"><?php echo $errors['pitch']; ?></div>

		<label>Link</label>
		<input type="text" name="link" value="">
		<div class="red-text"><?php echo $errors['link']; ?></div>

		<label>Button Text</label>
		<input type="text" name="buttonName" value="">
		<div class="red-text"><?php echo $errors['buttonName']; ?></div>

		<!-- Image Upload -->
		<label>Image</label>
		<input type="file" name="articleImage">

		<input type="submit" name="submit" value="Submit" class="">
		<!-- Once this button is pressed, all the $uploadData['arrayKey'] turns into a POST request. Which is an associative array.-->
		<!-- So it can be accessed via $_POST[$key] with $key being as it was called in the 'name' tag of the input field in the form -->
		</div>
	</form>
</section>
