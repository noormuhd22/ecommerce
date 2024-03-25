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
                    <form action="uploadproduct.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="categoryname" name="categoryname" required>
                        </div>
                        <div class="form-group">
                        <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <?php
                // Include database connection
                include 'connection.php';

                // Fetch categories from the database
                $sql_categories = "SELECT * FROM categories";
                $result_categories = $conn->query($sql_categories);

                if ($result_categories->num_rows > 0) {
                    while ($row = $result_categories->fetch_assoc()) {
                        $selected = ($row['categoryname'] == $product['category']) ? "selected" : "";
                        echo "<option value='" . $row['categoryname'] . "' $selected>" . $row['categoryname'] . "</option>";
                    }
                }
                ?>
            </select>
        
                        </div>
                        <div class="form-group">
                            <label for="price">price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
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
