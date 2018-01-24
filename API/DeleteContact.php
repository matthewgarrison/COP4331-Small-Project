<?php
	// Assumes the input is JSON in the format of {"userID":"", "contactID":""}
	
	$inData = getRequestInfo();
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "Group7User";
	$dbPwd = "Group7Pass";
	$dbName = "contactManager";
	
	$userID = trimAndSanitize($inData["userID"]);
	$contactID = trimAndSanitize($inData["contactID"]);
	
	$error_occurred = false;
	
	// Connect to database
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	if ($conn->connect_error){
		$error_occurred = true;
		returnWithError($conn->connect_error);
	}
	else{
		$sql = "select NAME from CONTACTS where USER_ID = " . $userID . " and CONTACT_ID = " . $contactID;
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			$error_occurred = true;
			returnWithError("No contact found");
		}
		else{
		$sql = "delete from CONTACTS where USER_ID = " . $userID . " and CONTACT_ID = " . $contactID;
			if( $result = $conn->query($sql) != TRUE ){
				$error_occurred = true;
				returnWithError( $conn->error );
			}
		}
		$conn->close();
	}
	
	if (!$error_occurred){
		returnWithError("");
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
	
	function sendAsJSON($obj){
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendAsJson( $retValue );
	}
	
?>