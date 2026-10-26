<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\MyClass;
use App\Models\Section;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Repositories\MyClassRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyMaterialController extends Controller
{
    protected $my_class;

    public function __construct(MyClassRepo $my_class)
    {
        $this->middleware('auth');
        $this->my_class = $my_class;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = StudyMaterial::visibleTo($user)
            ->with(['teacher', 'my_class', 'section', 'subject'])
            ->orderBy('created_at', 'desc');

        if ($request->has('class_id') && $request->class_id) {
            $query->where('my_class_id', $request->class_id);
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $materials = $query->paginate(15);
        $classes = $this->my_class->all();

        $subjects = collect();
        if ($user->user_type === 'teacher') {
            $subjects = Subject::where('teacher_id', $user->id)->get();
        } elseif (in_array($user->user_type, ['super_admin', 'admin'])) {
            $subjects = Subject::all();
        }

        return view('pages.support_team.study_materials.index', compact('materials', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->user_type, ['super_admin', 'admin', 'teacher'])) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'my_class_id' => 'required|exists:my_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'material_file' => 'required|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,jpg,jpeg,png',
        ], [
            'material_file.mimes' => 'The file must be a document, presentation, spreadsheet, archive, or image (pdf, doc, docx, ppt, pptx, xls, xlsx, txt, zip, jpg, png).',
            'material_file.max' => 'The file size must not exceed 10MB.',
        ]);

        // If teacher, verify assignment to class or subject
        if ($user->user_type === 'teacher') {
            $teachesClass = Section::where('my_class_id', $request->my_class_id)->where('teacher_id', $user->id)->exists();
            $teachesSubject = $request->subject_id ? Subject::where('id', $request->subject_id)->where('teacher_id', $user->id)->exists() : false;
            $classHasSubject = Subject::where('my_class_id', $request->my_class_id)->where('teacher_id', $user->id)->exists();

            if (!$teachesClass && !$teachesSubject && !$classHasSubject) {
                return back()->withInput()->with('flash_danger', __('You are not assigned to this class or subject.'));
            }
        }

        $file = $request->file('material_file');
        $originalName = $file->getClientOriginalName();
        $safeOriginalName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);
        $extension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        // Extra check against dangerous extensions
        $dangerousExtensions = ['php', 'phtml', 'phar', 'exe', 'sh', 'bat', 'cmd', 'js', 'vbs', 'ps1', 'cgi', 'pl'];
        if (in_array(strtolower($extension), $dangerousExtensions, true)) {
            return back()->withInput()->with('flash_danger', __('Executable and script files are strictly prohibited.'));
        }

        // Store privately
        $storedPath = $file->store('study_materials');

        StudyMaterial::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $storedPath,
            'file_name' => $safeOriginalName,
            'file_size' => $fileSize,
            'file_type' => strtolower($extension),
            'my_class_id' => $validated['my_class_id'],
            'section_id' => $validated['section_id'] ?? null,
            'subject_id' => $validated['subject_id'] ?? null,
            'teacher_id' => $user->id,
        ]);

        return redirect()->route('study_materials.index')->with('flash_success', __('Study material uploaded successfully.'));
    }

    public function download($id)
    {
        $user = Auth::user();
        $material = StudyMaterial::visibleTo($user)->findOrFail($id);

        if (!Storage::exists($material->file_path)) {
            return back()->with('flash_danger', __('File not found on storage server.'));
        }

        return Storage::download($material->file_path, $material->file_name);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $material = StudyMaterial::findOrFail($id);

        // Allowed only for Super Admin or the uploading teacher
        if (!Qs::userIsSuperAdmin() && $material->teacher_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::exists($material->file_path)) {
            Storage::delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('study_materials.index')->with('flash_success', __('Study material deleted successfully.'));
    }
}
