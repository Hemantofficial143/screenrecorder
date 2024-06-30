<?php

namespace App\Helpers\Recording;
use App\Helpers\BaseHelper;

class Helper extends BaseHelper{
    public function authUser(){
        return \Auth::user();
    }
}
