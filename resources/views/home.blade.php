@extends('layouts.header')

@section('content')

<!-- Edit Modal -->
<!--   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group">
              <label><b>Department : </b></label>
              <select name="egno" class="form-control" id="egno">    
              </select>
              <div id="ediv_gno_name"></div>
              <span style="color:red">@error('egno') {{'Genral No*'}} @enderror</span>
              <span style="color:red">@error('egno_name') {{' '}} @enderror</span>
              <br>
            </div>
            
            <div class="form-group">
              <label><b>Date : </b></label>
              <input type="date" name="edate" id="etxtDate" class="form-control">
              <span style="color:red">@error('edate') {{'Date*'}} @enderror</span><br>
            </div>

            <div class="form-group">
              <label><b>Received From : </b></label>
              <select name="efac" class="form-control" id="efac">
                <option value="-1">Select Faculty</option>
              </select>
              <div id="ediv_fac_name"></div>
              <span style="color:red">@error('efac') {{'Receive From*'}} @enderror</span>
              <span style="color:red">@error('efac_name') {{' '}} @enderror</span>
              <br>
            </div>

            <div class="form-group">
              <label><b>Subject : </b></label>
              <textarea name="esubject" id="esubject" placeholder="Write here..." class="form-control">    
              </textarea>
              <span style="color:red">@error('esubject') {{'Subject*'}} @enderror</span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" value="Update" name="update" id="update" class="btn btn-primary" />
        </div>
        </form>
      </div>
    </div>
  </div>

 -->
	<br>
	<div class="row">
		<div class="col-2">
			<div style="border-radius: 20px;padding: 10px 10px 5px 10px;width: 150px;
				text-align: center;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;cursor: pointer;">
				<h4>Home &nbsp;&nbsp;<i class="fa fa-home"></i></h4>
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
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data['list'] as $list)
				<tr>
					<td>{{$loop->iteration}}</td>
					<!-- <td>
						@foreach($data['gno'] as $dept)
							@if($list->gno == $dept->did)
								{{$dept->dname}}
							@endif
						@endforeach	
					</td> -->
					<td>{{$list->gno}}</td>
					<td>{{$list->ino}}</td>
					<td>{{ \Carbon\Carbon::parse($list->date)->format('d/m/Y') }}</td>
					
					<!-- <td>
						@foreach($data['fac'] as $fac)
							@if($list->rfrom == $fac->fid)
								{{$fac->name}}
							@endif
						@endforeach
					</td> -->
					<td>{{$list->rfrom}}</td>
					<td style="width: 255px;text-align: justify;">
						{{$list->subject}}
					</td>
					<td>
						<a href="{{ url('edit',[$list->id])}}" id="edit" class="btn btn-success" title="Edit">
							<i class="fa fa-edit"></i></a>
						<a href="{{url('delete',[$list->id])}}" class="btn btn-danger" title="Delete"
							onclick="return confirm('Are you Sure ?')">
							<i class="fa fa-trash"></i></a>
						<a href="{{ url('view',[$list->id]) }}" class="btn btn-secondary" id="view" 
							title="View Details">
          		<i class="fa fa-eye"></i></a>

        		<a href="{{ url('upload',[$list->id]) }}" class="btn btn-primary" id="upload" 
        			title="Upload File">
          		<i class="fa fa-arrow-up-from-bracket"></i></a>
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
      		$('#plus').show();

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
					placeholder='Enter Genral No.' class='form-control' autocomplete='off'>";
					document.getElementById('div_gno_name').innerHTML += tag2;
					document.getElementById('fac').innerHTML += "<option value=0>Other</option>";
				}
			});


			$(document).on("change","#fac",function(e){
				e.preventDefault();
				if($("#fac").val() == 0)
				{
					var tag = "<input type='text' name='fac_name' id='fac_name'\
					placeholder='Enter Reciever Name.' class='form-control' autocomplete='off'>";
					document.getElementById('div_fac_name').innerHTML += tag;
				}
				else{
		          $("#fac_name").hide();
		    }
			});

			$(document).on("click","#uploadbtn",function(e){
				e.preventDefault();
				var uploadid = $(this).val();
				// alert(uploadid);
				$('#h_uploadid').val(uploadid);
			});

		});
	</script>
	
@endsection