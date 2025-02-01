<!DOCTYPE html>
<html>
<head>
    <title>Modify Patient</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to shared CSS file -->
</head>
<body>
    <header>
        <h1>Modify Patient Weight</h1>
    </header>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        // Retrieve form data
        $ohip = $_POST['ohip'];
        $new_weight = $_POST['new_weight'];
        $unit = $_POST['unit'];

        // Convert weight to kilograms if entered in pounds
        if ($unit === 'pounds') {
            $new_weight = round($new_weight / 2.20462, 2);
        }

        // Check if the patient exists
        $checkQuery = "SELECT * FROM patient WHERE ohip = '$ohip'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            // Update the patient's weight in the database
            $updateQuery = "UPDATE patient SET weight = $new_weight WHERE ohip = '$ohip'";
            if ($conn->query($updateQuery)) {
                echo "<p style='text-align:center;color:green;'>Patient's weight updated successfully!</p>";
            } else {
                echo "<p style='text-align:center;color:red;'>Error updating weight: {$conn->error}</p>";
            }
        } else {
            // Display an error if the patient does not exist
            echo "<p style='text-align:center;color:red;'>Error: Patient with OHIP $ohip does not exist.</p>";
        }

        $conn->close(); // Close the database connection
    }
    ?>

    <!-- Form to modify a patient's weight -->
    <form method="post" style="text-align: center;">
        <label>OHIP Number:</label>
        <input type="text" name="ohip" required><br><br> <!-- Input field for OHIP number -->
        <label>New Weight:</label>
        <input type="number" name="new_weight" step="0.01" required><br><br> <!-- Input field for new weight -->
        <label>Unit:</label>
        <input type="radio" name="unit" value="kilograms" checked> Kilograms
        <input type="radio" name="unit" value="pounds"> Pounds<br><br> <!-- Radio buttons for weight unit -->
        <button type="submit">Update Weight</button> <!-- Submit button -->
    </form>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>
</body>
</html>
