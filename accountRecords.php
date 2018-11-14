<?php
    /*
        This script is used when the user picks to see the records 
        regarding his account. This script will not run if the user
        picks another option in the usrInterface.html
    */

        //Retrieve session information [username, cardnumber, email]
        session_start();
        $patronName = $_SESSION['patName'];         //Record Patron Name
        $patronCardNum = $_SESSION['patCardNum'];   //Record Patron Card Number 
        $patronEmail = $_SESSION['patEmail'];       //Record Patron Email

        //Instantiate variables that will be used in db connectivity
        $servername = "localhost";
        $username = "root";
        $password = "123";
        $database = "test_db";

        //Connecting with the database and checking if the connection is successful
        $conn = new mysqli($servername, $username, $password, $database);
        if (mysqli_connect_error()) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        //Creating queries for the database and pulling any available records
        $custinfo_query=mysqli_query($conn,"SELECT * 
                                            FROM PATRON_RECORDS 
                                            WHERE PATRON_NAME= '$patronName' && PATRON_CARDNUM= '$patronCardNum' && PATRON_EMAIL= '$patronEmail'");
        
        //Check if there are any records with such information, if not, redirect to a different page
        $countInfoQuery=mysqli_num_rows($custinfo_query);
        if($countInfoQuery == 0){
            mysqli_close($conn);
            header( "Location: recNotFound.html" );
        }    
        //Retrieve customer ID (Probably not the most efficient way but it works)                                    
        while($row = $custinfo_query->fetch_assoc()) {
            $customerId = $row["PATRON_ID"]; //retrieve customer id
        }

        //Look up books that match customer order information in both ORDERS and BOOKS records
        $custorder_query=mysqli_query($conn,"SELECT ORDER_RECORDS.BOOK_ID, BOOKS.BOOK_NAME, BOOKS.BOOK_AUTHOR, ORDER_RECORDS.DUE_DATE 
                                             FROM ORDER_RECORDS INNER JOIN BOOKS ON  ORDER_RECORDS.BOOK_ID = BOOKS.BOOK_ID 
                                             WHERE ORDER_RECORDS.PATRON_ID = '$customerId'");
    
        //Count the amount of records regarding the customer order
        $countOfRecords=mysqli_num_rows($custorder_query); 

        //Close connection with the database
        mysqli_close($conn);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> Library User System </title>
        <!--Link to CSS-->
        <link rel="stylesheet" href="css/acctRecordsDesign.css"/>
        <!--Link to javascript file-->
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
            <h1>Library User System</h1>
            <h2> Customer Information </h2>
            <table>
                <tr><td> Patron name: </td> <td><?php echo($patronName); ?> </td></tr>  
                <tr><td> Patron email: </td> <td><?php echo($patronEmail); ?> </td></tr>
                <tr><td> Patron card #: </td> <td><?php echo($patronCardNum); ?> </td></tr>
            </table>
            <h2>Books on record </h2>
                <?php
                    //If any order records are present, display them 
                    if($countOfRecords > 0){
                        echo ('<table><tr><td><strong> Book ID </strong></td> <td><strong> Book name </strong></td> <td><strong> Book author </strong></td> <td><strong> Due date </strong></td></tr>');
                        while($row1 = $custorder_query->fetch_assoc()) {
                            echo ('<tr><td>' . $row1["BOOK_ID"] . '</td><td>' . $row1["BOOK_NAME"] . '</td><td>' . $row1["BOOK_AUTHOR"] . '</td><td>' . $row1["DUE_DATE"] . '</td></tr>');
                        }
                        echo ('</table>');
                    }
                    //If no records are available, close the table early and notify the user
                    else{
                        echo ('<p> No records found </p>');
                    }
                ?>
            </table>
            <!--Menu Buttons-->
            <div class="acctCrt">
                <button onclick="location.href = 'usrInterface.html'">Back to main menu</button>
                <button onclick="location.href = 'index.html'">Logout</button>
            </div>
    </body>
</html>
