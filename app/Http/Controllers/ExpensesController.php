<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use RealRashid\SweetAlert\Facades\Alert;

class ExpensesController extends Controller
{
    public function createProjectExpenses($id)
    {
        $project = Project::where('id', $id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);
        $members = $team->allUsers();
        return view('pages.project.expenses.create', compact('project', 'members'));
    }

    public function storeProjectExpenses(Request $request)
    {
        $request->validate([
            'description' => 'required|min:3|max:30',
            'ammount' => 'required',
            'expenses_date' => 'required',
            'expenses_category' => 'required',
            'team_member' => 'required',
            'receipt' => 'mimes:jpg,png|max:2048',
            'project_id' =>  'required',
        ]);

        $numbers = explode(',', $request->ammount);
        $ammount = (int)join('', $numbers);

        $file = $request->file('receipt');

        if ($receiptFile = $request->file('receipt')) {
            $destinationPath = 'uploads/receipt';
            $receiptName1 = $receiptFile->getClientOriginalName();
            $receiptName2 = explode('.', $receiptName1)[0]; 
            $receiptName = $receiptName2 . "_" . date('YmdHis') . "." . $receiptFile->getClientOriginalExtension();
            $receiptFile->move($destinationPath, $receiptName);
            $file = "$receiptName";
        } else {
            unset($file);
        }

        if(empty($request->receipt)){
            Expense::create([
                'description' => $request->description,
                'ammount' => $ammount,
                'expenses_date' => $request->expenses_date,
                'expenses_category' => $request->expenses_category,
                'team_member' => $request->team_member,
                'project_id' =>  $request->project_id,
            ]);
        } else {
            Expense::create([
                'description' => $request->description,
                'ammount' => $ammount,
                'expenses_date' => $request->expenses_date,
                'expenses_category' => $request->expenses_category,
                'team_member' => $request->team_member,
                'receipt' => $receiptName,
                'project_id' =>  $request->project_id,
            ]);
        }
        
        Alert::success('Success!', 'Project expenses has been succesfully created.');

        $project_id = $request->project_id;
        return redirect()->route('project.show', $project_id);
    }

    public function editProjectExpenses($id, Expense $expense)
    {
        $project = Project::where('id', $id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);
        $members = $team->allUsers();
        return view('pages.project.expenses.edit', compact('expense', 'project', 'members'));
    }

    public function updateProjectExpenses(Request $request)
    {
        $id = $request->expenses_id;
        $expenses = Expense::where('id', $id)->first();

        $request->validate([
            'description' => 'required|min:3|max:30',
            'ammount' => 'required',
            'expenses_date' => 'required',
            'expenses_category' => 'required',
            'team_member' => 'required',
            'receipt' => 'mimes:jpg,png|max:2048',
            'project_id' =>  'required',
        ]);

        $numbers = explode(',', $request->ammount);
        $ammount = (int)join('', $numbers);

        $file = $request->file('receipt');

        if ($receiptFile = $request->file('receipt')) {
            $destinationPath = 'uploads/receipt';
            $receiptName1 = $receiptFile->getClientOriginalName();
            $receiptName2 = explode('.', $receiptName1)[0]; 
            $receiptName = $receiptName2 . "_" . date('YmdHis') . "." . $receiptFile->getClientOriginalExtension();
            $receiptFile->move($destinationPath, $receiptName);
            $file = "$receiptName";
        } else {
            unset($file);
        }

        if(empty($request->receipt)){
            $expenses->update([
                'description' => $request->description,
                'ammount' => $ammount,
                'expenses_date' => $request->expenses_date,
                'expenses_category' => $request->expenses_category,
                'team_member' => $request->team_member,
                'project_id' =>  $request->project_id,
            ]);
        } else {
            $expenses->update([
                'description' => $request->description,
                'ammount' => $ammount,
                'expenses_date' => $request->expenses_date,
                'expenses_category' => $request->expenses_category,
                'team_member' => $request->team_member,
                'receipt' => $receiptName,
                'project_id' =>  $request->project_id,
            ]);
        }

        Alert::success('Success!', 'Project expenses has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.show', $project_id);
    }

    public function editStatusExpenses($id, Expense $expense)
    {
        $project = Project::where('id', $id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);
        $members = $team->allUsers();
        return view('pages.project.expenses.edit-status', compact('expense', 'project', 'members'));
    }

    public function updateStatusExpenses(Request $request)
    {
        $request->validate([
            'expenses_status' => 'required',
        ]);
        
        $id = $request->expenses_id;
        $expenses = Expense::where('id', $id)->first();

        $expenses->update([
            'expenses_status' => $request->expenses_status,
        ]);

        Alert::success('Success!', 'Expenses status has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.show', $project_id);
    }
}
