<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        img{
            height:300px;
            width:300px;
            border-radius: 30px;
        }
        
ul.topnav {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color:  #4b16ad;
}

ul.topnav li {float: left;}

ul.topnav li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}
#loggedInUser{
    background-color:red;
    padding:4px;
    border-radius:2px;
}
.topnav img{
    border-radius:20px;
    height:50px;
    width:50px;
    
}
ul.topnav li a:hover:not(.active) {background-color: #111;}

ul.topnav li.right {float: right;}

@media screen and (max-width: 600px) {
  ul.topnav li.right, 
  ul.topnav li {float: none;}
}

    </style>
</head>
<body>



<ul class="topnav">
  <li><a href="#img"><img src="logo.jpg" alt="img"></a></li>
  <li><a href="Adminlogin.php">Admin</a></li>
  

</ul>
    <div class="container-fluid center">
        <div class="row">
            <div class="col-12 text-center mb-4">
             
                <img src="logo.jpg" alt="Logo" class="img-fluid">
            </div>
            <div class="col-12 text-center">
                

                <a href="loginpage.php"><button class="btn btn-primary">Login</button></a>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
