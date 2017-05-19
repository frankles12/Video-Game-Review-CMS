<?php
session_start();

include "connection.php";

if (!isset($_SESSION['logged_in'])) {
    print "In order to view this page you must be logged in. Please follow this link to login. <a href=\"login.php\">login.php";
} else {
    if ($_SESSION['logged_in_access_level'] == 'administrator') {
        $selection_query = "SELECT review_id, game_name, game_review, game_rating, game_image_url, DATE_FORMAT (review_creation_date, '%M %d, %Y %l:%i%p') as review_creation_date
                        FROM a5_reviews";

        $selection_result = $mysqli->query($selection_query);


    } else if ($_SESSION['logged_in_access_level'] == 'reviewer') {

        $selection_query = "SELECT r.review_id, r.game_name, r.game_review, r.game_rating, r.game_image_url, DATE_FORMAT (r.review_creation_date, '%M %d, %Y %l:%i%p') as review_creation_date
                        FROM a5_reviews r, a5_users u
                        WHERE r.user_id = u.user_id AND u.user_id = '".$_SESSION['logged_in_user_id']."'";

        $selection_result = $mysqli->query($selection_query);
    }

    if(isset($_POST['submit'])) {
        $insert_review_query = "INSERT INTO a5_reviews(review_id, game_name, game_review, game_rating, game_image_url, review_creation_date, user_id) 
                                         VALUES ('" . $_POST['review_id'] . "', '" . $_POST['game_name'] . "', '" . $_POST['game_review'] . "', '" . $_POST['game_rating'] . "', '" . $_POST['game_image_url'] . "', CURRENT_TIMESTAMP, '" . $_SESSION['logged_in_user_id'] . "')";
        $mysqli->query($insert_review_query);
        header("Location: admin.php");
    }



$empty_name = false;
    $empty_review = false;
    $empty_rating = false;
    $empty_image = false;




if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {

if (empty($_POST["game_name"])) {
    $empty_name = true;
} else {
    $empty_name = false;
}
    if (empty($_POST["game_review"])) {
        $empty_review = true;
    } else {
        $empty_review = false;
    }
    if (empty($_POST["game_rating"])) {
        $empty_rating = true;
    } else {
        $empty_rating = false;
    }
    if (empty($_POST["game_image_url"])) {
        $empty_image = true;
    } else {
        $empty_image = false;
    }

}

        ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name ="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <title><? print $_SERVER['PHP_SELF']; ?></title>
    </head>

    <body>
    <p>Congratulations <? print $_SESSION['first_name'];?> <? print $_SESSION['last_name']; ?>, you have successfully logged in!</p>

    <p>Click here to logout: <a href="logout.php">logout.php</a></p>
    <hr/>

    <table>
        <thead>Video Game Reviews</thead>
        <tbody>
        <tr>
            <?
            if(($_SESSION['logged_in_access_level'] == "administrator")) { ?>
                <td>Operation</td> <?
            } ?>
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
            if(($_SESSION['logged_in_access_level'] == "administrator")) {
                print "<td>  
                               <a href=\"delete.php?review_id=".$row->review_id."\">delete</a> 
                               </td>";
            }
            print "<td>" . $row->review_id . "</td>";
            print "<td>" . $row->game_name . "</td>";
            print "<td>" . $row->game_review . "</td>";
            print "<td>" . $row->game_rating . "</td>";
            print "<td><img width='50%' height='50%' alt=" . '"' . $row->game_name . '"'.  " src=" . '"' . $row->game_image_url . '"'.  "</img></td>";
            print "<td>" . $row->review_creation_date . "</td>";
            print "</tr>";

        }
        ?>
    </table>

    <form method="post" action="">
        <label for="game_name">Game Name</label>
        <input name="game_name" id="game_name" type="text" /><?php if ($empty_name = true) {echo "Please Enter a Field";}?><br />
        <label for="game_review">Game Review</label>
        <textarea name="game_review"></textarea><?php if ($empty_review = true) {echo "Please Enter a Field";}?><br />
        <label for="game_image_url">Game Image URL</label>
        <input name="game_image_url" id="game_image_url" type="text" /><?php if ($empty_image = true) {echo "Please Enter a Field";}?><br />
        <select name="game_rating">
            <option value="1">1/10</option>
            <option value="2">2/10</option>
            <option value="3">3/10</option>
            <option value="4">4/10</option>
            <option value="5">5/10</option>
            <option value="6">6/10</option>
            <option value="7">7/10</option>
            <option value="8">8/10</option>
            <option value="9">9/10</option>
            <option value="10">10/10</option>
        </select><br />
        <input name="submit" id="submit" type="submit" value="Submit Review" />
    </form>

    </body>
    </html>

<? }
$mysqli->close(); ?>
