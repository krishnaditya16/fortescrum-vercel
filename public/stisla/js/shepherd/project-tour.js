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
        text: 'Congratulations! You have completed the Project tour.',
    });
});

tour.addStep({
    id: "start-tour-step",
    text: "Welcome to the Project tour!",
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
    id: "project-all",
    text: "This is the total number of project your team is working on.",
    attachTo: {
        element: "#project-all",
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
    id: "project-in-progress",
    text: "This is the total number project that is still in progress.",
    attachTo: {
        element: "#project-in-progress",
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
    id: "project-on-hold",
    text: "This is the total number project that is still on hold.",
    attachTo: {
        element: "#project-on-hold",
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
    id: "project-completed",
    text: "This is the total number project that is already completed",
    attachTo: {
        element: "#project-completed",
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

// Check if the element with ID "add-project" exists
if (document.getElementById("add-project")) {
    tour.addStep({
        id: "add-project",
        text: "You can add a new project by clicking on this button.",
        attachTo: {
            element: "#add-project",
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
}

tour.addStep({
    id: "project-table",
    text: "Projects data are listed on the table below and you can do operation based on your role.",
    attachTo: {
        element: "#project-table",
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

