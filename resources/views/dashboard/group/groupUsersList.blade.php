@extends('dashboard.base')
@section('content')
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-12">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i>{{ __('Group Users') }}</div>
            <div class="card-body">
              <table id ="groupUsersTable" class="table table-responsive-sm table-striped table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Group Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0; 
                if(!empty($groupLists)){
                ?>
                @foreach($groupLists as $key=>$groupList) 
                <?php $i++; ?>
                  <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $groupList->data()['name'] }}</td>
                  <td>
                  <div class="action-btn">
                    <a href="{{ url('/group/'.$groupList->data()['groupId']) }}" class="btn btn-outline-primary"><i class="fa fa-eye"></i> View Members</a>
                    <!-- <form action="{{ route('group-destroy', $key ) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Are you sure Delete?')" ><img src="assets/icons/delete.png"></button>
                    </form> -->
                    </div>
                  </td>
                  </tr>
                @endforeach
                <?php } ?>
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
    $('#groupUsersTable').DataTable();
} );
</script>
@endsection