<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" 
rel="stylesheet">
    <title>app</title>
</head>

<style>
    body{
        background-color: black;
        color:white;
        font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-style: normal;
    }
   
   
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
h3{
    color:white;
}

.navbar {
  background-color: #333; 
  overflow: hidden; 
}


.navbar a {
  float: left; 
  display: block; 
  color: white; 
  text-align: center; 
  padding: 14px 20px;
  text-decoration: none; 
}

.navbar a:hover {
  background-color: #ddd; 
  color: black; 
}

.navbar a.active {
  background-color: #555; 
}
</style>
<body>
<h3>@yield("title")</h3>
<nav class="navbar">
    <ul>
        <a href="/"><li>home</li></a>
        <a href="/about/noor/123"><li>About</li></a>
        <a href="/menu"><li>Menu</li></a>
    <ul>
</nav>
    
</body>
</html>