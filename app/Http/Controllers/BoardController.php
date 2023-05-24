<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view('pages.board.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'project_id' => 'required',
        ]);

        Board::create($request->all());

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/task');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createBoard($id)
    {
        $projects = Project::where('id', $id)->first();

        return view('pages.project.task.create-board', compact('projects'));
    }

    public function storeBoard(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'project_id' => 'required',
        ]);

        $project_id = $request->project_id;

        Board::create($request->all());

        Alert::success('Success!', 'Board has been succesfully created.');

        return redirect()->route('project.task', $project_id);
    }

    public function editBoard($id, Board $board)
    {
        $projects = Project::where('id', $id)->first();

        return view('pages.project.task.edit-board', compact('board', 'projects'));
    }

    public function updateBoard(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'project_id' => 'required',
        ]);
        
        $id = $request->board_id;
        $board = Board::where('id', $id);
        $board->update([
            'title' => $request['title'],
            'project_id' => $request['project_id'],
        ]);

        $project_id = $request->project_id;

        Alert::success('Success!', 'Board has been succesfully updated.');

        return redirect()->route('project.task', $project_id);
    }

    public function destroyBoard($id, $board) 
    {
        Board::where('id', $board)->delete();

        Alert::success('Success!', 'Board has been succesfully deleted.');

        return back();
    }
}
