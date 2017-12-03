let submit = function (action, data, method = 'POST') {
    return $.ajax({
        type: method,
        url: action,
        data: data,
        dataType: 'json'
    });
};

let $form = $('#copy-report-form');
let action = $form.attr('action');
let $textarea = $('#app_update_official_report_officialReport');

$(document).on('click', '#copy-report', () => {
    let report = $('#report').text();
    console.log(report);
    $textarea.val(report);

    submit(action, $form.serialize()).then((data) => {
        console.log(data);
    }).catch((e) => {
        console.error(e);
    })
});

$textarea.on('change keyup paste', () => {
    submit(action, $form.serialize()).then((data) => {
        console.log(data);
    }).catch((e) => {
        console.error(e);
    })
});