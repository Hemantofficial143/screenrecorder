<?php

namespace App\Helpers;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BaseHelper{
    public function authUser(){
        return \Auth::user();
    }

    public function dateFormat($date,$formatValue){
        $date = \Carbon\Carbon::parse($date);
        switch($formatValue){
            case 'days_passed':
                if ($date->isToday()) {
                    $date = "Today at ".$date->format('h:i A');
                }else{
                    $date = Carbon::parse($date)->toDateString().' 00:00:00';
                    $nowDate = Carbon::now()->toDateString().' 00:00:00';
                    $dayDiff = Carbon::parse($date)->diffInDays(Carbon::parse($nowDate));
                    $date = $dayDiff." day".($dayDiff > 1 ? 's' : '')." ago";
                }
            break;
            default:
                $date = $date->toDateTimeString();
            break;
        }
        return $date;
    }

    public function getFilePath($disk,$fileName){
        return Storage::disk($disk)->path($fileName);
    }

}
