<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.emails.index', compact('templates'));
    }
    public function editor($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.emails.editor', compact('template'));
    }
    // public function edit($id)
    // {
    //     $template = EmailTemplate::findOrFail($id);
    //     return view('admin.emails.edit', compact('template'));
    // }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->body = $request->input('email_template_content');
        $template->save();
    
        return redirect()->route('admin.emails.index')->with('success', 'Template updated successfully!')->with('selected_id', $id);
    }
    
    public function saveAsNewTemplate(Request $request)
    {
        $template = new EmailTemplate();
        $template->name = $request->input('template_name');
        $template->body = $request->input('email_template_content');
        $template->default_body = $request->input('email_template_content');
        $template->save();
    
        return redirect()->route('admin.emails.index')->with('success', 'New template created successfully!')->with('selected_id', $template->id);
    }    

    // public function resetToDefault($id)
    // {
    //     $template = EmailTemplate::findOrFail($id);
    //     $template->body = $template->default_body;
    //     $template->save();
    //     return redirect()->route('admin.emails.index')->with('success', 'Template updated successfully!');
    // }
}