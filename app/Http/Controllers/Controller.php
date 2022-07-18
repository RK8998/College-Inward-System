<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;
use App\Models\listmodel;
use App\Exports\listExport;
use Excel;
use App;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function ExportIntoExcel(){
        return Excel::download(new listExport,'list.xlsx');
    }
    
    public function filter(Request $request){
         if(session()->has("Login_session")){
            $request->validate([
                'from'=>'required',
                'to'=>'required'
            ]);

            $from = $request->from."<br>";
            $to = $request->to."<br>";
            if($from > $to)
            {
               return back()->with("fail","Invalid date range...");
            }
            else
            {
                $filter = DB::table('list')->whereBetween('date',[$from,$to])->get();    
                return view('filter',compact('filter'));
            }
            // $filter = DB::table('list')->whereBetween('date',[$from,$to])->get();    
            // return view('filter',compact('filter'));
        }else{
            return back();
        } 
    }
    public function login(Request $request){

        $request->validate([
            "username"=>"required",
            "password"=>"required",
        ]);

        $q = DB::table('user')
            ->where('username',$request->username)
            ->where('password',$request->password)->get();

        $cnt = count($q);
        
        // echo $q[0]->role;
        $request->session()->put('Login_session',$q);
        if($cnt == 1){
            if($q[0]->role == 1)
            {
                return redirect('home');
            }
            if($q[0]->role == 2)
            {
                return redirect('dept');
            }
        }else{
            return back()->with("fail","Username or password are invalid");
        }
    }

    public function logout(){
        if(session()->has("Login_session")){
            if(session()->has('Login_session')){
                session()->flush('Login_session');
                return redirect('/');
            }
        }else{
            return back();
        } 
    }

    public function home()
    {
        if(session()->has('Login_session')){
            $data['list'] = DB::table('list')->orderBy('id')->get();
            $data['gno'] = DB::table('dept')->get();
            $data['fac'] = DB::table('fac')->get();
            
            // echo "<pre>";
            // print_r($data);
            return view("home", compact('data'));
        }else{
            return redirect("/");
        }
    }
    public function trash()
    {
        if(session()->has('Login_session')){
            $data['trash'] = DB::table('trash')->get();
            $data['gno'] = DB::table('dept')->get();
            $data['fac'] = DB::table('fac')->get();
            
            // echo "<pre>";
            // print_r($data);
            return view("trash", compact('data'));
        }else{
            return back();
        }
    }
    public function restore($tid)
    {
        if(session()->has('Login_session')){
            $trash = DB::table('trash')->where('tid',$tid)->get();
            $insert = DB::table('list')->insert([
                'id'=>$trash[0]->tid,
                'gno'=>$trash[0]->gno,
                'ino'=>$trash[0]->ino,
                'date'=>$trash[0]->date,
                'rfrom'=>$trash[0]->rfrom,
                'subject'=>$trash[0]->subject
            ]);
            if($insert){
                $del = DB::table('trash')->where('tid',$tid)->delete();
                if($del){
                    return redirect('/home')->with('success','Restore Successfully...');
                }
            }else{
                return back()->with("fail","Something Went Wrong !");
            }
        }else{
            return back();
        }
    }
    public function fetch_dept()
    {
        if(session()->has('Login_session')){
            $data = DB::table('dept')->get();
            return response()->json([
                'status'=>'success',
                'dept'=>$data
            ]);
        }else{
            return back();
        }
    }

    public function fetch_dept_name(Request $request)
    {
        if(Session()->has('Login_session')){

            $dept_name = DB::table('dept')->where('dname',$request->dname)->get();
            $fac = DB::table('fac')->where('did',$dept_name[0]->did)->get();
            return response()->json([
                'status'=>'success',
                'dept_name'=>$dept_name,
                'fac'=>$fac,
            ]);
        }else{

        }
    }

    public function fetch_dept_name2(Request $request)
    {
        if(Session()->has('Login_session')){
            $dept_name = DB::table('dept')->where('dname',$request->dname)->get();
            $fac = DB::table('fac')->where('did',$dept_name[0]->did)->get();
            return response()->json([
                'status'=>'success',
                'dept_name'=>$dept_name,
                'fac'=>$fac,
            ]);
        }else{

        }
    }

    public function store(Request $request){
        if(Session()->has('Login_session')){
           
            if($request->gno == '0' AND $request->fac == '0')       // if
            {
                $request->validate([
                    "gno"=>"required|not_in:-1",
                    "gno_name"=>"required",
                    "date"=>"required",
                    "fac"=>"required|not_in:-1",
                    "fac_name"=>"required",
                    "subject"=>"required"
                ]);
                // --------------------------------------------------
                $data = DB::table('list')->orderBy('id', 'desc')->first();
                $finalino = "";
                if($data != "")
                {
                    $no = substr($data->ino,-3);
                    // echo "no = ".$no."<br>";
                    $ino = 0;
                    $ino = $no + 1;
                    if ($no >= 9 && $no < 99) {    
                        $finalino = $request->gno_name."0".$ino;        
                    }
                    elseif ($no >= 99 && $no < 999) {
                        $finalino = $request->gno_name.$ino;           
                    }
                    else{
                        $finalino = $request->gno_name."00".$ino;        
                    }
                    
                }else{
                    $ino = 1;
                    $finalino = $request->gno."00".$ino;    
                }
                // --------------------------------------------------
                

                $q = DB::table('list')->insert([
                    'gno'=>$request->gno_name,
                    'ino'=>$finalino,
                    'date'=>$request->date,
                    'rfrom'=>$request->fac_name,
                    'subject'=>$request->subject
                ]);

                // if($q){
                //     return redirect('home')->with('success','Successfully Added...');
                // }else{
                //     return back()->with('fail','Try Again !');
                // }
            }
            else if($request->fac == '0')                           //else if
            {
                $request->validate([
                    "gno"=>"required|not_in:-1",
                    // "gno_name"=>"required",
                    "date"=>"required",
                    "fac"=>"required|not_in:-1",
                    "fac_name"=>"required",
                    "subject"=>"required"
                ]);

                // --------------------------------------------------
                $data = DB::table('list')->orderBy('id', 'desc')->first();
                $finalino = "";
                if($data != "")
                {
                    $no = substr($data->ino,-3);
                    echo "no = ".$no."<br>";
                    $ino = 0;
                    $ino = $no + 1;
                    if ($no >= 9 && $no < 99) {    
                        $finalino = $request->gno."0".$ino;        
                    }
                    elseif ($no >= 99 && $no < 999) {
                        $finalino = $request->gno.$ino;           
                    }
                    else{
                        $finalino = $request->gno."00".$ino;        
                    }
                    
                }else{
                    $ino = 1;
                    $finalino = $request->gno."00".$ino;    
                }
                // --------------------------------------------------

                $q = DB::table('list')->insert([
                    'gno'=>$request->gno,
                    'ino'=>$finalino,
                    'date'=>$request->date,
                    'rfrom'=>$request->fac_name,
                    'subject'=>$request->subject
                ]);

                // if($q){
                //     return redirect('home')->with('success','Successfully Added...');
                // }else{
                //     return back()->with('fail','Try Again !');
                // }
            }
            else                                        // else
            {
                $request->validate([
                    "gno"=>"required|not_in:-1",
                    // "gno_name"=>"required",
                    "date"=>"required",
                    "fac"=>"required|not_in:-1",
                    // "fac_name"=>"required",
                    "subject"=>"required"
                ]);

                // --------------------------------------------------
                $data = DB::table('list')->orderBy('id', 'desc')->first();
                $finalino = "";
                if($data != "")
                {
                    $no = substr($data->ino,-3);
                    echo "no = ".$no."<br>";
                    $ino = 0;
                    $ino = $no + 1;
                    if ($no >= 9 && $no < 99) {    
                        $finalino = $request->gno."0".$ino;        
                    }
                    elseif ($no >= 99 && $no < 999) {
                        $finalino = $request->gno.$ino;           
                    }
                    else{
                        $finalino = $request->gno."00".$ino;        
                    }
                    
                }else{
                    $ino = 1;
                    $finalino = $request->gno."00".$ino;    
                }
                // --------------------------------------------------

                $q = DB::table('list')->insert([
                    'gno'=>$request->gno,
                    'ino'=>$finalino,
                    'date'=>$request->date,
                    'rfrom'=>$request->fac,
                    'subject'=>$request->subject
                ]);

                // echo $q;
                // if($q){
                //     return redirect('home')->with('success','Successfully Added...');
                // }else{
                //     return back()->with('fail','Try Again !');
                // }
            }
           

            if(isset($request->img)){
                $list = DB::table('list')->orderBy('id','desc')->first();

                $file = $request->file('img');
                $name = $request->file('img')->getClientOriginalName();
                $destinationPath = 'Files/'; 
                if($file->getClientOriginalExtension() == null){
                    return back()->with("fail","No Changes Are Apply !");
                }
                $extension = $file->getClientOriginalExtension(); 
                // $fileName = rand(11111, 99999).'.'.$extension;
                // $fileName = $name.'.'.$extension; 
                $fileName = $name; 
                $response_success = $file->move($destinationPath, $fileName); 

                $update = DB::table('list')->where('id',$list->id)->update([
                     "img"=>$fileName,
                ]);
                
                if($update){
                    return redirect('home')->with("success","Successfully Added (Upload)...");
                }else{
                    return redirect('home')->with("fail","Try Again !");
                }
            }
            else{
                if($q){
                    return redirect('home')->with('success','Successfully Added...');
                }else{
                    return back()->with('fail','Try Again !');
                }
            }
        }else{
            return back();
        }
    }

    public function upload($id)
    {
        if(Session()->has('Login_session')){
            $data = $id;
            return view('upload',compact('data'));
        }else{
            return back();
        }
    }

    public function uploadadd(Request $request)
    {
        if(Session()->has('Login_session')){
            $request->validate([
                "img"=>"required",
            ]);
            $file = $request->file('img');
            $name = $request->file('img')->getClientOriginalName();
            $destinationPath = 'Files/'; 
            if($file->getClientOriginalExtension() == null){
                return back()->with("fail","No Changes Are Apply !");
            }
            $extension = $file->getClientOriginalExtension(); 
            // $fileName = rand(11111, 99999).'.'.$extension;
            // $fileName = $name.'.'.$extension; 
            $fileName = $name; 
            $response_success = $file->move($destinationPath, $fileName); 

            $update = DB::table('list')->where('id',$request->uploadid)->update([
                 "img"=>$fileName,
            ]);
            
            if($update){
                return redirect('home')->with("success","Upload Successfully...");
            }else{
                return redirect('home')->with("fail","No Changes Are Apply !");
            }

        }else{
            return back();
        }
    }

    public function delete($id){
        if(Session()->has('Login_session')){
            $trash = DB::table('list')->where('id',$id)->get();
            echo "<pre>"; print_r($trash);
            $q = DB::table('trash')->insert([
                "tid"=>$id,
                "gno"=>$trash[0]->gno,
                "ino"=>$trash[0]->ino,
                "date"=>$trash[0]->date,
                "rfrom"=>$trash[0]->rfrom,
                "subject"=>$trash[0]->subject,
            ]);
            if($q){
                $delete = DB::table('list')->where('id',$id)->delete();
                if($delete){
                    return redirect('home')->with('success','Delete Successfully ( Move to trash )');
                }
                else{
                    return redirect('home')->with('fail','Try Again !');   
                }
            }
        }else{
            return back();
        }
    }
    public function delete_trash($id){
        if(Session()->has('Login_session')){
            $delete = DB::table('trash')->where('tid',$id)->delete();
            if($delete){
                return redirect('trash')->with('success','Delete Successfully...');
            }
            else{
                return redirect('trash')->with('fail','Try Again !');   
            }
        }else{
            return back();
        }
    }

    public function view($id)
    {
        if(Session()->has('Login_session')){
            $data['view'] = DB::table('list')->where('id',$id)->get();
            $data['dept'] = DB::table('dept')->where('did',$data['view'][0]->gno)->get();
            $data['fac'] = DB::table('fac')->where('fid',$data['view'][0]->rfrom)->get();
            
            // echo "<pre>";
            // print_r($data);
            return view('view',compact('data'));
        }else{
            return back();
        }
    }

    public function edit($id)
    {
        if(Session()->has('Login_session')){
            $data['edit'] = DB::table('list')->where('id',$id)->get();
            $data['dept_id'] = DB::table('dept')->where('dname',$data['edit'][0]->gno)->get();
            if(count($data['dept_id']) == 0)
            {
                 $data['dept'] = DB::table('dept')->get();
                 // $data['fac'] = "";
            }
            else
            {
                $data['dept'] = DB::table('dept')->get();
                $data['fac'] = DB::table('fac')->where('did',$data['dept_id'][0]->did)->get();    
            }
            
            
            // echo "<pre>";
            // print_r($data);

            return view('edit',compact('data'));
        }else{
            return back();
        }
    }
    public function update(Request $request)
    {
        if(Session()->has('Login_session'))
        {
            if(isset($request->egno_name) AND isset($request->efac_name))
            {
                $request->validate([
                    "egno_name"=>"required",
                    "edate"=>"required",
                    "efac_name"=>"required",
                    "esubject"=>"required",
                ]);
                $inward = DB::table('list')->select('ino')->where('id',$request->eid)->get();
                $finalino = $request->egno_name.''.substr($inward[0]->ino, -3);
                // echo $finalino;
                $update = DB::table('list')->where('id',$request->eid)->update([
                    "gno"=>$request->egno_name,
                    "ino"=>$finalino,
                    "date"=>$request->edate,
                    "rfrom"=>$request->efac_name,
                    "subject"=>$request->esubject,
                ]);
                if($update)
                {
                    return redirect('home')->with('success','Update Successfully');
                }else{
                    return redirect('home')->with('fail','No Any Changes Apply !');
                }
            }
            elseif (isset($request->efac_name)) 
            {
                $request->validate([
                    "egno"=>"required",
                    "edate"=>"required",
                    "efac_name"=>"required",
                    "esubject"=>"required",
                ]);
                $inward = DB::table('list')->select('ino')->where('id',$request->eid)->get();
                $finalino = $request->egno.''.substr($inward[0]->ino, -3);
                // echo $finalino;
                $update = DB::table('list')->where('id',$request->eid)->update([
                    "gno"=>$request->egno,
                    "ino"=>$finalino,
                    "date"=>$request->edate,
                    "rfrom"=>$request->efac_name,
                    "subject"=>$request->esubject,
                ]);
                if($update)
                {
                    return redirect('home')->with('success','Update Successfully');
                }else{
                    return redirect('home')->with('fail','No Any Changes Apply !');
                }
            }
            else
            {
                $request->validate([
                    "egno"=>"required",
                    "edate"=>"required",
                    "efac"=>"required",
                    "esubject"=>"required",
                ]);
                $inward = DB::table('list')->select('ino')->where('id',$request->eid)->get();
                $finalino = $request->egno.''.substr($inward[0]->ino, -3);
                // echo $finalino;
                $update = DB::table('list')->where('id',$request->eid)->update([
                    "gno"=>$request->egno,
                    "ino"=>$finalino,
                    "date"=>$request->edate,
                    "rfrom"=>$request->efac,
                    "subject"=>$request->esubject,
                ]);
                if($update)
                {
                    return redirect('home')->with('success','Update Successfully');
                }else{
                    return redirect('home')->with('fail','No Any Changes Apply !');
                }
            }
        }
        else
        {

        }
    }

// *****************************************************************Login2
    public function home2()
    {
        if(session()->has('Login_session')){
            return view("home2");
        }else{
            return back();
        }
    }
    public function department()
    {
        if(session()->has('Login_session')){
            $data = DB::table('dept')->get();
            return view("dept",compact('data'));
        }else{
            return back();
        }    
    }
    public function add_dept(Request $request)
    {
        if(session()->has('Login_session')){
           $request->validate([
                "dname"=>"required",
                "name"=>"required"
           ]);
           $insert = DB::table('dept')->insert([
                "dname"=>$request->dname,
                "name"=>$request->name
           ]);
           if($insert)
           {    
                return back()->with("success","Department Added Successfully");
           }else{
                return back()->with("fail","Try Again !");
           }
        }else{
            return back();
        }    
    }
    public function delete_dept($did)
    {
        if(session()->has('Login_session')){
           $delete = DB::table('dept')->where('did',$did)->delete();
           if($delete)
           {    
                return redirect('dept')->with("success","Department Delete Successfully");
           }else{
                return back()->with("fail","Try Again !");
           }
        }else{
            return back();
        }    
    }
    public function edit_dept($did)
    {
        if(session()->has('Login_session')){
            $data = DB::table('dept')->get();
            $edit = DB::table('dept')->where('did',$did)->get();
            Session::put('olddept', $edit[0]->dname);
            if(count($edit))
            {    
                return view('dept',compact('data','edit'));
            }else{
                return back()->with("fail","Try Again !");
            }
        }else{
            return back();
        }    
    }
    public function update_dept(Request $request)
    {
        if(session()->has('Login_session')){
            $request->validate([
                "edname"=>"required",
                "ename"=>"required"
            ]);

            $update = DB::table('dept')->where('did',$request->edid)->update([
                "dname"=>$request->edname,
                "name"=>$request->ename,
            ]);
            $olddept = Session::get('olddept');
            $q = DB::table('list')->where('gno',$olddept)->update([
                "gno"=>$request->edname
            ]);
            if($update){
                return redirect('dept')->with('success','Update Successfully');
            }
            else{
                return back()->with('fail','No Any Changes Apply !');
            }
        }else{
            return back();
        }
    }
//***************************************************************************
    public function faculty()
    {
        if(session()->has('Login_session')){
            $dept = DB::table('dept')->get();
            $fac = DB::table('fac')->get();
            return view("fac",compact('dept','fac'));
        }else{
            return back();
        } 
    }
     public function add_fac(Request $request)
    {
        if(session()->has('Login_session')){
           $request->validate([
                "did"=>"required|not_in:-1",
                "name"=>"required"
           ]);
           $insert = DB::table('fac')->insert([
                "name"=>$request->name,
                "did"=>$request->did
           ]);
           if($insert)
           {    
                return back()->with("success","Faculty Added Successfully");
           }else{
                return back()->with("fail","Try Again !");
           }
        }else{
            return back();
        }    
    }
    public function delete_fac($fid)
    {
        if(session()->has('Login_session')){
           $delete = DB::table('fac')->where('fid',$fid)->delete();
           if($delete)
           {    
                return redirect('faculty')->with("success","Faculty Delete Successfully");
           }else{
                return back()->with("fail","Try Again !");
           }
        }else{
            return back();
        }    
    }
     public function edit_fac($fid)
    {
        if(session()->has('Login_session')){
            $edit = DB::table('fac')->where('fid',$fid)->get();
            $dept = DB::table('dept')->get();
            $fac = DB::table('fac')->get();
            
            Session::put('oldfac', $edit[0]->name);
            if(count($edit))
            {    
                return view('fac',compact('fac','dept','edit'));
            }else{
                return back()->with("fail","Try Again !");
            }
        }else{
            return back();
        }    
    }
    public function update_fac(Request $request)
    {
        if(session()->has('Login_session')){
            $request->validate([
                "edid"=>"required|not_in:-1",
                "ename"=>"required"
            ]);
            $update = DB::table('fac')->where('fid',$request->efid)->update([
                "name"=>$request->ename,
                "did"=>$request->edid,
            ]);
            $oldfac = Session::get('oldfac');
            $q = DB::table('list')->where('rfrom',$oldfac)->update([
                "rfrom"=>$request->ename
            ]);
            if($update){
                return redirect('faculty')->with('success','Update Successfully');
            }
            else{
                return back()->with('fail','No Any Changes Appply !');
            }
        }else{
            return back();
        }
    }
}
