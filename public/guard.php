<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$cookie = trim($_POST['cookie']);
if (!$cookie) {
    echo "No cookie provided.";
    exit;
}

// 1) Fetch the “protect” form
$ch = curl_init('https://mbasic.facebook.com/profile/pic/protect/?source=timeline');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTPHEADER => [
        "Cookie: $cookie",
        "User-Agent: Mozilla/5.0 (Linux; Android 10) AppleWebKit/537.36 Chrome/86.0.4240.198 Mobile Safari/537.36"
    ]
]);
$html = curl_exec($ch);
curl_close($ch);

// 2) Parse the form’s action URL and hidden inputs
if (!preg_match('#<form.*?action="([^"]+)".*?</form>#s', $html, $m)) {
    echo "Could not find the guard form. Is your cookie valid?";
    exit;
}
$action = html_entity_decode($m[1]);

// pull out all <input name="…" value="…">
preg_match_all('#<input[^>]+name="([^"]+)"[^>]+value="([^"]*)"[^>]*>#', $html, $inputs, PREG_SET_ORDER);

$postFields = [];
foreach ($inputs as $i) {
    $postFields[$i[1]] = $i[2];
}

// 3) Submit the guard‐enable request
$ch = curl_init('https://mbasic.facebook.com' . $action);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($postFields),
    CURLOPT_HTTPHEADER => [
        "Cookie: $cookie",
        "User-Agent: Mozilla/5.0 (Linux; Android 10)"
    ]
]);
$response = curl_exec($ch);
curl_close($ch);

// 4) Check for success
if (strpos($response, 'Profile picture guard is now enabled') !== false
    || strpos($response, 'Changés successfully') !== false) {
    echo "<p style='color:green;'>✅ Profile picture guard enabled!</p>";
} else {
    echo "<p style='color:red;'>❌ Failed to enable guard. Please verify your cookie.</p>";
}
