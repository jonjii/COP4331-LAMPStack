
<?php

$inData = getRequestInfo();

$uid = 0;

$conn = new mysqli("localhost", "YayApi", "ILovePHP", "COP4331");	

if( $conn->connect_error )
{
	returnWithInfo($uid, $conn->connect_error );
}
else
{
	// Login to see if the user exists
	$stmt1 = $conn->prepare("SELECT ID FROM Users WHERE Login=? AND Password =?");
	$stmt1->bind_param("ss", $inData["login"], $inData["password"]);
	$stmt1->execute();
	$result = $stmt1->get_result();
	
	$stmt1->close();

	// Checks if we have an associative array, meaning a user exists
	if( $row = $result->fetch_assoc()  )
	{
		returnWithError($uid, "User already exists!");
	}
	else
	{
		// Actually does the inserting for the user!
		$prev_uid = $conn->insert_id;
		$stmt2 = $conn->prepare("INSERT INTO `Users` (`FirstName`, `LastName`, `Login`, `Password`)
								VALUES (?, ?, ?, ?)");
		$stmt2->bind_param("ssss", $inData["firstName"], $inData["lastName"], $inData["login"], $inData["password"]);
		$stmt2->execute();
		$stmt2->close();

		// returns the last inserted id
		$uid = $conn->insert_id;
		 
		// If we have a different id after inserting, we successfully inserted!
		if( $prev_uid != $uid )
		{
			returnWithInfo($uid, "User added successfully");
		}
		// cringe
		else
		{
			returnWithError(0, "Error while adding user");
		}	
	}

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

function returnWithError( $uid, $err)
{
	$retValue = '{"id":' . $uid . ',"error":"' . $err . '"}';
	sendResultInfoAsJson( $retValue );
}
?>
