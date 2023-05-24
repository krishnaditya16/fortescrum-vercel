<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $project->title }} - Details</h4>
            </div>
            <div class="card-body">
                {!! $project->description !!}
                {{-- <div id="gantt"></div> --}}
            </div>
        </div>
    </div>
</div>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const project = @json($project);
        const tasks = @json($task);

        const taskItems = tasks.map(task => ({
            id: task.id,
            name: task.title,
            start: task.start_date,
            end: task.end_date,
            progress: task.progress,
        }));

        const gantt = new Gantt("#gantt", taskItems, {
            header_height: 50,
            column_width: 30,
            step: 24,
            view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
            bar_height: 20,
            bar_corner_radius: 3,
            arrow_curve: 5,
            padding: 18,
            view_mode: 'Month',
            date_format: 'YYYY-MM-DD',
            custom_popup_html: function (task) {
                const startDate = moment(task.start).format('MMM DD');
                const endDate = moment(task.end).format('MMM DD');
                const duration = moment(task.end).diff(moment(task.start), 'days') + 1;

                return `<div class="details-container">
                            <div class="task-info">
                                <h5>${task.name}: ${startDate} - ${endDate}</h5>
                                <p>Duration: ${duration} days</p>
                                <p>Progress: ${task.progress}%</p>
                            </div>
                        </div>`;
            }
        });

        gantt.change_view_mode('Week'); // Initial view mode

        // Optional: Handle window resize to adjust the chart size
        window.addEventListener('resize', function () {
            gantt.refresh();
        });
    });
</script> --}}

