<?php

namespace App\Http\Controllers;

use App\Models\OrderCommunication;
use App\Models\WorkRequest;
use Illuminate\Http\Request;

class OrderCommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // Dapatkan work request berdasarkan ID
        $workRequests = WorkRequest::findOrFail($id);

        // Data dummy vendor 
        $vendors = [
            [
                'id' => '1',
                'name' => 'PT. Vendor Contoh 1',
                'address' => 'Jl. Contoh Alamat No. 123',
                'type' => 'Penyedia Barang'
            ],
            [
                'id' => '2',
                'name' => 'CV. Mitra Jaya',
                'address' => 'Jl. Raya Bogor No. 45',
                'type' => 'Penyedia Jasa'
            ],
            [
                'id' => '3',
                'name' => 'PT. Sumber Rejeki',
                'address' => 'Jl. Gatot Subroto No. 78',
                'type' => 'Penyedia Barang & Jasa'
            ],
            [
                'id' => '4',
                'name' => 'PT. Teknologi Maju',
                'address' => 'Jl. Sudirman No. 10',
                'type' => 'Penyedia Jasa IT'
            ],
            [
                'id' => '5',
                'name' => 'UD. Jaya Abadi',
                'address' => 'Jl. Pasar Minggu No. 25',
                'type' => 'Penyedia Barang'
            ]
        ];

        return view(
            'pages.work-request.work-request-details.order-communication.index',
            compact('workRequests', 'vendors')
        );
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
