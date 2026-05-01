<?php

namespace App\Http\Controllers;

use App\Models\LeadUser;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class TemplateController extends Controller
{
    public function index()
    {
        $all=[
            'templates'=>Template::get(),
            'leads'=>LeadUser::get(),
            'trainers'=>User::where('role_id',User::Trainer)->get(),
            'staffs'=>User::where('role_id',User::Staff)->get(),
            'users'=>User::where('role_id',User::User)->get()
        ];
        return view('admin.sms.index', [
            'templates'=>Template::paginate(),
            'all'=>$all,
            'value'=>request('value') ?? null,
        ]);
    }
    public function add()
    {
        return view('admin.sms.create');
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'description' => 'required|max:255',
        ]);
        try {
            Template::create([
                'title' => $request->title,
                'subject' => $request->subject,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            flash('Operation Failed', 'error');
            return back();
        }
        return to_route(auth()->user()->roleName . 'sms.index')->with('success', 'Template created successfully');
    }

    public function edit($id)
    {
        return view('admin.sms.edit', [
            'template' => Template::find($id),
        ]);
    }
    public function store(Request  $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'subject' => 'required',
            'description' => 'required|max:255',
        ]);
        try {
            Template::updateOrCreate(
                ['id' => $id],
                [
                    'title' => $request->title,
                    'subject' => $request->subject,
                    'description' => $request->description,
                ]
            );
        } catch (\Throwable $th) {
            flash('Operation Failed', 'error');
            return back();
        }
        return to_route(auth()->user()->roleName . 'sms.index')->with('success', 'Template Updated successfully');
    }
    public function delete($id)
    {
        try {
            Template::destroy($id);
        } catch (\Throwable $th) {
            flash('Operation Failed', 'error');
            return back();
        }
        return to_route(auth()->user()->roleName . 'sms.index')->with('success', 'Template Deleted successfully');
    }
    public function send()
    {
        return view('admin.sms.sendSms', [
            'template' => Template::find(request('template')),
            'user' => LeadUser::find(request('user')),
        ]);
    }
    public function broadcast()
    {
        $template=Template::find(request('templates'));
        if (request('leads') == null) {
            return back()->with('warning', 'please select a valid user');
        }
        $string = request('leads');
        $leads = array_map('intval', explode(',', $string));
        $data = LeadUser::whereIn('id', $leads)->get();
        echo  'Total Leads '.count($leads).'<br>';
        foreach($data as $lead){
            echo 'Name ::'.$lead->first_name.' '.$lead->last_name.'<br>';
            echo 'Phone ::'.$lead->phone.'<br>';
            $message = str_replace('{Member}', $lead->first_name . ' ' . $lead->last_name, $template->description);
            echo 'Message ::'.$message.'<br><br>';
        }
    }
}
