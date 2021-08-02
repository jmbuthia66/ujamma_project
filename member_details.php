<?php
include_once "header_layout.php";

//container
echo "<div class='col-sm-9'>";
   
   echo "<div class='page-header'>";
       echo "<h1>Member Details</h1>";
    echo "</div>";

    //display member details insert php start 
    // PAGINATION VARIABLES
    // page is the current page, if there's nothing set, default is page 1
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // set records or rows of data per page
    $records_per_page = 5;
    
    // calculate for the query LIMIT clause
    $from_record_num = ($records_per_page * $page) - $records_per_page;
    
    // delete message prompt will be here
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    
    // if it was redirected from delete.php
    if($action=='deleted'){
        echo "<div class='alert alert-success'>Record was deleted.</div>";
    }
    
    // select data for current page
    $query = "SELECT member_id,first_name,middle_name,surname,mobile_no FROM member_details ORDER BY member_id ASC LIMIT :from_record_num, :records_per_page";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    
    // this is how to get number of rows returned
    $num = $stmt->rowCount();
    
    // link to create record form
    echo "<a href='add_member.php' class='btn btn-primary m-b-1em'>Add New Member</a>";
    echo "<br/>";
    echo "<div class='nav-search' id='nav-search'>";
    echo "<form class='form-search'>";
    echo "<span class='input-icon'>";
    echo "<input type='text' placeholder='Search ...' class='nav-search-input' id='nav-search-input' autocomplete='off' />";
    echo "<i class='ace-icon fa fa-search nav-search-icon'></i>";
    echo "</span>";
    echo "</form>";
    echo "</div>";
    echo "<br/>";
    echo "<br/>";

    //check if more than 0 record found
    if($num>0){
    
        // data from database will be here
        echo "<table class='table table-hover table-responsive table-bordered'>";
        //start table
        
            //creating our table heading
            echo "<tr>";
                echo "<th>Member ID</th>";
                echo "<th>First Name</th>";
                echo "<th>Middle Name</th>";
                echo "<th>Surname</th>";
                echo "<th>Mobile Number</th>";
                echo "<th>Action</th>";
            echo "</tr>";
            
            // table body will be here
            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['firstname'] to
                // just $firstname only
                extract($row);
                
                // creating new table row per record
                echo "<tr>";
                    echo "<td>{$member_id}</td>";
                    echo "<td>{$first_name}</td>";
                    echo "<td>{$middle_name}</td>";
                    echo "<td>{$surname}</td>";
                    echo "<td>{$mobile_no}</td>";
                    echo "<td>";
                        // read one record 
                        echo "<a href='member_details_read_one.php?member_id={$member_id}' class='btn btn-info m-r-1em'>Read</a>";
                        
                        // we will use this links on next part of this post
                        echo "<a href='member_details_update.php?member_id={$member_id}' class='btn btn-primary m-r-1em'>Edit</a>";
            
                        // we will use this links on next part of this post
                        echo "<a href='#' onclick='delete_user({$member_id});'  class='btn btn-danger'>Delete</a>";
                    echo "</td>";
                echo "</tr>";
            }
        
        // end table
        echo "</table>";

        // PAGINATION
        // count total number of rows
        $query = "SELECT COUNT(*) as total_rows FROM member_details";
        $stmt = $conn->prepare($query);
        
        // execute query
        $stmt->execute();
        
        // get total rows
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $row['total_rows'];

        // paginate records
        $page_url="member_details.php?";
        include_once "paging.php";
    }
    
    // if no records found
    else{
        echo "<div class='alert alert-danger'>No records found.</div>";
    } //display member details insert php end 

echo "</div>";

?>  

<script type='text/javascript'>
// confirm record deletion
function delete_user( member_id ){
     
    var answer = confirm('Are you sure you want to delete?');
    if (answer){
        // if user clicked ok, 
        // pass the id to delete.php and execute the delete query
        window.location = 'member_details_delete.php?member_id=' + member_id;
    } 
}
</script>

<?php
include_once "footer_layout.php"
?>