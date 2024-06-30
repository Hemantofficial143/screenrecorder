<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Recording\Helper;
use Illuminate\Support\Facades\URL;



class Recording extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'recording_id';

    protected $appends = ['link','days_passed','thumb_path'];
    protected $helper;

    public function __construct(){
        parent::__construct();
        $this->helper = new Helper();
    }

    public function getLinkAttribute(){

        return Storage::disk('recordings')->url($this->name);
    }
    public function getThumbPathAttribute(){
        return Storage::disk('thumbs')->url($this->thumb);
    }


    public function getDaysPassedAttribute(){
        return $this->helper->dateFormat($this->created_at,'days_passed');
    }



    public function list($data){
        $authUser = $this->helper->authUser();
        $recordings = $this::where('user_id',$authUser->user_id)->orderBy('created_at','DESC')->get();
        return $recordings;

    }


    public function saveRecord($data){
        $authUser = $this->helper->authUser();
        $recording = new $this();
        $recording->user_id = $authUser->user_id;
        $recording->name = $data['name'];
        $recording->thumb = $data['thumb'];
        $recording->extension = $data['extension'];
        $recording->size = $data['size'];
        $recording->save();
        return $recording;
    }


}
