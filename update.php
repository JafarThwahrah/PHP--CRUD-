<?php
// Get the userid
require_once 'dbconfig.php';
$userid = intval($_GET['id']);
$sql = "SELECT CardID,`Image`,Model,Price,Color,PostingDate from tblusers where CardID=:uid";
//Prepare the query:
$query = $dbh->prepare($sql);
//Bind the parameters
$query->bindParam(':uid', $userid, PDO::PARAM_STR);
//Execute the query:
$query->execute();
//Assign the data which you pulled from the database (in the preceding step) to a variable.
$results = $query->fetchAll(PDO::FETCH_OBJ);
// For serial number initialization
$cnt = 1;
if ($query->rowCount() > 0) {
    //In case that the query returned at least one record, we can echo the records within a foreach loop:
    foreach ($results as $result) {
?>
        <form name="insertrecord" method="post">
            <div class="row">
                <div class="col-md-4"><b>CardID</b>
                    <input type="text" name="firstname" value="<?php echo htmlentities($result->CardID); ?>" class="form-control" required>
                </div>
                <div class="col-md-4"><b>Image</b>
                    <input type="text" name="lastname" value="<?php echo htmlentities($result->Image); ?>" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Model</b>
                    <input type="text" name="emailid" value="<?php echo htmlentities($result->Model); ?>" class="form-control" required>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4"><b>Price</b>
                    <input type="text" name="contactno" value="<?php echo htmlentities($result->Price); ?>" class="form-control" maxlength="10" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"><b>color</b>
                    <input type="text" name="address" value="<?php echo htmlentities($result->Color); ?>" class="form-control" maxlength="10" required>
                </div>
            </div>
    <?php }
} ?>
    <div class="row" style="margin-top:1%">
        <div class="col-md-8">
            <input type="submit" name="update" value="Update">
        </div>
    </div>
        </form>


        <?php
        // include database connection file
        require_once 'dbconfig.php';
        if (isset($_POST['update'])) {
            // Get the userid
            $userid = intval($_GET['id']);
            // Posted Values
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $emailid = $_POST['emailid'];
            $contactno = $_POST['contactno'];
            $address = $_POST['address'];
            // Query for Updation
            $sql = "update tblusers set CardId=:fn,Image=:ln,Model=:eml,Price=:cno,Color=:adrss where CardID=:uid";
            //Prepare Query for Execution
            $query = $dbh->prepare($sql);
            // Bind the parameters
            $query->bindParam(':fn', $fname, PDO::PARAM_STR);
            $query->bindParam(':ln', $lname, PDO::PARAM_STR);
            $query->bindParam(':eml', $emailid, PDO::PARAM_STR);
            $query->bindParam(':cno', $contactno, PDO::PARAM_STR);
            $query->bindParam(':adrss', $address, PDO::PARAM_STR);
            $query->bindParam(':uid', $userid, PDO::PARAM_STR);
            // Query Execution
            $query->execute();
            // Mesage after updation
            echo "<script>alert('Record Updated successfully');</script>";
            // Code for redirection
            echo "<script>window.location.href='index.php'</script>";
        }
        ?>