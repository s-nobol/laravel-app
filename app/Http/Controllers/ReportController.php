<?php

namespace App\Http\Controllers;

use App\Report;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    //  通報モデルは記事の削除と同時に削除したい
    public function index()
    {
        //
        return Report::all();
    }

    public function store(ReportRequest $request)
    {
        //
        Report::create($request->all());
        return "通報した";
    }

    public function show(Report $report)
    {
        //
    }
    
    
    public function destroy(Report $report)
    {
        //
        $report->delete();
        return "削除";
    }
}
