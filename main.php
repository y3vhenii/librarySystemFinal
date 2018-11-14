<?php
    /*
        This form is used to start the session and
        log in the system. If the record is found in the
        database, the user will be transferred to the user interface,
        otherwise the person will be notified that the account was not found.
    */
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $database = "test_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);
        if (mysqli_connect_error()) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $_SESSION['patName'] = $_POST['patName'];           // Declare patronName in the session
        $_SESSION['cardNumber'] = $_POST['patCardNum'];     // Declare cardNumber in the session   
        $cardNum = $_SESSION['cardNumber'];
        $patroName = $_SESSION['patName'];
        $custinfo_query=mysqli_query($conn,"SELECT * 
                                            FROM PATRON_RECORDS 
                                            WHERE PATRON_NAME= '$patroName' && PATRON_CARDNUM= '$cardNum'");  //Pull the record from db 
        
        //If the account exists in the database, count will be one, otherwise the user will be redirected to another page
        $count=mysqli_num_rows($custinfo_query);
        if ($count==1){
            mysqli_close($conn);
            header( "Location: usrInterface.html" );
        }  
        else{
            mysqli_close($conn);
            header( "Location: recNotFound.html" );
        }               
?>


