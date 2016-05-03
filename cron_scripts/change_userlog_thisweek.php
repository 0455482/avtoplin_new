<?php
	$conn = new mysqli('109.123.4.55', 'root', 'P0t3nc1a123!', 'avtoplin');

	$sql = "UPDATE user SET logged_this_week = 0";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		return 1;
	} else {
		return 0;
	}
?>