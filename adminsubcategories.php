
<?php
session_start();


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <title>Subcategory</title>
    <style>
        body {
            overflow-x: hidden; 
            overflow-y: auto; 
        }
        h2{
            text-align:center;
            margin-top:50px;
        }
        table {     
            width: 100%;
            border-collapse: collapse;
            width:900px;
            margin-left:auto;
            margin-right:auto;
            border-radius:25px;
            overflow:hidden;
            border: 2px solid #dddddd;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);


        }
        table img{
            width:200px;
        height:200px;
        border-radius:6px;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
       
        th {
            background-color: #f2f2f2;
            
        }
        .col{
            float:left;
  
        }
        .confirm-dialog {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .confirm-box {
            background-color: white;
            border-radius: 5px;
            width: 300px;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .confirm-buttons {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include 'adminnavbar.php'; ?> 
    <h2>SubCategory</h2>
   
    <div class="col">
      
         
                <a href="addsubcategory.php"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSlideModal">Add Product</button></a>
            </div>
            <br>
            <br>

   
    <table  id="myTable">
   

        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th> Name</th>
                <th>Price</th>
                <th>Edit</th>
                <th>Delete</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            
            include 'connection.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM special";
$result = $conn->query($sql);
$serialnumber =1;
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$serialnumber."</td>";
                echo "<td><img src='".$row["img"]."' alt='Item Image'></td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["price"]."</td>";
                echo "<td><a href='editsubcategory.php?id=".$row["id"]."'><button type='button' class='btn btn-primary'>Edit</button></a></td>"; 

                echo "<td><button type='button' class='btn btn-danger' onclick='askconfirm(".$row["id"].")'>Delete</button></td>"; 
                echo "</tr>";
                $serialnumber++;
            }
            ?>
        </tbody>
    </table>
    <div class="confirm-dialog" id="confirmDialog">
        <div class="confirm-box">
            <p>Are you sure you want to delete this slide?</p>
            <div class="confirm-buttons">
                <button type="button" class="btn btn-success" onclick="confirmDelete()">Yes</button>
                <button type="button" class="btn btn-danger" onclick="hideConfirmDialog()">No</button>
            </div>
        </div>
    </div>




    <script>
        var deleteid;
        function askconfirm(id){
        deleteid =id;
        document.getElementById('confirmDialog').style.display='block';
        }


        function hideConfirmDialog(){
            document.getElementById('confirmDialog').style.display='none';

        }

        function confirmDelete(){
            window.location.href ="deletesubcategory.php?id=" + deleteid;
        }

   
    </script>


    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
   
<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
</body>
</html>
