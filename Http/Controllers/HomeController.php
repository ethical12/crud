<?php

namespace App\Http\Controllers;
use App\User;
use App\todo;
use App\todos;
use Auth;
use Crypt;
use Excel;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(todo $todo)
    {
        $userid=Auth::user()->id;
        $userType=Auth::user()->user_type;
        if ($userType==1) {
            $trashdata = todos::onlyTrashed()->get()->count();
            $count = todos::where('status',1)->get()->count();
        }
        else
        {
            $trashdata = todos::where('user_id',$userid)->onlyTrashed()->get()->count();
            $count = todos::where('status',1)->where('user_id',$userid)->get()->count();
        }
        $countuser = user::get()->count();
        $date = date('Y-m-d');
        // $time = Carbon::now();
        $var  = Carbon::now('Asia/Kolkata');
        $time = $var->toTimeString();
        return view('admin',compact('count','countuser','date','time','trashdata')); 
    }

    public function usersData()
    {
        // $userType=Auth::user()->user_type;
        // if ($userType == 1) {
            $viewdata=User::paginate(7);
          // return view('todo',compact('viewdata'));
        return view('userdata',compact('viewdata'));
        // }
        // else
        // {
        //     return back();
        // }
        
    }


    public function changepassword(Request $request)
    {
        $request->validate([

            'newpassword'=>'required | min:8',
            'conpassword'=>['same:newpassword']

        ]);
        $res=user::find($request->pass_id);
        $new_password=$res->newpassword;
        $con_password=Hash::make($request->conpassword);
        if ($new_password = $con_password) {
            $res->password = Hash::make($request->conpassword);
        $res->save();
        $request->session()->flash('msg','Password Changed Sucessfull');
        return back();
        }else{
            $request->session()->flash('msg','Password Not Match');
        return back();
        }
    }

    public function profile(Request $request){
        $viewdata=Auth::user();
        $pass=$viewdata->password;
        // $decrypted = Crypt::decrypt($pass);
        //  print_r($decrypted); die;
        return view('profile',compact('viewdata'));
    }
    public function changeUser_password(Request $request){
        $request->validate([

            'old_password'=>'required |min:8',
            'newpassword'=>'required | min:8',
            'conpassword'=>['same:newpassword']

        ]);
        $viewdata=Auth::user();
        $id=$viewdata->id;
        $res=user::find($id);
        $oldPass=$request->old_password;
        $pass=$viewdata->password;
        //$old_input=Hash::make($oldPass);
        if (Hash::check($oldPass, $pass)) {
            $res->password = Hash::make($request->conpassword);
            $res->save();
            $request->session()->flash('msg','Password Changed Sucessfull!!!');
            return redirect()->route('profile');
        }else{
            $request->session()->flash('msg','Old Password Wrong!!!!');
           return redirect()->route('profile');
        }
        
    }
    public function profile_Pic(Request $request){
        $viewdata=Auth::user();
        $id=$viewdata->id;
        $res=user::find($id);
        if ($request->hasfile('profile_image')) {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalExtension();
               $filename = time() . '.' . $extension;
               $file->move('user_profile_image/',$filename);
               $res->image = $filename;
           }   else{
            // return $request;
            // $res->profile_image = '';
            $request->session()->flash('msg','Not Update Image Sucessfull');
            return redirect()->route('profile');
           }
        $res->save();
        $request->session()->flash('msg','Update Image Sucessfull');
         return redirect()->route('profile');
    }
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
