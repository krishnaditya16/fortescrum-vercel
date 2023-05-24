<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/user/{{ $user->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        @if($user->id == Auth::user()->id)
        <a class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="You are the owner of this account"><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $user->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
        @endif
    </div>
</div>