@extends('layouts.header')

@section('content')
  
<!-- view Modal -->
<div id="view_box" style="margin-top:25px;">
  <form action="{{ url('uploadadd') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">  
      <input type="hidden" name="uploadid" value="{{$data}}">
        <div class="form-group">
          <label><b>Upload : </b></label><br/><br/>
          <input type="file" name="img" id="img" class="form-control" >
          <span style="color:red">@error('img') {{'Please choose file*'}} @enderror</span><br>
        </div>
  </div>
  <div class="modal-footer">
    <a href="{{ url('/home') }}" type="button" class="btn btn-secondary">Close</a>
    <input type="submit" name="upload" id="upload" value="Upload" class="btn btn-primary" />
  </div>
  </form>
</div>



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
  </script>
  
@endsection