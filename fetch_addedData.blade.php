
@extends('layouts.header')
@section('content');

<style type="text/css">
  .show_data{border:none;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="padding: 2px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All Data</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li> -->
              <li class="breadcrumb-item active"><a class="btn btn-warning" href="{{ route('showData')}}">Add Data</a></li>
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

        <form method="get" action="{{route('searchuserData')}}">
        <div class="row" style="margin-bottom: 1%;">
          <div class="col-md-2">
              <input type="search" name="search" value="{{ $search??null}}" class="form-control" placeholder="by name">
            </div>
            <div class="col-md-2">
              <input type="search" name="number" value="{{ $number??null}}" class="form-control" placeholder="by number">
            </div>
            <div class="col-md-2">
              <input type="search" name="email" value="{{ $email??null}}" class="form-control" placeholder="by email">
            </div>
            <div class="col-md-2">
              <input type="search" name="role" value="{{ $role??null}}" class="form-control" placeholder="by role">
            </div>
            <div class="col-md-2">
              <input type="date" name="created_at" value="{{ $created_at??null}}" class="form-control" placeholder="by created_at">
            </div>
            <div class="col-md-2">
              <input type="date" name="updated_at" value="{{ $updated_at??null}}" class="form-control" placeholder="by updated_at">
            </div>
            <div class="col-md-1">
              <br>
              <button class="btn btn-dark">Search</button>
            </div>
            </form>
            <div class="col-md-2">
              
                <br>
                <a class="btn btn-warning" href="{{ route('export') }}?search={{request()->get('number')}} & email={{request()->get('email')}} & role={{request()->get('role')}} & created_at={{request()->get('created_at')}} & updated_at={{request()->get('updated_at')}} & name={{request()->get('search')}}">Export Data</a>
           
            </div>
            
            <div class="col-md-1">
              <br>
              <a href="fetch_addeddata"><i class="fas fa-sync" style="margin-left: 1%;"></i></a>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <form id="myForm" method="get" action="{{route('getRowData')}}">
              <!-- @csrf -->
              <div class="col-md-2" style="float: right;">
              <select class="form-select" id="rowfilter" style="width: 100%;" name="rowdataget">
                <option>{{ $rowfilter??null}}</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
              </select>
              </div>
            </div>
            </form>
        </div>
        <div class="row">

    <table id="example" class="table nowrap" style="background-color: white;">
      <thead>
        <!-- <tr>
          <td></td>
          <td><input type="text" id="exam_search" class="form-control" placeholder="by name"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by number"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by email"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by role"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by status"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by created_at"></td>
          <td><input type="search" name="search" class="form-control" placeholder="by updated_at"></td>
        </tr> -->
        <tr>
           <th>S.No</th>
           <th>Image</th>
           <th>@sortablelink('name')</th>
           <th>@sortablelink('number')</th>
           <th>@sortablelink('email')</th>
           <th>@sortablelink('role')</th>
           <th>@sortablelink('status')</th>
           <!-- <th>@sortablelink('created_at')</th>
           <th>@sortablelink('updated_at')</th> -->
           <th>action</th>
        </tr>
      </thead>
    <tbody>
    @foreach($viewdata as $key =>$todo)
    <tr>
        
      <td>{{ ($viewdata->currentpage()-1) * $viewdata->perpage() + $key + 1 }}</td>
      <td class="viewid" style="display: none;">{{$todo->id}}</td>
      <td><img src="{{asset('public/profile_image')}}/{{$todo->image}}" style="height: 50px; width: 50px;border-radius: 25px;"></td>
           <td>{{$todo->name}}</td>
           <td>{{$todo->number}}</td>
           <td>{{$todo->email}}</td>
           <td>{{$todo->role}}</td>
           <td><?php $status=$todo->status; if ($status == 1) { ?>
             <!-- <p style="color: green;">Active</p> -->
             <svg xmlns="http://www.w3.org/2000/svg" width="35" height="25" fill="currentColor" class="bi bi-toggle-on active" viewBox="0 0 16 16" style="color:green;" data-toggle="modal" data-target="#active">
            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
           <?php }else{ ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="26" fill="currentColor" class="bi bi-toggle-on dactive" viewBox="0 0 16 16" style="color:red;" data-toggle="modal" data-target="#dactive">
            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
           <?php } ?></td>
           <!-- <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td> -->
           <td>
            @can("allowUser",$todo)
            <!-- <a href="#" class="delete">Delete</a> --><i class="fas fa-trash-alt delete" data-toggle="modal" data-target="#delete_specialities_details"></i>
            @endcan
            <a href="{{route('todo_edit',[ base64_encode($todo->id ?? '') ])}}"><i class="fas fa-pen"></i></a>
            <!-- <a href="{{route('todo_view',[$todo->id])}}"> --><i class="far fa-eye viewdata" data-toggle="modal" data-target="#view_specialities_details"></i><!-- </a> -->
            </form>
           </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    {!! $viewdata->appends(Request::input())->render() !!}
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--==============Activate user=========----->
<div class="modal fade" id="active" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('activeUser')}}">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure You Are Dactivated This..</h5>
        <input type="hidden" name="current_url" value="{{  url()->full() }}">
        <input type="hidden" name="active_id" id="active_id">
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
<!---===================Dactivate User============----->
<div class="modal fade" id="dactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('activeUser')}}">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are You Sure You Are Activated This</h5>
        <input type="hidden" name="current_url" value="{{  url()->full() }}">
        <input type="hidden" name="active_id" id="dactive_id">
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
  <!--  delete Modal -->
<div class="modal fade" id="delete_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="todo_delete">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you Sure??</h5>
        <input type="hidden" name="deleteid" id="delete_id">
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
<!---------view model---------->
<!-- Modal -->
<div class="modal fade" id="view_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="todo_delete">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document" style="padding: 2%;">
    <div class="modal-content">
      <div class="container" style="height: 300px; overflow-x: scroll;">
        <!-- <div id="result"></div> -->
        <table id="show" class="table">
          
        </table>
        <!-- <input type="text" name="name" id="name">
        <input type="text" name="name" id="name">
        <input type="text" name="name" id="mobile"> -->
      </div>
      <div class="modal-footer">
        <!-- <button type="submit" class="btn btn-primary">Yes</button> -->
       
        </form>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!------without submit send data on contriller for rowselect------>
<script>
$(document).ready(function() {
    $(".viewdata").click(function() {
            // var formData = $(".idform").val();
            // alert(formData);
            var row = $(this).closest("tr").find('.viewid').text();
             //alert(row);
             $.ajax({
                 url:'{{route('todo_view')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
                  "row":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#show").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },  
                  success: function(response){
                    
                      $('#show').html(response);

               }
             });
        });  
});
  </script>  



<script type="text/javascript">
  $(function() {
      $('#rowfilter').change(function() {
            $('#myForm').submit();
      });
});
</script>
<!-------delete script--------->
<script> 
$(".delete").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#delete_id').val(rowIndex);
    $('#delete_specialities_details').modal('show');   
});



</script> 

<!-----active----->
<script> 
$(".active").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#active_id').val(rowIndex);  
});
</script> 
<!-----dacrive----->
<script> 
$(".dactive").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
      $('#dactive_id').val(rowIndex); 
});



</script> 
@endsection

