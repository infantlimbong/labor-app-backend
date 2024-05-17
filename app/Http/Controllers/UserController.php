<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Successfully fetched all users',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'roles' => 'required|integer',
            'nim' => 'nullable|string|max:255|unique:users',
            'phone_number' => 'nullable|string|max:255|unique:users',
            'gender' => 'sometimes|boolean',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('public/images');
            $url = Storage::url($imagePath);
            $imagePath = Str::after($url, 'public/');
        } else {
            $imagePath = null;
        }

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Validate and create the user
        $validated = $validator->validated();
        $validated['password'] = Hash::make($request->password);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'roles' => $validated['roles'],
            'nim' => $validated['nim'],
            'phone_number' => $validated['phone_number'],
            'gender' => $validated['gender'],
            'picture' => $imagePath,
        ]);

        // Return a successful response
        return response()->json([
            'message' => 'User successfully created',
            'data' => $user
        ], 201);
    }
    
    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return response()->json([
            'message' => 'Successfully fetched user',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string',
            'roles' => 'sometimes|required|integer',
            'nim' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        if ($request->has('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json([
            'message' => 'User successfully updated',
            'data' => $user
        ], 200);
    }

    public function editPicture(Request $request, User $user)
    {
        // Validate incoming request data
        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Store the new image file
        if ($request->hasFile('picture')) {
            // Delete previous image
            Storage::delete($user->picture);

            $imagePath = $request->file('picture')->store('public/images');
            $url = Storage::url($imagePath);
            $imagePath = Str::after($url, 'public/');

            // Update user with the new image path
            $user->picture = $imagePath;
            $user->save();

            return response()->json(['message' => 'User picture successfully updated', 'data' => $user], 200);
        }

        return response()->json(['message' => 'No new image provided'], 400);
    }

    // Retrieve the authenticated user data
    public function currentUser(Request $request)
    {
        return response()->json(['message' => 'Successfully fetch user data', 'data' => $request->user()], 200);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'User successfully deleted'
        ], 200);
    }
}