<?php
    /*
        This script is used to redirect the user to the appropriate form 
        based on the option that they picked in the user interface.
    */
        session_start();
        $optionSelected = $_POST['selection'];              //The selection that the user made

        $_SESSION['patName'] = $_POST['patName'];           // Declare patron name in the session
        $_SESSION['patCardNum'] = $_POST['patCardNum'];     // Declare card number in the session 
        $_SESSION['patEmail'] = $_POST['patEmail'];         // Declare patron email in the session

        $name = $_POST['patName'];
        $num = $_POST['patCardNum']; 
        $emaail = $_POST['patEmail']; 

        //Instantiate variables that will be used in db connectivity
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $database = "test_db";

        //Connecting with the database
        $conn = new mysqli($servername, $username, $password, $database);
        if (mysqli_connect_error()) {
            die("Database connection failed: " . mysqli_connect_error());
        }

         //Run a db query in order to retrieve Customer ID
         $custinfo_query=mysqli_query($conn,"SELECT * 
                                             FROM PATRON_RECORDS 
                                             WHERE PATRON_NAME= '$name' && PATRON_CARDNUM= '$num' && PATRON_EMAIL= '$emaail'");
        
        //Check if there is a record with this cusomer in the db, if not, redirect to a different page
        $countInfoQuery=mysqli_num_rows($custinfo_query);
        if($countInfoQuery == 0){
            mysqli_close($conn);
            header( "Location: recNotFound.html" );
        }    
        
        //Run through the possible options and act accordingly
        else if ($optionSelected == "accountRecords.php"){
            //Retrieve customer ID                                  
            while($row = $custinfo_query->fetch_assoc()) {
                $_SESSION['patID'] = $row["PATRON_ID"]; //retrieve customer id
            }
            mysqli_close($conn);
            header( "Location: accountRecords.php" );
        }  
        else if ($optionSelected == "makeOrder.php"){
            //Retrieve customer ID                                  
            while($row = $custinfo_query->fetch_assoc()) {
                $_SESSION['patID'] = $row["PATRON_ID"]; //retrieve customer id
            }
            mysqli_close($conn);
            header( "Location: makeOrder.php" ); 
        } 
        else if ($optionSelected == "bookReturn.html"){
            //Retrieve customer ID                                  
            while($row = $custinfo_query->fetch_assoc()) {
                $_SESSION['patID'] = $row["PATRON_ID"]; //retrieve customer id
            }
            mysqli_close($conn);
            header( "Location: returnBook.html" ); 
        }                 
?>