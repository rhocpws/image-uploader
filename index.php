<html>
<head>
<?php
$author = getenv('AUTHOR');
$storage_type = getenv('STORAGE_TYPE');

echo "<title>Boingo Image Library Demo Application by " . $author . "</title>";

?>
<link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One|Slabo+13px" rel="stylesheet">
<style>
body {
    background-color: #ffffff;
    font-family: arial;
	margin: 0px;
	height: 100%;
}

#body-wrapper {
    background-color: white;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 40px;
    border-radius: 5px;
    padding: 25px;
    padding-bottom: 200px;
}
	
#navbar {
	background: rgba(0,0,0,.75);
	height: 82px;
	margin-top: -25px;
	}
	
#footer {
	background: rgba(0,0,0,.75);
	height: 7px;
	margin-top: 25px;
	padding: 25px;
	position: absolute;
	bottom: 0px;
	font-size: 10px;
	color: #ffffff;
	}
	
#logo {
	width: 149px;
    border-right: white;
    border-right-style: solid;
    border-right-width: 1px;
    display: -webkit-box;
    margin: 25;
	}

h1 {
    font-family: 'Alfa Slab One', cursive;
	margin: 0px;
	color: rgba(0,0,0,.75);
}
	
h2 {
    font-family: 'Alfa Slab One', cursive;
	margin: 0px;
	color: rgba(0,0,0,.75);
}
	
h3 {
    font-family: 'Alfa Slab One', cursive;
	margin: 0px;
	color: rgba(0,0,0,.75);
}
img {
    padding: 10px;
}
.wrapper {
    border-radius: 5px;
    border: 1px solid lightgray;
    padding: 25px;
    width: 40%;
    margin: 20px;
}
#upload-form {
    background-color: #f2f2f2;
}

#results-box {
    width: 40%;
    color: red;
    font-color: #fff;
    font-weight: bold;
}

</style>
</head>
<body>
	<div id="navbar">
		<div id="logo">
			<a href="http://www.boingo.com" target="_blank"><img src="images/copy-cropped-icons1.png"/></a>
		</div>
	
	
	</div>
<div id="body-wrapper">
<?php 
echo "
<h1>Image Library with " . $storage_type . " storage backend.</h1>
"
?>
<div class="wrapper" id="upload-form">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <p><input type="file" name="fileToUpload" id="fileToUpload"></p>
    <p><input type="submit" value="Upload Image" name="submit"></p>
</form>
</div>
<?php
$target_dir = "uploads/";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$target_file = $target_dir . strtolower(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
echo "<div class='wrapper' id='results-box'>";
if(isset($_POST["submit"])) {
    echo "<h3>Image Scan Results:</h3>";
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "<p>File is an image - " . $check["mime"] . ".</p>";
        $uploadOk = 1;
    } else {
        echo "<p>File is not an image.</p>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<p>Sorry, file already exists.</p>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<p>Sorry, your file is too large.</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
    $uploadOk = 0;
}
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<p>". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
    }
}
echo "</div>";
}
echo "<h3>Uploaded Files</h3>";
$files = array_diff(scandir($target_dir), array('.', '..','uploads','.trashcan'));
foreach ($files as $f) {
  echo "<a href='uploads/$f' target='blank'><img src='uploads/$f' width='40%' /></a>";
}
?>
</div>
	<div id="footer">
	© 2018 Boingo Wireless, Inc. All rights reserved. Boingo, Boingo Wireless, Boingo Wi-Finder and the Boingo Wireless Logo are registered trademarks of Boingo Wireless, Inc. Trademarks included are the property of their respective companies. Privacy Policy | Terms of Use | Service Provision Conditions | Condições de Oferta des Serviçios
	</div>
</body>
</html>
