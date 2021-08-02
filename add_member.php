<?php
include_once "header_layout.php";

//member details insert php start

   if($_POST){      
       try{
       
           // insert query
           $query = "INSERT INTO member_details SET first_name=:first_name, middle_name=:middle_name, surname=:surname, mobile_no=:mobile_no, created=:created";
           
           // prepare query for execution
           $stmt = $conn->prepare($query);
           
           $first_name=htmlspecialchars(strip_tags($_POST['first_name']));
           $middle_name=htmlspecialchars(strip_tags($_POST['middle_name']));
           $surname=htmlspecialchars(strip_tags($_POST['surname']));
           $mobile_no=htmlspecialchars(strip_tags($_POST['mobile_no']));
           $created=date('Y-m-d H:i:s'); // specify when this record was inserted to the database
           
           // bind the parameters
           $stmt->bindParam(':first_name', $first_name);
           $stmt->bindParam(':middle_name', $middle_name);
           $stmt->bindParam(':surname', $surname);
           $stmt->bindParam(':mobile_no', $mobile_no);
           $stmt->bindParam(':created', $created);
           
           // Execute the query
           if($stmt->execute()){
               echo "<div class='alert alert-success'>Record was saved.</div>";
           }else{
               echo "<div class='alert alert-danger'>Unable to save record.</div>";
           }           
       }
       
       // show error
       catch(PDOException $exception){
           die('ERROR: ' . $exception->getMessage());
       }
   } //member details insert php end 
?>  

<!-- container -->
 <div class="col-sm-9">
   
   <div class="page-header">
       <h1>Add Member Details</h1>
   </div>

<!-- member details html form start-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

<table class='table table-hover table-responsive table-bordered'>
   <tr>
       <td>First Name</td>
       <td><input type='text' name='first_name' class='form-control' required /></td>
   </tr>
   <tr>
       <td>Middle Name</td>
       <td><input type='text' name='middle_name' class='form-control' required  /></td>
   </tr>
   <tr>
       <td>Surname</td>
       <td><input type='text' name='surname' class='form-control' required  /></td>
   </tr>
   <tr>
       <td>Mobile Number</td>
       <td><input type='text' name='mobile_no' class='form-control' required  /></td>
   </tr>
   <tr>
       <td></td>
       <td>
           <input type='submit' value='Save' class='btn btn-primary' />
           <a href='member_details.php' class='btn btn-danger'>Back to members details</a>
       </td>
   </tr>
</table>
</form> <!-- member details html form end-->
     
</div> <!-- end .container -->

<?php
include_once "footer_layout.php"
?>