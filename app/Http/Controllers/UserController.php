<?php

namespace App\Http\Controllers;

use App\Models\PostGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {   
        $postGroups = PostGroup::all();
        return view('users.edit', compact('user', 'postGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required'],
            'post_groups' => ['array'],
            'post_groups.*' => ['exists:post_groups,id',]
        ]);
        
        $user->update($request->all());

        if ($request->has('post_groups')) {
            $user->postGroups()->sync($request->post_groups);
        }
        

        return redirect()->route('users.edit', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
