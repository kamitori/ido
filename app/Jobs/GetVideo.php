<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Video;
class GetVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // set_time_limit(0);
        // $index = 1;
        // for($i=1; $i<=86; $i++){
        //     $html =  getList('https://aidol.asia/idol/page/'.$i);
        //     $list_video = extractList($html);
        //     foreach ($list_video as $key => $link) {
        //         $content = getLink($link);
        //         $video = extractContent($content);
        //         $video['link'] = $link;
        //         $vid = new Video();
        //         $vid->name      = $video['name'];     
        //         $vid->link      = $video['link'];     
        //         $vid->download1 = $video['download1'];
        //         $vid->download2 = $video['download2'];
        //         $vid->code      = $video['code'];     
        //         $vid->size      = $video['size'];     
        //         $vid->time      = $video['time'];     
        //         $vid->file      = $video['file'];     
        //         $vid->released  = $video['released']; 
        //         $vid->width     = $video['width'];    
        //         $vid->studio    = $video['studio'];   
        //         $vid->actors    = $video['actors']; 
        //         $path_image = public_path().'/upload/images/';
        //         if(!\File::exists($path_image)) {
        //             \File::makeDirectory($path_image, $mode = 0777, true, true);
        //         }
        //         $filename_image = $video['code'].pathinfo($video['image'], PATHINFO_EXTENSION);
        //         Image::make($video['image'])->save($path_image.$filename_image);

        //         $path_preview = public_path().'/upload/previews/';
        //         if(!\File::exists($path_preview)) {
        //             \File::makeDirectory($path_preview, $mode = 0777, true, true);
        //         }
        //         $filename_preview = $video['code'].pathinfo($video['image'], PATHINFO_EXTENSION);
        //         Image::make($video['image'])->save($path_preview.$filename_preview);
        //         $vid->image     = '/upload/images/'.$file_image;
        //         $vid->preview   = '/upload/previews/'.$file_preview;
        //         $vid->save();
        //         echo "\t--".$index.'\t'.$video['code']."\n";
        //         $index++;
        //         sleep(20);
        //     }
        //     echo "\n\n<=== Done page ".$i."===>\n\n";
        // }
    }
}
