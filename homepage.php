<?php
session_start();
include("connect.php");

// Handle contact detail submission
if(isset($_POST['submitContact'])){
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $registrationNumber = $_POST['registration_number'];
    $address = $_POST['address'];

    $insertContactQuery = "INSERT INTO contact_details (email, mobile, registration_number, address) VALUES ('$email', '$mobile', '$registrationNumber', '$address')";
    if($conn->query($insertContactQuery) === TRUE){
        echo "Contact details added successfully.";
    } else {
        echo "Error adding contact details: " . $conn->error;
    }
}

// Handle search form submission
$searchResult = null;
if(isset($_POST['searchContact'])){
    $searchRegistrationNumber = $_POST['search_registration_number'];
    $searchQuery = "SELECT * FROM contact_details WHERE registration_number='$searchRegistrationNumber'";
    $result = $conn->query($searchQuery);
    if($result->num_rows > 0){
        $searchResult = $result->fetch_assoc();
    } else {
        echo "No contact found with the given registration number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #c9d6ff;
        }

        .container {
            text-align: center;
            padding: 5% 0;
        }

        h1 {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-top: 20px;
            display: inline-block;
        }

        .search-result {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello 
            <?php 
            if(isset($_SESSION['email'])){
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");
                $row = mysqli_fetch_assoc($query);
                echo $row['firstName'] . ' ' . $row['lastName'];
            }
            ?>
            :)
        </h1>
        
        <!-- Contact Details Form -->
        <form method="post" action="">
            <label for="mobile">Mobile Number:</label><br>
            <input type="text" id="mobile" name="mobile" required><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" required><br>
            <label for="address">Address:</label><br>
            <textarea id="address" name="address" required></textarea><br><br>
            <label for="registration_number">Registration Number:</label><br>
            <input type="text" id="registration_number" name="registration_number" required><br><br>
            <input type="submit" name="submitContact" value="Submit">
        </form>

        <!-- Search Form -->
        <form method="post" action="">
            <label for="search_registration_number">Search by Registration Number:</label><br>
            <input type="text" id="search_registration_number" name="search_registration_number" required><br><br>
            <input type="submit" name="searchContact" value="Search">
        </form>

        <!-- Display Search Result -->
        <?php
        if($searchResult) {
            echo "<div class='search-result'>";
            echo "<h2>Contact Details</h2>";
            echo "<p><strong>Email:</strong> " . $searchResult['email'] . "</p>";
            echo "<p><strong>Mobile:</strong> " . $searchResult['mobile'] . "</p>";
            echo "<p><strong>Address:</strong> " . $searchResult['address'] . "</p>";
            echo "<p><strong>Registration Number:</strong> " . $searchResult['registration_number'] . "</p>";
            echo "</div>";
        }
        ?>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
