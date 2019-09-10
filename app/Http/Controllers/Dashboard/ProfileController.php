<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\Auth\Domain\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
/**
 * Description of ProfileController
 *
 * @author augus
 */
class ProfileController extends Controller
{
    public function index(Request $req)
    {
        $item = $req->user();
        return view('dashboard.profile.index', compact('item'));
    }
    
    public function updatePasswordView()
    {
        return view('dashboard.profile.password', compact('item'));
    }
    
    public function updatePassword(Request $req)
    {
        $this->validate($req, [
            'old_password' => 'string|required',
            'password' => 'required|confirmed'
        ]);
        
        try {
            $user = $req->user();
            if (!Hash::check($req->old_password, $user->password)) {
                throw new \InvalidArgumentException("Senha antiga não confere!");
            }
            
            $user->password = Hash::make($req->password);
            $user->save();
            
            return redirect()->back()->with('message', 'Atualizado com sucesso.');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }        
    }
    
    public function update(Request $req)
    {
        $this->validate($req, [
            'name' => 'string|required',
            'email' => "email",
            'image' => "nullable|image"
        ]);
        
        try {
            $user = $req->user();
            $user->name = $req->name;
            if($req->email !== $user->email){
                if(User::where('email', $req->email)->count()){
                    throw new \InvalidArgumentException("Email existente.");
                }
            }    
            if($req->image){
                Storage::disk('public')->delete($user->image);
                $user->image = Storage::disk('public')->putFile('avatars', $req->file('image'));
            }
            $user->save();
            
            return redirect()->back()->with('message', 'Atualizado com sucesso.');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
