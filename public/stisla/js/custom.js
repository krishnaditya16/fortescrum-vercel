/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(window).on("load", function () {
    $("#preloader-active").delay(450).fadeOut("slow");
    $("body").delay(450).css({
        overflow: "visible",
    });
});

$(document).ready(function () {
    $(document).on("click", ".link-dropdown-kanban", function () {
        var form = $(this).closest("form");
        form.submit();
    });
});

function printContent(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

function exportChart() {
    // Get the canvas element
    var canvas = document.getElementById('myChart');
    
    // Convert the canvas to a data URL
    var dataURL = canvas.toDataURL('image/png');
    
    // Create a temporary anchor element
    var downloadLink = document.getElementById('downloadLink');
    
    // Set the href attribute to the data URL
    downloadLink.href = dataURL;
    
    // Set the download attribute with the desired file name
    downloadLink.download = 'chart.png';
    
    // Simulate a click on the anchor element to trigger the download
    downloadLink.click();
}

$("#meetingType").change(function () {
    if ($(this).val() == "1") {
        $("#meetingLink").show();
        $("#link").attr("required", "");
        $("#link").attr("data-error", "This field is required.");
    } else {
        $("#meetingLink").hide();
        $("#link").removeAttr("required");
        $("#link").removeAttr("data-error");
    }
});
$("#meetingType").trigger("change");

$("#meetingType").change(function () {
    if ($(this).val() == "0") {
        $("#meetingLocation").show();
        $("#location").attr("required", "");
        $("#location").attr("data-error", "This field is required.");
    } else {
        $("#meetingLocation").hide();
        $("#location").removeAttr("required");
        $("#location").removeAttr("data-error");
    }
});
$("#meetingType").trigger("change");

$(document).ready(function () {
    $(document).on("click", ".notif-read", function () {
        var form = $(this).closest("form");
        form.submit();
        e.preventDefault();
    });
});

$(document).ready(function () {
    $(document).on("click", ".message-read", function () {
        var form = $(this).closest("form");
        form.submit();
        e.preventDefault();
    });
});

$(document).ready(function () {
    $(".btn-receipt").click(function () {
        $("#receipt_toggle").toggle();
    });
});

$(document).ready(function () {
    $(".btn-role").click(function () {
        var text = document.getElementById("role-answer");
        var role = document.getElementById("btn-role");
        var role2 = document.getElementById("role-hdn");
        if (text.innerHTML == "No") {
            text.innerHTML = "Yes";
            role.value = 1;
            role2.value = 1;
        } else {
            text.innerHTML = "No";
            role.value = 0;
            role2.value = 1;
        }
        console.log(role);
        console.log(role2);
    });
});

$("#paymentMethod").change(function () {
    if ($(this).val() == "0") {
        // Show the transaction ID and proof of payment fields
        $("#transactionID").show();
        $("#transaction_id").attr("required", "");
        $("#transaction_id").attr("data-error", "This field is required.");

        $("#proofPayment").show();
        $("#invoice_payment").attr("required", "");
        $("#invoice_payment").attr("data-error", "This field is required.");

        // Hide the stripePayment div
        $("#stripePayment").hide();

        // Remove the validation attributes from the credit card fields
        $("#card_name").removeAttr("pattern");
        $("#card_name").removeAttr("title");

        $("#card_number").removeAttr("pattern");
        $("#card_number").removeAttr("title");

        $("#card_exp_month").removeAttr("pattern");
        $("#card_exp_month").removeAttr("title");

        $("#card_exp_year").removeAttr("pattern");
        $("#card_exp_year").removeAttr("title");

        $("#card_cvc").removeAttr("pattern");
        $("#card_cvc").removeAttr("title");
        
    } else if ($(this).val() == "1") {
        // Hide the transaction ID and proof of payment fields
        $("#transactionID").hide();
        $("#transaction_id").removeAttr("required");
        $("#transaction_id").removeAttr("data-error");

        $("#proofPayment").hide();
        $("#invoice_payment").removeAttr("required");
        $("#invoice_payment").removeAttr("data-error");

        // Show the stripePayment div
        $("#stripePayment").show();

        // Add validation attributes to the credit card fields
        $("#card_name").attr("pattern", "[A-Za-z ]+");
        $("#card_name").attr("title", "Please enter a valid name.");

        $("#card_number").attr("pattern", "[0-9]{16}");
        $("#card_number").attr("title", "Please enter a 16-digit card number.");

        $("#card_exp_month").attr("pattern", "^(0?[1-9]|1[0-2])$");
        $("#card_exp_month").attr("title", "Please enter a valid month (1-12).");

        $("#card_exp_year").attr("pattern", "^[0-9]{4}$");
        $("#card_exp_year").attr("title", "Please enter a valid 4-digit year.");

        $("#card_cvc").attr("pattern", "^[0-9]{3,4}$");
        $("#card_cvc").attr("title", "Please enter a valid CVC.");
    }
});

$("#paymentMethod").trigger("change");

