<?php

namespace App\Policies;

use App\Todos;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //dd($user);
         return $user->user_type === 1;
    }

    // public function allowUser(User $user){
    //     $UserRole=$user->user_type;
    //     return $UserRole === 1;
    
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Todos  $todos
     * @return mixed
     */
    public function view(User $user, Todos $todos)
    {
        //dd($user);
       
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Todos  $todos
     * @return mixed
     */
    public function update(User $user, Todos $todos)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Todos  $todos
     * @return mixed
     */
    public function delete(User $user, Todos $todos)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Todos  $todos
     * @return mixed
     */
    public function restore(User $user, Todos $todos)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Todos  $todos
     * @return mixed
     */
    public function forceDelete(User $user, Todos $todos)
    {
        //
    }
}
