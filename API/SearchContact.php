<?php
	// Expects input in the form of {"search":"", "uID":""}
	// The results field in the output JSON is an array of strings formatted as "Contact ID, name, phone number, email, notes"
	
	$inData = getRequestInfo();
	
	$searchResults = "";
	$searchCount = 0;
	$searchName = trimAndSanitize($inData["search"]);
	$userID = trimAndSanitize($inData["uID"]);
	$error_occurred = false;
	
	// Server info for connection
	$servername = "localhost";
	$dbUName = "Group7User";
	$dbPwd = "Group7Pass";
	$dbName = "contactManager";
	$conn = new mysqli($servername, $dbUName, $dbPwd, $dbName);
	
	if ($conn->connect_error) 
	{
		$error_ocurred = true;
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$sql = "select * from CONTACTS where NAME like '%" . $searchName . "%' AND USER_ID = " . $userID;
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				if( $searchCount > 0 )
				{
					$searchResults .= ",";
				}
				$searchCount++;
				$searchResults .= '"' . $row["CONTACT_ID"] . ': ' . $row["NAME"] . ', ' . $row["PHONENUMBER"] . ', ' . $row["EMAIL"] . ', ' . $row["NOTES"] . '"';
			}
		}
		else
		{
			$error_occurred = true;
			returnWithError( "No Records Found" );
		}
		$conn->close();
	}
	
	if (!$error_occurred){
		returnWithInfo( $searchResults );
	}
	
	// Removes whitespace at the front and back, and removes single quotes and semi-colons
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
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"result":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"result":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
