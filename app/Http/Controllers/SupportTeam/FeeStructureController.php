<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\MyClass;
use App\Services\FeeManagementService;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    protected $feeService;

    public function __construct(FeeManagementService $feeService)
    {
        $this->feeService = $feeService;
        $this->middleware('teamAccount');
    }

    public function index(Request $req)
    {
        $academicYear = $req->academic_year ?: Qs::getCurrentSession();

        $d['academic_year'] = $academicYear;
        $d['categories'] = FeeCategory::where('is_active', true)->orderBy('name')->get();
        $d['structures'] = FeeStructure::where('academic_year', $academicYear)
            ->with(['category', 'my_class', 'section', 'student'])
            ->orderBy('id', 'desc')
            ->get();
        $d['classes'] = MyClass::orderBy('name')->get();

        return view('pages.support_team.fees.structures.index', $d);
    }

    public function store(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:150',
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'period_type' => 'required|in:one_time,monthly,term,annual',
            'my_class_id' => 'nullable|exists:my_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'student_id' => 'nullable|exists:users,id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'due_day' => 'nullable|integer|min:1|max:32',
        ]);

        $data = $req->all();
        $data['academic_year'] = $req->academic_year ?: Qs::getCurrentSession();
        $data['is_taxable'] = $req->has('is_taxable');

        $this->feeService->saveFeeStructure($data);

        return redirect()->route('fees.structures.index', ['academic_year' => $data['academic_year']])
            ->with('flash_success', __('Fee structure created successfully.'));
    }

    public function update(Request $req, $structure_id)
    {
        $id = is_numeric($structure_id) ? $structure_id : Qs::decodeHash($structure_id);
        $req->validate([
            'title' => 'required|string|max:150',
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'period_type' => 'required|in:one_time,monthly,term,annual',
            'my_class_id' => 'nullable|exists:my_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'student_id' => 'nullable|exists:users,id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'due_day' => 'nullable|integer|min:1|max:32',
        ]);

        $data = $req->all();
        $data['id'] = $id;
        $data['is_taxable'] = $req->has('is_taxable');

        $this->feeService->saveFeeStructure($data);

        return back()->with('flash_success', __('Fee structure updated successfully.'));
    }

    public function destroy($structure_id)
    {
        $id = is_numeric($structure_id) ? $structure_id : Qs::decodeHash($structure_id);
        $structure = FeeStructure::findOrFail($id);
        $structure->delete();

        return back()->with('flash_success', __('Fee structure deleted successfully.'));
    }

    public function storeCategory(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:fee_categories,code',
            'fee_type' => 'required|in:admission,tuition_monthly,annual,exam,transport,hostel,lab,library,other',
            'description' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        FeeCategory::create([
            'name' => $req->name,
            'code' => strtoupper($req->code),
            'fee_type' => $req->fee_type,
            'description' => $req->description,
            'is_taxable' => $req->has('is_taxable'),
            'tax_rate' => $req->has('is_taxable') ? (float) $req->tax_rate : 0.00,
            'is_active' => true,
        ]);

        return back()->with('flash_success', __('Fee category created successfully.'));
    }
}
