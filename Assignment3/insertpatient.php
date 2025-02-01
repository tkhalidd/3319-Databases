<!DOCTYPE html>
<html>
<head>
    <title>Insert New Patient</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to shared CSS for consistent styling -->
</head>
<body>
    <header>
        <h1>Insert New Patient</h1>
    </header>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        // Retrieve form data
        $ohip = $_POST['ohip'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $birthdate = $_POST['birthdate'];
        $doctor = $_POST['doctor'];

        // Check if the OHIP number is unique
        $checkQuery = "SELECT ohip FROM patient WHERE ohip = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $ohip);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Display an error if OHIP already exists
            echo "<p style='text-align:center;color:red;'>Error: OHIP number already exists. Please use a unique OHIP number.</p>";
        } else {
            // Insert the new patient into the database
            $insertQuery = "INSERT INTO patient (ohip, firstname, lastname, weight, height, birthdate, treatsdocid) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssdsss", $ohip, $firstname, $lastname, $weight, $height, $birthdate, $doctor);

            if ($stmt->execute()) {
                echo "<p style='text-align:center;color:green;'>Patient added successfully!</p>";
            } else {
                echo "<p style='text-align:center;color:red;'>Error: {$conn->error}</p>";
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <!-- Form to insert a new patient -->
    <form method="post" style="text-align: center;">
        <label>OHIP: <input type="text" name="ohip" required></label><br><br>
        <label>First Name: <input type="text" name="firstname" required></label><br><br>
        <label>Last Name: <input type="text" name="lastname" required></label><br><br>
        <label>Weight (kg): <input type="number" name="weight" step="0.01" required></label><br><br>
        <label>Height (m): <input type="number" name="height" step="0.01" required></label><br><br>
        <label>Birthdate: <input type="date" name="birthdate" required></label><br><br>
        <label>Doctor:
            <select name="doctor" required>
                <?php
                // Connect to the database to fetch doctors
                $conn = new mysqli('localhost', 'root', 'cs3319', 'assign2db');
                if ($conn->connect_error) {
                    die("<p style='text-align:center;color:red;'>Error connecting to database: {$conn->connect_error}</p>");
                }

                $doctorQuery = "SELECT docid, firstname, lastname FROM doctor";
                $result = $conn->query($doctorQuery);

                // Populate the dropdown with doctor data
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['docid']}'>{$row['firstname']} {$row['lastname']}</option>";
                    }
                } else {
                    echo "<option disabled>No doctors available</option>";
                }

                $conn->close(); // Close the database connection
                ?>
            </select>
        </label><br><br>
        <input type="submit" value="Add Patient"> <!-- Submit button -->
    </form>

    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a>
    </footer>
</body>
</html>
