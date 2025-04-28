<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class WorkRequestDataTableController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    // 🛑 Hapus Cache saat ada Filtering / Searching
    if ($request->has('search') && !empty($request->search['value'])) {
      Cache::forget('work_request_datatable_' . $user->id);
    }

    $cacheKey = 'work_request_datatable_' . $user->id;
    if (Cache::has($cacheKey) && !$request->has('search')) {
      return Cache::get($cacheKey);
    }

    // ✅ Query utama
    $query = WorkRequest::query()
      ->with(['workRequestItems', 'workRequestRab', 'workRequestSignatures', 'User'])
      ->where(function ($query) use ($user) {
        $query->where('created_by', $user->id)
          ->orWhere('last_reviewers', 'LIKE', '%' . $user->role . '%'); // Cek manual LIKE
      })
      ->select('work_request.*')
      ->orderBy('deadline', 'asc');

    // ✅ Gunakan DataTables untuk proses data
    $data = DataTables::eloquent($query)
      ->addIndexColumn()

      ->addColumn('request_number', function ($row) {
        return $row->request_number ? $row->request_number : '-';
      })

      ->addColumn('work_name_request', function ($row) {
        return $row->work_name_request ? $row->work_name_request : '-';
      })

      ->addColumn('department', function ($row) {
        return $row->department ? $row->department : '-';
      })

      ->addColumn('project_title', function ($row) {
        return $row->project_title ? $row->project_title : '-';
      })

      ->addColumn('total_rab', function ($row) {
        return 'Rp ' . number_format($row->total_rab, 2, ',', '.');
      })

      // 🔍 FILTERING
      ->filterColumn('request_number', function ($query, $keyword) {
        $query->whereRaw('LOWER(request_number) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })

      ->filterColumn('work_name_request', function ($query, $keyword) {
        $query->whereRaw('LOWER(work_name_request) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })

      ->filterColumn('department', function ($query, $keyword) {
        $query->whereRaw('LOWER(department) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })

      ->filterColumn('project_title', function ($query, $keyword) {
        $query->whereRaw('LOWER(project_title) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })

      ->filterColumn('contract_number', function ($query, $keyword) {
        $query->whereRaw('LOWER(contract_number) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })

      ->filterColumn('pic', function ($query, $keyword) {
        $query->whereRaw('LOWER(pic) LIKE ?', ["%" . strtolower($keyword) . "%"]);
      })


      ->make(true);

    // 🚀 Simpan hasil query ke Redis selama 1 jam (hanya jika tidak ada pencarian)
    if (!$request->has('search')) {
      Cache::put($cacheKey, $data, 3600);
    }

    return $data;
  }

  /**
   * Hapus cache saat data berubah (Insert, Update, Delete)
   */
  public function clearCache()
  {
    $user = Auth::user();
    Cache::forget('work_request_datatable_' . $user->id);
  }
}
