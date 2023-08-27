<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index()
   {
   // Retrieve a paginated list of users from the database
    $users = User::paginate();

    return view('admin.users.index', compact('users'));
   }

   public function create()
   {


    return view('admin.users.create');
   }



   public function store(Request $request)
   {

    $validate = $request->validate([
        'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role_as' => ['required', 'integer']
        ]);
        User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'role_as' => $request->role_as,
        ]);


        return redirect('/admin/users')->with('message','User Created successfully');

   }

   public function edit(int $userId)

   {

    $user = User::findOrFail($userId);

    return view('admin.users.edit', compact('user'));

   }

   public function update(Request $request, int $userId)
{
     // Validate the incoming request data
    $validate = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'password' => ['nullable', 'string', 'min:8'], // Allow empty password
        'role_as' => ['required', 'integer'],
    ]);
  // Find the user to update based on the provided $userId
    $user = User::findOrFail($userId);

    // Prepare the data to update, including conditional password update
    $data = [
        'name' => $request->name,
        'role_as' => $request->role_as,
    ];
// Check if the 'password' field is filled in the request
    if ($request->filled('password')) {

        // If password is provided, hash and include it in the update data
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect('/admin/users')->with('message', 'User updated successfully');
}


   public function destroy(Request $request, $user_id)
   {
       $user = User::findOrFail($user_id);
       $user->delete();

       return redirect('/admin/users')->with('message', 'User deleted successfully');
   }



}




