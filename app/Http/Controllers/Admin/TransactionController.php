<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Admin\Orders\OrderService;
use App\Services\Admin\Transaction\TransactionService;
use App\Services\Admin\User\UserService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $userService;
    private $transactioService;
    private $orderService;

    /**
     * TransactionController constructor.
     * @param $userService
     * @param $tramactioService
     * @param $orderService
     */
    public function __construct(UserService $userService,TransactionService $transactioService,OrderService $orderService)
    {
        $this->userService = $userService;
        $this->tranactioService = $transactioService;
        $this->orderService = $orderService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTransactionByUser($id)
    {
        $user=$this->userService->getUserById($id);
        $transactions=$this->tranactioService->getTransactionByUser($id);

        return view('admin.customs.transactions',compact(['user','transactions']));
    }


}
