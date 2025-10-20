<?php
include("connection.php");
$userID = 1;

// compute current month start/end
$currentStart = date('Y-m-01');          // e.g. "2025-10-01"
$currentEnd   = date('Y-m-t');           // e.g. "2025-10-31"

// compute last month start/end
$lastStart = date('Y-m-01', strtotime('-1 month'));
$lastEnd   = date('Y-m-t',  strtotime('-1 month'));

// --- Current month ---
$queryCurrent = "
    SELECT COALESCE(SUM(amount), 0) AS amount
    FROM user_allowance
    WHERE userID = ?
      AND month_year BETWEEN ? AND ?
";
$stmt = $conn->prepare($queryCurrent);
if (!$stmt) {
    die("Prepare failed (current): " . $conn->error);
}
$stmt->bind_param("iss", $userID, $currentStart, $currentEnd);
$stmt->execute();
if ($stmt->errno) {
    die("Execute failed (current): " . $stmt->error);
}
$resultCurrent = $stmt->get_result();
$rowCurrent = $resultCurrent ? $resultCurrent->fetch_assoc() : null;
$currentAllowance = $rowCurrent ? (float)$rowCurrent['amount'] : 0.0;
$stmt->close();

// --- Last month ---
$queryLast = "
    SELECT COALESCE(SUM(amount), 0) AS amount
    FROM user_allowance
    WHERE userID = ?
      AND month_year BETWEEN ? AND ?
";
$stmt = $conn->prepare($queryLast);
if (!$stmt) {
    die("Prepare failed (last): " . $conn->error);
}
$stmt->bind_param("iss", $userID, $lastStart, $lastEnd);
$stmt->execute();
if ($stmt->errno) {
    die("Execute failed (last): " . $stmt->error);
}
$resultLast = $stmt->get_result();
$rowLast = $resultLast ? $resultLast->fetch_assoc() : null;
$lastAllowance = $rowLast ? (float)$rowLast['amount'] : 0.0;
$stmt->close();

// difference & status
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
