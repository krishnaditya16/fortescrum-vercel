@php
$team = Auth::user()->currentTeam;
$invoice = DB::table('invoices')->where('id', $value)->first();
$payment = DB::table('payments')->where('invoice_id', $value)->first();
@endphp

@if(Auth::user()->ownsTeam($team) || Auth::user()->hasTeamRole($team, 'project-manager')) 
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.invoice.show', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View Invoice</a>
        <a href="{{ route('project.invoice.edit', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i></i> Edit Invoice</a>
        @if($invoice->inv_status == 0)
        <a href="{{ route('project.invoice.send', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-paper-plane"></i> Send Email</a>
        @endif
        @if($invoice->inv_status == 2 || $invoice->inv_status == 3 || $invoice->inv_status == 4)
            <a href="{{ route('project.invoice.confirm', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-credit-card"></i> View Payment</a>
        @endif
        <div class="dropdown-divider"></div>   
        @if(!empty($payment))  
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="Action is disabled for this invoice."><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $value }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete Invoice</a>
        @endif
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($team, 'client-user'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.invoice.show', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View Invoice</a>
        @if($invoice->inv_status == 0 || $invoice->inv_status == 1)
            <a href="{{ route('project.invoice.payment', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-credit-card"></i> Process Payment</a>
        @elseif($invoice->inv_status == 4)
            <a href="{{ route('project.invoice.payment.edit', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-edit"></i> Edit Payment</a>
        @endif
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($team, 'team-member'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.invoice.show', ['id' => $this->project, 'invoice' => $value]) }}" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View Invoice</a>
    </div>
</div>
@endif