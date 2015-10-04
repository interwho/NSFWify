<?php
function watermark($image) {
	$overlay = 'logo.png';
	$opacity = "100";

	// Set offset from bottom-right corner
	$w_offset = 0;
	$h_offset = 100;
	$extension = strtolower(substr($image, strrpos($image, ".") + 1));

	// Load image from file
	switch ($extension)
	{
		case 'jpg':
		$background = imagecreatefromjpeg($image);
		break;
		case 'jpeg':
		$background = imagecreatefromjpeg($image);
		break;
		case 'png':
		$background = imagecreatefrompng($image);
		break;
		case 'gif':
		$background = imagecreatefromgif($image);
		break;
		default:
		die("Image is of unsupported type.");
	}

	// Find base image size
	$swidth = imagesx($background);
	$sheight = imagesy($background);

	// Turn on alpha blending
	imagealphablending($background, true);

	// Get the size of overlay
	$owidth = imagesx($overlay);
	$oheight = imagesy($overlay);

	// Create each image object
	$photo = imagecreatefromjpeg($image);
	$watermark = imagecreatefrompng($overlay);
	imagealphablending($photo, true);

        // Copy the watermark onto the master, $offset px from the bottom right corner.
	$offset = 10;
	imagecopy($photo, $watermark, imagesx($photo) - imagesx($watermark) - $offset, imagesy($photo) - imagesy($watermark) - $offset, 0, 0, imagesx($watermark), imagesy($watermark));
        
	// Output to the browser
	header("Content-Type: image/jpeg");
	imagejpeg($photo, $image);
	
	// Destroy the images
	imagedestroy($background);
	imagedestroy($overlay);
}

if ($_FILES['image']) {
	watermark($_FILES['image']['tmp_name']);
	die();
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>NSFWify | Instantly make any image NSFW</title>
</head>
<body>
	<form enctype="multipart/form-data" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		Choose a file to NSFWify: <input name="image" type="file" /><br>
		<input type="submit" value="NSFWify!" />
	</form>
</body>
</html>
