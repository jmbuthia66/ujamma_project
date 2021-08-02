<?php
include_once "header_layout.php";

  // PHP read record by ID will be here -->
      // get passed parameter value, in this case, the record ID
      // isset() is a PHP function used to verify if a value is there or not
      $member_id=isset($_GET['member_id']) ? $_GET['member_id'] : die('ERROR: Record Member ID not found.');
      
      // read current record's data
      try {
          // prepare select query
          $query = "SELECT member_id,first_name,middle_name,surname,mobile_no FROM member_details WHERE member_id = ?";
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

  <!-- HTML form to update record will be here -->
  <!-- PHP post to update record will be here -->
  <?php

      // check if form was submitted
      if($_POST){
          
          try{
          
              // write update query
              // in this case, it seemed like we have so many fields to pass and 
              // it is better to label them and not use question marks
              $query = "UPDATE member_details SET first_name=:first_name, middle_name=:middle_name, surname=:surname, mobile_no=:mobile_no WHERE member_id = :member_id";
      
              // prepare query for excecution
              $stmt = $conn->prepare($query);
      
              // posted values
                $first_name=htmlspecialchars(strip_tags($_POST['first_name']));
                $middle_name=htmlspecialchars(strip_tags($_POST['middle_name']));
                $surname=htmlspecialchars(strip_tags($_POST['surname']));
                $mobile_no=htmlspecialchars(strip_tags($_POST['mobile_no']));
        
              // bind the parameters
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':middle_name', $middle_name);
                $stmt->bindParam(':surname', $surname);
                $stmt->bindParam(':mobile_no', $mobile_no);
                $stmt->bindParam(':member_id', $member_id);
              
              // Execute the query
              if($stmt->execute()){
                  echo "<div class='alert alert-success'>Record was updated.</div>";
              }else{
                  echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
              }
              
          }
          
          // show errors
          catch(PDOException $exception){
              die('ERROR: ' . $exception->getMessage());
          }
      }
  ?>

<!-- container -->
<div class="col-sm-9">
  
  <div class="page-header">
      <h1>Update Member Detail</h1>
  </div>
  <!--we have our html form here where new record information can be updated-->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?member_id={$member_id}");?>" method="post">
      <table class='table table-hover table-responsive table-bordered'>
          <tr>
              <td>First Name</td>
              <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' required  /></td>
          </tr>
          <tr>
              <td>Middle Name</td>
              <td><input type='text' name='middle_name' value="<?php echo htmlspecialchars($middle_name, ENT_QUOTES);  ?>" class='form-control' required  /></td>
          </tr>
          <tr>
              <td>Surname</td>
              <td><input type='text' name='surname' value="<?php echo htmlspecialchars($surname, ENT_QUOTES);  ?>" class='form-control' required  /></td>
          </tr>
          <tr>
              <td>Mobile Number</td>
              <td><input type='text' name='mobile_no' value="<?php echo htmlspecialchars($mobile_no, ENT_QUOTES);  ?>" class='form-control' required  /></td>
          </tr>
          <tr>
              <td></td>
              <td>
                  <input type='submit' value='Save Changes' class='btn btn-primary' />
                  <a href='member_details.php' class='btn btn-danger'>Back to read products</a>
              </td>
          </tr>
      </table>
  </form>
   
</div> <!-- end .container -->

<?php
include_once "footer_layout.php"
?>