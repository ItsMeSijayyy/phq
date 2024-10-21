<?php
// Include the database connection
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the responses
    $responses = [];
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["response_$i"]) && is_numeric($_POST["response_$i"])) {
            $responses[$i] = (int) $_POST["response_$i"];
        } else {
            echo "Error: Please answer all questions.<br>";
            exit();
        }
    }

    // Calculate total score
    $total_score = array_sum($responses);

    // Determine depression level
    $depression_level = '';
    if ($total_score <= 4) {
        $depression_level = 'Minimal depression';
    } elseif ($total_score <= 9) {
        $depression_level = 'Mild depression';
    } elseif ($total_score <= 14) {
        $depression_level = 'Moderate depression';
    } elseif ($total_score <= 19) {
        $depression_level = 'Moderately severe depression';
    } else {
        $depression_level = 'Severe depression';
    }

    // User ID should be dynamically retrieved, assuming default for now
    $user_id = 1; // Replace this with dynamic user ID

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO phq9_results 
        (user_id, total_score, depression_level, response_1, response_2, response_3, response_4, response_5, response_6, response_7, response_8, response_9, response_10)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if prepare was successful
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);  // Display error if query preparation fails
    }

    // Bind parameters and execute the query
    $stmt->bind_param("iissiiiiiiii", $user_id, $total_score, $depression_level,
        $responses[1], $responses[2], $responses[3], $responses[4], $responses[5],
        $responses[6], $responses[7], $responses[8], $responses[9], $responses[10]);

    // Check if execution is successful
    if ($stmt->execute()) {
        echo "Record saved successfully!";
    } else {
        echo "Execute failed: " . $stmt->error;  // Display error if execution fails
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>