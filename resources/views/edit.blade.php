@extends('layouts.header')

@section('content')
	
<!-- view Modal -->
@foreach($data['edit'] as $edit)

<div id="view_box">
  <form action="{{ url('update') }}" method="GET">
    <div class="modal-body">  
      <input type="hidden" name="eid" value="{{$edit->id}}">
      <div class="form-group">
	      <label><b>Department : </b></label>
	      <select name="egno" class="form-control" id="egno">
          <option value="-1">Select Department</option>    
           {{ $flag=0 }}
            @foreach($data['dept'] as $dept)
              @if($dept->dname == $edit->gno)
                <option selected>{{$edit->gno}}</option>
                {{$flag=1}}
              @else
                <option>{{$dept->dname}}</option>
              @endif
            @endforeach
          <option value="0">Other</option>
        </select>
        <span style="color:red">@error('egno') {{'Genral No*'}} @enderror</span>
        <span style="color:red">@error('egno_name') {{' '}} @enderror</span>
	      <div id="ediv_gno_name">
          @if($flag==0)
              <input type='text' name='egno_name' id='egno_name' class='form-control' 
                value="{{$edit->gno}}">
          @endif
        </div>
	      <br>
	    </div>

        <div class="form-group">
          <label><b>Date : </b></label>
          <input type="date" name="edate" id="etxtDate" class="form-control" value="{{$edit->date}}">
          <span style="color:red">@error('edate') {{'Date*'}} @enderror</span><br>
        </div>

        <div class="form-group">
          <label><b>Received From : </b></label>
          <select name="efac" class="form-control" id="efac">
            <option value="-1">Select Faculty</option>
            {{ $flag=0 }}
            @if(isset($data['fac']))
              @foreach($data['fac'] as $fac)
                @if($fac->name == $edit->rfrom)
                  <option selected>{{$edit->rfrom}}</option>
                  {{$flag=1}}
                @else
                  <option>{{$fac->name}}</option>
                @endif
              @endforeach
            @endif
            <option value="0">Other</option>
          </select>
          <div id="ediv_fac_name">
            @if($flag==0)
              <input type='text' name='efac_name' id='efac_name' class='form-control' 
                value="{{$edit->rfrom}}">
            @endif
          </div>
          <span style="color:red">@error('efac') {{'Receive From*'}} @enderror</span>
          <span style="color:red">@error('efac_name') {{' '}} @enderror</span>
          <br>
        </div>

        <div class="form-group">
          <label><b>Subject : </b></label>
          <textarea name="esubject" id="esubject" placeholder="Write here..." class="form-control">  
            {{$edit->subject}}  
          </textarea>
          <span style="color:red">@error('esubject') {{'Subject*'}} @enderror</span>
        </div>
  </div>
  <div class="modal-footer">
    <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary">Close</a>
    <input type="submit" name="update" id="update" value="Update" class="btn btn-primary" />
  </div>
  </form>
</div>
@endforeach


@endsection

@extends('layouts.footer')

@section('scripts')

<script type="text/javascript">

    	$(document).ready(function(){
      		$('#tbl').DataTable();
      		// $('#msg').delay(2000).hide();
    	});
			$(document).ready(function() {
            $('#esubject').val($.trim($('#esubject').val()));
            $("#gno_name").hide();	    
            $("#plus").hide();
      });

        // on changed genral number (department)
      $(document).on("change","#egno",function(e){
        e.preventDefault();
        
        $("#ediv_gno_name").html(" ");
        $("#egno_name").show();
        $("#efac").html(" ");
        document.getElementById('efac').innerHTML += "<option value=-1>Select Faculty</option>";
        
        if($("#egno").val() != 0)
        {
          var data = {
            'dname':$("#egno").val(),
          }
          var dname = $("#egno").val();
          

          $.ajax({
            type:'GET',
            url:'fetch_dept_name2',
            data:data,
            dataType:'json',
            success:function(response){
              console.log(response);
              var tag1 = "<input type='text' name='egno_name' id='egno_name' \
              class='form-control' value='"+response.dept_name[0].name+"' disabled>";
              document.getElementById('ediv_gno_name').innerHTML += tag1;

              for (var i = 0; i<response.fac.length; i++) {
                var name = response.fac[i].name;
                var fid = response.fac[i].fid;
                var tag = "<option>"+name+"</option>";
                document.getElementById('efac').innerHTML += tag;
              }
              document.getElementById('efac').innerHTML += "<option value=0>Other</option>";
            }
          });
        }
        else
        {
          var tag2 = "<input type='text' name='egno_name' id='egno_name'\
          placeholder='Enter Genral No.' class='form-control' autocomplete='off'>";
          document.getElementById('ediv_gno_name').innerHTML += tag2;
          document.getElementById('efac').innerHTML += "<option value=0>Other</option>";
        }
      });

      $(document).on("change","#efac",function(e){
          e.preventDefault();
          if($("#efac").val() == 0)
          {
            var tag = "<input type='text' name='efac_name' id='efac_name'\
            placeholder='Enter Reciever Name.' class='form-control' autocomplete='off'>";
            document.getElementById('ediv_fac_name').innerHTML += tag;
          }
          else{
            $("#efac_name").hide();
          }
      });
		
	</script>
	
@endsection