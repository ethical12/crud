<?php 
 namespace App\Gate;
 /**
  * 
  */
 class Gate
 {
 	
 	function __construct(argument)
 	{
 		# code...
 	}
 	public function allowaction($user,$id){
 		return $user->id === $id ? Response::allow() : Response::deny("You are not authorised");

 	}
 }
?>