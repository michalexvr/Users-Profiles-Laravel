@extends('layouts.app')
@section('content')
<div class="panel panel-default col-md-8 col-md-offset-2">
	<div class="page-title">
		<div class="title_left">
			<h3>Users
			@if(App\Http\Controllers\User_credentialsController::has_permision('users/add')) 
				[<a href="{{ url('users/add') }}">Add</a>]
			@endif
			</h3>
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
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<!-- Table -->
				<table class="table table-responsive" >
					<thead>
						<tr>
							<th>Name</th>
							<th>Mail</th>
							<th>Profile</th>
							<th>Actions</th>
						</tr>
        			</thead>
        			<tbody>
            		@if( count($users) === 0)
            			<tr>
                			<td colspan="6">
								No users registered in the system.
							</td>
            			</tr>
            			@else
              				@foreach($users as $user)
              				<tr>
                  				<td>
                      				{{ $user->name }}
                  				</td>
                  				<td>
                      				{{ $user->email }}
                  				</td>
                  				<td>
                      				{{ isset($profiles[$user->user_profile_id])?$profiles[$user->user_profile_id]:"Without profile" }}
                  				</td>
  					            <td>
  					            @if(App\Http\Controllers\User_credentialsController::has_permision('users/edit/'.$user->id))
                     				<a href="{{ url('users/edit/'.$user->id) }}" role="button" class="btn btn-info btn-xs">
                   	  					<span class="glyphicon glyphicon-pencil" alt="editar"></span> Edit
                     				</a>
                     			@endif
                     			@if(App\Http\Controllers\User_credentialsController::has_permision('users/password/'.$user->id))
                     				<a href="{{ url('users/password/'.$user->id) }}" role="button" class="btn btn-success btn-xs">
                   	  					<span class="glyphicon glyphicon-lock" alt="addimagen"></span> Change Password
                     				</a>
                     			@endif
                     			@if(App\Http\Controllers\User_credentialsController::has_permision('users/delete/'.$user->id))
                     				<a href="{{ url('users/delete/'.$user->id) }}" role="button" class="btn btn-danger btn-xs"  onclick="return confirm('User will be deleted, ¿Are you sure?');">
                   	  					<span class="glyphicon glyphicon-remove" alt="addimagen"></span> Delete user
                     				</a>
                     			@endif
  					            </td>                
							</tr>
  					        @endforeach
            		@endif
  					</tbody>
				</table>
			</div>
		</div>
	</div>
 </div> 
@endsection