<?php
define('ARR_HEADER', 
[
  ['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'],
  // ['User-Agent: Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36'],
  // ['User-Agent: Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25'],
  // ['User-Agent: Mozilla/5.0 (MSIE 9.0; Windows NT 6.1; Trident/5.0)'],
  // ['User-Agent: Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14'],
  // ['User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:19.0) Gecko/20100101 Firefox/19.0'],
  // ['User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0'],
  // ['User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; NOKIA; Lumia 920)'],
]);

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
  curl_setopt($ch, CURLOPT_HTTPHEADER,ARR_HEADER[array_rand(ARR_HEADER)]);
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
  curl_setopt($ch, CURLOPT_HTTPHEADER,ARR_HEADER[array_rand(ARR_HEADER)]);
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
  curl_setopt($ch, CURLOPT_HTTPHEADER,ARR_HEADER[array_rand(ARR_HEADER)]);
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
  $arrReturn['image'] = 'https://aidol.asia/'.$html_result->query('//img[@itemprop="photo"]/attribute::src')->item(0)->nodeValue;
  $download1 = $html_result->query('//span[@id="full442"]/a')->item(0)->nodeValue;
  $arrReturn['download1'] = getLinkFollow($download1);
  
  $download2 = $html_result->query('//span[@id="full443"]/a')->item(0)->nodeValue;
  $arrReturn['download2'] = getLinkFollow($download2);

  $preview = $html_result->query('//span[@itemprop="thumbnail"]/a/img/attribute::src')->item(0)->nodeValue;

  $arrReturn['preview']   = str_replace('/th/', '/i/', $preview);

  $code     = $html_result->query('//span[@itemprop="episodeNumber"]')->item(0)->nodeValue;
  $size     = $html_result->query('//span[@itemprop="contentSize"]')->item(0)->nodeValue;
  $time     = $html_result->query('//span[@itemprop="duration"]')->item(0)->nodeValue;
  $file     = $html_result->query('//span[@itemprop="encodingFormat"]')->item(0)->nodeValue;
  $released = $html_result->query('//span[@itemprop="dateCreated"]/a')->item(0)->nodeValue;
  $width    = $html_result->query('//span[@itemprop="videoFrameSize"]')->item(0)->nodeValue;
  $studio   = '';
  $studio_a = $html_result->query('//span[@itemprop="keywords"]/span/a');
  foreach ($studio_a as $key => $value) {
    if($key==0){
      $studio   .= $value->nodeValue;
    }else{
      $studio   .= ','.$value->nodeValue;
    }
  }
  $actors   = '';

  $actors_a = $html_result->query('//span[@itemprop="actor"]/a');
  foreach ($actors_a as $key => $value) {
    if($key==0){
      $actors   .= $value->nodeValue;
    }else{
      $actors   .= ','.$value->nodeValue;
    }
  }

  $arrReturn['code']      =  $code;
  $arrReturn['size']      =  $size;
  $arrReturn['time']      =  $time;
  $arrReturn['file']      =  $file;
  $arrReturn['released']  =  $released;
  $arrReturn['width']     =  $width;
  $arrReturn['studio']    =  $studio;
  $arrReturn['actors']    =  $actors;
  return $arrReturn;
}