<h2 class="section-title">Client's Account Data</h2>
<p class="section-lead mb-3">
    You can manage client's account here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    <a href="{{ route('client-user.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:client.client-user-table />
            </div>
        </div>
    </div>
</div>