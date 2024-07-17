<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {      
        $user = $student;
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {      
        $classrooms = Classroom::all();
        $parents = User::where('role', 'parent')->get();
        return view('students.create', compact('classrooms', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {   
        // Validate the request
        $validated= $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'birthdate' => ['required', 'date'],
                'gender' => ['required'],
                'classroom' => ['nullable'],
                'parents' => ['array'],
                'parents.*' => ['exists:users,id',]
            ]);
        // dd($request->classroom);
        $student = Student::create($validated);
        
        if ($request->has('classroom')) {
            $student->classroom()->attach($request->classroom);
        }

        if ($request->has('parents')) {
            $student->parents()->attach($request->parents);
        }

        // Additional logic, e.g., redirect or return response
        // return redirect(route('students.index'))->with('success', 'Student created successfully.');
        return to_route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {   
        $classrooms = Classroom::all();
        $parents = User::where('role', 'parent')->get();
        
        return view('students.edit', compact('student', 'classrooms', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated= $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'birthdate' => ['required', 'date'],
                'gender' => ['required'],
                'classroom' => ['nullable'],
                'parents' => ['array'],
                'parents.*' => ['exists:users,id',]
            ]);

        $student->update($request->except(['classroom', 'parents']));
        
        if ($request->has('classroom')) {
            $student->classroom()->sync($request->classroom);
        }
        
        if ($request->has('parents')) {
            $student->parents()->sync($request->parents);
        }
        

        return redirect()->route('students.edit', $student->id)->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();
        // delete all related entries
        return to_route('students.index')->with('success', 'Student deleted successfully.');
    }
}
