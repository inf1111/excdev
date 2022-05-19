$(document).ready (function () {

    feather.replace({ 'aria-hidden': 'true' })

    if($('#ops-table').length) {

        $('#ops-table').DataTable({
            serverSide: true,
            ajax: config.routes.historyAjax,
            columns: [
                { name: 'id' },
                { name: 'amount' },
                { name: 'description', searchable: true },
                { name: 'date' },
            ],
        });

    }

    if($('#opsContainer').length) {

        setInterval(function(){

            $.ajax({
                type: 'POST',
                url: config.routes.postLoadRecentOps,
                success: function(serverResponse) {
                    $('#opsContainer').html(serverResponse);
                },
            });

        }, config.t);

    }

});
