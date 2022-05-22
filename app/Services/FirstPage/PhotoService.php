<?php


namespace App\Services\FirstPage;


class PhotoService
{
    public function photoSearch()
    {
        $photoSearch=\App\Models\Photo::where('picable_type',"searchphoto")->first();
        return isset($photoSearch)?$photoSearch:"notfound";
}
}
