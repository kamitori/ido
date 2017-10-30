<?php

function pr($array) {
	echo "<pre>";
	print_r($array);
	echo "<pre/>";
}

function get_headers_from_curl_response($response)
{
  $headers = array();

  $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

  foreach (explode("\r\n", $header_text) as $i => $line)
      if ($i === 0)
          $headers['http_code'] = $line;
      else
      {
          list ($key, $value) = explode(': ', $line);

          $headers[$key] = $value;
      }

  return $headers;	
}

function getList($link){
	$ch = curl_init($link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0',
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'));
  $response = curl_exec($ch);
  curl_close($ch);
  $d = new \DOMDocument();
  @$d->loadHTML($response);
  return $d;
}

function extractList($html){
  $html_result = new \DOMXPath($html);
  $lists = $html_result->query('//div[@class="news-text clearfix"]/a[@class="fulllink"]/attribute::href');
  $arrReturn = [];
  foreach ($lists as $k => $item) {
  	$arrReturn[] = $item->nodeValue;
  }
  return $arrReturn;
}

function getLink($link){
	$ch = curl_init($link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0',
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'));
  $response = curl_exec($ch);
  curl_close($ch);
  $d = new \DOMDocument();
  @$d->loadHTML($response);
  return $d;
}

function getLinkFollow($link){
	$ch = curl_init($link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_HEADER, TRUE);
  curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0',
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'));
  $response = curl_exec($ch);
  curl_close($ch);
  $header = get_headers_from_curl_response($response);
  return $header['Location'];
}

function extractContent($html){
	$arrReturn = [];
	$arrReturn['name']	    =	'';
	$arrReturn['link']	    =	'';
	$arrReturn['download1']	=	'';
	$arrReturn['download2']	=	'';
	$arrReturn['image']	    =	'';
	$arrReturn['preview']	  =	'';
	$arrReturn['code']	    =	'';
	$arrReturn['size']	    =	'';
	$arrReturn['time']	    =	'';
	$arrReturn['file']	    =	'';
	$arrReturn['released']	=	'';
	$arrReturn['width']	    =	'';
	$arrReturn['studio']	  =	'';
	$arrReturn['actors']	  =	'';
  $html_result = new \DOMXPath($html);

  $arrReturn['name'] = $html_result->query('//meta[@property="og:title"]/attribute::content')->item(0)->nodeValue;
  // $arrReturn = [];
  // foreach ($lists as $k => $item) {
  // 	$arrReturn[] = $item->nodeValue;
  // }
  return $arrReturn;
}