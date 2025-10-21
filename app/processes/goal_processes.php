<?php
include("connection.php");
$userID = 1;

$sql = "SELECT title, target_amount, current_amount, goal_image
        FROM goals
        WHERE userID = ? AND status = 'ongoing'
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $goal = $result->fetch_assoc();
    $title = $goal['title'];
    $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;

    if (!empty($goal['goal_image'])) {
        if (function_exists('finfo_open')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($goal['goal_image']);
            if (!$mime) $mime = 'image/jpeg';
        } else {
            $mime = 'image/jpeg';
        }
        $goal_image = 'data:' . $mime . ';base64,' . base64_encode($goal['goal_image']);
    } else {
        $goal_image = 'images/default.png';
    }
} else {
    $title = "No Active Goals";
    $progress = 0;
    $goal_image = "images/default.png";
}

$stmt->close();
?>
