<?php

namespace App\Http\Controllers;

use App\todo;
use App\Todos;
use App\User;
use Auth;
use Redirect;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Post::class, 'user');
    }

    public function index(Request $request)
    {
         
        // $viewdata=todos::sortable()->paginate(10);
        // return view('fetch_addedData',compact('viewdata'))->with('no', 1);
        //$this->authorize('view', User::class);
        $number=$request->get('number');
        $name=$request->get('search');
        $email=$request->get('email');
        $role=$request->get('role');
        $created_at=$request->get('created_at');
        $updated_at=$request->get('updated_at');
        $searchdata = [];
            if(!empty($request->get('search'))) {
                $searchdata[]= ['name','like','%'.filter_var($request->get('search'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('number'))) {
                $searchdata[]= ['number','=',filter_var($request->get('number'),FILTER_VALIDATE_INT)];
            }
            if(!empty($request->get('email'))) {
                $searchdata[]= ['email','like','%'.filter_var($request->get('email'),FILTER_SANITIZE_EMAIL).'%'];
            }            
            if(!empty($request->get('role'))) {
                $searchdata[]= ['role','like','%'.filter_var($request->get('role'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('created_at'))) {
                $searchdata[]= ['created_at','like','%'.filter_var($request->get('created_at'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('updated_at'))) {
                $searchdata[]= ['updated_at','like','%'.filter_var($request->get('updated_at'),FILTER_SANITIZE_STRING).'%'];
            }
            // if(!empty(Auth::user()->id)) {
            //     $searchdata[]= [filter_var(Auth::user()->id,FILTER_SANITIZE_STRING)];
            // }
            // if(!empty(Auth::user()->user_id)) {
            //     $searchdata[]= [filter_var(Auth::user()->user_id,FILTER_SANITIZE_STRING)];
            // }
            $userid=Auth::user()->id;
            $userType=Auth::user()->user_type;
            $userData = Todos::SearchUserData($searchdata,$userid,$userType);
               return view('fetch_addeddata',['viewdata'=>$userData,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
            
            
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addData');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();
        $request->validate([
            'name'=>'required | min:5',
            'mobile'=>'required | min:10',
            'email'=>['required', 'string', 'email', 'max:255', 'unique:todos'],
            'role'=>'required',
            'gender'=>'required',
            'profile_image'=>'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $res=new Todo;
        $res->name=$request->input('name');
        $res->number=$request->input('mobile');
        $res->email=$request->input('email');
        $res->role=$request->input('role');
        $res->gender=$request->input('gender');
        $res->status=1;
        $res->user_id=Auth::user()->id;
         if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)){
              $request->session()->flash('msg','Email Invalid');
         return redirect()->route('showData');
         }elseif(!filter_var($request->input('mobile'), FILTER_VALIDATE_INT)){
                $request->session()->flash('msg','Number Invalid');
         return redirect()->route('showData');
            }
            elseif(!filter_var($request->input('name'), FILTER_SANITIZE_STRING)){
                $request->session()->flash('msg','Only string');
         return Redirect::back();
            }
        else{
       
        if ($request->hasfile('profile_image')) {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalExtension();
               $filename = time() . '.' . $extension;
               $file->move('public/profile_image/',$filename);
               $res->image = $filename;
           }   else{
            return $request;
            $res->profile_image = '';
           }
        //$res->save();
           $userData = Todos::InsertUserData($res);
        if ($res->save()) {
            $request->session()->flash('msg','Insert Sucessfull');
            return Redirect('fetch_addeddata');
        }else{
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }
        
        //return response()->json($res);
      }
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function dashboardcountdata(todo $todo)
    {
        $count = todo::where('status',1)->get()->count();
        $trashdata = todos::onlyTrashed()->get()->count();
        $countuser = DB::table('users')->get()->count();
        $date = date('Y-m-d');
        // $time = Carbon::now();
        $var  = Carbon::now('Asia/Kolkata');
        $time = $var->toTimeString();
        return view('admin',compact('count','countuser','date','time','trashdata'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(todo $todo,$id)
    {
        $userid=Auth::user()->id;
        $Data_id = base64_decode($id);
        $userType=Auth::user()->user_type;
        $todoArr=Todo::where('user_id',$userid)->find($Data_id);
        if ($todoArr) {
           return view('editData')->with('todoArr',$todoArr);
        }
        elseif ($userType==1) {
            $todoArr=Todo::find($user_id);
            return view('editData')->with('todoArr',$todoArr);
        }
        else
        {
            return back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo $todo)
    {
        $request->validate([
            'name'=>'required | min:5',
            'mobile'=>'required | min:10',
            'email'=>['required', 'string', 'email', 'max:255'],
            'role'=>'required',
            'profile_image'=>'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $res=Todos::find($request->id);
        $res->name=$request->input('name');
        $res->number=$request->input('mobile');
        $res->email=$request->input('email');
        $res->role=$request->input('role');
        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)){
              $request->session()->flash('msg','Email Invalid');
         return Redirect::back();
         }elseif(!filter_var($request->input('mobile'), FILTER_VALIDATE_INT)){
                $request->session()->flash('msg','Number Invalid');
         return Redirect::back();
            }
            elseif(!filter_var($request->input('name'), FILTER_SANITIZE_STRING)){
                $request->session()->flash('msg','Only string');
         return Redirect::back();
            }
        else{
        if ($request->hasfile('profile_image') !="") {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalExtension();
               $filename = time() . '.' . $extension;
               $file->move('public/profile_image/',$filename);
               $res->image = $filename;
           }   
        //$res->save();
           $userData = Todos::UpdateUserData($res);
        if ($res->save()) {
            $request->session()->flash('msg','Updated Sucessfull');
            return Redirect('fetch_addeddata');
        }
        else
        {
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }

        
        //return response()->json($res);
       }
    }

    public function activeDactivateUser(Request $request){
        if (filter_var($request->active_id, FILTER_VALIDATE_INT))
        {
            $url = $request->input('current_url');
            $id = $request->input('active_id');
            $data= DB::table('todos')->where('id',$id)->get();
            $status=$data[0]->status;
            //print_r($url); die;
            if ($status==1) {
                $res=Todos::find($request->active_id);
                $res->status=0;
                //$res->save();
                $ActiveUserData = Todos::ActiveUserData($res);
            }else{
                $res=Todos::find($request->active_id);
                $res->status=1;
                //$res->save();
                $DactiveUserData = Todos::ActiveUserData($res);
            }
            //return Redirect('fetch_addeddata');
            //return Redirect::to(Input::get('redirects_to'));
            //return redirect('fetch_addeddata?page='.$page);
            return redirect($url);
        }
    }
    public function getusersData(Request $request)
    {
        $res=$request->input('email');
        $data= todo::where('email',$res)->get();
        return response()->json($data);
    }



    // public function search(Request $request)
    // {
        // $number=$request->get('number');
        // $name=$request->get('search');
        // $email=$request->get('email');
        // $role=$request->get('role');
        // $created_at=$request->get('created_at');
        // $updated_at=$request->get('updated_at');
        // $post=todos::where('name','like','%'.$request->search.'%')->where('number','like','%'.$request->number.'%')->where('email','like','%'.$request->email.'%')->where('role','like','%'.$request->role.'%')->where('created_at','like','%'.$request->created_at.'%')->where('updated_at','like','%'.$request->updated_at.'%')->paginate(10);
        // //print_r($post); die;
        // return view('fetch_addeddata',['viewdata'=>$post,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
    // }

    public function deletedsearch(Request $request)
    {
        $number=$request->get('number');
        $name=$request->get('search');
        $email=$request->get('email');
        $role=$request->get('role');
        $created_at=$request->get('created_at');
        $updated_at=$request->get('updated_at');
        $deletesearchdata = [];
            if(!empty($request->get('search'))) {
                $deletesearchdata[]= ['name','like','%'.filter_var($request->get('search'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('number'))) {
                $deletesearchdata[]= ['number','like','%'.filter_var($request->get('number'),FILTER_VALIDATE_INT).'%'];
            }
            if(!empty($request->get('email'))) {
                $deletesearchdata[]= ['email','like','%'.filter_var($request->get('email'),FILTER_SANITIZE_EMAIL).'%'];
            }            
            if(!empty($request->get('role'))) {
                $deletesearchdata[]= ['role','like','%'.filter_var($request->get('role'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('created_at'))) {
                $deletesearchdata[]= ['created_at','like','%'.filter_var($request->get('created_at'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('updated_at'))) {
                $deletesearchdata[]= ['updated_at','like','%'.filter_var($request->get('updated_at'),FILTER_SANITIZE_STRING).'%'];
            }
        //$post=todos::where($searchdata)->onlyTrashed()->paginate(10);
        $userData = Todos::DeleteSearchUserData($deletesearchdata);
        //print_r($post); die;
        return view('deleted',['viewdata'=>$userData,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
    }

    // public function examsearch(Request $request,todo $todo)
    // {
    //     if($request->ajax()){
    //         $search = $request->get('search');
    //         //print_r($search); die;
    //          $search = str_replace(" ", "%", $search);
    //         $viewdata=todos::where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%')->get();
    //         // print_r($viewdata); die;
    //         return view('include.all_data',compact('viewdata'))->with('no', 1);
    //         //echo json_encode($viewdata);
    //     }
    // }
     
     /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function rowfilter(Request $request)
    {
        if (filter_var($request->rowdataget, FILTER_VALIDATE_INT))
        {
            $data=$request->get('rowdataget');
            //$viewuserdata=todos::paginate($data);
            $rowfilteruserData = Todos::RowFilterUserData($data);
            return view('fetch_addedData',['viewdata'=>$rowfilteruserData,'rowfilter'=>$data,])->with('no', 1);
        }
    }
    public function deletedrowfilter(Request $request)
    {
        if (filter_var($request->rowdataget, FILTER_VALIDATE_INT))
        {
            $data=$request->get('rowdataget');
            //$viewuserdata=todos::onlyTrashed()->paginate($data);
            $DeletedrowfilteruserData = Todos::DeletedRowFilterUserData($data);
            return view('deleted',['viewdata'=>$DeletedrowfilteruserData,'rowfilter'=>$data,])->with('no', 1);
        }
    }

    public function Email_already(Request $request){
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL))
        {
            $data=$request->email;
            //$checkEmail=todo::where('email',$request->email)->first();
            $checkEmail = Todos::CheckEmail($data);
            if ($checkEmail) {
                echo 'false';
            }else
            {
                echo "true";
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, todo $todo)
    {
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
          $id = $request->input('deleteid');
          // print_r($id); die;
          $userdata=Todos::find($id);
         //print_r($userdata); die;
        if (!$userdata) {
            return 'Not delete';
        }
        if ($userdata->delete()) {
            return back()->with('status','user data delete sucessfull');
            # code...
        }
        // return Redirect('fetch_addeddata');
        }else{
            return back();
        }
    }

    public function viewdata(Request $request, todo $todo)
    {
        if (filter_var($request->input('row'), FILTER_VALIDATE_INT))
        {
            // $request->session()->flash('msg','Please use right way!!!');
            // return Redirect::back();
        $id=$request->input('row');
         $data=todo::where('id',$id)->get();
         $data .= "
            <tr>
                  <th>Name:</th>
                  <td>".$data[0]->name."</td>
             </tr><tr>
                  <th>Email:</th>
                  <td>".$data[0]->email."</td>
             </tr><tr>
                  <th>Number:</th>
                  <td>".$data[0]->number."</td>
             </tr><tr>
                  <th>Role:</th>
                  <td>".$data[0]->role."</td>

             </tr><tr>
                  <th>Image:</th>
                  <td><img src='http://localhost/laravel/blog/public/public/profile_image/".$data[0]->image."' style='height:100px; width:100px;'></td>

             </tr>";
          echo $data;
      }
      else
      {
        return back();
         //return $this->request->setJSON($data);
      }
    }
    public function deleteddata(){
        $userid=Auth::user()->id;
        $userType=Auth::user()->user_type;
        if ($userType==1) {
            $viewdata=todos::sortable()->onlyTrashed()->paginate(10);
        }
        else
        {
            $viewdata=todos::where('user_id',$userid)->sortable()->onlyTrashed()->paginate(10);
        }
        
        return view('deleted',compact('viewdata'))->with('no', 1);
    }
    public function restore(Request $request){
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
            // $request->session()->flash('msg','Please use right way!!!');
            // return Redirect::back();
        $id = $request->input('deleteid');
        //print_r($id); die;
        //todos::withTrashed()->find($id)->restore();
        $restore = Todos::RestoreData($id);
        return redirect()->route('deleted')
            ->with('success', 'You successfully restored the project');
        }
        else
        {
            return back();
        }
    }
    public function forcedelete(Request $request){
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
        $id = $request->input('deleteid');
        //use model
              todos::where('id', $id)->forceDelete();
        //end model
        return redirect()->route('deleted')
            ->with('success', 'You successfully restored the project');
        }
        else
        {
            return back();
        }
    }

    public function export(Request $request) 
    {
        // $data=$request->search;
        // $data=$request->email;
        return Excel::download(new UsersExport($request->search,$request->email,$request->name,$request->role,$request->created_at,$request->updated_at), 'users.xlsx');
    }
}
