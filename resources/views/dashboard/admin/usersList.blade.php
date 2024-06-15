@extends('dashboard.base')
@section('content')
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-12">
          <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i>{{ __('Users') }}</div>
              <div class="card-body">
                <div class="row"> 
                  <a href="{{ route('users.create') }}" class="btn btn-primary m-2">{{ __('Add User') }}</a>
                </div>
                <table id="userstable" class="table table-responsive-sm table-striped table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Uid</th>
                    <th>Phone Number</th>
                    <th>Nama</th>
                    <th>NamaBisnis</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($userListArray as $user) 
                    <tr>
                      <td>{{ $user->data()['uid'] }}</td>
                      <td>{{ $user->data()['phoneNumber'] }}</td>
                      <td>{{ $user->data()['name'] }}</td>
                      <td>{{ $user->data()['namaBisnis'] }} <br> {{ $user->data()['deskripsi'] }}</td>
                      <td>
                      <div class="action-btn" style="display: inline-flex;">
                        <a href="{{ url('/users/' . $user->data()['uid']) }}" class="btn btn-outline-warning btn-sm"><span class="fa fa-eye"></span></a>
                        <a href="{{ url('/users/' . $user->data()['uid'] . '/edit') }}" class="btn btn-outline-info btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        <a href="{{ url('/users/' . $user->data()['uid'] . '/reloadData') }}" class="btn btn-outline-info btn-sm"><i class="fa fa-pencil-square-o"></i> Update</a>
                        
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')


<script>
$(document).ready(function() {
    $('#userstable').DataTable();
} );
</script>
@endsection