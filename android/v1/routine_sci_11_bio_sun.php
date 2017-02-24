<?php

	$con = mysqli_connect("localhost", "root", "") or die("Could not connect: " . mysqli_error());

	$db_select = mysqli_select_db($con ,"android");

	$result = mysqli_query($con, "SELECT * FROM routine_sci_11_bio_sun");

	$response = array();

	while ($array = mysqli_fetch_array($result)) {		
		$response[] = $array;
	}

	echo json_encode($response);

?>