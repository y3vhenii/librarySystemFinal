<?php
    session_start();
    $patronName = $_SESSION['patName'];         //Record Patron Name
    $patronCardNum = $_SESSION['patCardNum'];   //Record Patron Card Number 
    $patronEmail = $_SESSION['patEmail'];       //Record Patron Email
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
            <h2>Search and Order Books here</h2>
            <form action="executeOrder.php" onsubmit="" method="post">
                <div class="form1">
                    <label>Search for books here:</label>
                    <input type="text" id= "srchdb" name="srchdb" placeholder="Enter Book name here..."/> <br />
                    <p>Note: Please enter book name exactly as it says on the official title</p>
                    <button type ="submit" value="Submit">Search</button>
                    <button type="button" onclick="location.href = 'usrInterface.html';">Back to home page</button>
                </div>
            </form>
    </body>
</html>
        