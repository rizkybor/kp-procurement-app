<?php

namespace App\Http\Controllers;

use App\Models\OrderCommunication;
use Illuminate\Http\Request;

class OrderCommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.work-request.work-request-details.order-communication.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderCommunication $orderCommunication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderCommunication $orderCommunication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderCommunication $orderCommunication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderCommunication $orderCommunication)
    {
        //
    }
}
