<?php

namespace App\Http\Controllers;

use App\Models\author_book;
use Illuminate\Http\Request;

class AuthorBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if(is_null($request->book_id) or is_null($request->author_id)){
            // return  API_Response(null,'not found',404);
            return response()->json(null, 404);
        }
        $data=author_book::create([
            'book_id'=>$request->book_id,
            'author_id'=>$request->author_id
        ]);
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(author_book $author_book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(author_book $author_book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, author_book $author_book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(author_book $author_book)
    {
        //
    }
}
