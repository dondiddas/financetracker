<?php
include("connection.php"); // Database connection

$userID = 1; // Replace with session user id in production
$currentMonth = date('Y-m'); // e.g. "2025-10"
$currentStart = date('Y-m-01'); // e.g. "2025-10-01"
$currentEnd   = date('Y-m-t');  // e.g. "2025-10-31"

// --- Get current month allowance ---
// Handles both CHAR(7) ('YYYY-MM') and DATE type columns for month_year
$queryAllowance = "
    SELECT COALESCE(SUM(amount), 0) AS total_allowance
    FROM user_allowance
    WHERE userID = ?
      AND (
          month_year = ? 
          OR (month_year BETWEEN ? AND ?)
          OR DATE_FORMAT(month_year, '%Y-%m') = ?
      )
";
$stmt = $conn->prepare($queryAllowance);
if (!$stmt) {
    die('Prepare failed (allowance): ' . $conn->error);
}
$stmt->bind_param("issss", $userID, $currentMonth, $currentStart, $currentEnd, $currentMonth);
$stmt->execute();
$res = $stmt->get_result();
$currentAllowance = $res->fetch_assoc()['total_allowance'] ?? 0;
$stmt->close();


// --- Get total expenses for current month ---
$queryExpense = "
    SELECT COALESCE(SUM(amount), 0) AS total_expenses
    FROM transactions
    WHERE userID = ?
      AND type = 'expense'
      AND date BETWEEN ? AND ?
";
$stmt = $conn->prepare($queryExpense);
if (!$stmt) {
    die('Prepare failed (expenses): ' . $conn->error);
}
$stmt->bind_param("iss", $userID, $currentStart, $currentEnd);
$stmt->execute();
$res = $stmt->get_result();
$totalExpenses = $res->fetch_assoc()['total_expenses'] ?? 0;
$stmt->close();


// --- Calculate spending rate ---
$spendingRate = ($currentAllowance > 0)
    ? round(($totalExpenses / $currentAllowance) * 100, 2)
    : 0;

// --- Format display ---
$spentDisplay = "₱" . number_format($totalExpenses, 2);
?>
