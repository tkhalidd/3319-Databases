<!DOCTYPE html>
<html>
<head>
    <title>Nurse Information</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to shared CSS for consistent styling -->
</head>
<body>
    <header>
        <h1>Nurse Information</h1>
    </header>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        // Get the selected nurse's ID
        $nurse_id = $_POST['nurse_id'];

        // Query to get nurse's details, including supervisor's name
        $nurseQuery = "SELECT n1.firstname AS nurse_firstname, n1.lastname AS nurse_lastname,
                              n2.firstname AS supervisor_firstname, n2.lastname AS supervisor_lastname
                       FROM nurse n1
                       LEFT JOIN nurse n2 ON n1.reporttonurseid = n2.nurseid
                       WHERE n1.nurseid = '$nurse_id'";

        $nurseResult = $conn->query($nurseQuery);
        if ($nurseResult && $nurseResult->num_rows > 0) {
            $nurse = $nurseResult->fetch_assoc();

            // Display the nurse's name and supervisor's name
            echo "<h2 style='text-align:center;'>Nurse: {$nurse['nurse_firstname']} {$nurse['nurse_lastname']}</h2>";
            echo "<p style='text-align:center;'>Supervisor: " . ($nurse['supervisor_firstname'] ?? "None") . " " . ($nurse['supervisor_lastname'] ?? "") . "</p>";

            // Query to get all doctors the nurse works for and hours worked
            $doctorQuery = "SELECT d.firstname AS doctor_firstname, d.lastname AS doctor_lastname, w.hours
                            FROM workingfor w
                            JOIN doctor d ON w.docid = d.docid
                            WHERE w.nurseid = '$nurse_id'";

            $doctorResult = $conn->query($doctorQuery);
            if ($doctorResult && $doctorResult->num_rows > 0) {
                echo '<table style="margin: 20px auto; width: 80%;">';
                echo '<tr><th>Doctor First Name</th><th>Doctor Last Name</th><th>Hours Worked</th></tr>';

                $total_hours = 0;
                while ($row = $doctorResult->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['doctor_firstname']}</td>
                            <td>{$row['doctor_lastname']}</td>
                            <td>{$row['hours']}</td>
                          </tr>";
                    $total_hours += $row['hours'];
                }

                echo "</table>";
                echo "<p style='text-align:center;'><strong>Total Hours Worked:</strong> $total_hours</p>";
            } else {
                echo "<p style='text-align:center;'>No doctors assigned to this nurse.</p>";
            }
        } else {
            echo "<p style='text-align:center;color:red;'>Error: Nurse not found or no data available.</p>";
        }

        $conn->close(); // Close the database connection
    }
    ?>

    <!-- Form to select a nurse -->
    <form method="post" style="text-align: center;">
        <label>Select a Nurse:</label>
        <select name="nurse_id" required>
            <?php
            // Fetch all nurses for the dropdown
            $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
            if ($conn->connect_error) {
                die("<p style='text-align:center;color:red;'>Error connecting to database: {$conn->connect_error}</p>");
            }

            $nursesQuery = "SELECT nurseid, firstname, lastname FROM nurse";
            $nursesResult = $conn->query($nursesQuery);

            // Populate the dropdown with nurse data
            if ($nursesResult && $nursesResult->num_rows > 0) {
                while ($row = $nursesResult->fetch_assoc()) {
                    echo "<option value='{$row['nurseid']}'>{$row['firstname']} {$row['lastname']}</option>";
                }
            } else {
                echo "<option disabled>No nurses available</option>";
            }

            $conn->close(); // Close the database connection
            ?>
        </select>
        <br><br>
        <button type="submit">View Info</button> <!-- Submit button -->
    </form>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>
</body>
</html>
