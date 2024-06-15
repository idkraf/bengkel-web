@extends('dashboard.base')
@section('content')
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-12">
            <div class="card">
                <div class="card-header">
                  <i class="fa fa-align-justify"></i> Group Name: {{ $group->data()['name'] }}</div>
                <div class="card-body">
                    <h5>Group Desc: {{ $group->data()['name'] }}</h5>
                    <!--<a href="{{ route('users.index') }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>-->
                    <table id="groupMember" class="table table-responsive-sm table-striped table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>id</th>
                            <th>Member</th>
                            <!--<th>Action</th>-->
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        if (!empty($group->data()['name'])) { ?>
                          @foreach($user as $name) 
                            <?php
                            $i++;
                            if (isset($name)) { ?>
                              <tr>
                                  <td>{{ $i }}</td>
                                  <td>{{$name['name']}}</td>
                              </tr>
                            <?php } ?>
                          @endforeach
                        <?php }
                        ?>
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
    $('#groupMember').DataTable();
} );
</script>
@endsection