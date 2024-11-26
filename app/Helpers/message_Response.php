<?php

function API_Response($data= null,$message=null,$status=null){
    $array=[
        'data'=>$data,
        'message'=>$message,
        'status'=>$status
    ];
    return response($array,$status);
}
