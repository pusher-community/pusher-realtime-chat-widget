<?php
require_once('../lib/squeeks-Pusher-PHP/lib/Pusher.php');
require_once('Activity.php');
require_once('config.php');

date_default_timezone_set('UTC');

$chat_info = $_POST['chat_info'];

$channel_name = null;

if( !isset($_POST['chat_info']) ){
  header("HTTP/1.0 400 Bad Request");
  echo('chat_info must be provided');
}

if( !isset($_SERVER['HTTP_REFERER']) ) {
  header("HTTP/1.0 400 Bad Request");
  echo('channel name could not be determined from HTTP_REFERER');
}

$channel_name = get_channel_name($_SERVER['HTTP_REFERER']);
$chat_info = sanitise_input($chat_info);

$activity = new Activity('chat-message', $chat_info['text'], $chat_info);

$pusher = new Pusher(APP_KEY, APP_SECRET, APP_ID);
$data = $activity->getMessage();
$response = $pusher->trigger($channel_name, 'chat_message', $data, null, true);

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
echo(json_encode($data));

function get_channel_name($http_referer) {
  // not allowed :, / % #
  $pattern = "/(\.|,|\/|\:)+/";
  $channel_name = preg_replace($pattern, '-', $http_referer);
  return $channel_name;
}

function sanitise_input($chat_info) {
  $email = isset($chat_info['email'])?$chat_info['email']:'';
  
  $data = array();
  $data['displayName'] = htmlspecialchars($chat_info['nickname']);
  $data['text'] = htmlspecialchars($chat_info['text']);
  $data['email'] = htmlspecialchars($email);
  $data['time'] = date("D F j Y H:i:s");
  return $data;
}
?>