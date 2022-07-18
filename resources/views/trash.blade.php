@extends('layouts.header')

@section('content')

	<br>
	<div class="row">
		<div class="col-2">
			<div style="border-radius: 20px;padding: 10px 10px 5px 10px;width: 150px;
				text-align: center;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;cursor: pointer;">
				<h4>Trash &nbsp;&nbsp;<i class="fa fa-trash"></i></h4>
			</div>		
		</div>
		<div class="col-3">
			@if(Session::get('success'))
				<div id="msg" class="alert alert-success">{{Session::get('success')}}</div>
			@endif
			@if(Session::get('fail'))
				<div id="msg" class="alert alert-danger">{{Session::get('fail')}}</div>
			@endif	
		</div>
	</div>
	
	<br>
	<table id="tbl" class="display" width="100%" style="text-align:center;">
		<thead>
			<tr>
				<th>No.</th>
				<th>Department</th>
				<th>Inward No.</th>
				<th>Date</th>
				<th>Received From</th>
				<th>Subject</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data['trash'] as $trash)
				<tr>
					<td>{{$loop->iteration}}</td>
					<!-- <td>
						@foreach($data['gno'] as $dept)
							@if($trash->gno == $dept->did)
								{{$dept->dname}}
							@endif
						@endforeach
						
					</td> -->
					<td>{{$trash->gno}}</td>
					<td>{{$trash->ino}}</td>
					<td>{{ \Carbon\Carbon::parse($trash->date)->format('d/m/Y') }}</td>
					<!-- <td>
						@foreach($data['fac'] as $fac)
							@if($trash->rfrom == $fac->fid)
								{{$fac->name}}
							@endif
						@endforeach
					</td> -->
					<td>{{$trash->rfrom}}</td>
					<td style="width: 300px; text-align: justify;">{{$trash->subject}}</td>
					<td>
						<!-- <a href="#" class="btn btn-success"><i class="fa fa-edit"></i></a> -->
						<a href="{{url('delete_trash',[$trash->tid])}}" class="btn btn-danger"
							onclick="return confirm('Are you Sure ?')" title="Permanently removed">
							<i class="fa fa-trash"></i></a>

						<a href="{{url('restore',[$trash->tid])}}" class="btn btn-primary"
							onclick="return confirm('Are you Sure ?')" title="Restore">
							<i class="fa-solid fa-arrows-rotate"></i></a>
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
		$(document).ready(function() {
            $('#subject').val($.trim($('#subject').val()));
            $("#gno_name").hide();	
            document.getElementById('txtDate').valueAsDate = new Date();    
        });

		$(document).ready(function(){

			// fetch department name
			$(document).on("click","#plus",function(e){
				e.preventDefault();
				$("#gno").html(" ");
				document.getElementById('gno').innerHTML += "<option value=-1>Select Department</option>";
				$.ajax({
					type:'GET',
					url:'fetch_dept', 
					dataType:'json',
					success:function(response){
						// console.log(response.dept.length);
						for (var i = 0; i<response.dept.length; i++) {
							// console.log(response.dept[i].dname);
							var dname = response.dept[i].dname;
							var did = response.dept[i].did;
							var tag = "<option>"+dname+"</option>";
 							document.getElementById('gno').innerHTML += tag;
						}
						document.getElementById('gno').innerHTML += "<option value=0>Other</option>";
					}
				});
			});

			// on changed genral number (department)
			$(document).on("change","#gno",function(e){
				e.preventDefault();
				
				$("#div_gno_name").html(" ");
				$("#gno_name").show();
				$("#fac").html(" ");
				document.getElementById('fac').innerHTML += "<option value=-1>Select Faculty</option>";
				
				if($("#gno").val() != 0)
				{
					var data = {
						'dname':$("#gno").val(),
					}

					$.ajaxSetup({
					    headers: {
					        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					    }
					});

					$.ajax({
						type:'GET',
						url:'fetch_dept_name',
						data:data,
						dataType:'json',
						success:function(response){
							console.log(response);
							var tag1 = "<input type='text' name='gno_name' id='gno_name' \
							class='form-control' value='"+response.dept_name[0].name+"' disabled>";
							document.getElementById('div_gno_name').innerHTML += tag1;

							for (var i = 0; i<response.fac.length; i++) {
								var name = response.fac[i].name;
								var fid = response.fac[i].fid;
								var tag = "<option>"+name+"</option>";
	 							document.getElementById('fac').innerHTML += tag;
							}
							document.getElementById('fac').innerHTML += "<option value=0>Other</option>";
						}
					});
				}
				else
				{
					var tag2 = "<input type='text' name='gno_name' id='gno_name'\
					placeholder='Enter Genral No.' class='form-control'>";
					document.getElementById('div_gno_name').innerHTML += tag2;
					document.getElementById('fac').innerHTML += "<option value=0>Other</option>";
				}
			});


			$(document).on("change","#fac",function(e){
				e.preventDefault();
				if($("#fac").val() == 0)
				{
					var tag = "<input type='text' name='fac_name' id='fac_name'\
					placeholder='Enter Reciever Name.' class='form-control'>";
					document.getElementById('div_fac_name').innerHTML += tag;
				}
				
			});
		});
	</script>
	
@endsection