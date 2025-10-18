<?php
include("goal_processes.php");
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

  <div class="search-bar">
    <img src="https://img.icons8.com/ios-filled/24/search--v1.png" alt="search icon">
    <input type="search" placeholder="Search...">
  </div>

 <div class="progress">
  <h4 class="progress_title">Goal Progress</h4>
  <div class="progress1">
    <div class="progress-content">
        <img src="<?php echo $goal_image; ?>" alt="Goal Image" class="goal-image">
        <h4 class="goal-title"><?php echo htmlspecialchars($title); ?></h4>

      <div class="progress-bar-container">
        <div class="progress-bar" style="width: <?php echo (float)$progress; ?>%;"></div>
      </div>

      <p class="progress-percent">
        <?php echo number_format($progress, 1); ?>% Completed
      </p>
    </div>
  </div>
</div>

  <div class="allowance">
    <h4 class="allowance_title">Allowance Overview</h4>
    <div class="allowance1"></div>
  </div>

  <div class="spending">
    <div class="spending1">Spending Rate</div>
  </div>

  <div class="top">
    <div class="top1">Top Expenses</div>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar">
    <nav class="menu">
      <a href="dashboard.php" class="active">🏠 Overview</a>
      <a href="transactions.php">💳 Transactions</a>
      <a href="goals.php">🎯 Goals</a>
      <a href="#">🗓️ Planner</a>
      <a href="#">⏰ Reminders</a>
      <hr>
      <a href="#">⚙️ Settings</a>
      <a href="#">🚪 Logout</a>
    </nav>
  </aside>

  <div class="chart-wrapper">
    <canvas class="myChart"></canvas>
    <div class="chart">chart</div>
  </div>

  <div class="transac-wrapper">
    <div class="transac">Recent Transactions</div>
  </div>

  <div class="profile-wrapper">
    <div class="profile-area">
      <img src="https://img.icons8.com/ios-filled/50/user-male-circle.png" alt="Profile">
      <p class="name">Profile</p>
    </div>
  </div> 

  <div class="budget-wrapper">
    <div class="budget">Budget Health</div>
  </div>

  <div class="bills-wrapper">
    <div class="bills">Upcoming Bills</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="main.js"></script>
</body>
</html>
