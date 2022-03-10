<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UsersController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'password' => 'min:8|required',
            'email' => 'email|unique:users|required',
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->messages(), 'logged' => 0]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,     
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'logged' => true,
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        //test for password and like so
        $userCount = User::where("email", $request->email)->count();
        if ($userCount != 0) {
            if (!Hash::check($request->password, $user->password)) {
                // wrong password
                return response()->json([
                    'error' => 'Email or password is incorrect'
                ]);
            } else {
                return response()->json([
                    'logged' => true,
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                    'admin' => $user->admin
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Email or password is incorrect'
            ]);
        }
    }
    /**
     * Change Password User .
     *
     */
    public function changePassword(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'password' => 'min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()]);
        }
        //check if password and cPassword Same.
        if ($request->password == $request->cPassword) {
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['data' => 'Your password has been updated successfully']);
        } else {
            return response()->json([
                'data' => 'Check your password and Confirm password'
            ]);
        }
    }
    /**
     * Show all users
     */
    public function allUsers()
    {

        $data = User::latest()->orderBy('id', 'DESC')->paginate(5);
        return response()->json($data);
    }
    /**
     * Change User Password
     */
    function updatePasswordUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'password' => 'min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()]);
        }
        //check if password and cPassword Same.
        if ($request->password == $request->cPassword) {
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['data' => 'Your password has been updated successfully.']);
        } else {
            return response()->json([
                'data' => 'Check your password and Confirm password'
            ]);
        }
    }
    /**
     * Delete and forceDelete user
     */
    public function destroy($id, $idAdmin)
    {
        $idAdmin = User::find($idAdmin);
        if ($idAdmin->admin == 1) {
            $findUser = User::where('id', $id)->withTrashed()->first();
            if ($findUser->deleted_at == null) {
                User::find($id)->delete($id);
            } else {
                User::where('id', $id)->forceDelete();
            }
            return response()->json(['message' => 'User deleted successfully.']);
        } else {
            return response()->json(['message' => 'You are not admin.']);
        }
    }
    /**
     * Show all user in table with Trashed...
     */
    public function UsersWithTrashed()
    {
        $data = DB::table('users')
            ->whereNotNull('deleted_at')
            ->paginate(5);
        return response()->json($data);
    }
    /**
     * Show Deatils User for update password
     */
    public function user($id)
    {
        # code...
        $data = User::where('id', $id)->withTrashed()->first();
        return response()->json($data);
    }

    public function editUser(Request $request)
    {
        # code...
        $findUser = User::find($request->id);
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,' . $findUser->id,
            'password' => 'min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()]);
        }
        $findUser->name = $request->name;
        $findUser->email = $request->email;
        if ($request->password == null) {
        } else {
            $findUser->password = Hash::make($request->password);
        }

        $findUser->save();
        return response()->json(['data' => 'User updated successfully.']);
    }

    public function restore(Request $request, $id)
    {
        $user = User::where('id', $id)->restore();
        $user = User::find($id);
        return response()->json(['data' => 'User restored successfully. ' . $user->name]);
    }

    public function userInfo($id)
    {
        # code...

        $user = User::find($id);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'typeUser' => $user->admin,
            'countPosts' => post::where('user_id', $id)->count()
        ]);
    }
}
