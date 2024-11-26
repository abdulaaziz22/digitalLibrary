<?php
/*
   validtaor_Publisher() => this Function in Helpers folder in Publisher.php
   API_Response()        => this Function in Helpers folder in message_Response.php
*/

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Publisher=Publisher::all();
        return API_Response($Publisher,'ok',200) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=validator::make($request->all(),validtaor_Publisher());
        if($validator->fails()){
            // return API_Response($validator->errors(),'errors',404) ;
            return response()->json($validator->errors(), 404);
        }
        $Publisher=$request->Name;
        $data=Publisher::where('Name','=',$Publisher)->first();
        if(is_null($data)){
            $data_id=Publisher::create([
                'Name'=>$Publisher
            ]);
            $data_id=$data_id->id;
            // return API_Response($data_id,'ok',200) ;
            return response()->json($data_id, 200);
        }
        else{
            $data_id=$data->id;
            // return API_Response($data_id,'ok',200) ;
            return response()->json($data_id, 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        //
    }
}
