<?php
	if ($_GET["tweet"]){
	  $tweetThis = $_GET["tweet"];
	  $oauth_consumer_key="VPyir6ReB00Q2GiPYqHMQOox8";
	  $oauth_consumer_secret="OCB8jxfUufPDUAucDPNVNFBLECwAcCy8VyC9HrlpfkzXGimP3G";
	  $oauth_nonce="279307c4a506cd89d9ae823e29cfd0a3";
	  $oauth_signature="ZYD%2BJa%2B8LPkImyg5FNOA15Sh6Xg%3D";
	  $oauth_signature_method="HMAC-SHA1";
	  $oauth_timestamp="1417486346";
	  $oauth_version="1.0";
	
	  require_once('codebird.php');
	  \Codebird\Codebird::setConsumerKey($oauth_consumer_key, $oauth_consumer_secret);
	  $cb = \Codebird\Codebird::getInstance();
	  $cb->setToken("2901661539-ZEZN6Pk1UE3lNaGlGi2S3JY1GkFpGzeaJKnRO0E", "vhPXWnMdpIexbq5sDGhqkWax5aNFaGEWqnLRQmI15e009");
	  $params = array(
					'status' => $tweetThis
		);
		$reply = $cb->statuses_update($params);
		header("Location: " . "posts.php");
  }
?>