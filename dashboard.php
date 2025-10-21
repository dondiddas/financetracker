<?php
include("goal_processes.php");
include("allowance_processes.php");
include("spending_rate_processes.php");
include("top_expenses_processes.php");
include("savings_insight_processes.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <div class="left-grid">
    <div class="search-container">
        <img src="https://img.icons8.com/ios-filled/24/search--v1.png" alt="search icon">
        <input type="search" placeholder="Search...">
    </div>

    <!-- Sidebar-->
    <?php include('sidebar.php'); ?>

    <div class="profile-container"></div>
  </div>

  <div class="mid-grid">
    <div class="mid-container">
        <a href="goals.php" class="goal-container">
            <h4> Goal Progress</h4>
            <div class="goal-border">
                <div class="image-container">
                    <img src="<?php echo $goal_image; ?>" alt="Goal Image" class="goal-image">
                </div>
                <div class="goal-description-container">
                    <h4 class="goal-title"><?php echo htmlspecialchars($title); ?></h4>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: <?php echo (float)$progress; ?>%;"></div>
                    </div>
                    <p class="progress-percent">
                        <?php echo number_format($progress, 1); ?>% Completed
                    </p>
                </div>
            </div>
        </a>
        <div class="allowance-container">
            <h4>Allowance Overview</h4>
            <div class="allowance-border">
                <h5> <?php echo date('F Y'); ?></h5>
                  <h3><div class="current-allowance"> ₱<?php echo $currentAllowance?></div></h3>
                <div class="allowance-changes">
                    <div class="difference-container <?php echo $class; ?>">
                        <?php echo $status; ?>
                        <p> from last month</p>
                    </div>
                </div>               
            </div>
        </div>
        <div class="spending-container">
            <h4>Spending Rate</h4>
            <div class="spending-border">
                    <p class="spending-title"> Total spent</p>
                <p class="classpending"><?php echo $spentDisplay; ?></p>
                <div class="spending-descrip">
                    <?php echo $spendingRate ?>%
                   <p>of allowance</p>
                </div>
            </div>
        </div>
    </div>
      <div class="chart-container"></div>
      <div class="bottom-container">
        <div class="savings-insight">
  <h4 class="savings-title">Savings Insight</h4>

  <div class="savings-amount"><?php echo $savingsDisplay; ?> Saved</div>

  <div class="savings-bar" role="progressbar" aria-valuenow="<?php echo round($savingsPercent); ?>" aria-valuemin="0" aria-valuemax="100">
    <div class="savings-fill <?php echo $savingsClass; ?>" style="width: <?php echo $savingsPercent; ?>%;"></div>
  </div>

  <p class="savings-text">
    <?php echo $savingsPercentDisplay; ?> of your 
    ₱<?php echo number_format($currentAllowance, 2); ?> allowance remains this month.
  </p>
</div>
            <div class="upcoming-bills-container">
              <div class="upcoming-bills-border">
              <h4>Upcoming Bill</h4>
              </div>
            </div>
      </div>
    </div>
  <div class="right-grid">
    <div class="top-expenses-container">
        <h4>Expense Breakdown</h4>
          <ul>
            <?php foreach ($expenseCategories as $expense): ?>
                <li>
                    <span class="expense-category"><?= htmlspecialchars($expense['category_name']) ?></span>
                    <span class="expense-amount">₱<?= number_format($expense['total_spent'], 2) ?></span>
                </li>
            <?php endforeach; ?>
         </ul>
    </div>
    <div class="recent-transaction-container"></div>
  </div>

</body>
</html>

