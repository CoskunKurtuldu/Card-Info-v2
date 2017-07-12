<?php
/**
 * Created by PhpStorm.
 * User: gokturk
 * Date: 08.07.2017
 * Time: 12:15:19
 */

$url= "https://secure.payu.com.tr/api/card-info/v2/";
$secret="SECRET_KEY";
$arParams = array(
	"extraInfo"        => true,
	"dateTime"     => gmdate("c", time()),
	"merchant"      => 'OPU_TEST',
	"cc_cvv"        => 000,
	"cc_owner" => "Göktürk Enez",
	"exp_year" => "2018",
	"exp_month" => "12",
	"cc_number" => "4355084355084358",
);
ksort($arParams);
$hashString = "";

foreach ($arParams as $v) {
	$hashString .= strlen($v) . $v;
}
var_dump($arParams);
echo $hashString;
echo $arParams["signature"] = hash_hmac("SHA256", $hashString, $secret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));
$response = curl_exec($ch);
$curlerrcode = curl_errno($ch);
$curlerr = curl_error($ch);
if (empty($curlerr) && empty($curlerrcode)) {
	$parsedXML = @simplexml_load_string($response);
	echo "<pre>";
	print_r($response);
	echo "</pre>";
	if ($parsedXML !== FALSE) {
	echo "XML parsing is failed";
	}
}
else {
	echo "cURL error: " . $curlerr;
}
?>