function previewImage( input ) {
    if ( input.files && input.files[0] ) {
        const reader = new FileReader();
        reader.onload = function ( e ) {
            const preview = document.getElementById( 'fotoPreview' );
            preview.src = e.target.result;
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

// Auto-generate username from fullname
document.getElementById( 'fullname' ).addEventListener( 'blur', function () {
    const fullname = this.value.trim().toLowerCase();
    const usernameInput = document.getElementById( 'username' );

    if ( fullname && !usernameInput.value ) {
        // Convert to username format: firstname.lastname
        const nameParts = fullname.split( ' ' );
        let username = '';

        if ( nameParts.length > 1 ) {
            username = nameParts[0] + '.' + nameParts[nameParts.length - 1];
        } else {
            username = nameParts[0];
        }

        // Remove special characters
        username = username.replace( /[^a-z0-9.]/g, '' );
        usernameInput.value = username;
    }
} );

// Generate random password suggestion
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