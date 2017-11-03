<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Intervention\Image\Facades\Image;

class GetVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get All Video';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0);
        $index = 1;
        $start = 4;
        $end = 20;
        echo "\n\n<=== Starting ===>\n\n";
        try{
            for($i=$start; $i<=$end; $i++){
                if($i>1){
                    $html =  getList('https://aidol.asia/idol/page/'.$i.'/');
                }else{
                    $html =  getList('https://aidol.asia/idol/');
                }
                
                $list_video = extractList($html);
                foreach ($list_video as $key => $link) {
                    $check = Video::where('link','=',$link)->first();
                    if(!$check){
                        $content = getLink($link);
                        $video = extractContent($content);
                        $video['link'] = $link;
                        $vid = new Video();
                        $vid->name      = $video['name'];     
                        $vid->link      = $video['link'];     
                        $vid->download1 = $video['download1'];
                        $vid->download2 = $video['download2'];
                        $vid->code      = $video['code'];     
                        $vid->size      = $video['size'];     
                        $vid->time      = $video['time'];     
                        $vid->file      = $video['file'];     
                        $vid->released  = $video['released']; 
                        $vid->width     = $video['width'];    
                        $vid->studio    = $video['studio'];   
                        $vid->actors    = $video['actors']; 
                        $path_image = public_path().'/upload/images/';
                        if(!\File::exists($path_image)) {
                            \File::makeDirectory($path_image, $mode = 0777, true, true);
                        }
                        $filename_image = $video['code'].'.'.pathinfo($video['image'], PATHINFO_EXTENSION);
                        \Image::make($video['image'])->save($path_image.$filename_image);

                        $path_preview = public_path().'/upload/previews/';
                        if(!\File::exists($path_preview)) {
                            \File::makeDirectory($path_preview, $mode = 0777, true, true);
                        }
                        $filename_preview = $video['code'].'.'.pathinfo($video['preview'], PATHINFO_EXTENSION);
                        \Image::make($video['preview'])->save($path_preview.$filename_preview);
                        $vid->image     = '/upload/images/'.$filename_image;
                        $vid->preview   = '/upload/previews/'.$filename_preview;
                        $vid->save();
                        echo "\t--".$index."\t".$video['code']."\n";
                        sleep(rand(10,20));
                    }else{
                         echo "\t--".$index."\t".$check['code']." [<=====>]\n";
                    }
                    $index++;
                }
                echo "\n\n<=== Done page ".$i."===>\n\n";
            }
        }catch(\Exception $e){
            throw $e;
        }
    }
}
