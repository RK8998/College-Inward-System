<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>College</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />

<!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->

<!-- <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" 
integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style type="text/css">
  #view_box{
    /*border: 1px solid black;*/
    border-radius: 20px;
    /*box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;*/
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
  }
  .popup{
        width: 900px;
        /*margin: auto;
        text-align: left;*/
    }
    .popup img{
        width: 150px;
        height: 150px;
        cursor: pointer
    }
    .show{
        z-index: 999;
        display: none;
    }
    .show .overlay{
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.66);
        position: absolute;
        top: 0;
        left: 0;
    }
    .show .img-show{
        width: 600px;
        height: 400px;
        background: #FFF;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        overflow: hidden
    }
    .img-show span{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 99;
        cursor: pointer;
    }
    .img-show img{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    /*End style*/

</style>
</head>
<body>
	 
<!-- Insert Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="store" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="modal-body">
            <div class="form-group">
              <label><b>Department : </b></label>
              <select name="gno" class="form-control" id="gno">    
              </select>
              <div id="div_gno_name"></div>
              <span style="color:red">@error('gno') {{'Genral No*'}} @enderror</span>
              <span style="color:red">@error('gno_name') {{' '}} @enderror</span>
              <br>
            </div>
            
            <div class="form-group">
              <label><b>Date : </b></label>
              <input type="date" name="date" id="txtDate" class="form-control">
              <span style="color:red">@error('date') {{'Date*'}} @enderror</span><br>
            </div>

            <div class="form-group">
              <label><b>Received From : </b></label>
              <select name="fac" class="form-control" id="fac">
                <option value="-1">Select Faculty</option>
              </select>
              <div id="div_fac_name"></div>
              <span style="color:red">@error('fac') {{'Receive From*'}} @enderror</span>
              <span style="color:red">@error('fac_name') {{' '}} @enderror</span>
              <br>
            </div>

            <div class="form-group">
              <label><b>Subject : </b></label>
              <textarea name="subject" id="subject" placeholder="Write here..." class="form-control">    
              </textarea>
              <span style="color:red">@error('subject') {{'Subject*'}} @enderror</span>
              <br>
            </div>

            <div class="form-group">
              <label><b>Upload : </b></label>
              <input type="file" name="img" id="img" class="form-control" >
              <span style="color:red">@error('img') {{'Please choose file*'}} @enderror</span><br>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="submit" id="submit" class="btn btn-primary" />
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="filter" method="GEt">
          @csrf
        <div class="modal-body">
            <div class="form-group">
              <label><b>From : </b></label>
              <input type="date" name="from" id="from" class="form-control">
              <span style="color:red;">@error('from') {{'From date required'}} @enderror</span>
            </div>
            <br>
            <div class="form-group">
              <label><b>To : </b></label>
              <input type="date" name="to" id="to" class="form-control">
              <span style="color:red;">@error('to') {{'To date required'}} @enderror</span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="submit" id="submit" class="btn btn-primary" />
        </div>
        </form>
      </div>
    </div>
  </div>



  @if(Session::get('Login_session')[0]->role == 1)
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{url('https://scet.ac.in/')}}">SCET</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('home')}}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('trash') }}">Trash</a>
          </li>
        </ul>
        <form action="#" class="d-flex">

        <!-- <a href="{{ url('export') }}" class="btn btn-outline-success" id="export" title="Export Into Excel">
              <i class="fa-solid fa-file-arrow-down" style="font-size:25px"></i>
        </a> -->

         <a type="button" class="btn btn-danger" id="filter" data-toggle="modal" data-target="#filterModal"
          title="Filter Data">Export</a>
          
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

        <a type="button" class="btn btn-primary" id="plus" data-toggle="modal" data-target="#exampleModal"
          title="Add New Data">
            <i class="fa fa-plus" style="font-size:25px"></i>
        </a>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
          <a class="btn btn-outline-danger" href="{{url('logout')}}">Logout</a>
        </form>
      </div>
    </div>
  </nav>

  @elseif(Session::get('Login_session')[0]->role == 2)

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{url('https://scet.ac.in/')}}">SCET</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <!-- <a class="nav-link active" aria-current="page" href="{{url('home2')}}">Home</a> -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('dept') }}">Department</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('faculty') }}">Faculty</a>
          </li>
        </ul>
        <form class="d-flex">
          <a class="btn btn-outline-danger" href="{{url('logout')}}">Logout</a>
        </form>
      </div>
    </div>
  </nav>


  @endif

	<div class="container">
		@yield('content')
	

	