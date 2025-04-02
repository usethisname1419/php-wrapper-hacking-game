<?php
echo "<h1>PHP Wrapper LFI Practice</h1>";
echo "<p>Practice using different PHP wrappers to retrieve flags.</p>";

// Flag 1: php://input (POST input)
echo "<h2>Flag 1: Use php://input</h2>";
echo "<p>Hint: Use the php://input wrapper to read from POST input stream.</p>";
echo "<form method='POST' action=''>";
echo "<label for='flag1'>Enter Flag 1:</label>";
echo "<input type='text' id='flag1' name='flag1' required><br><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if (isset($_POST['flag1']) && $_POST['flag1'] === 'CorrectFlag1') {
    echo "<p>Correct! You've retrieved Flag 1.</p>";
} else {
    echo "<p>Incorrect! Try again for Flag 1.</p>";
}

// Flag 2: php://filter (base64 encode/decode)
echo "<h2>Flag 2: Use php://filter</h2>";
echo "<p>Hint: Use php://filter with base64 encoding/decoding to access the file content.</p>";
echo "<form method='POST' action=''>";
echo "<label for='flag2'>Enter Flag 2:</label>";
echo "<input type='text' id='flag2' name='flag2' required><br><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if (isset($_POST['flag2']) && $_POST['flag2'] === 'CorrectFlag2') {
    echo "<p>Correct! You've retrieved Flag 2.</p>";
} else {
    echo "<p>Incorrect! Try again for Flag 2.</p>";
}

// Flag 3: php://memory
echo "<h2>Flag 3: Use php://memory</h2>";
echo "<p>Hint: Use php://memory to access a text stored in memory.</p>";
echo "<form method='POST' action=''>";
echo "<label for='flag3'>Enter Flag 3:</label>";
echo "<input type='text' id='flag3' name='flag3' required><br><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if (isset($_POST['flag3']) && $_POST['flag3'] === 'CorrectFlag3') {
    echo "<p>Correct! You've retrieved Flag 3.</p>";
} else {
    echo "<p>Incorrect! Try again for Flag 3.</p>";
}

// Flag 4: php://device
echo "<h2>Flag 4: Use php://device</h2>";
echo "<p>Hint: Use php://device to access a system device or file.</p>";
echo "<form method='POST' action=''>";
echo "<label for='flag4'>Enter Flag 4:</label>";
echo "<input type='text' id='flag4' name='flag4' required><br><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if (isset($_POST['flag4']) && $_POST['flag4'] === 'CorrectFlag4') {
    echo "<p>Correct! You've retrieved Flag 4.</p>";
} else {
    echo "<p>Incorrect! Try again for Flag 4.</p>";
}

// Flag 5: php://stdin
echo "<h2>Flag 5: Use php://stdin</h2>";
echo "<p>Hint: Use php://stdin to read input from a file.</p>";
echo "<form method='POST' action=''>";
echo "<label for='flag5'>Enter Flag 5:</label>";
echo "<input type='text' id='flag5' name='flag5' required><br><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if (isset($_POST['flag5']) && $_POST['flag5'] === 'CorrectFlag5') {
    echo "<p>Correct! You've retrieved Flag 5.</p>";
} else {
    echo "<p>Incorrect! Try again for Flag 5.</p>";
}
?>
