<?php
include("connection.php");
$userID = 1;

// Get current and last month
$currentMonth = date('Y-m'); // e.g. 2025-10
$lastMonth = date('Y-m', strtotime('-1 month')); // e.g. 2025-09

// --- Current month total ---
$queryCurrent = "
    SELECT COALESCE(SUM(amount), 0) AS total
    FROM user_allowance
    WHERE userID = ?
      AND DATE_FORMAT(month_year, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryCurrent);
if (!$stmt) {
    die("Prepare failed (current): " . $conn->error);
}
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$resultCurrent = $stmt->get_result();
$currentAllowance = (float)($resultCurrent->fetch_assoc()['total'] ?? 0);
$stmt->close();

// --- Last month total ---
$queryLast = "
    SELECT COALESCE(SUM(amount), 0) AS total
    FROM user_allowance
    WHERE userID = ?
      AND DATE_FORMAT(month_year, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryLast);
if (!$stmt) {
    die("Prepare failed (last): " . $conn->error);
}
$stmt->bind_param("is", $userID, $lastMonth);
$stmt->execute();
$resultLast = $stmt->get_result();
$lastAllowance = (float)($resultLast->fetch_assoc()['total'] ?? 0);
$stmt->close();

// --- Compute difference & status ---
$difference = $currentAllowance - $lastAllowance;

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
