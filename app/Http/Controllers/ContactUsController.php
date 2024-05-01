<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function index()
    {
       return view('contact.index');
    }
    function get(Request $request) {
        $data = $request->all();
        $contact = Contact::skip($data['skip'] == NULL || $data['skip'] == "null" ? 0 : $data['skip'])->take($data['take'])->orderBy('id' , 'DESC')->get();
        $total = Contact::get()->count();
        return [ 'data' => $contact , '__count' => $total ];
    }
    public function create(){
        return view('contact.create');
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        $data = $request->all();
        if($validator->fails()){
            return response()->json(['success' => false, "error" => $this->validationMessage($validator->errors()->toArray())], 422);
        }
        if($data['id'] != ""){
            Contact::where( 'id' , $data['id'])->update(['name' => $data['name'] , 'email' => $data['email'] , 'message' => $data['message'] ]);
         
        }else{
            $product = Contact::insertGetId(['name' => $data['name'] , 'email' => $data['email'] , 'message' => $data['message'] ]);
        }
        return response()->json(['success' => true, 'data' => ['message' => 'Contact us stored successfully']], 200);
    }
    public function edit(string $id)
    { 
        $contact = Contact::find($id);
        return view('contact.create' , compact('contact'));  
    }
    public function destroy(string $id)
    {
        try {
            Contact::find($id)->delete();
            return response()->json(['success' => true,'message' => 'Contact deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => ['message' => $e->getMessage()]], 500);
        }
    }
}
