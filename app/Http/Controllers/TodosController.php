<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
     public function index(){
         $todos = Todo::all();
         return view('todos.index', compact('todos'));
     }

     public function show(Todo $todo){
         return view('todos.show', compact('todo')); //ROUTE MODEL BINDING USED

     }

     public function create(){
         return view('todos.create');
     }

     public function store(){
//         dd(request()->all());-->die dump/show the data without view.
         $this->validate(request(), [
             'name'=>'required|min:6|max:15',
             'description' =>'required'
         ]);
         $data = request()->all();
         $todo = new Todo();
         $todo->name = $data['name'];
         $todo->description = $data['description'];
         $todo->completed = false;
         $todo->save();

         session()->flash('success', 'Todo Created Successfully');


         return redirect('/todos');
     }

     public function edit(Todo $todo){
         return view('todos.edit', compact('todo')); //Route MODEL BINDING USED
     }
     public function update($todoId){
         $this->validate(request(), [
             'name'=>'required|min:6|max:15',
             'description' =>'required'
         ]);
         $data = request()->all();
         $todo = Todo::find($todoId);//MODEL BINDING NOT USED

         $todo->name = $data['name'];
         $todo->description = $data['description'];


         $todo->save();

         session()->flash('success', 'Todo Updated Successfully');

         return redirect('/todos');
     }

     public function destroy(Todo $todo){

         $todo->delete();


         session()->flash('danger', 'Todo deleted permanently');

         return redirect('/todos');//Route model binding used
     }

     public function complete(Todo $todo){
         $todo->completed = true;
         $todo->save();

         session()->flash('success', 'Todo Completed successfully');

         return redirect('/todos');//Route model binding used

     }
}
