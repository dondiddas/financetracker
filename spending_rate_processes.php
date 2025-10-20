<?php
include("connection.php"); // Database connection

$userID = 1;
$currentMonth = date('Y-m');

// --- Get current month allowance ---
$queryAllowance = "
    SELECT amount 
    FROM user_allowance 
    WHERE userID = ? 
      AND DATE_FORMAT(month_year, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryAllowance);
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$resultAllowance = $stmt->get_result();
$currentAllowance = $resultAllowance->fetch_assoc()['amount'] ?? 0;

// --- Get total expenses for current month ---
$queryExpense = "
    SELECT IFNULL(SUM(amount), 0) AS total_expenses
    FROM transactions
    WHERE userID = ?
      AND type = 'expense'
      AND DATE_FORMAT(date, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryExpense);
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$resultExpense = $stmt->get_result();
$totalExpenses = $resultExpense->fetch_assoc()['total_expenses'] ?? 0;

// --- Calculate spending rate ---
if ($currentAllowance > 0) {
    $spendingRate = round(($totalExpenses / $currentAllowance) * 100, 2);
} else {
    $spendingRate = 0;
}

// --- Display the actual amount spent ---
$spentDisplay = "₱" . number_format($totalExpenses, 2);
?>
