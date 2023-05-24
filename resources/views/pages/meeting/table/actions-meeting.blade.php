<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $this->project }}/meeting/{{ $meeting->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a role="button" wire:click="deleteConfirm({{ $meeting->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>