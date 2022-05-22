<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Date;
use Nette\Utils\DateTime;

class IsdateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $bargasht=explode('-',$value);
        $date=Date::create($bargasht[0],$bargasht[1],$bargasht[2])->format('Y/m/d');
        $datetime=DateTime::createFromFormat('Y/m/d',$date);

        if ($datetime==false){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'اشکالی در تاریخ وجود دارد.';
    }
}
