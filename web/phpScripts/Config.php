<?php 
$url = getenv('JAWSDB_MARIA_URL');
$dbparts = parse_url($url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'],'/');

 define('DB_USERNAME',$username);
 define('DB_PASSWORD',$password);
 define('DB_NAME',$hostname);
 define('DB_HOST',$database);

//defined a new constant for firebase api key
 define('FIREBASE_API_KEY', 'AAAAEFPbhLQ:APA91bF5gGM-3_JKeDC1y-yxJB9yvpqGNONLn0MZj6TPpCwjio39swUbtju84Jq5_glh1iBq6waPMhJlvbVVnYn_JHTEaC0YVlUsYkH9Ld-gjNbleBGfVb_7zr0IYqfcr0kzGBlcbVNy');
