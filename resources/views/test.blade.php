<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body>


<div>

<form action="{{url('store')}}" method="post" enctype="multipart/form-data">
        <!-- Add CSRF Token -->
        @csrf
    <div class="form-group">
        <label>Book Name</label>
        <input type="text" class="form-control" name="name" >
        <label>Publisher_id</label>
        <input type="number" name="Publisher_id" id="">
        <h4>description</h4>
        <textarea rows="5" cols="50" name="description" ></textarea> <br><br><br>    
         <br><br><br>
         <p>Upload the book_audio</p>
         <div class="form-group">
            <input type="file" name="book_audio" >
         </div>
         <select name="accepted" id="accepted">
             <option value="1">true</option>
             <option value="0">false</option>
         </select>
         <input type="text" name="category_id" id="category_id">
    </div>
    <br><br><br>
    <p>Upload the book</p>
    <div class="form-group">
        
        <input type="file" name="file_path" >
        <label for="">edition</label>
        <input type="text" name="edition" id="">
    </div>
    <br><br><br>
    <p>Upload the image of book</p>
    <div class="form-group">
        <input type="file" name="image" >
    </div>
    <br><br>
    <button type="submit">Submit</button>
</form>

</div>
</body>
</html>