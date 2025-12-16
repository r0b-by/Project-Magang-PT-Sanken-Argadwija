function updateKodeDokumen() {
    let ik = document.getElementById( 'kode_internal' ).value.toUpperCase();
    let dept = document.getElementById( 'kode_dept' ).value.toUpperCase();
    let run = document.getElementById( 'kode_running' ).value;
    let out = document.getElementById( 'kode_dokumen' );

    out.value = ( ik && dept && run ) ? ik + '-' + dept + run : "";
}

// Nama dokumen internal auto tampil
document.getElementById( 'kode_internal' ).addEventListener( 'change', function () {
    let name = this.options[this.selectedIndex].getAttribute( 'data-name' ) || "";
    document.getElementById( 'nama_internal' ).value = name;
    updateKodeDokumen();
} );

document.getElementById( 'kode_internal' ).addEventListener( 'input', updateKodeDokumen );
document.getElementById( 'kode_dept' ).addEventListener( 'change', updateKodeDokumen );
document.getElementById( 'kode_running' ).addEventListener( 'input', updateKodeDokumen );

// Generate barcode otomatis
function generateBarcode() {
    let input = document.getElementById( 'barcode' );
    if ( !input.value ) {
        let r = Math.random().toString( 36 ).substring( 2, 8 ).toUpperCase();
        let y = new Date().getFullYear();
        input.value = `DOC-${r}-${y}`;
    }
}