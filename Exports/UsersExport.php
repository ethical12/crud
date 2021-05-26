<?php

namespace App\Exports;

use App\todos;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
	protected $search;
	protected $email;
	protected $name;
	protected $role;
	protected $created_at;
	protected $updated_at;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($search, $email ,$name ,$role,$created_at,$updated_at)
    {
    	$this->search = $search;
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    
    public function collection()
    {
        // return todos::all();
        return todos::where('number','like','%'.$this->search.'%')->where('email','like','%'.$this->email.'%')->where('name','like','%'.$this->name.'%')->where('role','like','%'.$this->role.'%')->where('created_at','like','%'.$this->created_at.'%')->where('updated_at','like','%'.$this->updated_at.'%')->get();
    }
    
}
