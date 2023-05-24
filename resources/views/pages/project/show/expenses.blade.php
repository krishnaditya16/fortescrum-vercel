@php
    $team = Auth::user()->currentTeam;
    $user = Auth::user();
@endphp

<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Expenses Chart</h4>
            </div>
            <div class="card-body">
                <canvas id="expensesChart" data-expenses="{{ json_encode($expenses) }}"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Expenses Usages</h4>
            </div>
            <div class="card-body">
                <canvas id="expensesUsage" data-expenses="{{ json_encode($expenses) }}" data-budget="{{ json_encode($project->budget) }}"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $project->title }} - Expenses</h4>
                {{-- @if(!$user->hasTeamRole($team, 'client-user')) --}}
                <div class="card-header-action">
                    <a href="{{ route('project.expenses.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
                {{-- @endif --}}
            </div>
            @livewire('expense.expense-project', ['project' => $project])
        </div>
    </div>
</div>

@push('custom-scripts')
    <script src="{{ asset('stisla/js/expense-bar-chart.js') }}"></script>
    <script src="{{ asset('stisla/js/expense-doughnut-chart.js') }}"></script>
@endpush