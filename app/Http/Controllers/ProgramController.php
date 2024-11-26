<?php
/*
   PAGINATION_COUNT      => this CONSTANT in Helpers folder in formatBytes.php
   validtaor_program()   => this Function in Helpers folder in Programs.php
   formatBytes()         => this Function in Helpers folder in formateByte.php
   save_files_programs() => this Function in Helpers folder in Programs.php
   API_Response()        => this Function in Helpers folder in message_Response.php
*/
namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // https://example.com?Search=Photoshop , https://example.com?category=1
    {
        // $Programs=Program::with(['category'])->filter()->inRandomOrder()->paginate(PAGINATION_COUNT);
        if(is_null($request->Search) and is_null($request->category)){
            $query=DB::table('programs')->join('categories','categories.id','=','programs.category_id')
            ->select('programs.id','programs.Name as name','programs.File_path','programs.Description','programs.image','programs.Accepted','programs.Version', 'programs.size_Program', 'programs.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        elseif(is_null($request->category) and isset($request->Search)){
            $query=DB::table('programs')->join('categories','categories.id','=','programs.category_id')
            ->where('programs.Name','like','%'.$request->Search.'%')
            ->select('programs.id','programs.Name as name','programs.File_path','programs.Description','programs.image','programs.Accepted','programs.Version', 'programs.size_Program', 'programs.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        elseif(is_null($request->Search) and isset($request->category)){
            $query=DB::table('programs')->join('categories','categories.id','=','programs.category_id')
            ->where('categories.id','=',$request->category)
            ->select('programs.id','programs.Name as name','programs.File_path','programs.Description','programs.image','programs.Accepted','programs.Version', 'programs.size_Program', 'programs.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        elseif(isset($request->Search,$request->category)){
            $query=DB::table('programs')->join('categories','categories.id','=','programs.category_id')
            ->where('categories.id','=',$request->category)->where('programs.Name','like','%'.$request->Search.'%')
            ->select('programs.id','programs.Name as name','programs.File_path','programs.Description','programs.image','programs.Accepted','programs.Version', 'programs.size_Program', 'programs.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        else{
            return response()->json(null, 404);
        }



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
        $validator=validator::make($request->all(),validtaor_program());
        if($validator->fails()){
            // return API_Response($validator->errors(),'errors',404) ;
            return response()->json($validator->errors(), 404);
        }
        $size_Program=formatBytes($request->file_path->getSize());
        $Program_path=save_files_programs($request->file_path);
        $image_path=save_files_programs($request->image);
        $data=Program::create([
            'File_path'=>$Program_path,
            'Name'=>$request->name,
            'Description'=>$request->Description,
            'image'=>$image_path,
            'Accepted'=>$request->accepted,
            'Version'=>$request->Version,
            'size_Program'=>$size_Program,
            'category_id'=>$request->category_id
        ]);
        // return API_Response($data->id,'ok',200);
        return response()->json($data->id, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $program=Program::findOrfail($id);
        $category_id=$program->category_id;

        $programs=DB::table('programs')
        ->where('category_id','=',$category_id)
        ->where('Name','<>',$program->Name)->get();

        $categories=DB::table('categories')
        ->select('categories.name')
        ->where('categories.id','=',$category_id)->get();

        $programs=[
            $program,$programs,$categories
        ];
        // return API_Response($programs,'ok',200);
        return response()->json($programs, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        //
    }
}
