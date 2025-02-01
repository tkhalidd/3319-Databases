<!DOCTYPE html>
<html>
<head>
    <title>Delete Patient</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to the shared CSS file for consistent styling -->
</head>
<body>
    <header>
        <h1>Delete Patient</h1>
    </header>

    <?php
    // Connect to the database
    $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the OHIP number from the form
        $ohip = $_POST['ohip'];

        // Check if the patient exists
        $checkQuery = "SELECT * FROM patient WHERE ohip = '$ohip'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            // If patient exists, delete them
            $deleteQuery = "DELETE FROM patient WHERE ohip = '$ohip'";
            if ($conn->query($deleteQuery)) {
                echo "<p style='text-align:center;color:green;'>Patient with OHIP $ohip has been successfully deleted.</p>";
            } else {
                echo "<p style='text-align:center;color:red;'>Error deleting patient: {$conn->error}</p>";
            }
        } else {
            // Display an error message if the OHIP does not exist
            echo "<p style='text-align:center;color:red;'>Error: Patient with OHIP $ohip does not exist.</p>";
        }
    }

    // Fetch all patients to populate the dropdown menu
    $patientsQuery = "SELECT ohip, firstname, lastname FROM patient";
    $patientsResult = $conn->query($patientsQuery);
    ?>

    <!-- Form to select and delete a patient -->
    <form method="post" style="text-align: center;">
        <label for="ohip">Select a Patient:</label>
        <select name="ohip" id="ohip" required>
            <?php
            // Populate dropdown menu with patient data
            if ($patientsResult->num_rows > 0) {
                while ($row = $patientsResult->fetch_assoc()) {
                    echo "<option value='{$row['ohip']}'>{$row['firstname']} {$row['lastname']} (OHIP: {$row['ohip']})</option>";
                }
            } else {
                echo "<option disabled>No patients available</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit">Delete Patient</button> <!-- Submit button -->
    </form>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>

    <?php $conn->close(); // Close the database connection ?>
</body>
</html>
