<h2 class="section-title">Users Data</h2>
<p class="section-lead mb-3">
    You can manage users data here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Team - {{ Auth::user()->currentTeam->name }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('user.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:user.user-table />
            </div>
        </div>
    </div>
</div>