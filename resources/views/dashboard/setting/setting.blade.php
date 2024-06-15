@extends('dashboard.base')
@section('content')
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-12">
            <div class="card">
               <div class="card-header">
                <i class="fa fa-align-justify"></i>{{ __(' General Setting') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/setting-update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <?php
                            $app_name = DB::table('general_settings')
                            ->where('s_key', 'app_name')
                            ->first();
                            
                            $appname = $app_name->s_value;
                        ?>
                        <div class="input-group mb-4">
                            
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    App Name
                                </span>
                            </div>
                            <input id="title" class="form-control @error('app_name') is-invalid @enderror" type="text" placeholder="{{ __('App Name') }}" name="app_name" value="{{ $appname }}" required>
                            @error('app_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <?php
                            $color = DB::table('general_settings')
                            ->where('s_key', 'app_color')
                            ->first();
                            
                            $color_b = $color->s_value;
                            
                            $color_a = str_replace("0XFF", "", $color_b);
                            $app_color = '#' . $color_a;
                        ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                  App Color
                                </span>
                            </div>
                            <input id="pushnotis" class="form-control @error('app_color') is-invalid @enderror" type="color" placeholder="{{ __('App Color') }}" name="app_color" value="{{ $app_color }}" required style="max-width:20%; margin-left:0px;" >
                            @error('app_color')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group input-group mb-3">
                            
                            <div class="input-group-prepend">
                                  App Logo
                                
                            </div>
                            
							<div class="input-group">
								<div class="custom-file">
								    <label class="custom-file-label" for="uploadimage">Choose file</label>
									<input type="file" class="form-control @error('app_logo') is-invalid @enderror" name="app_logo" id="uploadimage">
								</div>
							</div>
						</div>
						
						<div class="user-profile">
                            <?php
                            $app_logo = DB::table('general_settings')
                            ->where('s_key', 'app_logo')
                            ->first();
                            
                            if(!empty($app_logo->s_value)){ ?>
                            
                            <img src="{{ url('/public/app_logo') }}/<?php echo $app_logo->s_value; ?>" style="width:100px; height:100px;">
                           
                            <?php } ?>
                        </div>
                        
                        <div class="form-group input-group mb-3"></div>
                        
                        <button class="btn btn-block btn-success" type="submit">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
@section('javascript')

<script src="https://adminlte.io/themes/v3/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
    
// <script>
// $(document).ready(function() {
//     $('#notification').DataTable();
// } );
// </script>
@endsection