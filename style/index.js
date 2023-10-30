$(document).ready(function () {
    $('#tab').DataTable({
        columnDefs: [
            {
                targets: [-1, -2, -3],
                className: 'dt-body-right'
            }
        ]
    });
});
