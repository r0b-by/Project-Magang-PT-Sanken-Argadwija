document.addEventListener( 'DOMContentLoaded', function () {
    if ( typeof $ !== 'undefined' && $.fn.DataTable ) {
        $( '.datatable' ).DataTable( {
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            columnDefs: [
                { orderable: false, targets: [4] } // Nonaktifkan sorting untuk kolom aksi
            ],
            order: [[0, 'asc']] // Urutkan berdasarkan kolom No
        } );
    }

    // Auto-hide alert setelah 5 detik
    setTimeout( function () {
        var alerts = document.querySelectorAll( '.alert' );
        alerts.forEach( function ( alert ) {
            var bsAlert = new bootstrap.Alert( alert );
            bsAlert.close();
        } );
    }, 5000 );
} );