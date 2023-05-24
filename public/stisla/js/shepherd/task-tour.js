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
        text: 'Congratulations! You have completed the Task tour.',
    });
});

tour.addStep({
    id: "start-tour-step",
    text: "Welcome to the Task tour!",
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
    id: "task-menu-list",
    text: "This is the list of menu for managing your task.",
    attachTo: {
        element: "#task-menu-list",
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
    id: "kanban-view",
    text: "If you click on this menu, the kanban view of the task will be displayed.",
    attachTo: {
        element: "#kanban-view",
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
    id: "table-view",
    text: "If you click on this menu, the table view of the task will be displayed.",
    attachTo: {
        element: "#table-view",
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
    id: "gantt-view",
    text: "If you click on this menu, the gantt chart of the task will be displayed.",
    attachTo: {
        element: "#gantt-view",
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

if (document.getElementById("board-new")) {
    tour.addStep({
        id: "board-new",
        text: "You can create a new board by accessing this menu.",
        attachTo: {
            element: "#board-new",
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

if (document.getElementById("task-new")) {
    tour.addStep({
        id: "task-new",
        text: "You can create a new task by accessing this menu.",
        attachTo: {
            element: "#task-new",
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
    id: "task-complete",
    text: "You can check the finishied tasks by accessing this menu.",
    attachTo: {
        element: "#task-complete",
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
    id: "kanban-list-view",
    text: "This is the kanban board that include the task in this project. You can manange the task by clicking on one of the kanban or trying one of the menu in the Options dropdown",
    attachTo: {
        element: "#kanban-list-view",
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
    id: "board-title",
    text: "This is the title of the board",
    attachTo: {
        element: "#board-title",
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
    id: "board-task-count",
    text: "This is the number of task available on this board",
    attachTo: {
        element: "#board-task-count",
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
    id: "kanban-board-list",
    text: "Click on the kanban to view a detailed information about the task, you can also manage the task progress by using the menus/buttons that are available in the kanban",
    attachTo: {
        element: "#kanban-board-list",
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