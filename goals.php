<?php
include("connection.php");

$userID = 1; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["goal_image"])) {
    $image = $_FILES["goal_image"]["tmp_name"];

    if ($image && file_exists($image)) {
        $imgData = addslashes(file_get_contents($image));

        $sql = "UPDATE goals 
                SET image = '$imgData' 
                WHERE userID = $userID AND status = 'ongoing' 
                LIMIT 1";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'> Image uploaded successfully!</p>";
        } else {
            echo "<p style='color: red;'> Error updating image: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'> No image selected or file not found.</p>";
    }
}
?>

<!-- HTML Upload Form -->
<form action="upload_goal_image.php" method="POST" enctype="multipart/form-data">
  <label><strong>Update Goal Image:</strong></label><br><br>

  <input type="file" name="goal_image" accept="image/*" required><br><br>

  <button type="submit">Upload Image</button>
</form>
