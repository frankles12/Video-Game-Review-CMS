<?
 include('connection.php');

/*
if(isset($_POST['submit']) && (!isset($_SESSION['logged_in']))) {

    $select_query = "SELECT username, password FROM a5_users"; // query to select all users/passwords
    $select_result = $mysqli->query($select_query);
    if($mysqli->error) {
        print "Select query error!  Message: ".$mysqli->error;
    }

    while($row = $select_result->fetch_object()) {
        if ((($_POST['username']) == ($row->username)) && (md5($_POST['password']) == ($row->password))) { // check if user input = a record in the database
            $_SESSION['logged_in'] = true;
            $_SESSION['logged_in_user'] = $row->username;
        } else {
            // do nothing
        }
    }
}

if (isset($_SESSION['logged_in'])) {
    header("Location: admin.php");
}

*/





if(isset($_POST['submit']) && (!isset($_SESSION['logged_in']))) {
    session_start();
    $select_query = "SELECT * FROM a5_users"; // query to select all users/passwords
    $select_result = $mysqli->query($select_query);
    if($mysqli->error) {
        print "Select query error!  Message: ".$mysqli->error;
    }

    while($row = $select_result->fetch_object()) {
        if ((($_POST['username']) == ($row->username)) && (md5($_POST['password']) == ($row->password))) { // check if user input = a record in the database
            $_SESSION['logged_in'] = true;
            $_SESSION['logged_in_user_id'] = $row->user_id;
            $_SESSION['logged_in_user'] = $row->username;
            $_SESSION['first_name'] = $row->first_name;
            $_SESSION['last_name'] = $row->last_name;
            $_SESSION['logged_in_access_level'] = $row->access_level;
        } else {
            // do nothing
        }
    }
}

if (isset($_SESSION['logged_in'])) {
    header("Location: admin.php");
}



?>




<!DOCTYPE html>
<html>
    <head>
        <meta name ="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <title><? print $_SERVER['PHP_SELF']; ?></title>
    </head>

    <body>
        <form method="post" action="">
            <label for="username">Username</label>
            <input name="username" id="username" type="text" /><br />
            <label for="password">Password</label>
            <input name="password" id="password" type="password" /><br />
            <input name="submit" id="submit" type="submit" value="Login" />
        </form>
    </body>
</html>









