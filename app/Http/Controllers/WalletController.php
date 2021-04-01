<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WalletRequest;
use App\Services\WalletService;

class WalletController extends Controller
{
    protected WalletService $service;

    public function __construct(WalletService $walletService)
    {
        $this->service = $walletService;  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $response = $this->service->findAll();
        return response()->json($response)->setStatusCode($response['status']);
    }

    //  /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  App\Http\Requests\WalletRequest  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(WalletRequest $request)
    // {
    //     $wallet = $request->all();
    //     $response = $this->service->create($wallet);
    //     return response()->json($response)->setStatusCode($response['status']);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->service->findById($id);
        return response()->json($response)->setStatusCode($response['status']);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  App\Http\Requests\WalletRequest  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(WalletRequest $request, $id)
    // {
    //     $wallet = $request->all();
    //     $response = $this->service->update($wallet, $id);
    //     return response()->json($response)->setStatusCode($response['status']);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->service->delete($id);
        return response()->json($response)->setStatusCode($response['status']);
    }
}
