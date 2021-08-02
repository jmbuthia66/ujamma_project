<?php
// include database connection
include_once 'dbconnect.php';
 
try {
     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $member_id=isset($_GET['member_id']) ? $_GET['member_id'] : die('ERROR: Record Member ID not found.');
 
    // delete query
    $query = "DELETE FROM member_details WHERE member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $member_id);
     
    if($stmt->execute()){
        // redirect to read records page and 
        // tell the user record was deleted
        header('Location: member_details.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>