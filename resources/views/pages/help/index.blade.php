<x-app-layout>
    <x-slot name="title">{{ __('Help Portal') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Help Portal') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Help Portal</div>
        </div>
    </x-slot>

    <h2 class="section-title">Help Portal</h2>
    <p class="section-lead mb-3">
        All the information that can help you use the app more effectively and efficiently.
    </p>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Jump To</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a class="nav-link active" id="help-tab1" data-toggle="tab" href="#help1" role="tab" aria-controls="help1" aria-selected="true"><i class="fas fa-question-circle"></i> Frequently Asked Questions</a></li>
                        <li class="nav-item"><a class="nav-link" id="help-tab2" data-toggle="tab" href="#help2" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-compass"></i>  How To Use Tour Feature</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="help1" role="tabpanel" aria-labelledby="help-tab1">
                    @include('pages.help.faq')
                </div>
                <div class="tab-pane fade" id="help2" role="tabpanel" aria-labelledby="help-tab2">
                    @include('pages.help.tour')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>