<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhoneView;
use App\ProductVisit;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ChartsController extends Controller
{
    public function index(Request $request){
        if(isset($request->type)){
            switch($request->type){
                case 'today':
                    $h = 0;
                    $phoneviews = array();
                    $productviews = array();

                    $labels = array();
                    while ($h < 24) {
                        $key = date('H:i', strtotime(date('Y-m-d') . ' + ' . $h . ' hours'));
                        $value = date('h:i A', strtotime(date('Y-m-d') . ' + ' . $h . ' hours'));
                        $phoneviews[$key] = 0;
                        $productviews[$key] = 0;
                        array_push($labels, $value);
                        $h++;
                    }
                    $phoneViews = PhoneView::where('date', '>', Carbon::now()->startOfDay())->get();
                    $productViews = ProductVisit::where('date', '>', Carbon::now()->startOfDay())->get();

                    foreach($phoneViews as $views){
                        $hour = Carbon::parse($views->date)->format('H');
                        $phoneviews[$hour.':00'] += 1;
                    }
                    foreach($productViews as $views){
                        $hour = Carbon::parse($views->date)->format('H');
                        $productviews[$hour.':00'] += 1;
                    }

                    $data['labels'] = $labels;
                    $data['data'] = [
                        'phoneviews' => array_values($phoneviews),
                        'productviews' => array_values($productviews)
                    ];
                    return response()->json($data);
                break;
                case 'daily':
                    $labels = $this->getLastNDays(7, 'd/m/Y');
                    $phoneviews = array();
                    $productviews = array();

                    foreach($labels as $date){
                        $phoneviews[$date] = 0;
                        $productviews[$date] = 0;
                    }

                    $phoneViews = PhoneView::where('date', '>=', Carbon::now()->subDays(7))->get();
                    $productViews = ProductVisit::where('date', '>', Carbon::now()->subDays(7))->get();
                    foreach($phoneViews as $views){
                        $date = Carbon::parse($views->date)->format('d/m/Y');
                        $phoneviews[$date] += 1;
                    }
                    foreach($productViews as $views){
                        $date = Carbon::parse($views->date)->format('d/m/Y');
                        $productviews[$date] += 1;
                    }

                    $data['labels'] = $labels;
                    $data['data'] = [
                        'phoneviews' => array_values($phoneviews),
                        'productviews' => array_values($productviews)
                    ];
                    return response()->json($data);
                break;

                case 'weekly': 
                    
                    $labels = $this->getLastNDays(30, 'd/m/Y');
                    $phoneviews = array();
                    $productviews = array();

                    foreach($labels as $date){
                        $phoneviews[$date] = 0;
                        $productviews[$date] = 0;
                    }
                    $phoneViews = PhoneView::where('date', '>=', Carbon::now()->subDays(30))->get();
                    $productViews = ProductVisit::where('date', '>=', Carbon::now()->subDays(30))->get();
                    foreach($phoneViews as $views){
                        $date = Carbon::parse($views->date)->format('d/m/Y');
                        $phoneviews[$date] += 1;
                    }
                    foreach($productViews as $views){
                        $date = Carbon::parse($views->date)->format('d/m/Y');
                        $productviews[$date] += 1;
                    }

                    $data['labels'] = $labels;
                    $data['data'] = [
                        'phoneviews' => array_values($phoneviews),
                        'productviews' => array_values($productviews)
                    ];
                    return response()->json($data);
                break;

                case 'monthly':
                    $start = Carbon::now()->subMonths(12);
                    $end = Carbon::now()->firstOfMonth();
                    $period = CarbonPeriod::create($start, '1 month', $end);
                    $phoneviews = array();
                    $productviews = array();

                    $labels = array();

                    foreach($period as $date){
                        array_push($labels, $date->format('M, Y'));
                    }
                    foreach($labels as $date){
                        $phoneviews[$date] = 0;
                        $productviews[$date] = 0;
                    }

                    
                    $phoneViews = PhoneView::whereBetween('date', [$start, $end])->get();
                    $productViews = ProductVisit::whereBetween('date', [$start, $end])->get();
                    foreach($phoneViews as $views){
                        $date = Carbon::parse($views->date)->format('M, Y');
                        $phoneviews[$date] += 1;
                    }
                    foreach($phoneViews as $views){
                        $date = Carbon::parse($views->date)->format('M, Y');
                        $productviews[$date] += 1;
                    }
                    

                    $data['labels'] = $labels;
                    $data['data'] = [
                        'phoneviews' => array_values($phoneviews),
                        'productviews' => array_values($productviews)
                    ];

                    return response()->json($data);
                break;

                case 'yearly': 
                    $phone = PhoneView::orderBy('date', 'ASC')->first()->date;
                    $product = ProductVisit::orderBy('date', 'ASC')->first()->date;
                    $start = 0;

                    if($phone < $product){
                        $start = $phone;
                    }else{
                        $start = $product;
                    }

                    $end = Carbon::now();

                    $phoneviews = array();
                    $productviews = array();

                    $labels = array();
                    for($i = Carbon::parse($start)->format('Y'); $i <= $end->format('Y'); $i++){
                        array_push($labels, $i);
                        $phoneviews[$i] = 0;
                        $productviews[$i] = 0;
                    }

                    $phoneViews = PhoneView::whereBetween('date', [$start, $end])->get();
                    $productViews = ProductVisit::whereBetween('date', [$start, $end])->get();
                    foreach($phoneViews as $views){
                        $date = Carbon::parse($views->date)->format('Y');
                        $phoneviews[$date] += 1;
                    }
                    foreach($productViews as $views){
                        $date = Carbon::parse($views->date)->format('Y');
                        $productviews[$date] += 1;
                    }

                    $data['labels'] = $labels;
                    $data['data'] = [
                        'phoneviews' => array_values($phoneviews),
                        'productviews' => array_values($productviews)
                    ];
                    return response()->json($data);
                break;
            }
        }else{

        }
        
    }   

    function getLastNDays($days, $format = 'd/m'){
        $m = date("m"); $de= date("d"); $y= date("Y");
        $dateArray = array();
        for($i=0; $i<=$days-1; $i++){
            $dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
        }
        return array_reverse($dateArray);
    }

}
