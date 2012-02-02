<?php
require_once('lib/squeeks-Pusher-PHP/lib/Pusher.php');
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
$options = sanitise_input($chat_info);

$activity = new Activity('chat-message', $options['text'], $options);

$pusher = new Pusher(APP_KEY, APP_SECRET, APP_ID);
$data = $activity->getMessage();
$response = $pusher->trigger($channel_name, 'chat_message', $data, null, true);

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

$result = array('activity' => $data, 'pusherResponse' => $response);
echo(json_encode($result));

function get_channel_name($http_referer) {
  // not allowed :, / % #
  $pattern = "/(\W)+/";
  $channel_name = preg_replace($pattern, '-', $http_referer);
  return $channel_name;
}

function sanitise_input($chat_info) {
  $email = isset($chat_info['email'])?$chat_info['email']:'';
  
  $options = array();
  $options['displayName'] = substr(htmlspecialchars($chat_info['nickname']), 0, 30);
  $options['text'] = substr(htmlspecialchars($chat_info['text']), 0, 300);
  $options['email'] = substr(htmlspecialchars($email), 0, 100);
  $options['get_gravatar'] = true;
  return $options;
}
?>