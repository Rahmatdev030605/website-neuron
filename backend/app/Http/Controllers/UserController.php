<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user()
    {
        return view('cms.User.user');
    }
    public function showuser(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai dari input pencarian

        // Jika ada parameter pencarian, lakukan pencarian berdasarkan nama
        if ($search) {
            $users = User::where('firstname', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Jika tidak ada parameter pencarian, ambil semua data user
            $users = User::all();
        }

        return view('cms.User.user', compact('users'));
    }
    public function deleteUser($id)
    {try{
        $user = User::findOrFail($id);
        $user->delete();
        deleteRec('User', Auth::id(), Auth::user()->role_id, $user->firstname);
        return redirect()->route('user')->with('success', 'User has been deleted successfully.');
        }catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('cms.User.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {try{
        $user = User::findOrFail($id);

        // Validasi data yang akan diupdate, jika diperlukan
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|in:1,2,3',
        ]);

        // Update data pengguna
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');

        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user', $id)->with('success', 'User has been updated successfully.');
        }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
