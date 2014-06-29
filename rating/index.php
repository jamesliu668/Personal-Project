<?php
	echo getUserIP()."";echo "<br/>";
	echo $_SERVER['REMOTE_ADDR'];echo "<br/>";
echo $_SERVER['HTTP_REFERER'];echo "<br/>";
echo $_SERVER['HTTP_USER_AGENT'];echo "<br/>";
echo get_browser(null, true);echo "<br/>";
echo mt_rand_str(10);
	
function mt_rand_str ($length, $c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
	$randomString = "";
	for($i = 0; $i < $length; $i++)
	{
		$randomString .= $c[mt_rand(0, strlen($c)-1)];
	}
    return $randomString;
}
	
	
	
	function getUserIP() {
        $alt_ip = $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $alt_ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            // make sure we dont pick up an internal IP defined by RFC1918
            foreach ($matches[0] AS $ip) {
                if (!preg_match("#^(10|172\.16|192\.168)\.#", $ip)) {
                    $alt_ip = $ip;
                    break;
                }
            }
        } else if (isset($_SERVER['HTTP_FROM'])) {
            $alt_ip = $_SERVER['HTTP_FROM'];
        }

        return $alt_ip;
    }
?>