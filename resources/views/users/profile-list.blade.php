@extends('layouts.app')
@section('content')
<div class="panel panel-default col-md-8 col-md-offset-2">
	<div class="page-title">
		<div class="title_left">
			<h3>User Profiles
			@if(App\Http\Controllers\User_credentialsController::has_permision('profiles/add'))
			[<a href="{{ url('profiles/add') }}">Add</a>]
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
		@if(session("message"))
			<div class="alert alert-{{session('message')["type"]}}" role="alert">{{ session('message')["data"] }}</div>
		@endif
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<!-- Table -->
				<table class="table table-responsive" >
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Accions</th>
						</tr>
        			</thead>
        			<tbody>
            		@if( count($profiles) === 0)
            			<tr>
                			<td colspan="6">
								No profiles registered in the system.
							</td>
            			</tr>
            			@else
              				@foreach($profiles as $profile)
              				<tr>
                  				<td>
                      				{{ $profile->profile_name }}
                  				</td>
                  				<td>
                      				{{ $profile->profile_description }}
                  				</td>
                  				{{-- We block the option to delete the admin profile --}}
                  				@if( $profile->profile_name != "admin")
  					            <td>
  					            @if(App\Http\Controllers\User_credentialsController::has_permision('profiles/add'))
                     				<a href="{{ url('profiles/edit/'.$profile->id) }}" role="button" class="btn btn-info btn-xs">
                   	  					<span class="glyphicon glyphicon-pencil" alt="editar"></span> Edit
                     				</a>
                     			@endif
                     			@if(App\Http\Controllers\User_credentialsController::has_permision('profiles/delete/'.$profile->id))
                     				<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm{{ $profile->id }}">
                     					<span class="glyphicon glyphicon-remove" alt="addimagen"></span> Delete profile
                     				</button>
					 				<form action="{{ url('profiles/delete/'.$profile->id) }}" method="post">
					                  <div class="modal fade bs-example-modal-sm{{ $profile->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    					<div class="modal-dialog modal-sm">
                      					<div class="modal-content">
											{{csrf_field()}}
                        					<div class="modal-header">
    	                      					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        	                  					</button>
	                          					<h4 class="modal-title" id="myModalLabel2">Delete profile</h4>
                        					</div>
                        					<div class="modal-body">
                          					<p>When a profile is deleted, it could has users associated.</p>
					                          <p>¿What to do?.</p>
					                          <select name="profile_id">
					                          <option value="delete">Delete asociated users</option>
											  @foreach($profiles as $prf)
											  	@if($profile->id != $prf->id)
											  		<option value="{{$prf->id}}">Transfer to the profile {{$prf->profile_name}}</option>
											  	@endif
											  @endforeach
											  </select>
					                        </div>
					                        <div class="modal-footer">
					                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					                          
					                          <button type="submit" class="btn btn-danger">Delete Profile</a>
					                        </div>

					                      </div>
					                    </div>
					                  </div>
					                  </form>
					                  @endif
  					            </td>
  					            @endif
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