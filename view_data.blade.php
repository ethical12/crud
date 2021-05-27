
@extends('layouts.header')
@section('content');
<style type="text/css">
  tr{margin-left: 2px;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="padding: 2px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Mr.{{ $viewuserdata->name }}</h1>
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
      <div class="container-fluid">
        <table style="background-color: white;width: 100%;">
          <tr>
            <th>Name</th>
            <td>{{ $viewuserdata->name }}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $viewuserdata->email }}</td>
          </tr>
          <tr>
            <th>Phone</th>
            <td>{{ $viewuserdata->number }}</td>
            </tr>
            <tr>
            <th>Role</th>
            <td>{{ $viewuserdata->role }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>{{ $viewuserdata->status }}</td>
          </tr>
          <tr>
            <th>Createad_at</th>
            <td>{{ $viewuserdata->created_at }}</td>
          </tr>
          <tr>
            <th>Updated_at</th>
            <td>{{ $viewuserdata->updated_at }}</td>
          </tr>
        </table>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@endsection

