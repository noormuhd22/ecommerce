
<?php
session_start();


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: adminsports.php");
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
        table {
            width: 100%;
            border-collapse: collapse;
            width:900px;
            margin-left:auto;
            margin-right:auto;



        }
        table img{
           max-width:400px;
            max-height:200px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .col{
            float:left;
  
        }
        
        h2{
            text-align:center;
            margin-top:50px;
        }
    </style>
</head>
<body>

<?php include 'adminnavbar.php'; ?> 
    <h2>Users</h2>
   
   

   
    <table>
        <thead>
            <tr>
                <th>Username</th>
              
                <th>Email</th> 
                <th>Mobile</th>

            </tr>
        </thead>
        <tbody>
            <?php
            // Include the PHP file to fetch data from the database
            include 'connection.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM user";
$result = $conn->query($sql);

            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["username"]."</td>";
             
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["mobile"]."</td>";


                echo "</tr>";
            }
            ?>
        </tbody>
    </table>


    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
</body>
</html>
