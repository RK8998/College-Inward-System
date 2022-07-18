@extends('layouts.header')

@section('content')
	
<!-- view Modal -->
@foreach($data['view'] as $view)
<div id="view_box">
  <div class="modal-body">
	    <div class="form-group">
	      <label><b>General no : </b></label>
	      <input type="text" name="vgno" id="vgno" disabled class="form-control"
	      value="{{ $view->gno }}">
	      <div id="div_gno_name"></div>
	      <br>
	    </div>
      
      <div class="form-group">
        <label><b>Inward no : </b></label>
        <input type="text" name="vino" id="vino" disabled class="form-control"
        value="{{ $view->ino }}">
        <div id="div_gno_name"></div>
        <br>
      </div>

      <div class="form-group">
        <label><b>Date : </b></label>
        <input type="text" name="vdate" id="vtxtDate" class="form-control" disabled
        value="{{ \Carbon\Carbon::parse($view->date)->format('d/m/Y') }}">
      </div><br>

      <div class="form-group">
        <label><b>Received From : </b></label>
        <input type="text" name="vfac" id="vfac" class="form-control" disabled
        value="{{ $view->rfrom }}">
        <div id="div_fac_name"></div>
        <br>
      </div>

      <div class="form-group">
        <label><b>Subject : </b></label>
        <textarea name="vsubject" id="vsubject" class="form-control" disabled >
        	{{ $view->subject }}
        </textarea><br/>
      </div>
      <div class="show">
        <div class="overlay"></div>
        <div class="img-show">
          <span>X</span>
          <img src="">
        </div>
      </div>
  <div class="modal-footer">
    <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary">Close</a>
    <!-- <input type="submit" name="submit" id="submit" class="btn btn-primary" /> -->
  </div>
</div>
    <hr>
    <br/>
    @if($view->img == NULL)
      <!-- <img src="http://localhost/college/public/img/default.jpg" id="myImg" 
      width="100" height="100" style="border-radius: 10px;"> -->
      <span class="mx-3" style="font-size:18px; font-weight: bold;">No Any Files Are There</span>
    @else
      <!-- <img src="http://localhost/college/public/img/{{ $view->img}}" id="myImg"
      width="100" height="100" style="border-radius: 10px;"> -->
      <!-- <embed src="http://localhost/college/public/img/{{ $view->img}}" width="300px" height="300px" /> -->
      <iframe src="http://localhost/college/public/Files/{{ $view->img}}" 
        style="width:100%; height:1000px;" frameborder="0"></iframe>
    @endif
    <br><br>
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
            $('#vsubject').val($.trim($('#vsubject').val()));
            $("#gno_name").hide();	    
            $("#plus").hide();
      });

		  $(function () {
          "use strict";
          
          $(".popup img").click(function () {
              var $src = $(this).attr("src");
              $(".show").fadeIn();
              $(".img-show img").attr("src", $src);
          });
          
          $("span, .overlay").click(function () {
              $(".show").fadeOut();
          });
          
      });
	</script>
	
@endsection