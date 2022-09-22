<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PHP CRUD Operations using PDO Extension </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>




<?php
// include database connection file
require_once 'dbconfig.php';
if (isset($_POST['insert'])) {
    // Posted Values
    $CardID = $_POST['CardID'];
    $Image = $_POST['Image'];
    $Model = $_POST['Model'];
    $Price = $_POST['Price'];
    $color = $_POST['color'];
    // Query for Insertion
    $sql = "INSERT INTO tblusers(CardID,`Image`,Model,Price,Color) VALUES(:id,:img,:mdl,:price,:clr)";
    //Prepare Query for Execution
    $query = $dbh->prepare($sql);
    // Bind the parameters
    $query->bindParam(':id', $CardID, PDO::PARAM_STR);
    $query->bindParam(':img', $Image, PDO::PARAM_STR);
    $query->bindParam(':mdl', $Model, PDO::PARAM_STR);
    $query->bindParam(':price', $Price, PDO::PARAM_STR);
    $query->bindParam(':clr', $color, PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    // Check that the insertion really worked. If the last inserted id is greater than zero, the insertion worked.
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        // Message for successfull insertion
        echo "<script>alert('Record inserted successfully');</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        // Message for unsuccessfull insertion
        echo "<script>alert('Something went wrong. Please try again');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}
?>













<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Insert Record | PHP CRUD Operations using PDO Extension</h3>
                <hr />
            </div>
        </div>
        <form name="insertrecord" method="post">
            <div class="row">
                <div class="col-md-4"><b>CardID</b>
                    <input type="text" name="CardID" class="form-control" required>
                </div>
                <div class="col-md-4"><b>Image</b>
                    <input type="text" name="Image" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Model</b>
                    <input type="text" name="Model" class="form-control" required>
                </div>
                <div class="col-md-4"><b>Price</b>
                    <input type="text" name="Price" class="form-control" maxlength="10" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>color</b>
                    <input class="form-control" name="color" required></input>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-md-8">
                    <input type="submit" name="insert" value="Submit">
                </div>
            </div>
        </form>
    </div>
    </div>


    <!-- Showing the cards -->


    <?php
    $sql = "SELECT CardID,`Image`,Model,Price,color,PostingDate from tblusers";
    //Prepare the query:
    $query = $dbh->prepare($sql);
    //Execute the query:
    $query->execute();
    //Assign the data which you pulled from the database (in the preceding step) to a variable.
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    // For serial number initialization
    $cnt = 1;
    if ($query->rowCount() > 0) {
    ?>
        <div class="d-flex justify-content-around mt-5 flex-wrap align-content-around">
            <?php
            //In case that the query returned at least one record, we can echo the records within a foreach loop:
            foreach ($results as $result) {
            ?>
                <!-- Display Records -->

                <div class="card w-25 m-5">
                    <img src="<?php echo ($result->Image); ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"> Model:<?php echo ($result->Model); ?></< /h5>
                            <h5 class="card-title">Card ID: <?php echo ($result->CardID); ?></< /h5>
                                <p class="card-text">Color : <?php echo ($result->color); ?></p>
                                <p class="card-text">Rent Price : <?php echo ($result->Price); ?>$</p>
                                <a href="index.php?del=<?php echo ($result->CardID); ?>"><button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><span class="glyphicon glyphicon-trash"></span></button></a>
                                <a href="update.php?cid=<?php echo ($result->CardID); ?>"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a>


                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><?php echo ($result->PostingDate); ?></small>
                    </div>

                </div>


        <?php
                // for serial number increment
                $cnt++;
            }
        } ?>
        </div>







</body>

</html>