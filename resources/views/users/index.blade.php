@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<h1 class="header-title">{{ trans('user.user_managment_process') }}</h1>
	</div>
	
	<div class="row">
		<div class="table-responsive">

			<table class="table table-borderless" id="table">
				<tr>
					<th>{{ trans('user.table_no') }}</th>
					<th>{{ trans('user.table_name') }} </th>
					<th>{{ trans('user.table_email') }} </th>
					<th>Date of Birth </th>
					<th>Gender</th>
					<th>{{ trans('user.table_role') }} </th>
					<th>{{ trans('user.table_action') }} </th>
				</tr>

				{{ csrf_field() }}

				<?php $no=1; ?>

				@foreach($users as $user)
				<tr class="user{{$user->id}}">
					<td> {{$no++}} </td>
					<td> {{$user->name}} </td> 
					<td> {{$user->email}} </td>
					<td> {{$user->dob}} </td> 
					<td> {{$user->gender}} </td> 
					<td> {{$user->role}} </td>
					<td> 
						@if(Auth::user()->role == 'Administrator')
						<button class="edit-modal btn btn-primary" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-password="{{$user->last_login_at}}" data-role="{{$user->role}}">Reset Password</button>
						@else
						Service is not allowed
						@endif
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	{{ $users->links() }}

	<!-- JavaScript Dialog Box -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal">
						<div class="form-group">
							<label for="id" class="control-label col-sm-2">ID</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fid" disabled="disabled">
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="control-label col-sm-2">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="n" required="required">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-sm-2">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="e" required="email">
							</div>
						</div>
						
						<div class="form-group">
							<label for="role" class="control-label col-sm-2">Reset Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="p" required="password">
							</div>
						</div>
					</form>

					<div class="modal-footer">
						<button type="button" class="btn actionBtn" data-dismiss="modal">
							<span id="footer_action_button"></span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal"> Close </button>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">


				// Edit Data (Modal and function edit data)
				$(document).on('click','.edit-modal', function(){

					
					$('#footer_action_button').text(" Reset Password");

					$('.actionBtn').addClass('btn-success');
					$('.actionBtn').removeClass('btn-danger');
					$('.actionBtn').addClass('edit');

					$('.modal-title').text('Password Reset');
					$('.deleteContent').hide();
					$('.form-horizontal').show();

					$('#fid').val($(this).data('id'));
					$('#n').val($(this).data('name'));
					$('#e').val($(this).data('email'));

					$('#p').val($(this).data('password'));
					$('#myModal').modal('show');

				});

				$('.modal-footer').on('click','.edit',function(){

					$.ajax({
						type: 'post',
						url: 'users/editUser',
						data: {
							'_token' : $('input[name=_token]').val(),
							'id' : $("#fid").val(),
							'name' : $("#n").val(),
							'email' : $("#e").val(),
							'password' : $("#p").val()
						},	
						success: function(data){
							alert("your password has been reset successfully !");
							window.location.href = "users";


						},
						error: function(){
							alert("Sorry, Something wrong...");
							console.log(response);


						}

					});
				});

			</script>
			
			@endsection