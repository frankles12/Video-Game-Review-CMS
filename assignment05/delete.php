<?php
session_start();

include "connection.php";

if (!isset($_SESSION['logged_in'])) {
    print "In order to view this page you must be logged in. Please follow this link to login. <a href=\"login.php\">login.php";
} else {
    if ($_SESSION['logged_in_access_level'] == 'administrator') {

    if (isset($_POST['yes'])) {
            $delete_review_query = "DELETE FROM a5_reviews 
                                     WHERE review_id ='" . $_POST['review_to_delete'] . "'";
            $mysqli->query($delete_review_query);
        header('Location: admin.php');

        }
        if (isset($_POST['no'])){
            header('Location: admin.php');
        }
    }

        $selection_query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, review_creation_date 
                        FROM a5_reviews";

        $selection_result = $mysqli->query($selection_query);




    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name ="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <title><? print $_SERVER['PHP_SELF']; ?></title>
    </head>

    <body>
    <p>Congratulations <? print $_SESSION['logged_in_user']; ?>, you have successfully logged in!</p>
    <p>Click here to get back to admin.php: <a href="admin.php">admin.php</a></p>
    <p>Click here to logout: <a href="logout.php">logout.php</a></p>
    <hr/>

    <table>
        <thead>Video Game Reviews</thead>
        <tbody>
        <tr>
            <td>review_id</td>
            <td>game_name</td>
            <td>game_review</td>
            <td>game_rating</td>
            <td>game_image_url</td>
            <td>review_creation_date</td>
        </tr>
        </tbody>
        <?
        while ($row = $selection_result->fetch_object()) {
            print "<tr>";
            print "<td>" . $row->review_id . "</td>";
            print "<td>" . $row->game_name . "</td>";
            print "<td>" . $row->game_review . "</td>";
            print "<td>" . $row->game_rating . "</td>";
            print "<td><img width='50%' height='50%' alt=" . '"' . $row->game_name . '"'.  " src=" . '"' . $row->game_image_url . '"' . "</img></td>";
            print "<td>" . $row->review_creation_date . "</td>";
            print "</tr>";

        }
        ?>
    </table>

    <br/>
    <form method="post" action="">
        <p>Do you really want to delete review_id <? print $_GET['review_id']; ?>?</p>
        <input name="review_to_delete" id="review_to_delete" type="hidden"
               value="<? print $_GET['review_id']; ?>"/><br/>
        <input name="yes" id="yes" type="submit" value="Yes"/>
        <input name="no" id="no" type="submit" value="No"/>
    </form>


    </body>
    </html>
<? } if ($_SESSION['logged_in_access_level'] == 'reviewer'){ // don't forget to close out properly! ?>
    <p>Please login as an admin: <a href="login.php">login.php</a></p>

<? } $mysqli->close(); ?>
