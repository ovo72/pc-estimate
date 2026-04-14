$databaseUrl = getenv("DATABASE_URL");

$db = parse_url($databaseUrl);

$host = $db["host"];
$user = $db["user"];
$pass = $db["pass"];
$dbname = ltrim($db["path"], "/");

$conn = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $pass
);
