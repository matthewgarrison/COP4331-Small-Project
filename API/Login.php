<?php
	// Assumes the input is a JSON file in the format of {"username":"", "password":""}
	
	$inData = getRequestInfo();
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "Group7User";
	$dbPwd = "Group7Pass";
	$dbName = "contactManager";
	
	$id = 0;
	$username = trimAndSanitize($inData["username"]);
	$password = trimAndSanitize($inData["password"]);
	
	$error_occurred = false;
	
	// Connect to database
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	if ($conn->connect_error){
		$error_occurred = true;
		returnWithError($conn->connect_error);
	}
	else{
		$sql = "SELECT USER_ID FROM USERS where USERNAME = '" . $username . "' AND PASSWORD = '" . $password . "'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$id = $row["USER_ID"];
		}
		else{
			$error_occurred = true;
			returnWithError( "No Records Found" );
		}
		$conn->close();
	}
	
	if (!$error_occurred){
		returnWithInfo($username, $id);
	}
	
	// Removes whitespace at the front and back, and removes single quotes and semi-colons
	function trimAndSanitize($str){
		$str = trim($str);
		$str = str_replace("'", "", $str );
		$str = str_replace(";", "", $str);
		return $str;
	}
	
	// Parse JSON file input
	function getRequestInfo(){
		return json_decode(file_get_contents('php://input'), true);
	}
	
	// Send the user's username and ID as JSON
	function sendAsJSON($obj){
		header('Content-type: application/json');
		echo $obj;
	}
	
	// Return in the case of an error
	function returnWithError( $err )
	{
		$retValue = '{"id":0,"username":"","error":"' . $err . '"}';
		sendAsJson( $retValue );
	}
	
	// Return and send the username and id
	function returnWithInfo( $username, $id )
	{
		$retValue = '{"id":' . $id . ',"username":"' . $username . '","error":""}';
		sendAsJson( $retValue );
	}
?>
