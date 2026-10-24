<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\MyClass;
use App\Models\Setting;
use App\Services\FeeManagementService;
use Illuminate\Http\Request;

class FeeReportController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount');
    }

    public function index(Request $req)
    {
        $filters = [
            'academic_year' => $req->academic_year ?: Qs::getCurrentSession(),
            'date_from' => $req->date_from,
            'date_to' => $req->date_to,
            'is_bs' => $req->has('is_bs') || $req->is_bs == 1,
            'my_class_id' => $req->my_class_id,
        ];

        $reports = $this->feeService->getFinancialReports($filters);

        $d = array_merge($reports, [
            'filters' => $filters,
            'classes' => MyClass::orderBy('name')->get(),
            'active_tab' => $req->tab ?: 'daily',
            's' => Setting::all()->flatMap(function ($s) {
                return [$s->type => $s->description];
            }),
        ]);

        return view('pages.support_team.fees.reports.index', $d);
    }
}
