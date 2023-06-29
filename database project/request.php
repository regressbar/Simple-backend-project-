<?php

$host = "localhost";
$user = "root";
$password ="";
$database = "realtorfirm";

$id = "";
$RName = "";
$CName = "";
$Terms = "";
$Amount = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// connect to mysql database
try{
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Error';
}

// get values from the form
function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['id'];
    $posts[1] = $_POST['RName'];
    $posts[2] = $_POST['CName'];
    $posts[3] = $_POST['Terms'];
    $posts[4] = $_POST['Amount'];
    return $posts;
}

// Search

if(isset($_POST['search']))
{
    $data = getPosts();
    
    $search_Query = "SELECT * FROM request WHERE IDrequest = $data[0]";
    
    $search_Result = mysqli_query($connect, $search_Query);
    
    if($search_Result)
    {
        if(mysqli_num_rows($search_Result))
        {
            while($row = mysqli_fetch_array($search_Result))
            {
                $id = $row['IDrequest'];
                $RName = $row['RName'];
                $CName = $row['CName'];
                $Terms = $row['Terms'];
                $Amount = $row['Amount of rooms'];
            }
        }else{
            echo 'No Data For This Id';
        }
    }else{
        echo 'Result Error';
    }
}


// Insert
if(isset($_POST['insert']))
{
    $data = getPosts();
    $insert_Query = "INSERT INTO `request` (`RName`, `CName`, `Terms`, `Amount of rooms`) VALUES ('$data[1]','$data[2]', '$data[3]', '$data[4]')";
    try{
        $insert_Result = mysqli_query($connect, $insert_Query);
        
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Inserted';
            }else{
                echo 'Data Not Inserted';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Insert '.$ex->getMessage();
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    $delete_Query = "DELETE FROM `request` WHERE `IDrequest` = $data[0]";
    try{
        $delete_Result = mysqli_query($connect, $delete_Query);
        
        if($delete_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Deleted';
            }else{
                echo 'Data Not Deleted';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Delete '.$ex->getMessage();
    }
}

// Edit
if(isset($_POST['update']))
{
    $data = getPosts();
    $update_Query = "UPDATE `request` SET `RName`='$data[1]',`CName`='$data[2]',`Terms`= '$data[3]',`Amount of rooms`= '$data[4]', WHERE `IDrequest` = $data[0]";
    try{
        $update_Result = mysqli_query($connect, $update_Query);
        
        if($update_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Updated';
            }else{
                echo 'Data Not Updated';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update '.$ex->getMessage();
    }
}



?>


<!DOCTYPE html>
<html>
    <head>
        <title>PHP INSERT UPDATE DELETE SEARCH</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form class="decor" action="request.php" method="post">
        <div class="form-left-decoration"></div>
        <div class="form-right-decoration"></div>
        <div class="circle"></div>
        <div class="form-inner">

            <input type="number" name="id" placeholder="ID" value="<?php echo $id;?>"><br><br>
            <input type="text" name="RName" placeholder="RName" value="<?php echo $RName;?>"><br><br>
            <input type="text" name="CName" placeholder="CName" value="<?php echo $CName;?>"><br><br>
            <input type="text" name="Terms" placeholder="Terms" value="<?php echo $Terms;?>"><br><br>
            <input type="number" name="Amount" placeholder="Amount" value="<?php echo $Amount;?>"><br><br>
            
                <!-- Input For Add Values To Database-->
                <input type="submit" name="insert" value="Add">
                
                
                <!-- Input For Clear Values -->
                <input type="submit" name="delete" value="Delete">
                
            </div>
        </form>
    </body>
</html>
