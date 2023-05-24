const tour = new Shepherd.Tour({
    useModalOverlay: true,
    defaultStepOptions: {
        classes: "shadow-md bg-purple-dark",
        scrollTo: true,
    },
});

tour.on('complete', function() {
    Swal.fire({
        icon: 'success',
        title: 'Tour Finished',
        text: 'Congratulations! You have completed the Dashboard tour.',
    });
});

tour.addStep({
    id: "start-tour-step",
    text: "Welcome to the Dashboard tour!",
    attachTo: {
        element: undefined,
        on: "center",
    },
    classes: "custom-shepherd-class",
    buttons: [
        {
            text: "Start Tour",
            action: function() {
                tour.next();
            },
            classes: "shepherd-button-primary",
        },
        {
            text: "Cancel",
            action: function() {
                tour.cancel();
            },
            classes: "shepherd-button-secondary",
        },
    ],
});

tour.addStep({
    id: "total-project-step",
    text: "This is the total number of project your team is working on.",
    attachTo: {
        element: "#total-project",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "total-sprint-step",
    text: "This is the total number of sprint your team is working on.",
    attachTo: {
        element: "#total-sprint",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "total-backlog-step",
    text: "This is the total number of backlog your team is working on.",
    attachTo: {
        element: "#total-backlog",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "total-task-step",
    text: "This is the total number of task your team is working on.",
    attachTo: {
        element: "#total-task",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "project-progress",
    text: "You can check all the project progress in your team here.",
    attachTo: {
        element: "#project-progress",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "project-meeting",
    text: "You can check all your team meeting data here.",
    attachTo: {
        element: "#project-meeting",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "team-user",
    text: "All the team user (Project Manager, Team Member, and Client in your team are listed here.",
    attachTo: {
        element: "#team-user",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "project-task",
    text: "All the tasks of each project in your team are listed here.",
    attachTo: {
        element: "#project-task",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

tour.addStep({
    id: "project-task-dropdown",
    text: "Click the dropdown then choose which project task you want to view.",
    attachTo: {
        element: "#project-dropdown",
        on: "bottom",
    },
    classes: "example-step-extra-class",
    buttons: [
        {
            text: "Close",
            action: tour.cancel,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Previous",
            action: tour.back,
            classes: "shepherd-button-secondary",
            secondary: true,
        },
        {
            text: "Next",
            action: tour.next,
        },
    ],
});

