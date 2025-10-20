<div class="side-bar-container">
    <nav class="menu">
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">🏠 Overview</a>
        <a href="goals.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'goals.php' ? 'active' : ''; ?>">🎯 Goals</a>
        <a href="transactions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : ''; ?>">💳 Transactions</a>
        <a href="#">🗓️ Planner</a>
        <a href="#">⏰ Reminders</a>
        <hr>
        <a href="#">⚙️ Settings</a>
        <a href="#">🚪 Logout</a>
    </nav>
</div>
