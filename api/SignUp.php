
<?php

	$inData = getRequestInfo();
	
	$uid = 0;

	$conn = new mysqli("localhost", "root", "group28POOS", "COP4331");	
	if( $conn->connect_error )
	{
		returnWithInfo( 0, $conn->connect_error );
	}
	else
	{
		// This may break! (woah)
		// The password may be a keyword!
		$stmt = $conn->prepare("INSERT INTO table (Users) 
								OUTPUT Inserted.ID 
								VALUES ('login', 'password', 'firstName', 'lastName', 'date_created', 'date_last_updated')");
		$stmt->bind_param("ssssss", $inData["login"], $inData["password"], $inData["firstName"], $inData["lastName"], $inData["date_created"], $inData["date_last_updated"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc() )
		{
			returnWithInfo($row['ID'], "User already exists!");
		}
		else
		{
			returnWithInfo($row['ID'], "User successfully added");
		}

		$stmt->close();
		$conn->close();
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
	
	function returnWithInfo( $uid, $msg )
	{
		$retValue = '{"id":' . $uid . ',"message":"' . $msg . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
