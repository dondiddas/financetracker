<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = 1; 

    if (isset($_FILES["goal_image"]) && $_FILES["goal_image"]["error"] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES["goal_image"]["tmp_name"]);

        $sql = "UPDATE goals 
                SET goal_image = ? 
                WHERE userID = ? AND status = 'ongoing' 
                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $imageData, $userID);

        if ($stmt->execute()) {
            header("Location: dashboard.php?upload=success");
            exit();
        } else {
            echo " Error uploading image: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo " Please select a valid image file.";
    }
}
?>
