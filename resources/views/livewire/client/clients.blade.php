<h2 class="section-title">Clients Data</h2>
<p class="section-lead mb-3">
    You can manage clients data here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if(empty($client))
                <div class="card-header-action">
                    <a href="{{ route('client.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
                @else
                <h4>Client Data</h4>
                @endif
            </div>
            <div class="card-body">
                <livewire:client.client-table />
            </div>
        </div>
    </div>
</div>

<h2 class="section-title">Client's Account Data</h2>
<p class="section-lead mb-3">
    You can manage client's account here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if(empty($client))
                <div class="card-header-action">
                    <a href="{{ route('client-user.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
                @else
                <h4>Client's Account Data</h4>
                @endif
            </div>
            <div class="card-body">
                <livewire:client.client-user-table />
            </div>
        </div>
    </div>
</div>