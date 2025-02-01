<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h1>Upload Banner Image</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Select image to upload:</label><br>
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
        <input type="submit" value="Upload Image" name="submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Define the upload directory
        $target_dir = "/var/www/html/a3/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        // Check if the directory exists
        if (!is_dir($target_dir)) {
            echo "<p style='color: red;'>Error: Upload directory does not exist.</p>";
            exit;
        }

        // Check if file is an image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            echo "<p style='color: red;'>File is not an image.</p>";
            exit;
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p style='color: green;'>The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded to /var/www/html/a3/.</p>";
        } else {
            echo "<p style='color: red;'>Sorry, there was an error uploading your file.</p>";
        }
    }
    ?>
</body>
</html>
