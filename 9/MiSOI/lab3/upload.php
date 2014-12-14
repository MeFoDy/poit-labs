<?php
session_start();
ini_set('display_errors', 'on');

################# VARIABLES ##############
$thumb_square_size = 200;

$max_image_size = 300;

$thumb_prefix = "thumb_";

$destination_folder = dirname(__FILE__) . '/images/';

$jpeg_quality = 100;

##########################################

if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	if (!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])) {
		die('File not uploaded!');
	}

	$image_name = $_FILES['image_file']['name'];
	$image_size = $_FILES['image_file']['size'];
	$image_temp = $_FILES['image_file']['tmp_name'];

	$image_size_info = getimagesize($image_temp);

	if ($image_size_info) {
		$image_width = $image_size_info[0];
		$image_height = $image_size_info[1];
		$image_type = $image_size_info['mime'];
	} else {
		die("Invalid file type!");
	}

	switch ($image_type) {
		case 'image/png':
			$image_res = imagecreatefrompng($image_temp);break;
		case 'image/gif':
			$image_res = imagecreatefromgif($image_temp);break;

		case 'image/jpeg':case 'image/pjpeg':
			$image_res = imagecreatefromjpeg($image_temp);break;
		default:
			$image_res = false;
	}

	if ($image_res) {
		$image_info = pathinfo($image_name);
		$image_extension = strtolower($image_info["extension"]);
		$image_name_only = strtolower($image_info["filename"]);

		$new_file_name = $image_name_only . '_' . rand(0, 9999999999) . '.' . $image_extension;

		$thumb_save_folder = $destination_folder . $thumb_prefix . $new_file_name;

		$image_save_folder = $destination_folder . $new_file_name;

		if (normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality)) {
			if (!crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality)) {
				die('Error Creating thumbnail');
			}
			setcookie("image", $image_save_folder);
			setcookie("thumb", $thumb_save_folder);

			echo '<div align="center">';
			echo '<img src="images/' . $new_file_name . '" alt="Resized Image" width="500">';
			echo '</div>';
		} else {
			echo '<p class="alert alert-danger">Error</p>';
		}

		imagedestroy($image_res);
	}
}

function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality) {

	if ($image_width <= 0 || $image_height <= 0) {return false;}

	if ($image_width <= $max_size && $image_height <= $max_size) {
		if (save_image($source, $destination, $image_type, $quality)) {
			return true;
		}
	}

	$image_scale = min($max_size / $image_width, $max_size / $image_height);
	$new_width = ceil($image_scale * $image_width);
	$new_height = ceil($image_scale * $image_height);

	$new_canvas = imagecreatetruecolor($new_width, $new_height);

	if (imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)) {
		return save_image($new_canvas, $destination, $image_type, $quality);

	}

	return false;
}

function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality) {
	if ($image_width <= 0 || $image_height <= 0) {return false;}

	if ($image_width > $image_height) {
		$y_offset = 0;
		$x_offset = ($image_width - $image_height) / 2;
		$s_size = $image_width-($x_offset * 2);
	} else {
		$x_offset = 0;
		$y_offset = ($image_height - $image_width) / 2;
		$s_size = $image_height-($y_offset * 2);
	}
	$new_canvas = imagecreatetruecolor($square_size, $square_size);

	if (imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)) {
		return save_image($new_canvas, $destination, $image_type, $quality);
	}

	return false;
}

function save_image($source, $destination, $image_type, $quality) {
	switch (strtolower($image_type)) {
		case 'image/png':

			return imagepng($source, $destination);
			break;
		case 'image/gif':

			return imagegif($source, $destination);
			break;

		case 'image/jpeg':case 'image/pjpeg':

			return imagejpeg($source, $destination, $quality);
			break;
		default:return false;
	}
}
