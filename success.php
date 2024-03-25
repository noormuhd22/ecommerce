<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Success</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Payment has been successful</h2>

  <div class="alert alert-success">
    <strong>Please note your payment id!</strong> <?php echo $_SESSION['paymentid'];?> 
  </div>

  <!-- Buttons to redirect to homepage and contact us page -->
  <div class="row mt-3">
    <div class="col">
      <a href="home.php" class="btn btn-primary">Go to Homepage</a>
    </div>
    <div class="col">
      <a href="contactus.php" class="btn btn-secondary">Contact Us</a>
    </div>
  </div>
  
</div>

</body>
</html>
