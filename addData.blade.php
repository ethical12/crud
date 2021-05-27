@extends('layouts.header')

@section('content');
<style type="text/css">
  .error{
    color: red;
  }
</style>
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Data</h1>
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
    @if (Session::has('msg'))
       <div class="alert alert-danger" role="alert">
        {!! session('msg') !!}
      </div>
      @endif
    <section class="content">
      <div class="container-fluid">
        <form id="registerForm" action="todo_submit" method="post" enctype="multipart/form-data">
          @csrf
        <!-- <fieldset> -->
        <div class="row">
          <div class="success-alert1"></div>
          <div class="col-md-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" placeholder="Enter Your Name" value="{{ old('name') }}">
            @error('name')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="mobile">Mobile:</label>
            <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
            @error('mobile')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="profile_image">Image:</label>
            <input type="file" class="form-control file_upload1" name="profile_image" id="imgInp" value="{{ old('profile_image') }}">
            <span id="file_error"></span>
            @error('profile_image')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="email">Email:</label>
            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}">
            @error('email')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="Role">Role:</label>
            <select name="role" class="form-control">
              <option></option>
              <option value="user"{{ old('role') == "user" ? 'selected' : '' }}>User</option>
              <option value="admin"{{ old('role') == "admin" ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="Role">Gender:</label><br>
            <span>Male</span>
            <input type="radio" name="gender" value="male"{{ (old('gender') == 'male') ? 'checked' : ''}}>
            <span>Female</span>
            <input type="radio" name="gender" value="femail"{{ (old('gender') == 'femail') ? 'checked' : ''}}>
            @error('gender')
            <p style="color: red">{{$message}}</p>
            @enderror
            <div id="messageBox"></div>
          </div>
          
          <div class="col-md-12"><br>
            <center><button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button></center>
        </div>
        <!-- <div class="Errors">
        <ul></ul> -->
      </div>
        <div class="col-md-6">
            <img id="blah" src="{{asset('user_profile/image.png')}}" alt="your image" style="height: 200px;width: 200px;"/>
        </div>
        </div>
        <!-- </fieldset> -->
      </form>
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- <script src="{{ asset('admin1/js/jquery.js') }}"></script> -->

  <!---======Selected Image Proview--========---->
<script type="text/javascript">
  imgInp.onchange = evt => {
  const [file] = imgInp.files;
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
<!---======End Selected Image Proview--========---->
<script>
$(document).ready(function(){
$("#imgInp").change(function(){
  //alert();
$("#file_error").html("");
$(".file_upload1").css("border-color","#F0F0F0");
var file_size = $('#imgInp')[0].files[0].size;
if(file_size > 2097152) {
  //alert();
$("#file_error").html("<p style='color:#FF0000'>File size is less than 2mb</p>");
$(".file_upload1").css("border-color","#FF0000");
return false;
} 
return true;
});
});
</script>
  <script>
   $("#registerForm").validate({
          rules:{
            name:{
              required: true,
              minlength:3
            },
            mobile:{
              required: true,
              minlength:10,
              maxlength:12
            },
           profile_image:{
              required:true,
              extension:"png|jpg|jpeg"
           },
            email:{
              required: true,
              email:true,
              remote: {
              url: baseUrl+"/email/already",
              type: "post",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {
                email: function() {
                  return $( "#email" ).val();
                },

              }
            }
          },
          role:{
              required: true
            },
            gender:{
              required:true
            }
        },
        errorPlacement: function (error, element) {
            console.log('dd', element.attr("name"))
            if (element.attr("name") == "gender") {
                error.appendTo("#messageBox");
            } else {
                error.insertAfter(element)
            }
        },
          message:{
            name:{
              required:"Name required",
              minlength:"Min length 3"
            },
            mobile:{
              required: "Mobile Number Required",
              minlength:"Min Length 10",
              maxlength:"max Length 10"
            },
            profile_image:{
              required:"image Required",
              extension:"Only Allow png|jpg|jpeg"
           },
           role:{
              required: "Role Required"
            },
            gender:{
              required:"Please Fil Any One"
            }
          }
    });


</script>
@endsection

