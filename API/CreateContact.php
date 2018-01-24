<?php

	// Assumes the input is a JSON file in the format of {"uID":"", "name":"", "phoneNumber":"", "email":"", "notes":""}
	
	$inData = getRequestInfo();
	
	$userID = trimAndSanitize($inData["uID"]);
	$name = trimAndSanitize($inData["name"]);
	$phoneNumber = trimAndSanitize($inData["phoneNumber"]);
	$email = trimAndSanitize($inData["email"]);
	$notes = trimAndSanitize($inData["notes"]);
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "Group7User";
	$dbPwd = "Group7Pass";
	$dbName = "contactManager";
	
	$error_occurred = false;
	
	// Connect to database
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	if ($conn->connect_error){
		$error_occured = true;
		returnWithError($conn->connect_error);
	}
	else{
		$sql = "insert into CONTACTS (USER_ID, NAME, PHONENUMBER, EMAIL, NOTES) VALUES ('" . $userID . "', '" . $name . "','" . $phoneNumber . "','" . $email . "','" . $notes . "')'";
		if( $result = $conn->query($sql) != TRUE )
		{
			$error_occurred = true;
			returnWithError( $conn->error );
		}
		$conn->close();
	}
	
	if (!$error_occurred){
		returnWithError("");
	}
	
	// Removes whitespice at the front and back, and removes single quotes and semi-colons
	function trimAndSanitize($str){
		$str = trim($str);
		$str = str_replace("'", "", $str );
		$str = str_replace(";", "", $str);
		return $str;
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendAsJson( $retValue );
	}
?>