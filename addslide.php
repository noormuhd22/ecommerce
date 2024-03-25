<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'adminnavbar.php'; ?> 
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Upload Image
                </div>
                <div class="card-body">
                    <form action="uploadslide.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Upload Image</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
</body>
</html>
