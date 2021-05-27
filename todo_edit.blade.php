<!DOCTYPE html>
<html>
<head>
    <title>registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
    <h2>Edit Data</h2>
    <form method="POST" action="{{route('todo_edit',[$todoArr->id])}}">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$todoArr->name}}">
            @error('name')
            <p style="color: red">{{$message}}</p>
            @enderror
        </div>

        <!-- <div class="form-group">
            <label for="email">Mobile:</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
            @error('mobile')
            <p>{{$message}}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('password')
            <p>{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Con_Password:</label>
            <input type="password" class="form-control" id="conpassword" name="conpassword">
            @error('conpassword')
            <p>{{$message}}</p>
            @enderror
        </div> -->
      <br>
        <div class="form-group">
            <center><button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button></center>
        </div>
    </form>
<a href="../todo_show"><p>Back</p></a>
 
 </div>
</body>
</html>