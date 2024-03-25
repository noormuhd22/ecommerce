<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Include the Poppins font from Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<style>
body {
  margin: 0;
  font-family: 'Poppins', sans-serif; /* Use Poppins font */
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


.dropdown-content {
  display: none;
  position: fixed;
  background-color:#4b16ad;
  min-width: 160px;
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown when hovering over the settings icon */
.dropdown:hover .dropdown-content {
  opacity: 1;
  display: block;
}

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

  <li><a href="adminhome.php">Home</a></li>
  <li><a href="adminslide.php">slides</a></li>
  <li><a href="admincategories.php">Categories</a></li>
  <li><a href="adminproducts.php">Products</a></li>
  <li><a href="adminsubcategories.php">subcategories</a></li>
  
  <li class="right"><a href="#about"><span id="loggedInUser"><?php echo $name  ?> </span></a></li>
  <li class="right dropdown" id="settingsDropdown"> <!-- Added id to the dropdown content -->
    <a href="#" class="material-symbols-outlined" id="settingsBtn">settings</a> <!-- Added id to the settings link -->
    <div class="dropdown-content">
      <a href="logout.php">Logout</a>
    </div>
  </li>
  <li class="right"><a href="adminmessage.php"><span class="material-symbols-outlined">
chat
</span></a></li>
  <li class="right"><a href="adminorders.php">orders</a></li>

</ul>


<script>
function initializeDropdown() {
  var settingsBtn = document.getElementById("settingsBtn");
  var settingsDropdown = document.getElementById("settingsDropdown");

  settingsBtn.addEventListener("click", function() {
    settingsDropdown.classList.toggle("open");
  });
}

initializeDropdown(); // Call the function to initialize dropdown after the page is loaded

</script>
<script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>

</body>
</html>
