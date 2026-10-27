<?php
// 1. Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed. Please submit the form at request-form.html.");
}

// 2. Retrieve submitted values (?? avoids warnings if a value is missing)
$course        = trim($_POST["course"] ?? "");
$topic         = trim($_POST["topic"] ?? "");
$preferredDate = trim($_POST["preferreddate"] ?? "");
$preferredTime = $_POST["preferredtime"] ?? "";

// 3. Array to hold validation messages
$errors = [];

// 4. Allowed values
$allowedCourses = ["IS 6465", "IS 6495", "IS 6570"];
$allowedTimes   = ["Morning", "Afternoon", "Evening"];

// 5. Validate each value
if (!in_array($course, $allowedCourses, true)) {
    $errors["course"] = "Select a valid course.";
}

if (!in_array($preferredTime, $allowedTimes, true)) {
    $errors["preferred_time"] = "Select a valid preferred time.";
}

if ($topic === "" || mb_strlen($topic) > 120) {
    $errors["topic"] = "Enter a topic of 1 to 120 characters.";
}

date_default_timezone_set("America/Denver");
$date = DateTime::createFromFormat("Y-m-d", $preferredDate);
$validDate = $date && $date->format("Y-m-d") === $preferredDate;

if (!$validDate) {
    $errors["preferred_date"] = "Enter a valid preferred date.";
} elseif ($preferredDate < date("Y-m-d")) {
    $errors["preferred_date"] = "The preferred date cannot be in the past.";
}

// Helper to escape output safely
function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutoring Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <main class="container py-5">
        <?php if ($errors): ?>
            <!-- 6. Show errors -->
            <h1>Please fix the following</h1>
            <div class="result">
                <ul class="error-list">
                    <?php foreach ($errors as $message): ?>
                        <li><?= e($message) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a class="btn btn-outline-secondary" href="request-form.html">Back to the form</a>
            </div>
        <?php else: ?>
            <!-- 7. Confirmation -->
            <h1>Request received</h1>
            <div class="result">
                <p><strong>Course:</strong> <?= e($course) ?></p>
                <p><strong>Topic:</strong> <?= e($topic) ?></p>
                <p><strong>Preferred date:</strong> <?= e($preferredDate) ?></p>
                <p><strong>Preferred time:</strong> <?= e($preferredTime) ?></p>
                <p><strong>Status:</strong> Pending review</p>
                <a class="btn btn-outline-secondary" href="request-form.html">Submit another request</a>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>
