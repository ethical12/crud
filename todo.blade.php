<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Styles -->
        <style>
           
        </style>
    </head>
    <body>
        <div class="container">
            <a href="todo_create">Add Record</a>
          <h3 style="color: green">{{session('msg')}}</h3>
        <table class="table">
  <thead>
    <tr>
           <th>id</th>
           <th>name</th>
           <th>number</th>
           <th>creater_at</th>
           <th>updated_at</th>
           <th>action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($viewdata as $todo)
    <tr>
        
      <td>{{$todo->id}}</td>
           <td>{{$todo->name}}</td>
           <td>{{$todo->number}}</td>
           <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td>
           <td><a href="todo_delete/{{$todo->id}}">Delete</a>
            <a href="todo_edit_data/{{$todo->id}}">Edit</a>
           </td>
           
    </tr>
    @endforeach
  </tbody>
</table>
{{$viewdata->links()}}
</div>
        <!-- <a href="todo_create">Add Record</a>
        {{session('msg')}} -->
       <!-- <table>
        <tr>
           <td>id</td>
           <td>name</td>
           <td>creater_at</td>
           <td>updated_at</td>
           <td>action</td>
       </tr>
           @foreach($viewdata as $todo)
        <tr>
           <td>{{$todo->id}}</td>
           <td>{{$todo->name}}</td>
           <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td>
           <td><a href="todo_delete/{{$todo->id}}">Delete</a>
            <a href="todo_edit_data/{{$todo->id}}">Edit</a>
           </td>
       </tr>
           @endforeach
       </table> -->
    </body>
</html>
