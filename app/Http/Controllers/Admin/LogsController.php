<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlloggiatiwebLog;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $query = AlloggiatiwebLog::with('booking');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $logs = $query->orderBy('sent_at', 'desc')->paginate(30);

        return view('admin.logs.index', compact('logs'));
    }
}
