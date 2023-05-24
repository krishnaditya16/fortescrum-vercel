"use strict";

$(".num-input").on('change, keyup', function() {
    var currentInput = $(this).val();
    var fixedInput = currentInput.replace(/[^\d.]/g, '');
    $(this).val(fixedInput);
});

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function calcTask() 
{
    const rate_task = document.getElementsByName('rate_task[]');
    const qty_task = document.getElementsByName('qty_task[]');
    const arr1 = [...rate_task].map(input => parseFloat(input.value));
    const arr2 = [...qty_task].map(input => parseFloat(input.value));

    const ele = $(".check-task");

    var total = [];
    var row =$(".total-task") 
    let sum = 0;

    for(let i=0;i<arr1.length;i++){
        total[i] = parseFloat(arr1[i]) * parseFloat(arr2[i]);

        if (ele[i].type == 'checkbox' && ele[i].checked == true){
            if(isNaN(total[i])){
                row[i].value = 0;
                sum += 0;
            } else {
                row[i].value = total[i];
                sum += total[i];
            }
            
        } else if(ele[i].type == 'checkbox' && ele[i].checked == false) {
            row[i].value = 0;
        }
    };
    if(isNaN(sum)){
        document.getElementById("subtotal_task").value = 0;
    } else {
        document.getElementById("subtotal_task").value = sum;
    }

    totalAll();
}

function calcTS() 
{
    const rate_ts = document.getElementsByName('rate_ts[]');
    const qty_ts = document.getElementsByName('quantity_ts');
    const arr1 = [...rate_ts].map(input => input.value);
    const arr2 = [...qty_ts].map(input => parseFloat(input.value));

    const qts = document.getElementsByName('qts');
    const arr3 = [...qts].map(input => input.value);

    const ele = $(".check-ts");

    var total = [];
    var row =$(".total-ts");
    let sum = 0;

    for(let i=0;i<arr1.length;i++){

        total[i] = parseFloat(arr1[i]) * parseFloat(arr2[i]);

        if (ele[i].type == 'checkbox' && ele[i].checked == true){
            if(isNaN(total[i])){
                row[i].value = 0;
                sum += 0;
            } else {
                row[i].value = total[i];
                sum += total[i];
            }
            $('.qty_ts').eq(i).val(arr3[i]);
            
        } else if(ele[i].type == 'checkbox' && ele[i].checked == false) {
            row[i].value = 0;
            $('.qty_ts').eq(i).val('');
        }
    };

    if(isNaN(sum)){
        document.getElementById("subtotal_ts").value = 0;
    } else {
        document.getElementById("subtotal_ts").value = sum;
    }

    totalAll();
}

function calcExp() 
{
    const exp_ammount = document.getElementsByName('expenses[]');
    const arr = [...exp_ammount].map(input => parseFloat(input.value));

    const ele = $(".check-exp");
    let sum = 0;

    for(let i=0;i<arr.length;i++){
        if (ele[i].type == 'checkbox' && ele[i].checked == true){
            sum += arr[i];
            $('.exp-ammount').eq(i).val(arr[i]);
        } else if(ele[i].type == 'checkbox' && ele[i].checked == false) {
            arr[i] = 0;
            $('.exp-ammount').eq(i).val('');
        }
    };

    if(isNaN(sum)){
        document.getElementById("subtotal_expenses").value = 0;
    } else {
        document.getElementById("subtotal_expenses").value = sum;
    }

    totalAll();
}

function totalAll()
{
    var st_task = parseFloat(document.getElementById("subtotal_task").value);
    var st_ts = parseFloat(document.getElementById("subtotal_ts").value);
    var st_exp = parseFloat(document.getElementById("subtotal_expenses").value);

    var tax = parseFloat(document.getElementById("tax").value)
    var discount = parseFloat(document.getElementById("discount").value)

    var total = (st_task + st_ts + st_exp);
    var discount_ammount = total * (discount/100);
    var tax_ammount = total * (tax/100);

    if(isNaN(tax)){
        total = total - discount_ammount;
    } else if(isNaN(discount)) {
        total = total - tax_ammount;
    } else {
        total = total - tax_ammount - discount_ammount;
    }   

    if(isNaN(tax)){
        document.getElementById("tax_detail").value = 0;
    } else {
        document.getElementById("tax_detail").value = tax_ammount;
    }

    if(isNaN(discount)){
        document.getElementById("discount_detail").value = 0;
    } else {
        document.getElementById("discount_detail").value = discount_ammount;
    }
    

    if(total < 0){
        document.getElementById("total_all").value = 0;
    } else {
        document.getElementById("total_all").value = total;
    }
}


