<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Document;
use App\Models\Signature;
use App\Models\UploadPdf;
use App\Models\Department;
use App\Models\DocumentLog;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mpdf\Mpdf;
use PDF;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected DocumentService $documentService) {}

    public function index(Request $request)
    {
        $this->authorize('all_documents');

        $user = Auth::user();
        $departments = $user->departments;

        $query = Document::query();

        if ($request->bulk_action_btn === 'search') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        if ($request->bulk_action_btn === 'filter') {
            $select_input = $request->filter;
            if ($select_input == 1) {
                $column = "created_at";
            } elseif ($select_input == 2) {
                $column = "updated_at";
            }
        } else {
            $column = "created_at";
        }

        if ($user->role_id == 1) {
            $query->where(function ($query) use ($user, $departments) {
                $query->whereHas('owners', function ($query) use ($user) {
                    $query->where('owner', $user->id);
                })->orWhereHas('departments', function ($query) use ($departments) {
                    $query->whereIn('departments.id', $departments->pluck('id'));
                });
            });
        }
        $documents = $query->orderBy($column, 'desc')->paginate();




        $departments = Department::get();

        return view('admin.docs.index', compact('documents', 'departments'));
    }
    public function main_archive()
    {
        $this->authorize('show_archive');
        $current_url = url()->current();
        $url = explode('/', $current_url);
        $documents = Document::onlyTrashed()->paginate();
        $departments = Department::get();

        return view('admin.docs.index', compact('documents', 'departments'));
    }
    public function store(Request $request)
    {
        $this->authorize('create_documents');

        $request->validate([
            'name' => 'required',
            'contents' => 'required',
            // 'department_id' => 'required',
        ]);
        $owner = Auth::user();
        // dd($request->all());
        $document = Document::create([
            'name' => $request->name,
            // 'department_id' => $request->department_id,
            'owner' => $owner->id,
            'content' => $request->contents,
        ]);
        if ($document && $request->has('department_id')) {
            $document->departments()->sync($request->department_id);
        }

        return redirect()->route('documents.index')->with('success', 'تم اضافة الملف بنجاح');
    }

    public function show($id)
    {
        $this->authorize('show_documents');

        $document = Document::where('id', $id)->withTrashed()->first();
        // dd($document->signature[0]->image);
        return view('admin.docs.show', compact('document'));
    }
    public function show_department_documents($id)
    {
        $this->authorize('show_departments_documents');
        $documents = Document::WhereHas('departments', function ($query) use ($id) {
            $query->where('departments.id', $id);
        })->get();
        // $documents = Document::findOrFail($id);
        return view('admin.docs.show_department_documents', compact('documents'));
    }
    public function create()
    {
        $this->authorize('create_documents');

        $departments = Department::get();

        return view('admin.docs.create', compact(['departments']));
    }
    public function edit($id)
    {
        $this->authorize('edit_documents');

        $departments = Department::get();
        $document = Document::where('id', $id)->withTrashed()->first();

        return view('admin.docs.edit', compact(['departments', 'document']));
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_documents');

        $request->validate([
            'name' => 'required',
            'contents' => 'required',
        ]);
        $owner = Auth::user();
        $document = Document::findOrFail($id);

        $oldName = $document->name;
        $oldContent = $document->content;
        $oldDepartments = $document->departments->pluck('id')->toArray();

        $document->update([
            'name' => $request->name,
            'content' => $request->contents,
        ]);
        if ($document && $request->has('department_id')) {
            $document->departments()->sync($request->department_id);
        }
        if ($oldName !== $request->name) {
            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => $owner->id,
                'action' => "عدل اسم الملف من : {$oldName} إلى : {$request->name} ",
                'created_at' => now(),
            ]);
        }

        if ($oldContent !== $request->contents) {
            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => $owner->id,
                'action' => "عدل المحتوى",
                'created_at' => now(),
            ]);
        }

        $newDepartments = is_array($request->department_id) ? $request->department_id : [];

        $addedDepartments = array_diff($newDepartments, $oldDepartments);
        $removedDepartments = array_diff($oldDepartments, $newDepartments);

        foreach ($addedDepartments as $departmentId) {
            $department = Department::find($departmentId);
            if ($department) {
                DocumentLog::create([
                    'document_id' => $document->id,
                    'user_id' => $owner->id,
                    'action' => "تمت مشاركتة الي قسم \" {$department->name}\"",
                    'created_at' => now(),
                ]);
            }
        }

        foreach ($removedDepartments as $departmentId) {
            $department = Department::find($departmentId);
            if ($department) {
                DocumentLog::create([
                    'document_id' => $document->id,
                    'user_id' => $owner->id,
                    'action' => "تمت الغاء مشتركتة من قسم \" {$department->name} \"",
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('documents.index')->with('success', 'تم تعديل الملف بنجاح');
    }
    public function createSignature($id)
    {
        $this->authorize('add_sginature');

        $document = Document::findOrFail($id);
        return view('admin.docs.signature', compact(['document']));
    }

    public function signature(Request $request)
    {
        $this->authorize('add_sginature');

        $request->validate([
            'document_id' => 'required',
        ]);
        if (isset($request->signatures)) {
            foreach ($request->signatures as $signatureData) {
                Signature::create([
                    'user_id' => Auth::id(),
                    'document_id' => $request->document_id,
                    'image' => $signatureData,
                    'notes' => $request->notes ?? null,
                ]);
            }
        } else {
            $user = Auth::user();
            Signature::create([
                'user_id' => $user->id,
                'document_id' => $request->document_id,
                'image' => $user->signature,
                'notes' => $request->notes ?? null,
            ]);
        }
        DocumentLog::create([
            'document_id' => $request->document_id,
            'user_id' => Auth::id(),
            'action' => 'وقع علي الوثيقة',
            'created_at' => now(),
        ]);

        return redirect()->route('documents.show', $request->document_id)->with('success', 'All signatures saved successfully!');
    }

    public function add_to_department(Request $request)
    {
        $this->authorize('share_with_departments');

        $document = Document::where('id', $request->document_id)->first();
        if ($document && $request->has('department_id')) {
            $document->departments()->attach($request->department_id);
            DocumentLog::create([
                'document_id' => $request->document_id,
                'user_id' => Auth::id(),
                'action' => 'شارك المستند',
                'created_at' => now(),
            ]);
        }
        return redirect()->back()->with('success', 'تم الاضافة بنجاح');
    }
    public function archive($id)
    {
        $this->authorize('archive');
        $docs = Document::findOrFail($id);
        $docs->delete();
        DocumentLog::create([
            'document_id' => $id,
            'user_id' => Auth::id(),
            'action' => 'نقل المستند الي الارشيف',
            'created_at' => now(),
        ]);
        return redirect()->back()->with('success', 'تم الاضافة الي الارشيف');
    }
    public function delete_archive($id)
    {
        $this->authorize('delete_from_archive');

        $docs = Document::withTrashed()->where('id', $id)->restore();

        return redirect()->back()->with('success', 'تم الغاء الارشفة');
    }
    public function delete($id)
    {
        $this->authorize('delete_documents');
        $docs = Document::findOrFail($id);
        $docs->forceDelete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
    public function follow($id)
    {
        $this->authorize('follow_document');

        $docs = Document::with('logs', 'departments')->findOrFail($id);
        // $actions = DocumentLog::where()->orderBy('created_at', 'asc')->get();
        return view('admin.docs.follow', compact('docs'));
    }
    public function external_files()
    {
        $this->authorize('uploadpdf');

        $documents = UploadPdf::paginate();
        return view('admin.docs.external_files', compact('documents'));
    }
    public function uploadPdf(Request $request)
    {
        $this->authorize('save_pdf');
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('pdfs', $fileName, 'public');
        $document = new UploadPdf();
        $document->user_id = Auth::user()->id;
        $document->name = $request->input('name');
        $document->path = 'pdfs/' . $fileName;
        $document->save();

        return redirect()->route('documents.external')->with('success', 'تم الرفع بنجاح');
    }
    public function deletePdf($id)
    {
        $document = UploadPdf::find($id);
        if (!$document) {
            return back()->with('error', 'الملف غير موجود');
        }
        Storage::disk('public')->delete($document->path);

        $document->delete();
        return back()->with('success', 'تم حذف الملف بنجاح');
    }
    public function viewPdf($id)
    {
        $document = UploadPdf::find($id);
        if (!$document) {
            return back()->with('error', 'الملف غير موجود');
        }
        $filePath = storage_path('app/public/' . $document->path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'الملف غير موجود');
        }

        // عرض الملف باستخدام دالة file
        return response()->file($filePath);
    }


    public function printPdf($id)
    {
        // $company_settings = CompanySettings::first();
        // ($invoice) ? $tenant = Tenant::where('id', $invoice->tenant_id)->first() : $tenant = null;
        // $document->toArray();
        // dd($document->signature[0]->user_id);
        $document = Document::findOrFail($id);
        $signature_one = null;
        $signature_two = null;
        if (isset($document->signature[0])) {
            $signature_one = $document->signature[0];
        }
        if (isset($document->signature[1])) {
            $signature_two = $document->signature[1];
        }
        // dd($signature_one->image , $signature_two);
        return PDF::loadView('admin.docs.printPdf', [
            'document'                      => $document,
            'signature_one'                 => $signature_one,
            'signature_two'                 => $signature_two,

        ])->download($document->name . '.pdf');
    }
}
