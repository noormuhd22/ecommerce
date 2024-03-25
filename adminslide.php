
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
    <title>Items Table</title>
    <style>

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
        td img{
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
    <h2>Slide</h2>
   
    <div class="col">
      
                <!-- Button to add a new slide -->
                <a href="addslide.php"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSlideModal">Add Slide</button></a>
            </div>

   
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the PHP file to fetch data from the database
            include 'connection.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT id, img FROM slides";
$result = $conn->query($sql);
$serialnumber =1;
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$serialnumber."</td>";
                echo "<td><img src='".$row["img"]."' alt='Item Image'></td>";
                echo "<td><a href='editslide.php?id=".$row["id"]."'><button type='button' class='btn btn-primary'>Edit</button></a></td>"; 

                echo "<td><button type='button' class='btn btn-danger' onclick='showConfirmDialog(".$row["id"].")' >Delete</button></td>"; 
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
        var deleteId; // Variable to store ID of slide to be deleted

        function showConfirmDialog(id) {
            deleteId = id;
            document.getElementById('confirmDialog').style.display = 'block';
        }

        function hideConfirmDialog() {
            document.getElementById('confirmDialog').style.display = 'none';
        }

        function confirmDelete() {
            // Redirect to delete action with the ID of the slide
            window.location.href = "deleteslide.php?id=" + deleteId;
        }
    </script>
    
    
    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
</body>
</html>
