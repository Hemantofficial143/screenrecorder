<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Helpers\BaseHelper;
use Illuminate\Support\Facades\Storage;

class VideoService{

    protected $helper;

    public function __construct(){
        $this->helper = new BaseHelper();
    }

    public function convertAndSaveVideo($file,$disk){
        // $ffmpeg = \FFMpeg\FFMpeg::create();
        // $video = $ffmpeg->open($file);
        // $format = new \FFMpeg\Format\Video\X264();
        // $format->setAudioCodec("libmp3lame");
        // $fileName = Str::random(10).'.mp4';
        // $video->save($format, $this->helper->getFilePath($disk,'').$fileName);

        $fileName = Storage::disk($disk)->put('',$file);
        return $fileName;
    }

    public function saveVideoThumb($fileName,$disk,$fromDisk){
        try{
            $videoUrl = $this->helper->getFilePath($fromDisk,$fileName);
            $thumbName = explode('.',$fileName)[0].'.png';
            $storageUrl = $this->helper->getFilePath($disk,'');
            \VideoThumbnail::createThumbnail(
                $videoUrl,
                $storageUrl,
                $thumbName,
                1
            );
            return $thumbName;
        }catch (\Exception $e){
            return "";
        }
    }





}
