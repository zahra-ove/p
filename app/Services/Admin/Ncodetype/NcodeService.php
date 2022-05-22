<?php


namespace App\Services\Admin\Ncodetype;


use App\Models\Ncodetype;

class NcodeService
{
    public function getAllNcodetype()
    {
        $ncode=Ncodetype::all();
        return count($ncode)!=0?$ncode:'notfound';
}
}
