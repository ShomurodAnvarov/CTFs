<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$profileImage = "uploads/profile.jpg"; // Default profile image
if (file_exists("uploads/profile.png")) {
    $profileImage = "uploads/profile.png";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card my-5">
                    <div class="card-body text-center">
                        <h2 class="card-title">User Profile</h2>
                        <!-- Link the profile image to view_image.php with the filename parameter -->
                        <a href="view_image.php?filename=<?php echo basename($profileImage); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="<?php echo basename($profileImage); ?>" class="profile-image mb-3">
                        </a>
                        <form method="POST" enctype="multipart/form-data" action="upload.php">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="file" name="file" accept=".jpg, .png">
                                <label class="custom-file-label" for="file">Upload a profile image</label>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Upload">
                        </form>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        // Script to update the label of the custom file input to show the selected file name
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>
</html>
