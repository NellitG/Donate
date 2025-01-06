<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'firstName' => 'required|string|min:3',
            'secondName' => 'required|string|min:3',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_no' => 'required|string|min:8|unique:users,phone_no',
        ]);

        /**Add the user to db */
        $user = new User();
        $result = $user->addUser($fields);

        /**Handle error */
        if (empty($result)) {
            return response([
                'message' => 'Something went wrong, try again later',
            ], 500);
        }

        /**Return response */
        return response([
            'message' => 'User was added successfully',
            "user" => $result,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = new User();

        /** Get the user and catch 404 error*/
        try {
            $userResult = $user->getUser($id);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
                // 'error' => $e->getCode()
            ], 500);
        }

        return response(['user' => $userResult]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = new User();

        /** Get the user and catch 404 error*/
        try {
            $thisUser = $user->getUser($id);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        /**Validate the input form */
        try {
            $fields = $request->validate([
                'firstName' => 'required|string|min:3',
                'secondName' => 'required|string|min:3',
                'email' => [
                    'required',
                    'email:rfc,dns',
                    // Rule::unique('users', 'email')->ignore($thisUser->id),
                ],
                'password' => 'required|string|min:8',
                'phone_no' => [
                    'required',
                    'string',
                    'min:8',
                    // Rule::unique('users', 'phone_no')->ignore($thisUser->id)
                ],
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        /** Update the user */
        $userResult = $user->updateUser($fields, $id);

        /**Handle error */
        if (empty($userResult)) {
            return response([
                'message' => 'Something went wrong, try again later',
            ], 500);
        }

        /**Return response */
        return response([
            'message' => 'User updated successfully',
            "user" => $userResult,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**Delete the user from db */
        $user = new User();

        try {
            $deletedUser = $user->deleteUser($id);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        /**Return response */
        return response([
            'message' => 'User was deleted successfully',
            "user" => $deletedUser,
        ]);
    }
}
