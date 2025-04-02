<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Initialize game state if not set
if (!isset($_SESSION['game_state'])) {
    $_SESSION['game_state'] = [
        'current_level' => 1,
        'completed_levels' => [],
        'start_time' => time()
    ];
}

// Handle flag submission
if (isset($_POST['flag'])) {
    $submitted_flag = trim($_POST['flag']);
    $current_level = $_SESSION['game_state']['current_level'];
    
    // Check if flag is correct
    $correct_flags = [
        1 => 'CTF{LFI_Challenge_Level_1}',
        2 => 'CTF{LFI_Challenge_Level_2}',
        3 => 'CTF{LFI_Challenge_Level_3}',
        4 => 'CTF{LFI_Challenge_Level_4}',
        5 => 'CTF{LFI_Challenge_Level_5}'
    ];
    
    if (isset($correct_flags[$current_level]) && $submitted_flag === $correct_flags[$current_level]) {
        $_SESSION['game_state']['completed_levels'][$current_level] = true;
        $_SESSION['game_state']['current_level'] = $current_level + 1;
        $success_message = "Correct! Moving to next level...";
    } else {
        $error_message = "Incorrect flag. Try again!";
    }
}

// Handle reset
if (isset($_GET['reset'])) {
    $_SESSION['game_state'] = [
        'current_level' => 1,
        'completed_levels' => [],
        'start_time' => time()
    ];
    header("Location: playgame.php");
    exit();
}

// Basic security check - only prevent directory traversal
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if (strpos($page, '..') !== false) {
        die("Nice try! But that's not allowed.");
    }
    
    // For Level 2 and 3, enforce using the base64 wrapper
    if (($page === 'backup/flag2' || $page === '.hidden/flag3') && strpos($page, 'php://filter/convert.base64-encode/resource=') === false) {
        die("For this level, you must use the PHP base64 wrapper to read the file!");
    }
    
    // For Level 4 and 5, enforce using the data wrapper
    if (($page === 'config/flag4' || $page === 'logs/flag5') && strpos($page, 'data://text/plain;base64,') === false) {
        die("For this level, you must use the data:// wrapper to read the file!");
    }
    
    // If it's a PHP wrapper, include it directly
    if (strpos($page, 'php://') === 0 || strpos($page, 'data://') === 0) {
        include($page);
    } else {
        // Try to include the file
        $file = "levels/" . $page . ".php";
        if (file_exists($file)) {
            include($file);
        } else {
            // If it's not a level file, try to include it directly
            // This allows reading flag files
            $file = "levels/" . $page;
            if (file_exists($file)) {
                include($file);
            } else {
                echo "File not found!";
            }
        }
    }
} else {
    // Default welcome page
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>LFI Challenge Game</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f0f0f0;
            }
            .welcome-message, .scenario {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }
            .flag-form {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                margin-top: 20px;
            }
            .flag-input {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 3px;
            }
            .submit-button {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 3px;
                cursor: pointer;
            }
            .submit-button:hover {
                background-color: #0056b3;
            }
            .success-message {
                color: #28a745;
                margin: 10px 0;
            }
            .error-message {
                color: #dc3545;
                margin: 10px 0;
            }
            .nav {
                background-color: #fff;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .nav a {
                color: #007bff;
                text-decoration: none;
                margin-right: 15px;
            }
            .nav a:hover {
                text-decoration: underline;
            }
            .reset-button {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 3px;
                cursor: pointer;
                margin-top: 20px;
            }
            .reset-button:hover {
                background-color: #c82333;
            }
            .level-title {
                font-size: 1.2em;
                color: #007bff;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="nav">
            <a href="?page=level1">Level 1</a>
            <a href="?page=level2">Level 2</a>
            <a href="?page=level3">Level 3</a>
            <a href="?page=level4">Level 4</a>
            <a href="?page=level5">Level 5</a>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="welcome-message">
            <h2>Welcome to LFI Challenge!</h2>
            <p>This is a scenario-based Local File Inclusion practice environment.</p>
            <p>Each level presents a different scenario where you need to find and read a flag file.</p>
            <p>Current Level: <?php echo $_SESSION['game_state']['current_level']; ?></p>
            <p>Available levels:</p>
            <ul>
                <li><a href="?page=level1">Level 1: The Secret File</a></li>
                <li><a href="?page=level2">Level 2: The Backup File</a></li>
                <li><a href="?page=level3">Level 3: The Hidden Directory</a></li>
                <li><a href="?page=level4">Level 4: The Config File</a></li>
                <li><a href="?page=level5">Level 5: The Log File</a></li>
            </ul>
        </div>

        <div class="flag-form">
            <h3>Submit Flag</h3>
            <div class="level-title">Level <?php echo $_SESSION['game_state']['current_level']; ?> Flag</div>
            <form method="POST">
                <input type="text" name="flag" class="flag-input" placeholder="Enter Level <?php echo $_SESSION['game_state']['current_level']; ?> flag here..." required>
                <button type="submit" class="submit-button">Submit Level <?php echo $_SESSION['game_state']['current_level']; ?> Flag</button>
            </form>
        </div>

        <button class="reset-button" onclick="window.location.href='?reset=1'">Reset Game</button>
    </body>
    </html>
    <?php
}
?>
