<?php

	// Assumes the input is a JSON file in the format of {"username":"", "password":""}
	
	$inData = getRequestInfo();
	
	$uName = $inData["username"];
	$pwd = $inData["password"];
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "NewUser";
	$dbPwd = "YES12345";
	$dbName = "contactManager";
	
	// Connect to database
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	if ($conn->connect_error){
		returnWithError($conn->connect_error);
	}
	else{
		$sql = "insert into Users (Username,Password) VALUES ('" . $Uname . "','" . $pwd . "')";
		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		$conn->close();
	}
	
	returnWithError("");

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
