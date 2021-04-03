<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected NotificationService $service;

    public function __construct(NotificationService $notificationService)
    {
        $this->service = $notificationService;  
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
}
