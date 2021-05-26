<?php

namespace App;
use App\Exports;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Maatwebsite\Excel\Concerns\FromCollection;
class Todos extends Model
{
	use Sortable;
    public $sortable = ['id',
                        'name',
                        'email',
                        'number',
                        'created_at',
                        'updated_at'];
	//protected $table = 'todos';
	use SoftDeletes;
	// protected $data = ['deleted_at'];
	// protected $table='todos';
	public static function UpdateUserData($res){
    $value=$res->save();
    return $value;
  }

  public static function InsertUserData($res){
    $value=$res->save();
    return $value;
  }

  public static function SearchUserData($searchdata,$userid,$userType){
  	//print_r($userid); die;
  	if ($userType ==1 ) {
  		$post=todos::where($searchdata)->paginate(10);
  	}
  	else
  	{
    $post=todos::where($searchdata)->where('user_id',$userid)->paginate(10);
    }
    return $post;

  }

  public static function ActiveUserData($res){
    $post=$res->save();
    return $post;
  }

  public static function DeleteSearchUserData($deletesearchdata){
    $post=todos::where($deletesearchdata)->onlyTrashed()->paginate(10);
    return $post;
  }

  public static function RowFilterUserData($rowfilteruserData){
    $viewuserdata=todos::paginate($rowfilteruserData);
    return $viewuserdata;
  }

  public static function DeletedRowFilterUserData($DeletedrowfilteruserData){
    $viewuserdata=todos::paginate($DeletedrowfilteruserData);
    return $viewuserdata;
  }

  public static function CheckEmail($checkEmail){
    $viewuserdata=todos::where('email',$checkEmail)->first();
    return $viewuserdata;
  }

  public static function RestoreData($restore){
    $viewuserdata=todos::withTrashed()->find($restore)->restore();
    return $viewuserdata;
  }

  // public static function ForceDelete($Forcedelete){
  //   $viewuserdata=todos::where('id',$Forcedelete)->forceDelete();
  //   return $viewuserdata;
  // }
	
}
