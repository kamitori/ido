<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getVideo(){
    	// $html =  getList('https://aidol.asia/idol/page/1/');
    	// $list_video = extractList($html);
    	// foreach ($list_video as $key => $link) {
    	// 	# code...
    	// }
    	$link = 'https://aidol.asia/idol/lcdv/6054-lcdv-40317-shizuka-nakamura-60f.html';
    	$content = getLink($link);
    	$video = extractContent($content);
    	$video['link'] = $link;
    	dd($video);
    }
}
