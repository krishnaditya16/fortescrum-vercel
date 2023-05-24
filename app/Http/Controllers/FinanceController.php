<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Stripe\StripeClient;
use Stripe\Exception\CardException;

class FinanceController extends Controller
{
    public function index()
    {
        return view('pages.finance.index');
    }

    public function manageBudget($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        $arr = [];
        foreach ($team->users as $user) {
            $arr[] = $user->id;
        }

        $client = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->join('clients', 'users.client_id', 'clients.id')
            ->whereIn('team_user.user_id', $arr)->where('role', 'client-user')
            ->select('clients.id', 'clients.name')
            ->first();

        $spending = Expense::where('project_id', $project->id)->where('expenses_status', 1)->sum('ammount') / 100;

        if ($team->id != $project->team_id) {
            abort(403);
        } else {
            return view('pages.finance.budget.manage', compact('project', 'team', 'client', 'spending'));
        }
    }

    public function updateBudget(Request $request, $id)
    {
        $request->validate([
            'budget' => 'required',
        ]);

        $numbers = explode(',', $request->budget);
        $budget = (int)join('', $numbers);

        $project = Project::find($id);
        $project->update([
            'budget' => $budget,
        ]);

        Alert::success('Success!', 'Project budget has been succesfully updated.');

        return redirect()->route('project.show', $project->id);
    }

    public function manageExpenses($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        $expenses = Expense::where("project_id", $project->id)->get();

        if ($project->team_id != $team->id) {
            abort(403);
        } else {
            return view('pages.finance.expenses.index', compact('project', 'team', 'expenses'));
        }
    }

    public function manageInvoice($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        if ($project->team_id != $team->id) {
            abort(403);
        } else {
            return view('pages.finance.invoice.index', compact('project', 'team'));
        }
    }

    public function createInvoice($id)
    {
        $team = Auth::user()->currentTeam;
        $arr = [];
        foreach ($team->users as $user) {
            $arr[] = $user->id;
        }

        $client = Client::whereIn('user_id', $arr)->first();
        $tasks = Task::where('project_id', $id)->get();
        $timesheets = Timesheet::with('tasks')->where('project_id', $id)->get();
        $expenses = Expense::where('project_id', $id)->where('expenses_status', 1)->get();

        $project = Project::find($id);

        return view('pages.finance.invoice.create', compact('project', 'client', 'tasks', 'timesheets', 'expenses'));
    }

    public function storeInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_address' => 'required',
            'issued' => 'required',
            'deadline' => 'required',
            'total_all' => 'required',
            // 'task_id[]' => 'required',
            // 'time_id[]' => 'required',
            // 'exp_id[]' => 'required',
            // 'total_task[]' => 'required',
            // 'total_ts[]' => 'required',
            // 'rate_task[]' => 'required',
            // 'qty_task[]' => 'required',
            // 'rate_ts[]' => 'required',
            // 'qty_ts[]' => 'required',
            'subtotal_task' => 'required',
            'subtotal_ts' => 'required',
            'subtotal_exp' => 'required',
        ], [
            'rate_task[].required' => 'The task rate field is required.',
            'qty_task[].required' => 'The task quantity field is required.',
            'total_task[].required' => 'The total task field is required.',
            'rate_ts[].required' => 'The timesheet rate field is required.',
            'total_ts[].required' => 'The total timesheet field is required.',
            'total_all.required' => 'The overall total field is empty, please fill all the field from selected invoice unit first.'
        ]);

        if ($validator->fails()) {
            Alert::warning('Warning!', 'Please input all the data before submitting the form');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task_id = implode(',', $request->task_id);
        $task_rate = implode(',', $request->rate_task);
        $task_qty = implode(',', $request->qty_task);
        $total_task = implode(',', $request->total_task);

        $timesheet_id = implode(',', $request->time_id);
        $timesheet_rate = implode(',', $request->rate_ts);
        $timesheet_qty = implode(',', $request->qty_ts);
        $total_ts = implode(',', $request->total_ts);

        $expenses_id = implode(',', $request->exp_id);
        $expenses_ammount = implode(',', $request->exp_ammount);

        Invoice::create([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'issued' => $request->issued,
            'deadline' => $request->deadline,
            'tax_percent' => $request->tax_percent,
            'tax_ammount' => $request->tax_ammount,
            'discount_percent' => $request->discount_percent,
            'discount_ammount' => $request->discount_ammount,
            'task_id' => $task_id,
            'rate_task' => $task_rate,
            'qty_task' => $task_qty,
            'total_task' => $total_task,
            'subtotal_task' => $request->subtotal_task,
            'timesheet_id' => $timesheet_id,
            'rate_ts' => $timesheet_rate,
            'qty_ts' => $timesheet_qty,
            'total_ts' => $total_ts,
            'subtotal_ts' => $request->subtotal_ts,
            'expenses_id' => $expenses_id,
            'exp_ammount' => $expenses_ammount,
            'subtotal_exp' => $request->subtotal_exp,
            'total_all' => $request->total_all,
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
        ]);

        Alert::success('Success!', 'Invoice has been succesfully created.');

        $project_id = $request->project_id;
        return redirect()->route('project.invoice.index', $project_id);
    }

    public function sendInvoiceMail($id, Invoice $invoice)
    {
        $project = Project::where('id', $id)->first();
        $client = Client::where('id', $invoice->client_id)->first();
        $from_mail = Auth::user()->email;
        $mail_sender = Auth::user()->name;

        $details = [
            'title' => 'New Invoice Has Been Assigned to Your Company',
            'url' => 'http://127.0.0.1:8000/project/' . $id . '/invoice' . '/' . $invoice->id,
            'invoice' => $invoice->id,
            'project' => $project->title,
            'client' => $client->name,
            'issued_date' => $invoice->issued,
            'total' => $invoice->total_all,
            'due_date' => $invoice->deadline,
            'from_mail' => $from_mail,
            'mail_sender' => $mail_sender,
        ];

        $invoice->update([
            'inv_status' => 1,
        ]);

        Mail::to($client->email)->send(new InvoiceMail($details));

        Alert::success('Success!', 'Invoice mail has been succesfully sent.');
        return back();
    }

    public function editInvoice($id, Invoice $invoice)
    {
        $client = Client::where('id', $invoice->client_id)->first();
        $project = Project::where('id', $invoice->project_id)->first();

        $task_id = explode(',', $invoice->task_id);
        $time_id = explode(',', $invoice->timesheet_id);
        $exp_id = explode(',', $invoice->expenses_id);

        $rate_task = explode(',', $invoice->rate_task);
        $qty_task = explode(',', $invoice->qty_task);
        $total_task = explode(',', $invoice->total_task);

        $rate_ts = explode(',', $invoice->rate_ts);
        $qty_ts = explode(',', $invoice->qty_ts);
        $total_ts = explode(',', $invoice->total_ts);

        $exp_ammount = explode(',', $invoice->exp_ammount);

        $tasks = Task::where('project_id', $id)->get();
        $timesheets = Timesheet::with('tasks')->where('project_id', $id)->get();
        $expenses = Expense::where('project_id', $id)->where('expenses_status', 1)->get();

        // Fix rate_task, qty_task, and total_task if the number of values is less than the number of tasks
        $taskCount = count($tasks);
        $rateCount = count($rate_task);
        if ($rateCount < $taskCount) {
            $rate_task = array_pad($rate_task, $taskCount, '');
        }

        if (count($qty_task) < $taskCount) {
            $qty_task = array_pad($qty_task, $taskCount, '');
        }

        if (count($total_task) < $taskCount) {
            $total_task = array_pad($total_task, $taskCount, '');
        }

        // Fix rate_ts, qty_ts, and total_ts if the number of values is less than the number of timesheets
        $timesheetCount = count($timesheets);
        $rateTsCount = count($rate_ts);
        if ($rateTsCount < $timesheetCount) {
            $rate_ts = array_pad($rate_ts, $timesheetCount, '');
        }

        if (count($qty_ts) < $timesheetCount) {
            $qty_ts = array_pad($qty_ts, $timesheetCount, '');
        }

        if (count($total_ts) < $timesheetCount) {
            $total_ts = array_pad($total_ts, $timesheetCount, '');
        }

        // Fix exp_ammount if the number of values is less than the number of expenses
        $expenseCount = count($expenses);
        $expAmmountCount = count($exp_ammount);
        if ($expAmmountCount < $expenseCount) {
            $exp_ammount = array_pad($exp_ammount, $expenseCount, '');
        }

        return view('pages.finance.invoice.edit', compact(
            'invoice',
            'project',
            'client',
            'tasks',
            'timesheets',
            'expenses',
            'task_id',
            'rate_task',
            'qty_task',
            'total_task',
            'time_id',
            'rate_ts',
            'qty_ts',
            'total_ts',
            'exp_id',
            'exp_ammount',
        ));
    }

    public function updateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_address' => 'required',
            'issued' => 'required',
            'deadline' => 'required',
            'total_all' => 'required',
        ], [
            'total_all.required' => 'The overall total field is empty, please fill all the field from selected invoice unit first.'
        ]);

        if ($validator->fails()) {
            Alert::warning('Warning!', 'Please input all the data before submitting the form');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task_id = implode(',', $request->task_id);
        $task_rate = implode(',', $request->rate_task);
        $task_qty = implode(',', $request->qty_task);
        $total_task = implode(',', $request->total_task);

        $timesheet_id = implode(',', $request->time_id);
        $timesheet_rate = implode(',', $request->rate_ts);
        $timesheet_qty = implode(',', $request->qty_ts);
        $total_ts = implode(',', $request->total_ts);

        $expenses_id = implode(',', $request->exp_id);
        $expenses_ammount = implode(',', $request->exp_ammount);

        $id = $request->invoice_id;
        $invoice = Invoice::where('id', $id)->first();

        $invoice->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'issued' => $request->issued,
            'deadline' => $request->deadline,
            'tax_percent' => $request->tax_percent,
            'tax_ammount' => $request->tax_ammount,
            'discount_percent' => $request->discount_percent,
            'discount_ammount' => $request->discount_ammount,
            'task_id' => $task_id,
            'rate_task' => $task_rate,
            'qty_task' => $task_qty,
            'total_task' => $total_task,
            'subtotal_task' => $request->subtotal_task,
            'timesheet_id' => $timesheet_id,
            'rate_ts' => $timesheet_rate,
            'qty_ts' => $timesheet_qty,
            'total_ts' => $total_ts,
            'subtotal_ts' => $request->subtotal_ts,
            'expenses_id' => $expenses_id,
            'exp_ammount' => $expenses_ammount,
            'subtotal_exp' => $request->subtotal_exp,
            'total_all' => $request->total_all,
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
        ]);

        Alert::success('Success!', 'Invoice has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.invoice.index', $project_id);
    }

    public function showInvoice($id, Invoice $invoice)
    {

        $project = Project::find($id);
        $client = Client::where('id', $invoice->client_id)->first();

        $task_id = explode(',', $invoice->task_id);
        $tasks = Task::whereIn('id', $task_id)->get();
        $rate_task = array_values(array_filter(explode(',', $invoice->rate_task)));
        $qty_task = array_values(array_filter(explode(',', $invoice->qty_task)));
        $total_task = array_values(array_filter(explode(',', $invoice->total_task)));

        $timesheet_id = explode(',', $invoice->timesheet_id);
        $timesheets = Timesheet::whereIn('id', $timesheet_id)->get();
        $rate_ts = array_values(array_filter(explode(',', $invoice->rate_ts)));
        $qty_ts = array_values(array_filter(explode(',', $invoice->qty_ts)));
        $total_ts = array_values(array_filter(explode(',', $invoice->total_ts)));

        $expenses_id = explode(',', $invoice->expenses_id);
        $expenses = Expense::whereIn('id', $expenses_id)->get();
        $exp_ammount = array_values(array_filter(explode(',', $invoice->exp_ammount)));

        $team = Auth::user()->currentTeam;

        // Fix rate_task, qty_task, and total_task if the number of values is less than the number of tasks
        $taskCount = count($tasks);
        $rateCount = count($rate_task);
        if ($rateCount < $taskCount) {
            $rate_task = array_pad($rate_task, $taskCount, '');
        }

        if (count($qty_task) < $taskCount) {
            $qty_task = array_pad($qty_task, $taskCount, '');
        }

        if (count($total_task) < $taskCount) {
            $total_task = array_pad($total_task, $taskCount, '');
        }

        // Fix rate_ts, qty_ts, and total_ts if the number of values is less than the number of timesheets
        $timesheetCount = count($timesheets);
        $rateTsCount = count($rate_ts);
        if ($rateTsCount < $timesheetCount) {
            $rate_ts = array_pad($rate_ts, $timesheetCount, '');
        }

        if (count($qty_ts) < $timesheetCount) {
            $qty_ts = array_pad($qty_ts, $timesheetCount, '');
        }

        if (count($total_ts) < $timesheetCount) {
            $total_ts = array_pad($total_ts, $timesheetCount, '');
        }

        // Fix exp_ammount if the number of values is less than the number of expenses
        $expenseCount = count($expenses);
        $expAmmountCount = count($exp_ammount);
        if ($expAmmountCount < $expenseCount) {
            $exp_ammount = array_pad($exp_ammount, $expenseCount, '');
        }

        return view(
            'pages.finance.invoice.show',
            compact(
                'invoice',
                'project',
                'client',
                'tasks',
                'rate_task',
                'qty_task',
                'total_task',
                'timesheets',
                'rate_ts',
                'qty_ts',
                'total_ts',
                'expenses',
                'exp_ammount',
                'team',
            )
        );
    }

    public function createPaymentInvoice($id, Invoice $invoice)
    {
        $project = Project::find($id);
        $payment = Payment::where('invoice_id', $invoice->id)->first();

        if (empty($payment)) {
            return view('pages.finance.invoice.create-payment', compact('project', 'invoice'));
        } else {
            Alert::warning('Warning!', 'Payment for Invoice : #INV-' . $invoice->id . ' has already been made.');
            return back();
        }
    }

    // public function storePaymentInvoice(Request $request)
    // {
    //     $request->validate([
    //         'invoice_payment' => 'mimes:pdf,jpg,png|max:2048',
    //         'payment_date' => 'required',
    //         'payment_type' => 'required',
    //     ]);

    //     $file = $request->file('invoice_payment');

    //     if ($invoiceFile = $request->file('invoice_payment')) {
    //         $destinationPath = 'uploads/invoice-payment';
    //         $invoiceName1 = $invoiceFile->getClientOriginalName();
    //         $invoiceName2 = explode('.', $invoiceName1)[0];
    //         $invoiceName = $invoiceName2 . "_" . date('YmdHis') . "." . $invoiceFile->getClientOriginalExtension();
    //         $invoiceFile->move($destinationPath, $invoiceName);
    //         $file = "$invoiceName";
    //     } else {
    //         unset($file);
    //     }

    //     $invoice = Invoice::where('id', $request->invoice_id)->first();

    //     Payment::create([
    //         'project_id' => $request->project_id,
    //         'invoice_id' => $request->invoice_id,
    //         'invoice_payment' => $invoiceName,
    //         'payment_date' => $request->payment_date,
    //         'payment_type' => $request->payment_type,
    //         'transaction_id' => $request->transaction_id,
    //         'notes' => $request->notes
    //     ]);

    //     $invoice->update([
    //         'inv_status' => 3,
    //     ]);

    //     Alert::success('Success!', 'Payment for Invoice : #INV-' . $invoice->id . ' has been succesfully created.');

    //     $project_id = $request->project_id;
    //     return redirect()->route('project.invoice.index', $project_id);
    // }

    public function storePaymentInvoice(Request $request)
    {
        $request->validate([
            'invoice_payment' => 'mimes:pdf,jpg,png|max:2048',
            'payment_date' => 'required',
            'payment_type' => 'required',
        ]);

        $file = $request->file('invoice_payment');

        if ($invoiceFile = $request->file('invoice_payment')) {
            $destinationPath = 'uploads/invoice-payment';
            $invoiceName1 = $invoiceFile->getClientOriginalName();
            $invoiceName2 = explode('.', $invoiceName1)[0];
            $invoiceName = $invoiceName2 . "_" . date('YmdHis') . "." . $invoiceFile->getClientOriginalExtension();
            $invoiceFile->move($destinationPath, $invoiceName);
            $file = "$invoiceName";
        } else {
            unset($file);
        }

        $invoice = Invoice::findOrFail($request->invoice_id);

        if ($request->payment_type == 1) {
            // Stripe payment processing
            try {
                $stripeSecretKey = env('STRIPE_SECRET');
    
                $stripe = new StripeClient($stripeSecretKey);
    
                $paymentMethod = $stripe->paymentMethods->create([
                    'type' => 'card',
                    'card' => [
                        'number' => $request->credit_card_number,
                        'exp_month' => $request->credit_card_expiry_month,
                        'exp_year' => $request->credit_card_expiry_year,
                        'cvc' => $request->credit_card_cvc,
                    ],
                    'billing_details' => [
                        'name' => $request->credit_card_name,
                    ],
                ]);
    
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $request->amount * 100, // Stripe amount is in cents
                    'currency' => 'usd',
                    'description' => 'Payment for Invoice #INV-' . $invoice->id,
                    'payment_method' => $paymentMethod->id,
                    'confirm' => true,
                ]);
    
                $transactionId = $paymentIntent->id;
    
                Payment::create([
                    'project_id' => $request->project_id,
                    'invoice_id' => $request->invoice_id,
                    'payment_date' => $request->payment_date,
                    'payment_type' => $request->payment_type,
                    'transaction_id' => $transactionId,
                    'notes' => $request->notes,
                ]);

                $invoice->update([
                    'inv_status' => 3,
                ]);

                Alert::success('Success!', 'Payment for Invoice: #INV-' . $invoice->id . ' has been successfully created.');
    
                return redirect()->route('project.invoice.index', $request->project_id);
            } catch (\Exception $e) {
                // Handle Stripe payment processing error
                return redirect()->back()->with('error', 'Payment processing exception failed: ' . $e->getMessage());
            }catch (CardException $e) {
                return redirect()->back()->with('error', 'Payment processing card exception failed: ' . $e->getMessage());
            } 
        }

        // Bank Transfer payment processing
        Payment::create([
            'project_id' => $request->project_id,
            'invoice_id' => $request->invoice_id,
            'invoice_payment' => $invoiceName,
            'payment_date' => $request->payment_date,
            'payment_type' => $request->payment_type,
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
        ]);

        $invoice->update([
            'inv_status' => 3,
        ]);

        Alert::success('Success!', 'Payment for Invoice: #INV-' . $invoice->id . ' has been successfully created.');
        return redirect()->route('project.invoice.index', $request->project_id);
    }

    public function editPaymentInvoice($id, Invoice $invoice)
    {
        $project = Project::find($id);
        $payment = Payment::where('invoice_id', $invoice->id)->first();

        if ($invoice->inv_status == 4) {
            return view('pages.finance.invoice.edit-payment', compact('project', 'invoice', 'payment'));
        } else {
            Alert::warning('Warning!', 'You cannot edit payment for this invoice.');
            return back();
        }
    }

    // public function updatePaymentInvoice(Request $request)
    // {
    //     $request->validate([
    //         'invoice_payment' => 'mimes:pdf,jpg,png|max:2048',
    //         'payment_date' => 'required',
    //         'payment_type' => 'required',
    //     ], [
    //         'invoice_payment.required' => 'The payment proof file is required.',
    //     ]);

    //     $file = $request->file('invoice_payment');

    //     if ($invoiceFile = $request->file('invoice_payment')) {
    //         $destinationPath = 'uploads/invoice-payment';
    //         $invoiceName1 = $invoiceFile->getClientOriginalName();
    //         $invoiceName2 = explode('.', $invoiceName1)[0];
    //         $invoiceName = $invoiceName2 . "_" . date('YmdHis') . "." . $invoiceFile->getClientOriginalExtension();
    //         $invoiceFile->move($destinationPath, $invoiceName);
    //         $file = "$invoiceName";
    //     } else {
    //         unset($file);
    //     }

    //     $invoice = Invoice::where('id', $request->invoice_id)->first();
    //     $payment = Payment::where('id', $request->payment_id)->first();

    //     $payment_file = $payment->invoice_payment;

    //     if (empty($file)) {
    //         $payment->update([
    //             'project_id' => $request->project_id,
    //             'invoice_id' => $request->invoice_id,
    //             'invoice_payment' => $payment_file,
    //             'payment_date' => $request->payment_date,
    //             'payment_type' => $request->payment_type,
    //             'transaction_id' => $request->transaction_id,
    //             'notes' => $request->notes
    //         ]);
    //     } else {
    //         $payment->update([
    //             'project_id' => $request->project_id,
    //             'invoice_id' => $request->invoice_id,
    //             'invoice_payment' => $invoiceName,
    //             'payment_date' => $request->payment_date,
    //             'payment_type' => $request->payment_type,
    //             'transaction_id' => $request->transaction_id,
    //             'notes' => $request->notes
    //         ]);
    //     }


    //     Alert::success('Success!', 'Payment for Invoice : #INV-' . $invoice->id . ' has been succesfully updated.');

    //     $project_id = $request->project_id;
    //     return redirect()->route('project.invoice.index', $project_id);
    // }

    public function updatePaymentInvoice(Request $request)
    {
        $request->validate([
            'invoice_payment' => 'mimes:pdf,jpg,png|max:2048',
            'payment_date' => 'required',
            'payment_type' => 'required',
        ]);

        $file = $request->file('invoice_payment');

        if ($invoiceFile = $request->file('invoice_payment')) {
            $destinationPath = 'uploads/invoice-payment';
            $invoiceName1 = $invoiceFile->getClientOriginalName();
            $invoiceName2 = explode('.', $invoiceName1)[0];
            $invoiceName = $invoiceName2 . "_" . date('YmdHis') . "." . $invoiceFile->getClientOriginalExtension();
            $invoiceFile->move($destinationPath, $invoiceName);
            $file = "$invoiceName";
        } else {
            unset($file);
        }

        $invoice = Invoice::findOrFail($request->invoice_id);
        $payment = Payment::findOrFail($request->payment_id);

        $payment_file = $payment->invoice_payment;

        if ($request->payment_type == 1) {
            // Stripe payment processing
            try {
                $stripeSecretKey = env('STRIPE_SECRET');

                $stripe = new StripeClient($stripeSecretKey);

                $paymentMethod = $stripe->paymentMethods->create([
                    'type' => 'card',
                    'card' => [
                        'number' => $request->credit_card_number,
                        'exp_month' => $request->credit_card_expiry_month,
                        'exp_year' => $request->credit_card_expiry_year,
                        'cvc' => $request->credit_card_cvc,
                    ],
                    'billing_details' => [
                        'name' => $request->credit_card_name,
                    ],
                ]);

                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => $request->amount * 100, // Stripe amount is in cents
                    'currency' => 'usd',
                    'description' => 'Payment for Invoice #INV-' . $invoice->id,
                    'payment_method' => $paymentMethod->id,
                    'confirm' => true,
                ]);

                $transactionId = $paymentIntent->id;

                $payment->update([
                    'project_id' => $request->project_id,
                    'invoice_id' => $request->invoice_id,
                    'payment_date' => $request->payment_date,
                    'payment_type' => $request->payment_type,
                    'transaction_id' => $transactionId,
                    'notes' => $request->notes
                ]);

                Alert::success('Success!', 'Payment for Invoice : #INV-' . $invoice->id . ' has been succesfully updated.');

                return redirect()->route('project.invoice.index', $request->project_id);
            } catch (\Exception $e) {
                // Handle Stripe payment processing error
                return redirect()->back()->with('error', 'Payment processing exception failed: ' . $e->getMessage());
            }catch (CardException $e) {
                return redirect()->back()->with('error', 'Payment processing card exception failed: ' . $e->getMessage());
            } 
        }

        // Bank Transfer payment processing
        if (empty($file)) {
            $payment->update([
                'project_id' => $request->project_id,
                'invoice_id' => $request->invoice_id,
                'invoice_payment' => $payment_file,
                'payment_date' => $request->payment_date,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes
            ]);
        } else {
            $payment->update([
                'project_id' => $request->project_id,
                'invoice_id' => $request->invoice_id,
                'invoice_payment' => $invoiceName,
                'payment_date' => $request->payment_date,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes
            ]);
        }

        Alert::success('Success!', 'Payment for Invoice : #INV-' . $invoice->id . ' has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.invoice.index', $project_id);
    }

    public function confirmInvoicePayment($id, Invoice $invoice)
    {
        $project = Project::find($id);
        $payment = Payment::where('invoice_id', $invoice->id)->first();

        if (empty($payment)) {
            Alert::warning('Warning!', 'Payment for Invoice : #INV-' . $invoice->id . ' is not found.');
            return back();
        } else {
            return view('pages.finance.invoice.confirm', compact('invoice', 'project', 'payment'));
        }
    }

    public function updateInvoicePayment(Request $request)
    {
        $request->validate([
            'inv_status' => 'required',
        ], [
            'inv_status.required' => 'The invoice payment status field is required.'
        ]);

        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $project_id = $request->project_id;

        $invoice->update([
            'inv_status' => $request->inv_status,
            'reason' => $request->reason,
        ]);

        Alert::success('Success!', 'Payment status for Invoice : #INV-' . $invoice->id . ' has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.invoice.index', $project_id);
    }

    public function downloadPayment($id, Invoice $invoice)
    {
        $payment = Payment::where('invoice_id', $invoice->id)->first();
        $file = public_path("uploads/invoice-payment/" . $payment->invoice_payment);
        return response()->download($file);
    }

    // public function getTaskData($id)
    // {
    //     $task = Task::where('project_id', $id)->get();
    //     return response()->json($task);
    // }

    // public function getTimesheetData($id)
    // {
    //     $timesheet = Timesheet::join('tasks', 'timesheets.task_id', 'tasks.id')
    //                         ->where('timesheets.project_id', $id)
    //                         ->select('tasks.*' ,'timesheets.id as time_id', 'timesheets.start_time', 'timesheets.end_time')
    //                         ->get();

    //     return response()->json($timesheet);
    // }
}
