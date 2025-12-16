document.addEventListener( 'DOMContentLoaded', function () {
    // Toggle semua checkbox
    const checkAll = document.getElementById( 'checkAll' );
    const checkboxes = document.querySelectorAll( '.dok-checkbox' );
    const selectedCount = document.getElementById( 'selectedCount' );

    function updateSelectedCount() {
        const checked = document.querySelectorAll( '.dok-checkbox:checked' ).length;
        selectedCount.textContent = `${checked} dokumen dipilih`;
    }

    if ( checkAll ) {
        checkAll.addEventListener( 'change', function () {
            checkboxes.forEach( cb => cb.checked = this.checked );
            updateSelectedCount();
        } );

        // Update checkAll status jika ada checkbox yang diubah
        checkboxes.forEach( cb => {
            cb.addEventListener( 'change', function () {
                if ( !this.checked ) {
                    checkAll.checked = false;
                } else {
                    // Cek apakah semua checkbox tercentang
                    const allChecked = Array.from( checkboxes ).every( c => c.checked );
                    checkAll.checked = allChecked;
                }
                updateSelectedCount();
            } );
        } );

        // Initial count
        updateSelectedCount();
    }

    function toggleAllCheckboxes() {
        if ( checkAll ) {
            checkAll.checked = !checkAll.checked;
            const event = new Event( 'change' );
            checkAll.dispatchEvent( event );
        }
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

// Global function untuk tombol "Pilih Semua"
function toggleAllCheckboxes() {
    const checkAll = document.getElementById( 'checkAll' );
    if ( checkAll ) {
        checkAll.checked = !checkAll.checked;
        const event = new Event( 'change' );
        checkAll.dispatchEvent( event );
    }
}