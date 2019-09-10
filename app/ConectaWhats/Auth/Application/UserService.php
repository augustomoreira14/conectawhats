<?php

namespace App\Http\Controllers\Auth\Application;

use App\ConectaWhats\Auth\Domain\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Events\UserCreated;
use App\ConectaWhats\Auth\Domain\Models\User;
/**
 * Description of UserService
 *
 * @author augus
 */
class UserService 
{
    public function createAdminUser($name, $email)
    {
        return $this->createUser($name, $email, rand(1000,9999), Role::ADMIN);
    }

    public function createUser($name, $email, $password, $role)
    {
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role
        ]);
        
        $user->activate();
        $user->save();
        
        event(new UserCreated($user, $password));
        
        return $user;
    }
    
    public function findUserBy($id)
    {
        //return User::where('id', $id)->first();
    }
}
