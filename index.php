<?php
session_start();

// Initialize flags and hint counter if not set
if (!isset($_SESSION['flags'])) {
    $_SESSION['flags'] = [
        'flag1' => false,
        'flag2' => false,
        'flag3' => false,
        'flag4' => false,
        'flag5' => false
    ];
}

if (!isset($_SESSION['hints_used'])) {
    $_SESSION['hints_used'] = 0;
}

// Function to check if a flag is found
function checkFlag($flagNumber) {
    return isset($_SESSION['flags']['flag' . $flagNumber]) && $_SESSION['flags']['flag' . $flagNumber];
}

// Handle file inclusion
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Security check for basic LFI
$allowed_pages = ['home', 'welcome', 'about', 'config', '.hidden/flag5'];
if (!in_array($page, $allowed_pages) && strpos($page, '..') !== false) {
    die("Nice try! But that's not allowed.");
}

// Flag checking logic
if (isset($_GET['flag'])) {
    $flagNum = $_GET['flag'];
    if ($flagNum >= 1 && $flagNum <= 5) {
        $_SESSION['flags']['flag' . $flagNum] = true;
        echo "<div style='background-color: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
        echo "Congratulations! You found flag " . $flagNum . "!";
        echo "</div>";
    }
}

// Reset game
if (isset($_GET['reset'])) {
    $_SESSION['flags'] = [
        'flag1' => false,
        'flag2' => false,
        'flag3' => false,
        'flag4' => false,
        'flag5' => false
    ];
    $_SESSION['hints_used'] = 0;
    header("Location: index.php");
    exit();
}

// Handle file inclusion
if (strpos($page, 'php://') === 0 || strpos($page, 'data://') === 0) {
    // If it's a PHP wrapper, include it directly
    include($page);
} else {
    // Try to include the file from pages directory first
    $file = __DIR__ . "/pages/" . $page . ".php";
    if (file_exists($file)) {
        include($file);
    } else {
        // If not found in pages directory, try root directory
        $file = __DIR__ . "/" . $page;
        if (file_exists($file)) {
            include($file);
        } else {
            echo "File not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LFI Practice Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .flag {
            background-color: #fff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .found {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .not-found {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .hint {
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
        .hint-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 10px;
        }
        .hint-button:hover {
            background-color: #0056b3;
        }
        .hint-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .hint-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            max-width: 400px;
        }
        .hint-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
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
        .flag-value {
            font-family: monospace;
            background-color: #f8f9fa;
            padding: 5px;
            border-radius: 3px;
            margin-top: 5px;
        }
        .reset-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }
        .reset-button:hover {
            background-color: #c82333;
        }
        .hints-counter {
            color: #666;
            font-style: italic;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>LFI Practice Game</h1>
    
    <div class="nav">
        <a href="?page=home">Home</a>
        <a href="?page=welcome">Welcome</a>
        <a href="?page=about">About</a>
        <a href="?page=config">Config</a>
        <a href="game/playgame.php">Challenge Game</a>
    </div>

    <div class="hints-counter">Hints remaining: <?php echo 2 - $_SESSION['hints_used']; ?></div>
    
    <div class="flag <?php echo checkFlag(1) ? 'found' : 'not-found'; ?>">
        <h3>Flag 1</h3>
        <p>Status: <?php echo checkFlag(1) ? 'Found!' : 'Not Found'; ?></p>
        <?php if (checkFlag(1)): ?>
            <div class="flag-value">CTF{LFI_Welcome_Flag_123}</div>
        <?php endif; ?>
        <p class="hint">Scenario: You're trying to access the welcome page. The flag is hidden in the page source.</p>
        <button class="hint-button" onclick="showHint(1)" <?php echo $_SESSION['hints_used'] >= 2 ? 'disabled' : ''; ?>>Show Parameter Hint</button>
    </div>

    <div class="flag <?php echo checkFlag(2) ? 'found' : 'not-found'; ?>">
        <h3>Flag 2</h3>
        <p>Status: <?php echo checkFlag(2) ? 'Found!' : 'Not Found'; ?></p>
        <?php if (checkFlag(2)): ?>
            <div class="flag-value">CTF{LFI_About_Flag_456}</div>
        <?php endif; ?>
        <p class="hint">Scenario: The about page contains sensitive information. You need to find a way to view its contents.</p>
        <button class="hint-button" onclick="showHint(2)" <?php echo $_SESSION['hints_used'] >= 2 ? 'disabled' : ''; ?>>Show Parameter Hint</button>
    </div>

    <div class="flag <?php echo checkFlag(3) ? 'found' : 'not-found'; ?>">
        <h3>Flag 3</h3>
        <p>Status: <?php echo checkFlag(3) ? 'Found!' : 'Not Found'; ?></p>
        <?php if (checkFlag(3)): ?>
            <div class="flag-value">CTF{LFI_Wrapper_Flag_789}</div>
        <?php endif; ?>
        <p class="hint">Scenario: The welcome page contains a flag, but it's not visible in the normal view. You need to read its source code.</p>
        <button class="hint-button" onclick="showHint(3)" <?php echo $_SESSION['hints_used'] >= 2 ? 'disabled' : ''; ?>>Show Parameter Hint</button>
    </div>

    <div class="flag <?php echo checkFlag(4) ? 'found' : 'not-found'; ?>">
        <h3>Flag 4</h3>
        <p>Status: <?php echo checkFlag(4) ? 'Found!' : 'Not Found'; ?></p>
        <?php if (checkFlag(4)): ?>
            <div class="flag-value">CTF{LFI_Config_Flag_789}</div>
        <?php endif; ?>
        <p class="hint">Scenario: The config file contains sensitive information. You need to find a way to read its contents using a different approach.</p>
        <button class="hint-button" onclick="showHint(4)" <?php echo $_SESSION['hints_used'] >= 2 ? 'disabled' : ''; ?>>Show Parameter Hint</button>
    </div>

    <div class="flag <?php echo checkFlag(5) ? 'found' : 'not-found'; ?>">
        <h3>Flag 5</h3>
        <p>Status: <?php echo checkFlag(5) ? 'Found!' : 'Not Found'; ?></p>
        <?php if (checkFlag(5)): ?>
            <div class="flag-value">CTF{LFI_Hidden_Dir_Flag_101}</div>
        <?php endif; ?>
        <p class="hint">Scenario: There's a hidden directory containing sensitive information. Can you find a way to access it?</p>
        <button class="hint-button" onclick="showHint(5)" <?php echo $_SESSION['hints_used'] >= 2 ? 'disabled' : ''; ?>>Show Parameter Hint</button>
    </div>

    <div class="hint-overlay" id="hintOverlay"></div>
    <div class="hint-popup" id="hintPopup">
        <span class="close-button" onclick="closeHint()">&times;</span>
        <div id="hintContent"></div>
    </div>

    <button class="reset-button" onclick="window.location.href='?reset=1'">Reset Game</button>

    <script>
        const hints = {
            1: "The 'page' parameter controls which file is included. Try different values to find the flag.",
            2: "Sometimes you need to look at the page source to find hidden information.",
            3: "PHP has special wrappers that can help you read file contents. Try 'php://filter'.",
            4: "The 'data://' wrapper can be used to include files in a different way.",
            5: "Hidden directories can be accessed using the 'page' parameter with the correct path."
        };

        let hintsUsed = <?php echo $_SESSION['hints_used']; ?>;
        const maxHints = 2;

        function showHint(flagNum) {
            if (hintsUsed >= maxHints) {
                alert("You've used all your hints! Use the reset button to start over.");
                return;
            }

            // Show the hint
            document.getElementById('hintContent').innerHTML = hints[flagNum];
            document.getElementById('hintOverlay').style.display = 'block';
            document.getElementById('hintPopup').style.display = 'block';

            // Increment hint counter
            hintsUsed++;
            
            // Update the counter display
            document.querySelector('.hints-counter').textContent = `Hints remaining: ${maxHints - hintsUsed}`;
            
            // Disable all hint buttons if we've used all hints
            if (hintsUsed >= maxHints) {
                document.querySelectorAll('.hint-button').forEach(button => {
                    button.disabled = true;
                    button.style.backgroundColor = '#cccccc';
                    button.style.cursor = 'not-allowed';
                });
            }

            // Send request to update server-side counter
            fetch('increment_hints.php')
                .catch(error => {
                    console.error('Error updating hint counter:', error);
                    alert('Error updating hint counter. Please refresh the page.');
                });
        }

        function closeHint() {
            document.getElementById('hintOverlay').style.display = 'none';
            document.getElementById('hintPopup').style.display = 'none';
        }

        // Close popup when clicking overlay
        document.getElementById('hintOverlay').onclick = closeHint;

        // Close popup when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeHint();
            }
        });
    </script>
</body>
</html>
