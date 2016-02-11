
<?php


curl_setopt_array($ch = curl_init(), array(
  CURLOPT_URL => "https://api.pushover.net/1/messages.json",
  CURLOPT_POSTFIELDS => array(
    "token" => "aY1LCn9N42G7XVWWBQoYhfnqfDWN21",
    "user" => "urx2HjhSFfhpensycMVsCyugF7dDTF",
    "message" => "hello world via vectronics website.   ASDLKHALSDHLASHDLKAHSDLHALSHDasd;ja;sdj;ajsd;ajs;ldjasjld;lajs;dja;jsd",
  ),
  CURLOPT_SAFE_UPLOAD => true,
));
curl_exec($ch);
curl_close($ch);


?>