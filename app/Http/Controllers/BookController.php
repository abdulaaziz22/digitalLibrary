<?php
/*
   PAGINATION_COUNT      => this CONSTANT in Helpers folder in formatBytes.php
   validtaor_Book()      => this Function in Helpers folder in Books.php
   formatBytes()         => this Function in Helpers folder in formateByte.php
   save_files_books()    => this Function in Helpers folder in Books.php
   API_Response()        => this Function in Helpers folder in message_Response.php
*/
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\category;
use App\Models\Author;
use App\Models\author_book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Services\payUService\Exceptor;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(is_null($request->category) and is_null($request->Search) and is_null($request->Author)){
            $query=DB::table('Books')->join('categories','categories.id','=','Books.category_id')
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);
        }
        elseif(is_null($request->category) and isset($request->Search) and is_null($request->Author)){
            $query=DB::table('Books')->join('categories','categories.id','=','Books.category_id')
            ->where('Books.name','like','%'.$request->Search.'%')
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);
        }
        elseif(is_null($request->Search) and is_null($request->Author) and isset($request->category)){
            $query=DB::table('Books')->join('categories','categories.id','=','Books.category_id')
            ->where('categories.id','=',$request->category)
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);
        }
        elseif(is_null($request->Search) and is_null($request->category) and isset($request->Author)){
            $query=DB::table('Authors')->join('author_books','Authors.id','=','author_books.author_id')
            ->join('Books','author_books.book_id','=','Books.id')->join('categories','categories.id','=','Books.category_id')
            ->where('Authors.id','=',$request->Author)->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        elseif(is_null($request->Author) and isset($request->Search,$request->category)){
            $query=DB::table('Books')->join('categories','categories.id','=','Books.category_id')
            ->where('Books.name','like','%'.$request->Search.'%')->where('categories.id','=',$request->category)
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query, 200);
        }
        elseif(isset($request->Search, $request->Author) and is_null($request->category)){
            $query=DB::table('Authors')->join('author_books','Authors.id','=','author_books.author_id')
            ->join('Books','author_books.book_id','=','Books.id')->join('categories','categories.id','=','Books.category_id')
            ->where('Books.name','like','%'.$request->Search.'%')->where('Authors.id','=',$request->Author)
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);
        }
        elseif(isset( $request->category, $request->Author) and is_null($request->Search)){
            $query=DB::table('Authors')->join('author_books','Authors.id','=','author_books.author_id')
            ->join('Books','author_books.book_id','=','Books.id')->join('categories','categories.id','=','Books.category_id')
            ->where('books.category_id','=',$request->category)->where('Authors.id','=',$request->Author)
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);

        }
        elseif(isset($request->category, $request->Author,$request->Search)){
            $query=DB::table('Authors')->join('author_books','Authors.id','=','author_books.author_id')
            ->join('Books','author_books.book_id','=','Books.id')->join('categories','categories.id','=','Books.category_id')
            ->where('books.category_id','=',$request->category)->where('Authors.id','=',$request->Author)->where('Books.name','like','%'.$request->Search.'%')
            ->select('Books.id','Books.name as name','books.file_path', 'books.image','books.Publisher_id','books.description','books.accepted','books.book_audio','books.edition','books.size_Book','books.size_audio_Book','books.category_id','categories.name as category_name')
            ->inRandomOrder()->paginate(PAGINATION_COUNT);
            return response()->json($query,200);
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
        $validator=validator::make($request->all(),validtaor_Book());
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
        //the formatBytes() Function in Helpers folder return the format size
        $size_Book=formatBytes($request->file_path->getSize());

        if(is_null($request->book_audio)){
            $size_audio_Book=null;
        }
        else{
            $size_audio_Book=formatBytes($request->book_audio->getSize());
        }

        $image_path=save_files_books($request->image);
        $book_path=save_files_books($request->file_path);
        $audio_book_path=save_files_books($request->book_audio);
        $data=Book::create([
            'name'=> $request->name,
            'Publisher_id'=>$request->Publisher_id,
            'accepted'=>$request->accepted,
            'category_id'=>$request->category_id,
            'edition'=>$request->edition,
            'description'=>$request->description,
            'file_path'=>$book_path,
            'image'=>$image_path,
            'book_audio'=>$audio_book_path,
            'size_Book'=> $size_Book,
            'size_audio_Book'=>$size_audio_Book
        ]);
        return response()->json($data->id, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book=book::findOrfail($id);
        $category_id=$book->category_id;
        $books=DB::table('books')
        ->where('category_id','=',$category_id)
        ->where('name','<>',$book->name)->get();



        $author = DB::table('author_books')
        ->join('authors', 'authors.id', '=', 'author_books.author_id')
        ->select('authors.name')
        ->where('author_books.book_id','=', $id)
        ->get();

        $categories=DB::table('categories')
        ->select('categories.name')
        ->where('categories.id','=',$category_id)->get();

        $publishers=DB::table('publishers')
        ->select('publishers.name')
        ->where('publishers.id','=',$book->Publisher_id)->get();

        $books=[
            [$book],[$books],[$author],[$categories],[$publishers]
        ];

        return response()->json($books, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
