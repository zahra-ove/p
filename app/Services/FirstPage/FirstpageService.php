<?php


namespace App\Services\FirstPage;



use App\Models\About;
use App\Models\Contact;
use App\Models\Photo;

use App\Models\Room;
use App\Models\Roompick;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FirstpageService
{

    public function setRoomPick($order,$roomId,$path)
    {
        $roompick= new Roompick();
        $roompick->order=$order;
        $roompick->room_id=$roomId;
        $room=Room::with('pansion')->find($roomId);
        $roompick->city_id=$room->pansion->city_id;
        $roompick->path=$path;
        if ($roompick->save()){
            return 'ok';
        }
        else{
            return 'notfound';
        }
}


    public function getAllRoomPick()
    {
        $roompick=Roompick::all();
        return count($roompick)!=0?$roompick:'notfound';
}
    public function getFirstSlider()
    {
        $slider=Slider::with('photo')->first();
        return isset($slider)?$slider:'notfound';
    }
    public function setSlider($title,$passage,$file)
    {
       $slider=Slider::with('photo')->first();
       if (isset($slider)){
           $slider->title=$title;
           $slider->passage=$passage;
       }
       else{
           $slider=new Slider();
           $slider->title=$title;
           $slider->passage=$passage;
       }
       DB::beginTransaction();
       if ($slider->save()){
           if ($file!=null) {
               $slider->photo()->delete();
               $photo = new Photo();
               $photo->picable_id = $slider->id;
               $photo->picable_type = "App\Models\Slider";
               $filename = $file->getClientOriginalName();
               $path = 'storage/images/slider/' . $filename;
               $photo->path = $path;
               $photo->pick = '0';
               $photo->save();
               $file->storeAs('public/images/slider/', $filename);
           }
           DB::commit();
           return 'ok';
       }
       else{
           DB::rollBack();
           return 'notfound';
       }
}
    public function getFirstAbout()
    {
        $about=About::with('photo')->first();
        return isset($about)?$about:'notfound';
    }
    public function setAbout($about_us,$about_boss,$boss_name,$file)
    {
       $about=About::with('photo')->first();
       if (isset($about)){
           $about->about_us=$about_us;
           $about->about_boss=$about_boss;
           $about->boss_name=$boss_name;
       }
       else{
           $about=new About();
           $about->about_us=$about_us;
           $about->about_boss=$about_boss;
           $about->boss_name=$boss_name;

       }
       DB::beginTransaction();
       if ($about->save()){
           if ($file!=null) {
               $about->photo()->delete();
               $photo = new Photo();
               $photo->picable_id = $about->id;
               $photo->picable_type = "App\Models\About";
               $filename = $file->getClientOriginalName();
               $path = 'storage/images/about/' . $filename;
               $photo->path = $path;
               $photo->pick = '0';
               $photo->save();
               $file->storeAs('public/images/about/', $filename);
           }
           DB::commit();
           return 'ok';
       }
       else{
           DB::rollBack();
           return 'notfound';
       }
}
    public function setContact($phone,$address,$email)
    {
       $contact=Contact::first();
       if (isset($contact)){
           $contact->phone=$phone;
           $contact->address=$address;
           $contact->email=$email;
       }
       else{
           $contact=new Contact();
           $contact->phone=$phone;
           $contact->address=$address;
           $contact->email=$email;

       }
       DB::beginTransaction();
       if ($contact->save()){

           DB::commit();
           return 'ok';
       }
       else{
           DB::rollBack();
           return 'notfound';
       }
}
    public function getFirstContact()
    {
        $contact=Contact::first();
        return isset($contact)?$contact:'notfound';
    }
}
