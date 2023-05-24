document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var meetings = JSON.parse(calendarEl.getAttribute('data-meetings'));

    var events = meetings.map(function(meeting) {
        var event = {
            title: meeting.title,
            description: meeting.description,
            start: meeting.meeting_date + 'T' + meeting.start_time,
            end: meeting.meeting_date + 'T' + meeting.end_time,
            meeting_date: meeting.meeting_date,
            meeting_location: meeting.meeting_location,
            meeting_link: meeting.meeting_link
        };
    
        if (meeting.type == 0) {
            event.location = meeting.meeting_location;
        } else {
            event.link = meeting.meeting_link;
        }
    
        return event;
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
            
        },
        buttonText: {
            today: 'Today',
            dayGridMonth: 'Month',
            timeGridWeek: 'Week',
            timeGridDay: 'Day',
            listMonth: 'List'
        },
        eventClick: function(event) {
            var modal = $("#meetingModal");
            var title = event.event.title;
            var description = event.event.extendedProps.description;
            var startTime = event.event.start;
            var endTime = event.event.end;
            var meetingDate = event.event.extendedProps.meeting_date;
            var meetingType = event.event.extendedProps.type;
            var meetingLocation = event.event.extendedProps.meeting_location;
            var meetingLink = event.event.extendedProps.meeting_link;

            // Format the start and end times
            var formattedStartTime = moment(startTime).format('LT');
            var formattedEndTime = moment(endTime).format('LT');
            var formattedMeetingDate = moment(meetingDate).format('MMM, Do YYYY');
        
            // Set the meeting details in the modal
            modal.find("#meetingModalLabel").text(title);

            if (description) {
                modal.find("#meetingModalDescription").text(description);
            } else {
                modal.find("#meetingModalDescription").text("There's no description");
            }

            // Set the start and end times in the modal
            modal.find("#meetingModalDate").text(formattedMeetingDate);
            modal.find("#meetingModalStartTime").text(formattedStartTime);
            modal.find("#meetingModalEndTime").text(formattedEndTime);
            modal.find("#meetingModalLocation").text(meetingLocation);
            $("#meetingModalLink").attr("href", meetingLink);
            $("#meetingModalLink").text(meetingLink);
            $("#meetingModalLink").on("click", function(event) {
                event.stopPropagation();
            });

            modal.modal();
        },
    });

    calendar.render();
});
