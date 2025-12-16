// Focus username field
document.getElementById( 'username' ).focus();

// Toggle password visibility
const togglePassword = document.getElementById( 'togglePassword' );
const passwordInput = document.getElementById( 'password' );

togglePassword.addEventListener( 'click', function () {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;

    // Toggle icon
    const icon = this.querySelector( 'i' );
    icon.classList.toggle( 'fa-eye' );
    icon.classList.toggle( 'fa-eye-slash' );
} );