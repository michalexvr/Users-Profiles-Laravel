@extends('layouts.app')
@section('content')
<div class="panel panel-default col-md-8 col-md-offset-2">
	<div class="page-title">
		<div class="title_left">
			<h3>Edit User Profile</h3>
		</div>
        <div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            	<div class="input-group">
                	<input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                 </div>
             </div>
        </div>			
	</div>
	<div class="clearfix"></div>
	@if( isset($message) )
  		<div class="alert alert-{{$message["type"]}}" role="alert">{{ $message["data"] }}</div>
	@endif
	@if(session("message"))
		<div class="alert alert-{{session('message')["type"]}}" role="alert">{{ session('message')["data"] }}</div>
	@endif	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
	        <!-- Form -->
        	<form action="{{url('profiles/edit/'.$profile->id)}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
	            <fieldset class="col-md-12">
	                <div class="form-group row">
    	                <label for="profile_name" class="col-sm-2 col-form-label">User Profile Name</label>
        	            <div class="col-sm-10">
            	            <input type="text" class="form-control" id="profile_name" value="{{ $profile->profile_name }}" name="profile_name" placeholder="Operator">
                	    </div>
	                </div>
	            
	                <div class="form-group row">
    	                <label for="profile_description" class="col-sm-2 col-form-label">Description</label>
        	            <div class="col-sm-10">
            	            <input type="text" class="form-control" id="profile_description" value="{{ $profile->profile_description }}" name="profile_description" placeholder="Designed to operate something">
                	    </div>
	                </div>

	                <div class="form-group row">
    	                <label for="profile_description" class="col-sm-2 col-form-label">Permissions</label>
        	            <div class="col-sm-10">
	                      <div class="form-group">
        	                <div class="col-md-9 col-sm-9 col-xs-12">
        	                @foreach($credentials as $credential)
    	                      <div class="">
        	                    <label>
            	                  <input type="checkbox" class="js-switch" name="credential[]" value="{{ $credential['uri'] }}"
            	                  @if(in_array($credential['uri'],$user_credentials))
            	                  	checked
            	                  @endif 
            	                  /> {{ $credential["name"] }}
                	            </label>
                    	      </div>
                    	    @endforeach
    	                    </div>
                      	</div>
                	   </div>
	                </div>

                
        	    </fieldset>


       	        <div class="offset-sm-2 col-sm-2">
               	</div>
       	        <div class="offset-sm-2 col-sm-10">
           	        <button type="submit" class="btn btn-primary">Modify Profile</button>
               	</div>

    	    </form>
    	  	</div>
    	</div>
    </div>
</div>
@endsection