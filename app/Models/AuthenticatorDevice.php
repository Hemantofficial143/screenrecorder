<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\BaseHelper as Helper;

class AuthenticatorDevice extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $primaryKey = 'authenticator_device_id';

    protected $helper;

    public function __construct(){
        parent::__construct();
        $this->helper = new Helper();
    }

    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

    public function saveRecord($data){
        $response = ['success' => false];
        $authUser = $this->helper->authUser();
        $device = new $this();
        $device->user_id = $authUser->user_id;
        $device->google2fa_secret = $data['google2fa_secret'];
        $device->save();
        $response['success'] = true;
        return $response;
    }

    public function getDevicesByUser($user_id,$count_only = false){
        $devices = new $this();
        $devices->where('user_id',$user_id);
        if($count_only){
            return $devices->count();
        }
        return $devices->get();

    }

}
