<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<form action="/login/process" method="POST" class="mt-4">
    <?= csrf_field() ?>
    
    <!-- Username -->
    <div class="mb-3">
        <label for="username" class="form-label small fw-bold">Username</label>
        <input type="text" 
               class="form-control form-control-sm" 
               id="username" 
               name="username" 
               placeholder="Username" 
               required
               value="<?= old('username') ?>">
    </div>
    
    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label small fw-bold">Password</label>
        <div class="input-group input-group-sm">
            <input type="password" 
                   class="form-control" 
                   id="password" 
                   name="password" 
                   placeholder="Password" 
                   required>
            <button class="btn btn-outline-secondary" 
                    type="button" 
                    id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
    
    <!-- Submit -->
    <button type="submit" class="btn btn-primary w-100 btn-sm">
        <i class="fas fa-sign-in-alt me-1"></i>Login
    </button>
    
    <!-- Info -->
    <div class="mt-3 text-center">
        <small class="text-muted">
            Hubungi admin untuk reset password
        </small>
    </div>
</form>

<script>
// Focus username field
document.getElementById('username').focus();

// Toggle password visibility
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click', function() {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    
    // Toggle icon
    const icon = this.querySelector('i');
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
});
</script>

<?= $this->endSection() ?>`