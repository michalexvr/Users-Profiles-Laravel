@extends('layouts.app')
@section('content')
<div class="panel panel-default col-md-8 col-md-offset-2">
	<div class="page-title">
		<div class="title_left">
			<h3>New User</h3>
		</div>
        <div class="title_right">
			<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            	<div class="input-group">
                	<input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">GO!</button>
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
        	<form action="{{url('users/add')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
	            <fieldset class="col-md-12">
	                <div class="form-group row">
    	                <label for="name" class="col-sm-2 col-form-label">User Name</label>
        	            <div class="col-sm-10">
            	            <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="John Connor">
                	    </div>
	                </div>
	            
	                <div class="form-group row">
    	                <label for="email" class="col-sm-2 col-form-label">Email</label>
        	            <div class="col-sm-10">
            	            <input type="text" class="form-control" id="email" value="{{ old('email') }}" name="email" placeholder="someone@mail.com">
                	    </div>
	                </div>

    	            <div class="form-group row">
        	            <label for="category" class="col-sm-2 col-form-label">User Profile</label>
	                	    <div class="col-sm-10">
    	        	            <select class="form-control" name="user_profile_id">
    	        	            @foreach($profiles as $profile)
    	        	            	<option value="{{ $profile->id }}" >{{ $profile->profile_name }}</option> 
    	        	            @endforeach
                	        	</select>                    	    
                    	</div>
	                </div>

	                <div class="form-group row">
    	                <label for="password" class="col-sm-2 col-form-label">Password</label>
        	            <div class="col-sm-10">
            	            <input type="password" class="form-control" id="password" name="password" >
                	    </div>
	                </div>

	                <div class="form-group row">
    	                <label for="password_confirm" class="col-sm-2 col-form-label">Confirm Password</label>
        	            <div class="col-sm-10">
            	            <input type="password" class="form-control" id="password_confirm" name="password_confirm" >
                	    </div>
	                </div>
                
        	    </fieldset>


       	        <div class="offset-sm-2 col-sm-2">
               	</div>
       	        <div class="offset-sm-2 col-sm-10">
           	        <button type="submit" class="btn btn-primary">Add User</button>
               	</div>

    	    </form>
    	  	</div>
    	</div>
    </div>
</div>
@endsection