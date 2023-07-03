<?php
require_once '../config/config.php';

// Access database configuration constants
$dbHost = DB_HOST;
$dbPort = DB_PORT;
$dbName = DB_NAME;
$dbUser = DB_USER;
$dbPass = DB_PASSWORD;

// Create a PDO instance
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle incoming requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all users
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($users);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new user
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);

    // Return success message
    echo "User created successfully!";
} else {
    // Invalid request method
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
