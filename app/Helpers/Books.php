<?php
use Illuminate\Validation\Rules\File;

function save_files_books($request){
    if(is_null($request)){
        return null;
    }
    $extions=$request->getclientoriginalextension();
    if(Str::contains('jpeg bmp png jpg', $extions)){
        $folder='\\image';
    }
    elseif(Str::contains('pdf', $extions)){
        $folder='\\Book';
    }
    else {
        $folder='\\audio';
    }
        $File_name=time().'.'.$extions;
        $File_path = $request->move('Books'.$folder,$File_name);
        return $File_path;
}


function validtaor_Book()
{
    return [
            'name' =>[
                'required',
                'max:30',
                'string',
                'min:2',
                'unique:Books,name'
            ],
            'image'=>[
                'required',
                File::image()->types(['jpeg','bmp','png','jpg'])
                ->max(2048),
            ],
            'file_path'=>[
                'required',
                File::types(['pdf'])
            ],
            'Publisher_id'=>[
                'required',
            ],
            'edition'=>[
                'string'
            ],
            'description'=>[
                'nullable',
                'max:1000'
            ],
            'category_id'=>[
                'required',
            ],
            'book_audio' =>[
                'nullable',
                File::types(['mp3'])
            ]
    ];
}
