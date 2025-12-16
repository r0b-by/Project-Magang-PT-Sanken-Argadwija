function previewImage( input ) {
    if ( input.files && input.files[0] ) {
        const reader = new FileReader();
        reader.onload = function ( e ) {
            const preview = document.getElementById( 'fotoPreview' );

            // Convert div to img if necessary
            if ( preview.tagName === 'DIV' ) {
                const img = document.createElement( 'img' );
                img.id = 'fotoPreview';
                img.className = 'rounded-circle border';
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.objectFit = 'cover';
                img.alt = 'Foto Profil';
                preview.parentNode.replaceChild( img, preview );
            }

            document.getElementById( 'fotoPreview' ).src = e.target.result;
        }
        reader.readAsDataURL( input.files[0] );
    }
}

function togglePassword( fieldId ) {
    const field = document.getElementById( fieldId );
    const button = field.nextElementSibling;
    const icon = button.querySelector( 'i' );

    if ( field.type === 'password' ) {
        field.type = 'text';
        icon.classList.remove( 'fa-eye' );
        icon.classList.add( 'fa-eye-slash' );
    } else {
        field.type = 'password';
        icon.classList.remove( 'fa-eye-slash' );
        icon.classList.add( 'fa-eye' );
    }
}

// Auto-generate password suggestion
document.addEventListener( 'DOMContentLoaded', function () {
    const passwordField = document.getElementById( 'password' );
    const generatePasswordBtn = document.createElement( 'button' );
    generatePasswordBtn.type = 'button';
    generatePasswordBtn.className = 'btn btn-outline-secondary btn-sm mt-2';
    generatePasswordBtn.innerHTML = '<i class="fas fa-key me-1"></i> Generate Password';
    generatePasswordBtn.onclick = function () {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        let password = '';
        for ( let i = 0; i < 12; i++ ) {
            password += chars.charAt( Math.floor( Math.random() * chars.length ) );
        }
        passwordField.value = password;
    };

    passwordField.parentNode.parentNode.appendChild( generatePasswordBtn );
} );