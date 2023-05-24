<?php

use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ClientUserController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('landing.index');
// })->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::put('/notif-read', [NotificationController::class, 'read'])->name('notif.read');
    Route::put('/notif-read-all', [NotificationController::class, 'readAll'])->name('notif.read.all');
    Route::get('/notification', [NotificationController::class, 'view'])->name('notif.show');
    Route::put('/message-read', [NotificationController::class, 'readMessage'])->name('message.read');
    Route::put('/message-read-all', [NotificationController::class, 'readMessageAll'])->name('message.read.all');

    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('/user/update-tour-settings', [UserController::class, 'updateTourSettings'])->name('user.update-tour-settings');

    //Project Resource
    Route::resource('project', ProjectController::class);
    Route::get('/project/{id}/download-proposal', [ProjectController::class, 'downloadProposal'])->name('project.proposal');

    //Project Task
    Route::get('/project/{id}/gantt-chart', [TaskController::class, 'ganttChart'])->name('project.task.gantt');

    //Project Report
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/project/{id}/sprint-reports', [ReportController::class, 'sprintReport'])->name('project.report.sprint');
    Route::get('/project/{id}/timesheet-reports', [ReportController::class, 'timesheetReport'])->name('project.report.timesheet');
    Route::get('/project/{id}/efficiency-reports', [ReportController::class, 'efficiencyReport'])->name('project.report.efficiency');
    Route::get('/project/{id}/sprint-reports/{sprint}/burndown', [ReportController::class, 'sprintBurndown'])->name('project.report.sprint.burndown');

    //Project Meeting
    Route::get('/meeting', [MeetingController::class, 'index'])->name('meeting.index');
    Route::get('/project/{id}/meeting', [MeetingController::class, 'meetingProject'])->name('project.meeting');

    //Project Finance
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');

    //Project Invoice
    Route::get('/project/{id}/manage-invoice', [FinanceController::class, 'manageInvoice'])->name('project.invoice.index');
    Route::get('/project/{id}/invoice/{invoice}', [FinanceController::class, 'showInvoice'])->name('project.invoice.show');
    Route::get('/project/{id}/invoice/{invoice}/payment-file', [FinanceController::class, 'downloadPayment'])->name('project.payment.download');

    //Project Expenses
    Route::get('project/{id}/create-expenses', [ExpensesController::class, 'createProjectExpenses'])->name('project.expenses.create');
    Route::post('/project/store-expenses', [ExpensesController::class, 'storeProjectExpenses'])->name('project.expenses.store');
    Route::get('/project/{id}/expenses/{expense}/edit', [ExpensesController::class, 'editProjectExpenses'])->name('project.expenses.edit');
    Route::put('/project/{id}/expenses/{expense}/update-expenses', [ExpensesController::class, 'updateProjectExpenses'])->name('project.expenses.update');

    //Project Timesheet
    Route::get('/project/{id}/tasks/{tasks}/record', [TimesheetController::class, 'createTimesheet'])->name('project.timesheet.create');
    Route::post('/project/store-timesheet', [TimesheetController::class, 'storeTimesheet'])->name('project.timesheet.store');

    //Help Portal
    Route::get('/help-portal', [HelpController::class, 'index'])->name('help.portal');

    Route::group(['middleware' => 'role:project-manager'], function () {
        Route::resource('user', UserController::class);
        Route::resource('client', ClientController::class);
        Route::resource('client-user', ClientUserController::class);
        Route::resource('backlog', BacklogController::class);
        Route::resource('sprint', SprintController::class);
        Route::resource('task', TaskController::class);

        //Update User Password and Proposal Download
        Route::get('project/{id}/download-proposal', [ProjectController::class, 'downloadProposal'])->name('project.proposal');
        Route::get('client-user/{id}/update-password', [ClientUserController::class, 'changePassword'])->name('change.password');
        Route::put('client-user/{id}/update-pass',  [ClientUserController::class, 'editPassword'])->name('user.password');

        //Project Finance
        Route::get('/project/{id}/manage-budget', [FinanceController::class, 'manageBudget'])->name('project.budget.manage');
        Route::put('/project/{id}/update-budget', [FinanceController::class, 'updateBudget'])->name('project.budget.update');
        Route::get('/project/{id}/manage-expenses', [FinanceController::class, 'manageExpenses'])->name('project.expenses.manage');

        //Project Invoice
        Route::get('/project/{id}/create-invoice', [FinanceController::class, 'createInvoice'])->name('project.invoice.create');
        Route::post('/project/{id}/store-invoice', [FinanceController::class, 'storeInvoice'])->name('project.invoice.store');
        Route::get('/project/{id}/invoice/{invoice}/edit', [FinanceController::class, 'editInvoice'])->name('project.invoice.edit');
        Route::put('/project/{id}/update-invoice', [FinanceController::class, 'updateInvoice'])->name('project.invoice.update');
        Route::get('/project/{id}/invoice/{invoice}/confirm', [FinanceController::class, 'confirmInvoicePayment'])->name('project.invoice.confirm');
        Route::put('/project/{id}/invoice/{invoice}/payment-confirm', [FinanceController::class, 'updateInvoicePayment'])->name('project.invoice.confirm.update');
        Route::get('/project/{id}/invoice/{invoice}/send', [FinanceController::class, 'sendInvoiceMail'])->name('project.invoice.send');

        // Route::get('getTask/{id}', [FinanceController::class, 'getTaskData']);
        // Route::get('getTimesheet/{id}', [FinanceController::class, 'getTimesheetData']);

        //Project Task
        Route::get('/project/{id}/tasks', [TaskController::class, 'taskList'])->name('project.task');
        Route::get('/project/{id}/table-view', [TaskController::class, 'tableView'])->name('project.task.table');
        Route::get('/project/{id}/finished-tasks', [TaskController::class, 'taskFinished'])->name('project.task.finished');
        Route::get('/project/{id}/create-task', [TaskController::class, 'createTask'])->name('project.task.create');
        Route::get('/project/{id}/tasks/{task}/edit', [TaskController::class, 'editTask'])->name('project.task.edit');
        Route::post('/project/store-task', [TaskController::class, 'storeTask'])->name('project.task.store');
        Route::put('/project/{id}/tasks/{task}/update-task', [TaskController::class, 'updateTask'])->name('project.task.update');
        Route::put('/project/{id}/tasks/{task}/move-task', [TaskController::class, 'moveTask'])->name('project.task.move');
        Route::put('/project/{id}/tasks/{task}/status', [TaskController::class, 'taskStatus'])->name('project.task.status');
        Route::delete('/project/{id}/tasks/{task}/destroy-task', [TaskController::class, 'destroyTask'])->name('project.task.destroy');
        Route::post('/project/remind-task', [TaskController::class, 'taskReminder'])->name('project.task.reminder');
        Route::get('/project/{id}/tasks/{task}/update-progress', [TaskController::class, 'editTaskProgress'])->name('project.task.progress');
        Route::put('/project/{id}/tasks/{task}/update-progress', [TaskController::class, 'updateTaskProgress'])->name('project.task.progress.update');

        //Project Board
        Route::get('/project/{id}/create-board', [BoardController::class, 'createBoard'])->name('project.board.create');
        Route::post('/project/store-board', [BoardController::class, 'storeBoard'])->name('project.board.store');
        Route::get('/project/{id}/tasks/edit-board/{board}', [BoardController::class, 'editBoard'])->name('project.board.edit');
        Route::put('/project/{id}/tasks/update-board/{board}', [BoardController::class, 'updateBoard'])->name('project.board.update');
        Route::delete('/project/{id}/board/{board}/destroy-board', [BoardController::class, 'destroyBoard'])->name('project.board.destroy');

        //Project Sprint
        Route::get('project/{id}/create-sprint', [SprintController::class, 'createProjectSprint'])->name('project.sprint.create');
        Route::post('/project/store-sprint', [SprintController::class, 'storeProjectSprint'])->name('project.sprint.store');
        Route::get('/project/{id}/sprint/{sprint}/edit', [SprintController::class, 'editProjectSprint'])->name('project.sprint.edit');
        Route::put('/project/{id}/sprint/{sprint}/update-sprint', [SprintController::class, 'updateProjectSprint'])->name('project.sprint.update');
        Route::put('/project/{id}/sprint/{sprint}/sprint-status', [SprintController::class, 'sprintStatus'])->name('project.sprint.status');

        //Project Backlog
        Route::get('project/{id}/create-backlog', [BacklogController::class, 'createProjectBacklog'])->name('project.backlog.create');
        Route::post('/project/store-backlog', [BacklogController::class, 'storeProjectBacklog'])->name('project.backlog.store');
        Route::get('/project/{id}/backlog/{backlog}/edit', [BacklogController::class, 'editProjectBacklog'])->name('project.backlog.edit');
        Route::put('/project/{id}/backlog/{backlog}/update-backlog', [BacklogController::class, 'updateProjectBacklog'])->name('project.backlog.update');

        //Project Expenses
        Route::get('/project/{id}/expenses/{expense}/edit-status', [ExpensesController::class, 'editStatusExpenses'])->name('project.expenses.status.edit');
        Route::put('/project/{id}/expenses/{expense}/update-status', [ExpensesController::class, 'updateStatusExpenses'])->name('project.expenses.status.update');

        //Project Meeting
        Route::get('project/{id}/create-meeting', [MeetingController::class, 'createMeeting'])->name('project.meeting.create');
        Route::post('/project/store-meeting', [MeetingController::class, 'storeMeeting'])->name('project.meeting.store');
        Route::get('/project/{id}/meeting/{meeting}/edit', [MeetingController::class, 'editMeeting'])->name('project.backlog.edit');
        Route::put('/project/{id}/meeting/{meeting}/update-meeting', [MeetingController::class, 'updateMeeting'])->name('project.backlog.update');
    });

    Route::group(['middleware' => 'role:client-user'], function () {
        Route::get('/project/{id}/project-status', [ProjectController::class, 'approve'])->name('project.status');
        Route::put('/project/{id}/project-approval', [ProjectController::class, 'approveProject'])->name('project.approval');

        //Project Invoice
        Route::get('/project/{id}/invoice/{invoice}/payment', [FinanceController::class, 'createPaymentInvoice'])->name('project.invoice.payment');
        Route::put('/project/{id}/invoice/{invoice}/process-payment', [FinanceController::class, 'storePaymentInvoice'])->name('project.invoice.payment.store');
        Route::get('/project/{id}/invoice/{invoice}/edit-payment', [FinanceController::class, 'editPaymentInvoice'])->name('project.invoice.payment.edit');
        Route::put('/project/{id}/invoice/{invoice}/update-payment', [FinanceController::class, 'updatePaymentInvoice'])->name('project.invoice.payment.update');
    });

    Route::group(['middleware' => 'role:team-member'], function () {

        //Project Task
        Route::get('/project/{id}/tasks', [TaskController::class, 'taskList'])->name('project.task');
        Route::get('/project/{id}/table-view', [TaskController::class, 'tableView'])->name('project.task.table');
        Route::get('/project/{id}/finished-tasks', [TaskController::class, 'taskFinished'])->name('project.task.finished');
        Route::put('/project/{id}/tasks/{task}/move-task', [TaskController::class, 'moveTask'])->name('project.task.move');
        Route::put('/project/{id}/tasks/{task}/status', [TaskController::class, 'taskStatus'])->name('project.task.status');
        Route::get('/project/{id}/tasks/{task}/update-progress', [TaskController::class, 'editTaskProgress'])->name('project.task.progress');
        Route::put('/project/{id}/tasks/{task}/update-progress', [TaskController::class, 'updateTaskProgress'])->name('project.task.progress.update');

        //Project Timesheet
        Route::get('/project/{id}/tasks/{tasks}/record', [TimesheetController::class, 'createTimesheet'])->name('project.timesheet.create');
        Route::post('/project/store-timesheet', [TimesheetController::class, 'storeTimesheet'])->name('project.timesheet.store');
    });
});

require __DIR__ . '/jetstream.php';
