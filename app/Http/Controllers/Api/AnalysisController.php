<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Services\AnalysisService;

class AnalysisController extends Controller
{
    public function index(Request $request){
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);

        if($request->type === 'PerDay'){
            list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
            
        }

        if($request->type === 'PerMonth'){
            list($data, $labels, $totals) = AnalysisService::perMonth($subQuery);
            
        }

        if($request->type === 'PerYear'){
            list($data, $labels, $totals) = AnalysisService::perYear($subQuery);
            
        }

        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals
        ], Response::HTTP_OK);
    }
}
