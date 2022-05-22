<?php

namespace App\Exceptions;

use Exception;

class WalletException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug($this->message);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return response()->view('exceptions.WalletException',['message' => $e->getMessage()]);
    }
}
