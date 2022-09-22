<?php
// Get the cardid
require_once 'dbconfig.php';
$CardID = ($_REQUEST['cid']);
$sql = "SELECT CardID,`Image`,Model,Price,Color,PostingDate from tblusers where CardID=:Cid";
//Prepare the query:
$query = $dbh->prepare($sql);
//Bind the parameters
$query->bindParam(':Cid', $CardID, PDO::PARAM_STR);
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
                    <input type="text" name="CardID" value="<?php echo ($result->CardID); ?>" class="form-control" required>
                </div>
                <div class="col-md-4"><b>Image</b>
                    <input type="text" name="Image" value="<?php echo ($result->Image); ?>" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Model</b>
                    <input type="text" name="Model" value="<?php echo ($result->Model); ?>" class="form-control" required>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4"><b>Price</b>
                    <input type="text" name="Price" value="<?php echo ($result->Price); ?>" class="form-control" maxlength="10" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"><b>color</b>
                    <input type="text" name="color" value="<?php echo ($result->Color); ?>" class="form-control" maxlength="10" required>
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
                    // Posted Values
            $CardID = $_POST['CardID'];
            $Image = $_POST['Image'];
            $Model = $_POST['Model'];
            $Price = $_POST['Price'];
            $color = $_POST['color'];
            // Query for Updation
            $sql = "update tblusers set CardId=:Cid,Image=:img,Model=:mdl,Price=:prc,Color=:clr where CardID=:Cid";
            //Prepare Query for Execution
            $query = $dbh->prepare($sql);
            // Bind the parameters
            $query->bindParam(':Cid', $CardID, PDO::PARAM_STR);
            $query->bindParam(':img', $Image, PDO::PARAM_STR);
            $query->bindParam(':mdl', $Model, PDO::PARAM_STR);
            $query->bindParam(':prc', $Price, PDO::PARAM_STR);
            $query->bindParam(':clr', $color, PDO::PARAM_STR);
            // Query Execution
            $query->execute();
            // Mesage after updation
            echo "<script>alert('Record Updated successfully');</script>";
            // Code for redirection
            echo "<script>window.location.href='index.php'</script>";
        }
        ?>