<?php
include_once "header_layout.php";
         
        //PHP read one record will be here 
       
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $member_id=isset($_GET['member_id']) ? $_GET['member_id'] : die('ERROR: Record Member ID not found.');
            
            // read current record's data
            try {
                // prepare select query
                $query = "SELECT member_id,first_name,middle_name,surname,mobile_no FROM member_details WHERE member_id = ? LIMIT 0,1";
                $stmt = $conn->prepare( $query );
            
                // this is the first question mark
                $stmt->bindParam(1, $member_id);
            
                // execute our query
                $stmt->execute();
            
                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
                // values to fill up our form
                $first_name = $row['first_name'];
                $middle_name = $row['middle_name'];
                $surname = $row['surname'];
                $mobile_no = $row['mobile_no'];
            }
            
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
?>

<!-- container -->
<div class="col-sm-9">

    <div class="page-header">
    <h1>Member Detail</h1>
    </div>
        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>First Name</td>
                <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Middle Name</td>
                <td><?php echo htmlspecialchars($middle_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Surname</td>
                <td><?php echo htmlspecialchars($surname, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Mobile Number</td>
                <td><?php echo htmlspecialchars($mobile_no, ENT_QUOTES);  ?></td>
            </tr>
            <tr> 
                <td colspan="2">
                    <a href='member_details.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>
 
</div> <!-- end .container -->

<?php
include_once "footer_layout.php";
?>