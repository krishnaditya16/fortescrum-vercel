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
        text: 'Congratulations! You have completed the Invoice tour.',
    });
});

tour.addStep({
    id: "start-tour-step",
    text: "Welcome to the Invoice tour!",
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
    id: "invoice-id",
    text: "This is the id of this invoice.",
    attachTo: {
        element: "#invoice-id",
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
    id: "invoice-status",
    text: "This is the current status of this invoice.",
    attachTo: {
        element: "#invoice-status",
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
    id: "invoice-project",
    text: "The invoice belong to this project.",
    attachTo: {
        element: "#invoice-project",
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
    id: "invoice-company",
    text: "This company is the one who issued the invoice.",
    attachTo: {
        element: "#invoice-company",
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
    id: "invoice-address",
    text: "This is the address of the company who issued the invoice.",
    attachTo: {
        element: "#invoice-address",
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
    id: "invoice-client",
    text: "This invoice is directed to this client.",
    attachTo: {
        element: "#invoice-client",
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
    id: "invoice-client-address",
    text: "This is the client address.",
    attachTo: {
        element: "#invoice-client-address",
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
    id: "invoice-issued",
    text: "This is the date when the invoice is issued.",
    attachTo: {
        element: "#invoice-issued",
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
    id: "invoice-deadline",
    text: "This is the deadline date of the invoice.",
    attachTo: {
        element: "#invoice-deadline",
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
    id: "invoice-task-table",
    text: "This is the list of task that are listed in the invoice.",
    attachTo: {
        element: "#invoice-task-table",
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
    id: "invoice-timesheet-table",
    text: "This is the list of timesheet that are listed in the invoice.",
    attachTo: {
        element: "#invoice-timesheet-table",
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
    id: "invoice-expense-table",
    text: "This is the list of expense that are listed in the invoice.",
    attachTo: {
        element: "#invoice-expense-table",
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
    id: "invoice-tax",
    text: "This is the amount of tax that are added to this invoice.",
    attachTo: {
        element: "#invoice-tax",
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
    id: "invoice-discount",
    text: "This is the amount of discount that are added to this invoice.",
    attachTo: {
        element: "#invoice-discount",
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
    id: "invoice-total",
    text: "This is the total amount for this invoice.",
    attachTo: {
        element: "#invoice-total",
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
    id: "invoice-print-button",
    text: "You can click on this button to print the invoice.",
    attachTo: {
        element: "#invoice-print-button",
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
