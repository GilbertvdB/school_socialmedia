<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostGroupStoreRequest;
use App\Models\PostGroup;
use Illuminate\Http\RedirectResponse;
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
    public function create(): View
    {
        return view('postgroups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostGroupStoreRequest $request): RedirectResponse
    {
        PostGroup::create($request->validated());

        return redirect()->route('postgroups.index')->with('success', 'PostGroup created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostGroup $postGroup): View
    {
        return view('postgroups.edit', compact('postGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostGroupStoreRequest $request, PostGroup $postGroup): RedirectResponse
    {
        $postGroup->update($request->validated());

        return redirect()->route('postgroups.index')->with('success', 'PostGroup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostGroup $postGroup): RedirectResponse
    {
        $postGroup->delete();

        return redirect()->route('postgroups.index')->with('success', 'PostGroup deleted successfully.');
    }
}
