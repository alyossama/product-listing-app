<?php
// $servername = "db";  // Name of the database service
// $username = "user";
// $password = "root";  // Use the password defined in docker-compose.yml
// $dbname = "test-1-db";

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

use App\classes\Test;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

var_dump($_ENV['DB_HOST']);
var_dump($_ENV['DB_PASSWORD']);
var_dump($_ENV['DB_HOST']);
// // echo phpinfo();

// $db = new PDO('mysql:host=db;dbname=test-1-db','user','root');
// var_dump($db);
// echo "hello from the real project";

// var_dump(__DIR__.'../.env');

// $test = new Test();

// echo $test->name;
// $test->sayHello();
