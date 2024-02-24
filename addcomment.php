<?php
// Connect to server and select database.
include("config.php");

// Escape user inputs for security
$name = strip_tags(mysqli_real_escape_string($objCon, $_POST['name']));
$email = strip_tags(mysqli_real_escape_string($objCon, $_POST['email']));
// Remove HTML tags from comment to prevent XSS
$comment = strip_tags(mysqli_real_escape_string($objCon, $_POST['comment']));

// Date time
$datetime = date("y-m-d h:i:s");

// Insert data into guestbook table
$sql = "INSERT INTO guestbook (name, email, comment, datetime) VALUES ('$name', '$email', '$comment', '$datetime')";
$objQuery = mysqli_query($objCon, $sql);

// Check if query successful
if($objQuery) {
    echo "Successful<br>";
    echo "<a href='viewguestbook.php'>View guestbook</a>";
} else {
    echo "ERROR";
}

// Close connection
mysqli_close($objCon);
?>
