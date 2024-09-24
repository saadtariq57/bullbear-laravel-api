<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    protected $segmentApi;
    protected $contactApi;
    protected $emailApi;

    public function __construct(\Mautic\Api\Segments $segmentApi, \Mautic\Api\Contacts $contactApi , \Mautic\Api\Emails $emailApi)
    {
        $this->segmentApi = $segmentApi;
        $this->contactApi = $contactApi;
        $this->emailApi = $emailApi;
    }

    public function index()
    {
        // Fetch all email templates from the database
        $templates = EmailTemplate::all();
    
        // Fetch all segments from Mautic API
        // $segmentId = 45;  // Static ID
        // $response = $this->segmentApi->get($segmentId);
        // return response()->json($response);
        $segmentsData = $this->segmentApi->getList();
        $allSegments = $segmentsData['lists'] ?? [];
        
        // Filter segments based on category ID
        $categoryId = 38;
        $filteredSegments = array_filter($allSegments, function ($segment) use ($categoryId) {
            return isset($segment['category']) && $segment['category']['id'] == $categoryId;
        });
    
        // Fetch all contacts from Mautic API
        // $contactId = 412096;  // Static ID
        // $response = $this->contactApi->get($contactId);
        // return response()->json($response);

        $contactsData = $this->contactApi->getList();
        $contacts = $contactsData['contacts'] ?? [];
        // return response()->json($contacts);
    
        // Compact and return data to the view
        return view('admin.emails.index', compact('filteredSegments', 'templates', 'contacts'));
    }
    public function sendEmails(Request $request)
    {
        $templateId = $request->input('template_id');
        $subject = $request->input('subject');
        $segments = $request->input('segments', []);
        // $request->validate([
        //     'subject' => 'required|string|max:255',
        //     'template_id' => 'required|exists:email_templates,id',
        //     'segments' => 'required|array',
        //     'segments.*' => 'exists:segments,id' // Adjust if necessary based on your database structure
        // ]);


        // Fetch the template
        $template = EmailTemplate::findOrFail($templateId);
        $emailContent = $template->body;

        
            $data = [
                'title' => 'Your Custom Email Title',
                'description' => '',
                'isPublished' => 1,
                'fromName' => 'wajid',
                'fromAddress' => 'admin@themesbrand.com',
                // 'name' => 'Custom Email for Segment ' . implode(', ', $segments),
                'name' => $subject,
                'subject' => $subject,  // Use the subject from the form
                'language' => 'en',
                'template' => 'mautic_code_mode',
                'emailType' => 'list',
                'lists' => $segments,
                'customHtml' => $emailContent,
                'plainText' => strip_tags($emailContent),
                'category' => 38,
                'createdBy' => 1,
                'createdByUser' => 'Auto',
                'useOwnerAsMailer' => 0
            ];
    
            $email = $this->emailApi->create($data);
            // $email = $this->emailApi->get(825);
                //    return response()->json($email);
            $response = $this->emailApi->send($email['email']['id']);
    
            
            if($response){
                return redirect()->route('admin.emails.index')->with('success', 'Emails sent successfully!');
            }else{
                return back()->with('error', 'Failed to send email.');
            }
        
    }
    
    

    public function editor($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.emails.editor', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->body = $request->input('email_template_content');
        $template->save();
    
        return redirect()->route('admin.emails.index')->with('success', 'Template updated successfully!')->with('selected_id', $id);
    }
    
    public function saveAsNewTemplate(Request $request)
    {
        // $template = new EmailTemplate();
        // $template->name = $request->input('template_name');
        // $template->body = $request->input('email_template_content');
        // $template->default_body = $request->input('email_template_content');
        // $template->save();
        $request->validate([
            'template_name' => 'required|string|max:255',
        ]);
        
        $template = EmailTemplate::create([
            'name' => $request->input('template_name'),
            'body' => '',
            'default_body' => '',
            'template_img' => '',
            'type' => 'custom'
        ]);
    
        return redirect()->route('admin.emails.index')->with('success', 'New template created successfully!')->with('selected_id', $template->id);
    }   

}