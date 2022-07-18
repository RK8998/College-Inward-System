@extends('layouts.header')

@section('content')

	
	 <br>
	<div class="row">
		<div class="col-10">
			<form action="{{ url('add_fac') }}" method="POST" id="addform">
				@csrf
				<div class="row">
					<div class="col-3">
						<select name="did" class="form-control">
							<option value="-1">Select Department</option>
							@foreach($dept as $d)
								<option value="{{$d->did}}">{{$d->dname}}</option>
							@endforeach
						</select>
						<span style="color:red;">@error('did') {{'Department*'}}@enderror</span>
					</div>
					<div class="col-5">
						<input type="text" name="name" id="name" placeholder="Faculty Name" 
						class="form-control" autocomplete="off">	
						<span style="color:red;">@error('name') {{'Name*'}} @enderror</span>
					</div>
					<div class="col-2">
						<input type="submit" name="add" id="add" value="Add" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
		<div class="col-2">
			<div style="border-radius: 20px;padding: 10px 15px 5px 10px;width: 150px;
				text-align: center;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;cursor: pointer;">
				<h4>Faculty</h4>
			</div>
		</div>
		@if(isset($edit))
			@foreach($edit as $item)
			<div class="col-10">
				<form action="{{ url('update_fac') }}" method="POST" id="editform">
					@csrf	
					<input type="hidden" name="efid" id="efid" value="{{$item->fid}}">
					<div class="row">
						<div class="col-3">
							<select name="edid" class="form-control">
								<option value="-1">Select faculty</option>
								@foreach($dept as $d)
									@if($d->did == $item->did)
										<option value="{{$d->did}}" selected>{{$d->dname}}</option>
									@else
										<option value="{{$d->did}}">{{$d->dname}}</option>
									@endif
								@endforeach
							</select>
							<span style="color:red;">@error('edid') {{'Department*'}}@enderror</span>
						</div>
						<div class="col-5">
							<input type="text" name="ename" id="ename" class="form-control" 
							placeholder="Update Faculty Name" autocomplete="off" value="{{$item->name}}">	
							<span style="color:red;">@error('ename') {{'Name*'}} @enderror</span>
						</div>
						<div class="col-2">
					  <input type="submit" name="update" id="update" value="Update" class="btn btn-primary">
						</div>
					</div>
				</form>
			</div>
			@endforeach
		@endif	 
	</div>
	<hr>
	@if(Session::get('success'))
		<div id="msg" class="alert alert-success">{{Session::get('success')}}</div>
	@endif
	@if(Session::get('fail'))
		<div id="msg" class="alert alert-danger">{{Session::get('fail')}}</div>
	@endif	

	<br>
	<table id="tbl" class="display" width="100%" style="text-align: center;">
		<thead>
			<tr>
				<th>No.</th>
				<th>Department</th>
				<th>faculty</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($fac as $item)
				<tr>
					<td>{{$loop->iteration}}</td>
					@foreach($dept as $d)
						@if($d->did == $item->did)
							<td>{{$d->dname}}</td>
						@endif
					@endforeach
					<td>{{$item->name}}</td>
					<td>
						<a href="{{ url('edit_fac',[$item->fid]) }}" id="edit" class="btn btn-success" >
							<i class="fa fa-edit"></i></a>
						<a href="{{url('delete_fac',[$item->fid])}}" class="btn btn-danger"
							onclick="return confirm('Are you Sure ?')">
							<i class="fa fa-trash"></i></a>
        				</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>


@endsection

@extends('layouts.footer')

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
      		$('#tbl').DataTable();
      		// $('#msg').delay(2000).hide();
    	});
	</script>
@endsection