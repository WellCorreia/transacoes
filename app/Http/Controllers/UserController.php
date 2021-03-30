<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    protected UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;  
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
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $request->all();
        $response = $this->service->create($user);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $request->all();
        $response = $this->service->update($user, $id);
        return response()->json($response)->setStatusCode($response['status']);
    }

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
