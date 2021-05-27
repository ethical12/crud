
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

        <form method="get" action="{{route('deletedsearchuserData')}}">
          
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
            <!-- <div class="col-md-2">
              
                <br>
                <a class="btn btn-warning" href="{{ route('export') }}?search={{request()->get('number')}} & email={{request()->get('email')}} & role={{request()->get('role')}} & created_at={{request()->get('created_at')}} & updated_at={{request()->get('updated_at')}} & name={{request()->get('search')}}">Export Data</a>
           
            </div> -->
            <div class="col-md-1">
              <br>
              <a href="{{route('deleted')}}"><i class="fas fa-sync" style="margin-left: 1%;"></i></a>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
              <form id="myForm" method="get" action="{{route('deletedrowData')}}">
              <div class="col-md-2" style="float: right;">
              <select class="form-select" id="deletedrowfilter" style="width: 100%;" name="rowdataget">
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
    @foreach($viewdata as $todo)
    <tr>
        
      <td>{{$no++}}</td>
      <td class="viewid" style="display: none;">{{$todo->id}}</td>
      <td><img src="{{asset('public/profile_image')}}/{{$todo->image}}" style="height: 50px; width: 50px;border-radius: 25px;"></td>
           <td>{{$todo->name}}</td>
           <td>{{$todo->number}}</td>
           <td>{{$todo->email}}</td>
           <td>{{$todo->role}}</td>
           <td><?php $status=$todo->status; if ($status == 1) { ?>
             <p style="color: green;">Active</p>
           <?php }else{ ?>
            <p style="color: red;">Not Active</p>
           <?php } ?></td>
           <!-- <td>{{$todo->created_at}}</td>
           <td>{{$todo->updated_at}}</td> -->
           <td><button class="btn btn-success restore" data-toggle="modal" data-target="#delete_specialities_details">Restore</button><button class="btn btn-danger delete" data-toggle="modal" data-target="#forcedelete_specialities_details">Delete</button></td>
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
<div class="modal fade" id="forcedelete_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('forcedelete')}}">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you Sure??pDelete</h5>
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
  <!--  delete Modal -->
<div class="modal fade" id="delete_specialities_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form method="post" action="{{route('restore')}}">
          @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you Sure??</h5>
        <input type="hidden" name="deleteid" id="restore_id">
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


<script type="text/javascript">
  $(function() {
      $('#deletedrowfilter').change(function() {
            $('#myForm').submit();
      });
});
</script>

<!-------delete script--------->
<script> 
$(".delete").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
    //alert(rowIndex);
      $('#delete_id').val(rowIndex);
    $('#delete_specialities_details').modal('show');   
});



</script>  
<script> 
$(".restore").click(function() {
    var $row = $(this).closest("tr");
    rowIndex =  $row.find('td:eq(1)').text();
    //alert(rowIndex);
      $('#restore_id').val(rowIndex);
    $('#delete_specialities_details').modal('show');   
});



</script>  
@endsection

