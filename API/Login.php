<?php

	// Assumes the input is a JSON file in the format of {"username":"", "password":""}
	
	$inData = getRequestInfo();
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "NewUser";
	$dbPwd = "YESYES";
	$dbName = "contactManager";
	
	$id = 0;
	$username = $inData["login"];
	
	// Connect to database
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	if ($conn->connect_error){
		returnWithError($conn->connect_error);
	}
	else{
		$sql = "SELECT User ID FROM Users where Username = '" . $inData["login"] . "' AND Password = '" . $inData["password"] . "'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$id = $row["ID"];
		}
		else{
			returnWithError( "No Records Found" );
		}
		$conn->close();
	}
	
	returnWithInfo($username, $id);

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
		$retValue = '{"id":0,"firstName":"","error":"' . $err . '"}';
		sendAsJson( $retValue );
	}
	
	// Return and send the username and id
	function returnWithInfo( $username, $id )
	{
		$retValue = '{"id":' . $id . ',"username":"' . $username . '","error":""}';
		sendAsJson( $retValue );
	}
?>
