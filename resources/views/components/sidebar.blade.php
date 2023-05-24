@php
$user = Auth::user();
$team = $user->currentTeam;

if($user->ownsTeam($team) || $user->hasTeamRole($team, 'project-manager')) {
    $links = [
        [
            "href" => [
                [
                    "section_text" => "Home",
                    "section_list" => [
                        ["href" => "dashboard", "text" => "Dashboard"],
                        ["href" => "chat", "text" => "Chat"],
                    ]
                ]
            ],
            "text" => "Home",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "User",
                    "section_list" => [
                        ["href" => "user.index", "text" => "All Users"],
                        ["href" => "client.index", "text" => "Clients Data"],
                        // ["href" => "client-user.index", "text" => "Client Users"],
                    ]
                ]
            ],
            "text" => "User",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Project",
                    "section_list" => [
                        ["href" => "project.index", "text" => "Project List"],
                        ["href" => "sprint.index", "text" => "Sprint"],
                        ["href" => "backlog.index", "text" => "Backlog"],
                        ["href" => "task.index", "text" => "Task"],
                    ]
                ],
                [
                    "section_text" => "Report & Finance",
                    "section_list" => [
                        ["href" => "report.index", "text" => "Project Report"],
                        ["href" => "finance.index", "text" => "Project Finance"]
                    ]
                ],
                [
                    "section_text" => "Meeting",
                    "section_list" => [
                        ["href" => "meeting.index", "text" => "Project Meeting"],
                    ]
                ]
            ],
            "text" => "Project",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Other",
                    "section_list" => [
                        ["href" => "profile.show", "text" => "Profile Settings"],
                        ["href" => "notif.show", "text" => "Notifications"],
                        ["href" => "help.portal", "text" => "Help Portal"],
                    ]
                ]
            ],
            "text" => "Other",
            "is_multi" => true,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if($user->hasTeamRole($team, 'client-user')){
    $links = [
        [
            "href" => [
                [
                    "section_text" => "Home",
                    "section_list" => [
                        ["href" => "dashboard", "text" => "Dashboard"],
                        ["href" => "chat", "text" => "Chat"],
                    ]
                ]
            ],
            "text" => "Home",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Project",
                    "section_list" => [
                        ["href" => "project.index", "text" => "Project List"],
                    ]
                ],
                [
                    "section_text" => "Report & Finance",
                    "section_list" => [
                        ["href" => "report.index", "text" => "Project Report"],
                        ["href" => "finance.index", "text" => "Project Finance"],
                    ]
                ],
                [
                    "section_text" => "Meeting",
                    "section_list" => [
                        ["href" => "meeting.index", "text" => "Project Meeting"],
                    ]
                ]
            ],
            "text" => "Project",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Other",
                    "section_list" => [
                        ["href" => "profile.show", "text" => "Profile Settings"],
                        ["href" => "notif.show", "text" => "Notifications"],
                        ["href" => "help.portal", "text" => "Help Portal"],
                    ]
                ]
            ],
            "text" => "Other",
            "is_multi" => true,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if($user->hasTeamRole($team, 'team-member')){
    $links = [
        [
            "href" => [
                [
                    "section_text" => "Home",
                    "section_list" => [
                        ["href" => "dashboard", "text" => "Dashboard"],
                        ["href" => "chat", "text" => "Chat"],
                    ]
                ]
            ],
            "text" => "Home",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Project",
                    "section_list" => [
                        ["href" => "project.index", "text" => "Project List"],
                    ]
                ],
                [
                    "section_text" => "Report & Finance",
                    "section_list" => [
                        ["href" => "report.index", "text" => "Project Report"],
                    ]
                ],
                [
                    "section_text" => "Meeting",
                    "section_list" => [
                        ["href" => "meeting.index", "text" => "Project Meeting"],
                    ]
                ]
            ],
            "text" => "Project",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Other",
                    "section_list" => [
                        ["href" => "profile.show", "text" => "Profile Settings"],
                        ["href" => "notif.show", "text" => "Notifications"],
                        ["href" => "help.portal", "text" => "Help Portal"],
                    ]
                ]
            ],
            "text" => "Other",
            "is_multi" => true,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if($user->hasTeamRole($team, 'guest')){
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
    ];
    $navigation_links = array_to_object($links);
}
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">ForteSCRUM</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="{{ asset('auth/img/logo_circle.png') }}" alt="">
            </a>
        </div>
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
            <li class="menu-header">{{ $link->text }}</li>
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        @if($section->section_text == 'Home')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'User')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'Project')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'Report & Finance')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-bar"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'Meeting')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-calendar"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'Other')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>{{ $section->section_text }}</span></a>
                        @endif
                        <ul class="dropdown-menu">
                            @foreach ($section->section_list as $child)
                                <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>
