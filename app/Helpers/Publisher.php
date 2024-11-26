<?php
use Illuminate\Validation\Rules\File;

function validtaor_Publisher(){
    return[
        'Name'=>[
            'required',
            'max:30',
            'string',
            'min:2'
        ],

    ];
}
