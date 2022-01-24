
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
	$stmt1 = $conn->prepare("SELECT ID, FROM Users WHERE Login=? AND Password =?");
	$stmt1->bind_param("ss", $inData["login"], $inData["password"]);
	$stmt1->execute();
	$result = $stmt1->get_result();
	
	$stmt1->close();

	if( $row = $result->fetch_assoc()  )
	{
		returnWithInfo($uid, "User already exists!");

	}
	else
	{
		$stmt2 = $conn->prepare("INSERT INTO `Users` (`FirstName`, `LastName`, `Login`, `Password`)
							VALUES (?, ?, ?, ?, ?, ?)");
		$stmt2->bind_param("ssss", $inData["firstName"], $inData["lastName"], $inData["login"], $inData["password"]);
		$stmt2->execute();

		
		$stmt2->close();

		$stmt3 = $conn->prepare("SELECT ID, FROM Users WHERE Login=? AND Password =?");
		$stmt3->bind_param("ss", $inData["login"], $inData["password"]);
		$stmt3->execute();

		$newID = $stmt3->get_result();

		
		$stmt3->close();

		if( $row2 = $newID->fetch_assoc()  )
		{
			returnWithInfo($uid, "User added successfully");
		}
		else
		{
			returnWithInfo($uid, "Error while adding user");
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

?>
