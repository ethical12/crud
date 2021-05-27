@extends('layouts.header')

@section('content');

<style type="text/css">
  .profile{

  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><button class="btn btn-danger">Hello:-{{$viewdata->name}}</button></h1>
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
      @if (Session::has('errormsg'))
       <div class="alert alert-danger" role="alert">
        {!! session('errormsg') !!}
      </div>
      @endif
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
       <!--  <div class="container mt-5 d-flex justify-content-center"> -->
    <div class="card p-3 profile Small shadow">
        <div class="d-flex align-items-center">
            <div class="image" data-toggle="modal" data-target="#Image"> <img src="{{asset('user_profile_image')}}/{{$viewdata->image}}" alt="Click and uplode" class="rounded" width="155"> </div>
            <div class="ml-3 w-100">
                <h4 class="mb-0 mt-0">{{$viewdata->name}}</h4> <span>Senior Journalist</span>
                <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">
                    <div class="d-flex flex-column"> <span class="articles">Your Email</span> <span class="number1">{{$viewdata->email}}</span> </div>
                    <div class="d-flex flex-column"> <span class="followers">Followers</span> <span class="number2">980</span> </div>
                    <div class="d-flex flex-column"> <span class="rating">Rating</span> <span class="number3">8.9</span> </div>
                </div>
                <div class="mt-2 d-flex flex-row align-items-center"> <button class="btn btn-sm btn-outline-primary w-100">Profile Create Date:: {{$viewdata->created_at}}</button> <button class="btn btn-danger w-100 ml-2" data-toggle="modal" data-target="#changepassword">Change Password</button> </div>
            </div>
        </div>
    </div>
<!-- </div> -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!--==============Activate user=========----->
<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('pass_change')}}" id="changepasswordvalidate">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        <label for="old_password">Old Password</label>
        <input class="form-control" type="password" name="old_password">
        @error('oldpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
        <label for="new_password">New Password</label>
        <input class="form-control" type="password" name="newpassword" id="newpassword">
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

<div class="modal fade" id="Image" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('userImage')}}" id="changepasswordvalidate" enctype="multipart/form-data">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <!-- <input class="form-control" type="hidden" name="pass_id" id="pass_id"> -->
        <div class="container">
        <div class="row">
          <div class="col-md-12">
        <label for="new_password">Con Password</label>
        <input class="form-control" type="file" name="profile_image" id="imgInp">
        @error('conpassword')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-12">
            <img id="blah" src="{{asset('user_profile_image')}}/{{$viewdata->image}}" alt="your image" style="height: 200px;width: 200px;"/>
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
<script type="text/javascript">
  imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
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
            old_password:{
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

 