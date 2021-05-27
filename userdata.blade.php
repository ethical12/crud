@extends('layouts.header')

@section('content');
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Data</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      @if (Session::has('msg'))
       <div class="alert alert-success" role="alert">
        {!! session('msg') !!}
      </div>
      @endif
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <table class="table" style="background-color: white;">
  <thead>
    <tr>
           <th>id</th>
           <th>name</th>
           <th>email</th>
           <!-- <th>password</th> -->
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
           <td>{{$todo->email}}</td>
           <!-- <td>base64_decode ({{$todo->password}});</td> -->
           <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td>
           <td><button class="btn btn-danger changepassword" data-toggle="modal" data-target="#changepassword">Change Password</button>
            <!-- <a href="todo_edit_data/{{$todo->id}}">Edit</a> -->
           </td>
           
    </tr>
    @endforeach
  </tbody>
</table>
{{$viewdata->links()}}
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!--==============Activate user=========----->
<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('changepassword')}}" id="changepasswordvalidate">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <input class="form-control" type="hidden" name="pass_id" id="pass_id">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
        <label for="new_password">New Password</label>
        <input class="form-control" type="text" name="newpassword" id="newpassword">
        @error('newpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
        <label for="new_password">Con Password</label>
        <input class="form-control" type="text" name="conpassword">
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
        </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Yes</button>
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
      </div>
  </div>
</div>

<script> 
$(".changepassword").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(0)').text();
    // rowEmail =  $row.find('td:eq(2)').text();
      $('#pass_id').val(rowIndex);
      // $('#pass_email').val(rowEmail);  
});
</script> 

<script>
   $("#changepasswordvalidate").validate({
          rules:{
            oldpassword:{
              required: true,
              minlength:8
            },
            newpassword:{
              required: true,
              minlength:8,
            },
            conpassword:{
              required: true,
              equalTo : "#newpassword"
            },
          },
        
    });

</script>
@endsection

 