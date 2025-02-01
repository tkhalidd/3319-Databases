<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif; /* Use a clean, professional font */
            background: linear-gradient(to bottom, #e0f7ff, #d1e8ff); /* Soft gradient background */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        /* Header styling */
        header {
            text-align: center; /* Center the header content */
            padding: 30px; /* Add space inside the header */
            background: linear-gradient(to right, #007acc, #005b99); /* Gradient background for the header */
            color: white; /* White text for contrast */
            border-bottom: 5px solid #004080; /* Bottom border to separate header visually */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        header h1 {
            margin: 0; /* Remove default margin for the title */
            font-size: 3em; /* Large font size for prominence */
            letter-spacing: 2px; /* Space letters slightly */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Add a shadow for a polished effect */
        }

        header p {
            font-size: 1.2em; /* Slightly larger font for readability */
            margin: 10px 0 0; /* Add space above the paragraph */
        }

        /* Menu container styling */
        .menu {
            display: flex; /* Use flexbox for layout */
            flex-wrap: wrap; /* Allow buttons to wrap if necessary */
            justify-content: center; /* Center buttons horizontally */
            padding: 50px 20px; /* Add space around the buttons */
        }

        /* Button styling */
        .menu button {
            background: linear-gradient(to bottom, #007acc, #005b99); /* Gradient background for buttons */
            color: white; /* White text for contrast */
            border: none; /* Remove default border */
            border-radius: 12px; /* Rounded corners for a modern look */
            padding: 15px 40px; /* Add space inside buttons */
            margin: 15px; /* Add space between buttons */
            font-size: 1.2em; /* Slightly larger font for readability */
            font-weight: bold; /* Bold text for emphasis */
            cursor: pointer; /* Change cursor to pointer on hover */
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* Shadow for a raised effect */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
        }

        /* Button hover effect */
        .menu button:hover {
            background: linear-gradient(to bottom, #005b99, #003f73); /* Darker gradient on hover */
            transform: translateY(-4px); /* Slight upward movement */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3); /* Increase shadow depth */
        }

        /* Button active (clicked) effect */
        .menu button:active {
            transform: translateY(2px); /* Button moves down slightly when clicked */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Shadow becomes shallower */
        }

        /* Footer styling */
        footer {
            text-align: center; /* Center the footer content */
            padding: 20px; /* Add space inside the footer */
            background: #004080; /* Dark blue background */
            color: white; /* White text for contrast */
            font-size: 1em; /* Standard font size */
            margin-top: 30px; /* Add space above the footer */
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        footer a {
            color: #d1e8ff; /* Light blue link color for consistency */
            text-decoration: none; /* Remove underline */
            font-weight: bold; /* Bold text for emphasis */
        }

        footer a:hover {
            text-decoration: underline; /* Add underline on hover for clarity */
        }
    </style>
</head>
<body>
    <!-- Header section -->
    <header>
        <h1>Healthcare Database</h1> <!-- Page title -->
        <p>Welcome to the management system. Choose an action below:</p> <!-- Brief description -->
    </header>

    <!-- Menu container with navigation buttons -->
    <div class="menu">
        <!-- Form buttons link to respective PHP files -->
        <form action="listpatients.php" method="get">
            <button>List All Patients</button>
        </form>
        <form action="insertpatient.php" method="get">
            <button>Insert New Patient</button>
        </form>
        <form action="modifypatient.php" method="get">
            <button>Modify Existing Patient</button>
        </form>
        <form action="deletepatient.php" method="get">
            <button>Delete Patient</button>
        </form>
        <form action="doctorinfo.php" method="get">
            <button>Doctor Information</button>
        </form>
        <form action="nurseinfo.php" method="get">
            <button>Nurse Information</button>
        </form>
    </div>

    <!-- Footer section -->
    <footer>
        &copy; 2024 Healthcare Database | <a href="mailto:tkhalid8@uwo.ca?subject=Healthcare Database Support">Contact Support</a> <!-- Support link -->
    </footer>
</body>
</html>
