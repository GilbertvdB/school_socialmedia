<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::paginate(10);
        return view('students.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {   
        return view('profile.show', ['user' => $student]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {      
        $classrooms = Classroom::all();
        $parents = User::parents()->get();
        return view('students.create', compact('classrooms', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentStoreRequest $request): RedirectResponse
    {   
        $student = Student::create($request->validated());
        
        if ($request->has('classroom')) {
            $student->classroom()->attach($request->classroom);
        }

        if ($request->has('parents')) {
            $student->parents()->attach($request->parents);
        }

        return to_route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {   
        $classrooms = Classroom::all();
        $parents = User::parents()->get();
        
        return view('students.edit', compact('student', 'classrooms', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentStoreRequest $request, Student $student): RedirectResponse
    {
        $validated= $request->validated();

        $student->update($request->except(['classroom', 'parents']));
        
        if ($request->has('classroom')) {
            $student->classroom()->sync($validated['classroom']);
        }
        
        if ($request->has('parents')) {
            $student->parents()->sync($validated['parents']);
        }
        
        return redirect()->route('students.edit', $student->id)->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return to_route('students.index')->with('success', 'Student deleted successfully.');
    }
}
