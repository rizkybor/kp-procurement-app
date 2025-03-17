<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $workRequest = WorkRequest::all();
        $workRequest = WorkRequest::with('workRequestRab')->get();


        return view('pages.work-request.index', compact('workRequest'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $monthRoman = $this->convertToRoman(date('n'));
        $year = date('Y');

        // Ambil nomor terakhir
        $lastNumber = WorkRequest::max('request_number');
        preg_match('/^(\d{4})/', $lastNumber, $matches);
        $lastNumeric = $matches[1] ?? '0010';
        $nextNumber = $lastNumber ? (intval($lastNumeric) + 10) : 10;

        // Format nomor dokumen
        $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

        $today = now()->toDateString();

        return view('pages.work-request.create', compact('numberFormat', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'work_name_request' => 'required',
            'department' => 'required',
            'project_title' => 'required',
            'project_owner' => 'required',
            'procurement_type' => 'required',
            'contract_number' => 'required',
            'request_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:request_date',
            'pic' => 'required',
            'aanwijzing' => 'required',
            'time_period' => 'nullable',
        ]);

        $monthRoman = $this->convertToRoman(date('n'));
        $year = date('Y');

        // Ambil nomor terakhir
        $lastNumber = WorkRequest::max('request_number');
        preg_match('/^(\d{4})/', $lastNumber, $matches);
        $lastNumeric = $matches[1] ?? '0010';
        $nextNumber = $lastNumber ? (intval($lastNumeric) + 10) : 10;

        // Format nomor dokumen
        $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

        $input = $request->all();
        $input['created_by'] = auth()->id();
        $input['request_number'] = $numberFormat;

        $workRequest = WorkRequest::create($input);

        return redirect()->route('work_request.work_request_items.edit', ['id' => $workRequest->id])
            ->with('success', 'Permintaan kerja berhasil diperbarui.');
    }


    /**
     * Display the specified resource.
     */
    public function show(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $workRequest = WorkRequest::find($id);

        if (!$workRequest) {
            return back()->with('error', 'Work request tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'work_name_request' => 'nullable',
            'department' => 'required',
            'project_title' => 'required',
            'project_owner' => 'required',
            'procurement_type' => 'required',
            'contract_number' => 'required',
            'request_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:request_date',
            'pic' => 'required',
            'aanwijzing' => 'required',
            'time_period' => 'nullable',
        ]);

        $workRequest->update($validatedData);

        return redirect()->route('work_request.work_request_items.edit', ['id' => $workRequest->id])
            ->with('success', 'Work request berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $workRequest = WorkRequest::find($id);
        $workRequest->delete();

        return redirect()->route('work_request.index')->with('success', 'Data berhasil dihapus!');
    }

    private function convertToRoman($month)
    {
        $romans = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        return $romans[$month - 1];
    }
}
