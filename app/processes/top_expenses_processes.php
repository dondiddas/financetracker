<?php
include("connection.php");

$userID = 1;
$currentMonth = date('Y-m');

// --- Get total expenses per category ---
$query = "
    SELECT 
        c.name AS category_name,
        SUM(t.amount) AS total_spent
    FROM transactions t
    JOIN categories c ON t.category_id = c.category_id
    WHERE t.userID = ?
      AND t.type = 'expense'
      AND DATE_FORMAT(t.date, '%Y-%m') = ?
    GROUP BY c.category_id, c.name
    ORDER BY total_spent DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $userID, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();

// --- Store results ---
$expenseCategories = [];
while ($row = $result->fetch_assoc()) {
    $expenseCategories[] = $row;
}
?>
