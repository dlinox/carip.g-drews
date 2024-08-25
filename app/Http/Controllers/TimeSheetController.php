<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimeSheetController extends Controller
{

    protected $timeSheet;

    public function __construct()
    {
        $this->timeSheet = new TimeSheet();
    }

    public function index()
    {
        return Inertia::render("Project/views/timesheet", [
            'title' => 'Tareo',
            'today' => date('Y-m-d'),
            //sumarle un dia a la fecha actual
            'todayJs' => date('Y-m-d', strtotime('+1 day')),
        ]);
    }

    //get items por fecha 
    public function getItemsByDate(Request $request)
    {
        $items = $this->timeSheet->getItemsByDate($request->date);
        return response()->json($items);
    }
}
