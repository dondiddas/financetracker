<?php
include("connection.php"); // your db connection
$userID = 1;
$currentMonth = date('Y-m');
$lastMonth = date('Y-m', strtotime('-1 month'));

// Get current month allowance
$queryCurrent = "SELECT amount FROM user_allowance WHERE userID = ? AND DATE_FORMAT(month_year, '%Y-%m') = ?";
$stmt = $conn->prepare($queryCurrent);
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$resultCurrent = $stmt->get_result();
$currentAllowance = $resultCurrent->fetch_assoc()['amount'] ?? 0;

// Get last month allowance
$queryLast = "SELECT amount FROM user_allowance WHERE userID = ? AND DATE_FORMAT(month_year, '%Y-%m') = ?";
$stmt = $conn->prepare($queryLast);
$stmt->bind_param("is", $userID, $lastMonth);
$stmt->execute();
$resultLast = $stmt->get_result();
$lastAllowance = $resultLast->fetch_assoc()['amount'] ?? 0;

// Calculate difference
$difference = $currentAllowance - $lastAllowance;

// Determine status

if ($difference > 0) {
    $status = "▲ ₱" . number_format($difference, 2);
    $class = "increase";
} elseif ($difference < 0) {
    $status = "▼ ₱" . number_format(abs($difference), 2);
    $class = "decrease";
} else {
    $status = "No change";
    $class = "no-change";
}
?>
