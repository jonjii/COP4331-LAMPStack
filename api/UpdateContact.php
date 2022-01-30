<?php

        $inData = getRequestInfo();

        $cid = 0;

        $conn = new mysqli("localhost", "YayApi", "ILovePHP", "COP4331");

        if( $conn->connect_error )
        {
                returnWithError( 0, $conn->connect_error );
        }
        else
        {
            
                // Actually does the inserting for the contact!
                $stmt = $conn->prepare("UPDATE Contacts SET FirstName=? AND LastName=? AND Email=? AND Phone=? WHERE UID=? AND CID=?); 
                                        
                $stmt->bind_param("ssssii", $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"], 
                                    $inData["uid"], $inData["cid"]);
                $stmt->execute();
                $stmt->close();

                // If we have a different id after inserting, we successfully inserted!
                if( $prev_cid != $cid )
                {
                        returnWithInfo($cid, "Contact added successfully");
                }
                // something weird happened!
                else
                {
                        returnWithError(0, "Error while adding contact");
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