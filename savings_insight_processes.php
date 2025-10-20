<?php
// savings_query.php
// Computes $currentAllowance, $totalSpent, $savings, $savingsPercent, $savingsPercentDisplay, $savingsDisplay, $savingsClass

include("connection.php");

$userID = 1; // replace with session user id later
$currentMonth = date('Y-m'); // "YYYY-MM"

// --- Get current month allowance (works for CHAR(7) 'YYYY-MM' or DATE stored) ---
$queryAllowance = "
    SELECT amount 
    FROM user_allowance 
    WHERE userID = ? 
      AND ( month_year = ? OR DATE_FORMAT(month_year, '%Y-%m') = ? )
    LIMIT 1
";
$stmt = $conn->prepare($queryAllowance);
$stmt->bind_param("iss", $userID, $currentMonth, $currentMonth);
$stmt->execute();
$res = $stmt->get_result();
$currentAllowance = $res->fetch_assoc()['amount'] ?? 0;
$stmt->close();

// --- Get total expenses for current month ---
$queryExpenses = "
    SELECT COALESCE(SUM(amount),0) AS total_spent 
    FROM transactions 
    WHERE userID = ? 
      AND type = 'expense' 
      AND DATE_FORMAT(date, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryExpenses);
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$res = $stmt->get_result();
$totalSpent = $res->fetch_assoc()['total_spent'] ?? 0;
$stmt->close();

// --- Compute savings & percentage (guard divide-by-zero) ---
$savings = $currentAllowance - $totalSpent;
$savingsPercent = ($currentAllowance > 0) ? ($savings / $currentAllowance) * 100 : 0;

// clamp to 0..100 for visual safety
$savingsPercent = max(0, min($savingsPercent, 100));
$savingsPercentDisplay = round($savingsPercent, 1) . "%";
$savingsDisplay = "₱" . number_format(max($savings, 0), 2);

// --- Determine color class per thresholds ---
// <=20 -> low (red), >20 && <=50 -> medium (neutral/yellow), >50 -> high (green)
if ($savingsPercent <= 20) {
    $savingsClass = 'low';
} elseif ($savingsPercent <= 50) {
    $savingsClass = 'medium';
} else {
    $savingsClass = 'high';
}
?>
