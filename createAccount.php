<?php
        $newPatronName = $_POST['newPatName'];        //Record Patron Name
        $newPatonCardNum = $_POST['newPatCardNum'];   //Record Patron Card Number 
        $newPatronEmail = $_POST['newPatEmail'];      //Record Patron Email

        //Connecting with the database
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $database = "test_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        if (mysqli_connect_error()) {
            die("Database connection failed: " . mysqli_connect_error());
        }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            Library User System
        </title>
        <!--Link to CSS-->
        <link rel="stylesheet" href="css/phpCreateAccountDesign.css"/>
    </head>
    <body>
        <h1>Library User System</h1>
        <?php
            //Insert new record in the table
            $sql = "INSERT INTO PATRON_RECORDS (PATRON_NAME, PATRON_EMAIL, PATRON_CARDNUM) VALUES ('$newPatronName', '$newPatronEmail', '$newPatonCardNum')";

            if (mysqli_query($conn, $sql)) {
                echo "<h2>Your account was created successfully</h2>";
                echo "<h2>Please Log in from the main page</h2>";
                echo "<h2>Thank you for choosing our service</h2>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            //Close connection with the database
            mysqli_close($conn);
        ?>
        <div>
            <button type= "button" onclick="location.href = 'index.html';">Go back to login page</button>
        </div>
    </body>
</html> 

