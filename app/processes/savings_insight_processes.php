<?php
// savings_insight_processes.php
// Computes: $currentAllowance, $totalSpent, $savings, $savingsPercent, $savingsPercentDisplay, $savingsDisplay, $savingsClass

include("connection.php");

$userID = 1; // TODO: replace with session user id
$currentMonth = date('Y-m'); // e.g. "2025-10"

// --- Get total allowance for current month ---
// Sum all entries within the same month (do NOT mix with other months)
$queryAllowance = "
    SELECT COALESCE(SUM(amount), 0) AS total_allowance
    FROM user_allowance
    WHERE userID = ?
      AND DATE_FORMAT(month_year, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryAllowance);
if (!$stmt) {
    die('Prepare failed (allowance): ' . $conn->error);
}
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$res = $stmt->get_result();
$currentAllowance = (float)($res->fetch_assoc()['total_allowance'] ?? 0);
$stmt->close();

// --- Get total expenses for current month ---
$queryExpenses = "
    SELECT COALESCE(SUM(amount), 0) AS total_spent
    FROM transactions
    WHERE userID = ?
      AND type = 'expense'
      AND DATE_FORMAT(date, '%Y-%m') = ?
";
$stmt = $conn->prepare($queryExpenses);
if (!$stmt) {
    die('Prepare failed (expenses): ' . $conn->error);
}
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$res = $stmt->get_result();
$totalSpent = (float)($res->fetch_assoc()['total_spent'] ?? 0);
$stmt->close();

// --- Compute savings and percentage ---
$savings = $currentAllowance - $totalSpent;
$savingsPercent = ($currentAllowance > 0) ? ($savings / $currentAllowance) * 100 : 0;

// clamp to 0–100 for visual consistency
$savingsPercent = max(0, min($savingsPercent, 100));

// --- Prepare display values ---
$savingsPercentDisplay = round($savingsPercent, 1) . "%";
$savingsDisplay = "₱" . number_format(max($savings, 0), 2);

// --- Determine color class (CSS threshold) ---
if ($savingsPercent <= 20) {
    $savingsClass = 'low';
} elseif ($savingsPercent <= 50) {
    $savingsClass = 'medium';
} else {
    $savingsClass = 'high';
}
?>
