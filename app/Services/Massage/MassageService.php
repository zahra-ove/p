<?php


namespace App\Services\Massage;


use App\Models\Massage;
use Illuminate\Database\Eloquent\Model;

class MassageService
{
    public function getFirstMassage()
    {
        $massage=Massage::first();
        return isset($massage)!=null?$massage:'notfound';
    }
    public function fivedaysorderSetting($fiveDaysOrder)
    {
        $massage=Massage::first();
        if (isset($massage)){
            $massage->fivedaysorder=$fiveDaysOrder;

        }
        else{
            $massage=new Massage();
            $massage->fivedaysorder=$fiveDaysOrder;

        }
        if ($massage->save()){
return 'ok';
        }
        else {
            return 'notfound';
        }
    }

    public function threedaysqestSetting($threeDaysQest)
    {
        $massage=Massage::first();
        if (isset($massage)){
            $massage->threedaysqest=$threeDaysQest;
        }
        else{
            $massage=new Massage();
            $massage->threedaysqest=$threeDaysQest;
        }
        if ($massage->save()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

    public function fivedayssoonSetting($fiveDaysSoon)
    {
        $massage=Massage::first();
        if (isset($massage)){
            $massage->fivedayssoon=$fiveDaysSoon;
        }
        else{
            $massage=new Massage();

            $massage->fivedayssoon=$fiveDaysSoon;
        }
        if ($massage->save()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
    }

}
