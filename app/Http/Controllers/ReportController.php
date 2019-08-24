<?php

namespace App\Http\Controllers;

use App\Report;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
     
    public function __construct()
    {
        $this->middleware('auth'); //(ログインユーザーのみ)
    }
     
  
    public function store(ReportRequest $request)
    {
        Report::create($request->all());
        return "通報しました";
    }

    
    public function destroy(Report $report)
    {
        $report->delete();
        return "削除しました";
    }
}
