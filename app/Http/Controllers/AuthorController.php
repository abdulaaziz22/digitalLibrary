<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Author::all();
        return response()->json($data, 200);
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
        $Author=$request->Author_name;
        $data=Author::where('Name','=',$Author)->first();
        if(is_null($data)){
            $data_id=Author::create([
                'Name'=>$Author
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
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
