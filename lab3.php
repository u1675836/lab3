<?php

// 1. Indexed array
$timeSlots = ["Morning", "Afternoon", "Evening"];
echo "<h2>1. Indexed array</h2>";
echo $timeSlots[0] . "<br>";   // Morning
echo $timeSlots[2] . "<br>";   // Evening

// 2. Associative array
$request = [
    "course" => "IS 6465",
    "topic"  => "PHP arrays",
    "status" => "Pending review"
];
echo "<h2>2. Associative array</h2>";
echo "Topic: " . htmlspecialchars($request["topic"], ENT_QUOTES, "UTF-8") . "<br>";

// 3. Multidimensional array
$requests = [
    ["student" => "Amina", "course" => "IS 6465", "status" => "Pending review"],
    ["student" => "Diego", "course" => "IS 6495", "status" => "Matched"]
];
echo "<h2>3. Multidimensional array</h2>";
foreach ($requests as $r) {
    echo htmlspecialchars($r["student"], ENT_QUOTES, "UTF-8") . " - "
        . htmlspecialchars($r["course"], ENT_QUOTES, "UTF-8") . " - "
        . htmlspecialchars($r["status"], ENT_QUOTES, "UTF-8") . "<br>";
}

// 4. foreach loop that builds <option> elements
$courses = ["IS 6465", "IS 6495", "IS 6570"];
echo "<h2>4. Courses as &lt;option&gt; elements</h2>";
echo "<select>";
foreach ($courses as $course) {
    $safe = htmlspecialchars($course, ENT_QUOTES, "UTF-8");
    echo "<option value='" . $safe . "'>" . $safe . "</option>";
}
echo "</select>";

?>
