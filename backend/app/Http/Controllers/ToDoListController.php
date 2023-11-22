<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Google\Cloud\MigrationCenter\V1\ReportSummary\UtilizationChartData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ToDoListController extends Controller
{

    public function getToDoList()
    {
        $todos = ToDoList::all();
        return view('cms.ToDoList.todolist', compact('todos'));
    }

    public function addToDoList()
    {
        $todo = ToDoList::find(1);
        return view('cms.ToDoList.create', ['todo' => $todo]);
    }


    public function storeToDoList(Request $request)
    {try{
        $validatedData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        $TodoList = new ToDoList([
            'title' => $request->title
        ]);

        ToDoList::create($validatedData);
        addRec('To Do List', Auth::id(), Auth::user()->role_id, $TodoList->title);
        return redirect()->route('adminpanel')->with('success', 'Data can be saved');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }



    public function editToDoList($id)
    {
        $todo = ToDoList::find($id);
        return view('cms.ToDoList.edit', compact('todo'));
    }

    public function updateToDoList(Request $request, $id)
    {try{
        $todo = ToDoList::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        $todoBefore = clone $todo;
        $todo->title = $request->input('title');


        $todo->update($request->all());
        editRec('To Do Lis', Auth::id(), Auth::user()->role_id, $todoBefore, $todo, $todoBefore->title);
        return redirect()->route('adminpanel');
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }


    public function deleteToDoList($id)
    {try{
        $todo = ToDoList::findOrFail($id);

        if ($todo) {
            $todoTitle = $todo->title;
            $todo->delete();
            deleteRec('To Do List', Auth::id(), Auth::user()->role_id, $todoTitle);
            return redirect()->route('adminpanel')->with('success', 'Item has been deleted.');
        } else {
            return redirect()->route('adminpanel')->with('error', 'Item not found.');
        }
    }catch(\Throwable $th){
        return redirect()->back()->with('error', $th->getMessage());
    }
    }

}
