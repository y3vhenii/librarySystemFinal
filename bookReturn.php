<?php
    /*
        The script is used when the user picks the return book option.
        This script will not run if the user
        picks another option in the usrInterface.html
    */

        //Retrieve session information [username, cardnumber, email]
        session_start();
        $patronName = $_SESSION['patName'];         //Record Patron Name from the session
        $patronCardNum = $_SESSION['patCardNum'];   //Record Patron Card Number from the session
        $patronEmail = $_SESSION['patEmail'];       //Record Patron Email from the session

        $bookName = $_POST['bookName'];             //Store Book name entered in the form
        $bookAuthor = $_POST['bookAuthor'];         //Store Author's name entered in the form

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
                                            WHERE PATRON_NAME= '$patronName' && PATRON_CARDNUM= '$patronCardNum' && PATRON_EMAIL= '$patronEmail'");
        
        //Check if there is a record with this cusomer in the db, if not, redirect to a different page
        $countInfoQuery=mysqli_num_rows($custinfo_query);
        if($countInfoQuery == 0){
            mysqli_close($conn);
            header( "Location: recNotFound.html" );
        }    

        //Retrieve Customer ID                                   
        while($row = $custinfo_query->fetch_assoc()) {
            $customerId = $row["PATRON_ID"];
        }

        //Find the book ID in the database
        $returnBook_query=mysqli_query($conn,"SELECT * 
                                              FROM BOOKS 
                                              WHERE BOOK_NAME= '$bookName' && BOOK_AUTHOR= '$bookAuthor'");

        //Retrieve book ID                                    
        while($row = $returnBook_query->fetch_assoc()) {
            $bookId = $row["BOOK_ID"]; 
        }

        //Run a query and delete the record that is related to this customer (will check the result once html is loaded)
        $deleteOrder_query=mysqli_query($conn,"DELETE FROM ORDER_RECORDS WHERE PATRON_ID= '$customerId' && BOOK_ID= '$bookId'");
        //Close connection
        mysqli_close($conn);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title> Library User System </title>
        <!--Link to CSS-->
        <link rel="stylesheet" href="css/createAcctFormDesign.css"/>
        <!--Link to javascript file-->
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
            <h1>Library User System</h1>
            <?php
                //Checking if the query has executed successfully
                if($deleteOrder_query) 
                {
                    echo("<h2> The book is returned successfully </h2>");
                }
                else
                {
                    echo("<h2> Something went wrong...Please contact the support. </h2>");
                }
            ?>
            <div class="form1">
                    <button type= "button" onclick="location.href = 'usrInterface.html';">Go back to user menu</button>
                    <button type= "button" onclick="location.href = 'index.html';">Go back to login page</button>
            </div>
    </body>
</html>
