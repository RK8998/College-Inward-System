@extends('layouts.header')

@section('content')

	
	<br>
	<div class="row">
		<div class="col-10">
			<form action="{{ url('add_dept') }}" method="POST" id="addform">
				@csrf
				<div class="row">
					<div class="col-3">
						<input type="text" name="dname" id="dname" placeholder="Department" 
						class="form-control" autocomplete="off">
						<span style="color:red;">@error('dname') {{'Department*'}}@enderror</span>
					</div>
					<div class="col-5">
						<input type="text" name="name" id="name" placeholder="Department Name" 
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
				<h4>Department</h4>
			</div>
		</div>	
		@if(isset($edit))
			@foreach($edit as $item)
			<div class="col-10">
				<form action="{{ url('update_dept') }}" method="POST" id="editform">
					@csrf	
					<input type="hidden" name="edid" id="edid" value="{{$item->did}}">
					<div class="row">
						<div class="col-3">
							<input type="text" name="edname" id="edname" class="form-control" 
							placeholder="Update Department"  autocomplete="off" value="{{$item->dname}}">
							<span style="color:red;">@error('edname') {{'Department*'}}@enderror</span>
						</div>
						<div class="col-5">
							<input type="text" name="ename" id="ename" class="form-control" 
							placeholder="Update Department Name" autocomplete="off" value="{{$item->name}}">	
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
				<th>Genral No.</th>
				<th>Department</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $dept)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$dept->dname}}</td>
					<td>{{$dept->name}}</td>
					<td>
						<a href="{{ url('edit_dept',[$dept->did]) }}" id="edit" class="btn btn-success" >
							<i class="fa fa-edit"></i></a>
						<a href="{{url('delete_dept',[$dept->did])}}" class="btn btn-danger"
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