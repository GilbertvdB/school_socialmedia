<?php

namespace App\Http\Controllers;

use App\Models\PostGroup;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $postGroups = PostGroup::paginate(10);
        return view('postgroups.index', compact('postGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('postgroups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        PostGroup::create($request->all());

        return redirect()->route('postgroups.index')->with('success', 'PostGroup created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostGroup $postGroup)
    {
        return view('postgroups.edit', compact('postGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostGroup $postGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
        ]);

        $postGroup->update($request->all());

        return redirect()->route('postgroups.index')->with('success', 'PostGroup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostGroup $postGroup)
    {
        $postGroup->delete();

        return redirect()->route('postgroups.index')->with('success', 'PostGroup deleted successfully.');
    }
}
