<?php
    session_start();
    $patronName = $_SESSION['patName'];             //Record Patron Name
    $patronCardNum = $_SESSION['patCardNum'];       //Record Patron Card Number 
    $patronEmail = $_SESSION['patEmail'];           //Record Patron Email
    $bookName = $_POST['srchdb'];                   //Record Book name 
    $_bookName = str_replace("'","\'",$bookName);   //Replace apostrophe with escape character in order to avoid SQL problems
    $patronID = $_SESSION['patID'];                 //Record Patron ID

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

    //Run a query and check whether the book exists in the database
    $bookinfo_query=mysqli_query($conn, "SELECT * FROM BOOKS WHERE BOOK_NAME='$_bookName'");
    $countOfRecords=mysqli_num_rows($bookinfo_query);
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
            <h2>Search results</h2>
                
                <?php
                    //If the book exists in the db, display it 
                    if($countOfRecords > 0){
                        echo ('<table><tr><td><strong> Book ID </strong></td> <td><strong> Book name </strong></td> <td><strong> Book author </strong></td></tr>');
                        while($row1 = $bookinfo_query->fetch_assoc()) {
                            $srchdBookID=$row1["BOOK_ID"];
                            $srchdBookName=$row1["BOOK_NAME"];
                            $srchdBookAuthor=$row1["BOOK_AUTHOR"];
                            echo ('<tr><td>' . $row1["BOOK_ID"] . '</td><td>' . $row1["BOOK_NAME"] . '</td><td>' . $row1["BOOK_AUTHOR"] . '</td></tr>');
                        }
                        echo ('</table>');

                        //Run a query to create a record related to that customer 
                        $bookinfo_query=mysqli_query($conn, "INSERT INTO ORDER_RECORDS (PATRON_ID, BOOK_ID)
                                                                    VALUES ('$patronID', '$srchdBookID')");
                        if($bookinfo_query){
                            echo ('<p> The book has been added to your account </p>');
                        }
                        else{
                            echo ('<p> Something went wrong... Please contact support. </p>');
                        }
                    }
                    //If the book is not available, notify the user
                    else{
                        echo ('<p> Unfortunately this book is not in our library yet...</p> <p> We will place an order on this book and notify you as soon as it arrives </p>');
                    }
                    //Close connection
                    mysqli_close($conn);
                ?>
                <!--Menu Buttons-->
                <div class="acctCrt">
                    <button onclick="location.href = 'usrInterface.html'">Back to main menu</button>
                    <button onclick="location.href = 'index.html'">Logout</button>
                </div>
    </body>
</html>