<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Models\Recording;
use App\Helpers\Recording\Helper;
use App\Services\VideoService;


class RecordingController extends Controller
{
    protected $modelObject;
    protected $helper;
    protected $videoService;

    public function __construct(){
        $this->modelObject = new Recording();
        $this->helper = new Helper();
        $this->videoService = new VideoService();
    }


    public function index(Request $request){
        $data = $request->all();
        $recordings = $this->modelObject->list($data);


        return Inertia::render('Recording/List', [
            'recordings' => $recordings,
        ]);
    }
    public function upload(Request $request){
        try{
            $file = $request->file('recording');
            $fileName = $this->videoService->convertAndSaveVideo($file,'recordings');
            $thumb = $this->videoService->saveVideoThumb($fileName,'thumbs','recordings');
            $durationInSeconds = $this->videoService->getVideoLength($this->helper->getFilePath('recordings',$fileName));
            $recording = $this->modelObject->saveRecord([
                'blob_url' => $request->blob_url,
                'name'  => $fileName,
                'thumb' => $thumb,
                'duration' => $durationInSeconds,
                'extension' => '',
                'size' => 1,
            ]);

            return ['success' => true, 'recording' => $recording];
        }catch(Exception $e){
            return ['success' => false, 'recording' => $e->getMessage()];
        }
    }

    public function view($recording_id,Request $request){
        $recording = $this->modelObject->find($recording_id);
        return view('recording.view',['recording' => $recording]);

        return Inertia::render('Recording/See', [
            'recording' => $recording
        ]);

    }


}
