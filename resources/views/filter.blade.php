@extends('layouts.header')

@section('content')

	<br>
	<div class="row">
		<div class="col-2">
			<div style="border-radius: 20px;padding: 10px 10px 5px 10px;width: 150px;
				text-align: center;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;cursor: pointer;">
				<h4>Filter &nbsp;&nbsp;<i class="fa-solid fa-filter"></i></h4>
			</div>		
		</div>
		<div class="col-5">
			@if(Session::get('success'))
				<div id="msg" class="alert alert-success">{{Session::get('success')}}</div>
			@endif
			@if(Session::get('fail'))
				<div id="msg" class="alert alert-danger">{{Session::get('fail')}}</div>
			@endif	
		</div>
	</div>

	<br>
	<table id="tbl" class="display" width="100%" style="text-align: center;">
		<thead>
			<tr>
				<th>No.</th>
				<th>Department</th>
				<th>Inward No.</th>
				<th>Date</th>
				<th>Received From</th>
				<th>Subject</th>
			</tr>
		</thead>
		<tbody>
			@foreach($filter as $list)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$list->gno}}</td>
					<td>{{$list->ino}}</td>
					<td>{{ \Carbon\Carbon::parse($list->date)->format('d/m/Y') }}</td>
					<td>{{$list->rfrom}}</td>
					<td style="width: 255px;text-align: justify;">
						{{$list->subject}}
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
      		// $('#tbl').DataTable();
					$('#tbl').DataTable( {
						dom: 'Bfrtip',
						buttons: [
							'copy', 'csv', 'excel', 'pdf', 'print'
						]
					});

					$("#plus").hide();
			});
	</script>
	
@endsection