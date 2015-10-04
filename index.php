<?php
function watermark($image, $extension) {
	$overlay = imagecreatefrompng('logo.png');
	$opacity = "100";

	// Set offset from bottom-right corner
	$w_offset = 0;
	$h_offset = 100;

	// Load image from file
	switch ($extension)
	{
		case 'image/jpeg':
			$background = imagecreatefromjpeg($image);
			break;
		case 'image/png':
			$background = imagecreatefrompng($image);
			break;
		case 'image/gif':
			$background = imagecreatefromgif($image);
			break;
		default:
			die("Only JPG, PNG, and GIF files can be made NSFW.");
	}

	// Find base image size
	$bwidth = imagesx($background);
	$bheight = imagesy($background);

	// Turn on alpha blending
	imagealphablending($background, true);

	// Get the size of overlay
	$owidth = imagesx($overlay);
	$oheight = imagesy($overlay);

        // Copy the overlay onto the background, $offset px from the bottom right corner.
	$offset = 10;
	imagecopy($background, $overlay, $bwidth - $owidth - $offset, $bheight - $oheight - $offset, 0, 0, $owidth, $oheight);
        
	// Output to the browser
	header("Content-Type: image/jpeg");
	imagejpeg($background);
	
	// Destroy the images
	imagedestroy($background);
	imagedestroy($overlay);
}

if (!empty($_FILES['image'])) {
	watermark($_FILES['image']['tmp_name'], $_FILES['image']['type']);
	die();
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>NSFWify | Instantly make any image NSFW</title>
</head>
<body>
	<form action="index.php" enctype="multipart/form-data" method="POST">
		Choose a file to NSFWify: <input name="image" type="file" size="25" /><br>
		<input type="submit" name="submit" value="NSFWify!" />
	</form>
</body>
</html>
