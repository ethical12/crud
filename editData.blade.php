@extends('layouts.header')

@section('content');
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Data</h1> 
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
       <div class="alert alert-danger" role="alert">
        {!! session('msg') !!}
      </div>
      @endif
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <form id="registerForm" method="POST" action="{{route('todo.update',[$todoArr->id])}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
        <div class="col-md-6">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$todoArr->name}}">
            @error('name')
            <p style="color: red">{{$message}}</p>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="mobile">Mobile:</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="{{$todoArr->number}}">
            @error('mobile')
            <p style="color: red">{{$message}}</p>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$todoArr->email}}">
            @error('email')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="Role">Role:</label>
            <select name="role" id="role" class="form-control">
              <option value="{{$todoArr->role}}">{{$todoArr->role}}</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
            @error('role')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="image">Image:</label>
            <input type="file" name="profile_image" value="{{$todoArr->image}}" class="form-control" id="imgInp">
            <span id="file_error" style="float: right"></span>
            @error('profile_image')
            <p style="color: red">{{$message}}</p>
            @enderror
          </div>
<br>
        <div id="updateupdateResult"></div>
        <div class="col-md-6"><br>
            <center><button style="cursor:pointer" type="submit" id="updatedataBtn" class="btn btn-primary">Submit</button></center>
        </div>
        <div class="col-md-6">
            <img id="blah" src="{{asset('public/profile_image')}}/{{$todoArr->image}}" alt="your image" style="height: 200px;width: 200px;"/>
        </div>
    </form>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!---======Selected Image Proview--========---->
<script type="text/javascript">
  imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}
</script>
<!---======End Selected Image Proview--========---->
  <script>
    $(document).ready(function() {

    $("#updatedataBtn").click(function() {

      var response =  validateForm();
      
      if(response == 0) {
        return;
      }

      var name  =   $("#name").val();
      var email  =   $("#email").val();
      var number  =   $("#mobile").val();
      var role  =   $("#role").val();
      // sending ajax request
      $.ajax({

        url: '{{route('todo.update',[$todoArr->id])}}',
        type: 'post',
        data: {
             
             "_token": "{{ csrf_token() }}",
               'name' : name, 'email' : email, 'mobile' : number, 'role' : role
          },
          
        //dataType: 'json',

        // before ajax request
        beforeSend: function() {
            $("#update_form")[0].reset();
          $("#updateResult").html("<p class='text-success'> Please wait.. </p>");
            
           $("#updatedataBtn").hide();
        },  

        // on success response
        success:function(response) {
            $("#update_form")[0].reset();
          $("#updateResult").html(response);
                        Swal.fire(
                              'Data Update Sucessfull!!!!',
                              'You clicked the button!',
                              'success'
                            );
                   window.location.href = "{{route('alldata')}}";
          $("#updatedataBtn").show();
        },

        // error response
        error:function(e) {
          $("#updateResult").html("Some error encountered.");
          
          $(".success-alert1").fadeTo(2000, 500).slideUp(500, function(){
                            $(".success-alert1").slideUp(500);
                        });
                        
                        
        }

      });
    });
  // ------------- form validation -----------------

    function validateForm() {

      $("#error").remove();

      if($("#name").val() == "") {
        $("#name").after("<span id='error' class='text-danger'> Enter your name </span>");
        return 0;
      }

      if($("#mobile").val() == "") {
        $("#mobile").after("<span id='error' class='text-danger'>Enter your mobile Number </span>");
        return 0;
      }
      
      if($("#email").val() == "") {
        $("#email").after("<span id='error' class='text-danger'>Enter your email </span>");
        return 0;
      }
      if($("#role").val() == "") {
        $("#role").after("<span id='error' class='text-danger'>Enter your role </span>");
        return 0;
      }
      
      return 1;

    }
    function getData() {
        
        var email  =   $("#email").val();
        // sending ajax request
      $.ajax({

        url: '{{route('todo.getdata')}}',
        type: 'get',
        dataType:"json",
          data: {
               "_token": "{{ csrf_token() }}",
               'email' : email
          },
          
        success:function(response) {
              //   print_r(response); die;
                //alert(response);
                  var obj = JSON.parse(response);
                   $("#name").val(obj.name);
                   $("#email").val(obj.email);
                   $("#mobile").val(obj.number);
                   $("#role").val(obj.role);
                  
                     
        },
        
        error:function(e) {
          alert();
                        
                        
        }

        });
    }
  
});


</script>
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
              // required:true,
              extension:"png|jpg|jpeg"
           },
            email:{
              required: true,
              email:true,
            //   remote: {
            //   url: baseUrl+"/email/already",
            //   type: "post",
            //   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //   data: {
            //     email: function() {
            //       return $( "#email" ).val();
            //     },

            //   }
            // }
            },
            role:{
              required: true
            },
            gender:{
              required:true
            }
          },
          messages:{
            name:{
              required:"Please Fill Name!!!",
              minlength:"!!3 charector required!!"
            },
            mobile:{
              required:"Mobile Number Required",
            minlength:"MinLength 10",
            maxlength:"maxlength 12"
          },
          profile_image:{
            extension:"Wrong File Type Only allow png,jpg,jpeg"
          },
          email:{
            required:"Email IS Required",
            email:"Please Fill Correct Email",
            remote:"Email Already"
          },
          role:{
            required:"Fill Role"
          },
          gender:{
            required:"Please Select Any One"
          }
          }
    });


</script>
@endsection
