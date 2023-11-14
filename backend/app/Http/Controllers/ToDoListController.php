<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Google\Cloud\MigrationCenter\V1\ReportSummary\UtilizationChartData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getToDoList()
    {
        $todos = ToDoList::all();
        return view('cms.ToDoList.todolist', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToDoList()
    {
        $todo = ToDoList::find(1);
        return view('cms.ToDoList.create', ['todo' => $todo]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeToDoList(Request $request)
    {
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editToDoList($id)
    {
        $todo = ToDoList::find($id);
        return view('cms.ToDoList.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateToDoList(Request $request, $id)
    {
        $todo = ToDoList::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        $titleBefore = $todo->title;
        $todo->title = $request->input('title');


        $todo->update($request->all());
        editRec('To Do Lis', Auth::id(), Auth::user()->role_id, $titleBefore, $todo->title);
        return redirect()->route('adminpanel');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteToDoList($id)
    {
        $todo = ToDoList::findOrFail($id);

        if ($todo) {
            $todoTitle = $todo->title;
            $todo->delete();
            deleteRec('To Do List', Auth::id(), Auth::user()->role_id, $todoTitle);
            return redirect()->route('todolist.index')->with('error', 'Item not found.');
        } else {
            return redirect()->route('todolist.index')->with('success', 'Item has been deleted.');

        }


    }
}
