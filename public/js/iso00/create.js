// Update kode dokumen final
function updateKodeDokumen() {
    let ik = document.getElementById( 'kode_internal' ).value.toUpperCase();
    let dept = document.getElementById( 'kode_dept' ).value.toUpperCase();
    let run = document.getElementById( 'kode_running' ).value;

    let output = document.getElementById( 'kode_dokumen' );

    if ( ik && dept && run ) {
        output.value = ik + '-' + dept + run;
    } else {
        output.value = '';
    }
}

// Tampilkan nama dokumen otomatis
document.getElementById( 'kode_internal' ).addEventListener( 'change', function () {
    let selected = this.options[this.selectedIndex];
    let name = selected.getAttribute( 'data-name' ) || '';
    document.getElementById( 'nama_internal' ).value = name;
    updateKodeDokumen();
} );

// Update kode final saat dept/run berubah
document.getElementById( 'kode_dept' ).addEventListener( 'change', updateKodeDokumen );
document.getElementById( 'kode_running' ).addEventListener( 'input', updateKodeDokumen );