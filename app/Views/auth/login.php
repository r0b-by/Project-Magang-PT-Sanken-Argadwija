<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #06d6a0;
        --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Back to Home Button */
    .btn-back-home {
        position: absolute;
        top: 20px;
        left: 20px;
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 10px rgba(67, 97, 238, 0.2);
        z-index: 1000;
    }

    .btn-back-home:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .input-group {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.25);
        transform: translateY(-1px);
    }

    .input-group-text {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border-left: none;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: none;
        background: #f8fafc;
    }

    /* Password Toggle Button */
    .password-toggle {
        background: transparent;
        border: none;
        color: #718096;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .password-toggle:focus {
        outline: none;
        color: var(--primary-color);
    }

    /* Login Button */
    .btn-login {
        background: var(--gradient);
        color: white;
        padding: 0.85rem 2rem;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
    }

    .btn-login:active {
        transform: translateY(0);
    }

    /* Info Text */
    .info-text {
        background: #f7fafc;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border-left: 4px solid var(--primary-color);
    }

    .info-text i {
        color: var(--primary-color);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .btn-back-home {
            top: 15px;
            left: 15px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .input-group-text {
            padding: 0.65rem 0.85rem;
            font-size: 1rem;
        }

        .form-control {
            padding: 0.65rem 0.85rem;
            font-size: 0.9rem;
        }

        .password-toggle {
            padding: 0.65rem 0.85rem;
            font-size: 0.95rem;
        }

        .btn-login {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
        }

        .form-label {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .btn-back-home {
            position: relative;
            top: 0;
            left: 0;
            margin-bottom: 1.5rem;
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form {
        animation: slideIn 0.5s ease;
    }
</style>

<!-- Back to Home Button -->
<a href="<?= base_url('/') ?>" class="btn-back-home">
    <i class="fas fa-arrow-left"></i>
    <span>Kembali ke Home</span>
</a>

<form action="/login/process" method="POST">
    <?= csrf_field() ?>
    
    <!-- Username Input -->
    <div class="mb-3">
        <label for="username" class="form-label">
            <i class="fas fa-user me-1"></i>Username
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-user"></i>
            </span>
            <input type="text" 
                   class="form-control" 
                   id="username" 
                   name="username" 
                   placeholder="Masukkan username" 
                   required
                   autocomplete="username"
                   value="<?= old('username') ?>">
        </div>
    </div>
    
    <!-- Password Input -->
    <div class="mb-4">
        <label for="password" class="form-label">
            <i class="fas fa-lock me-1"></i>Password
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-lock"></i>
            </span>
            <input type="password" 
                   class="form-control" 
                   id="password" 
                   name="password" 
                   placeholder="Masukkan password" 
                   autocomplete="current-password"
                   required>
            <button class="password-toggle" 
                    type="button" 
                    id="togglePassword"
                    aria-label="Toggle password visibility">
                <i class="fas fa-eye" id="toggleIcon"></i>
            </button>
        </div>
    </div>
    
    <!-- Login Button -->
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem
        </button>
    </div>
    
    <!-- Info Text -->
    <div class="mt-3">
        <div class="info-text">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Hubungi admin untuk reset password
            </small>
        </div>
    </div>
</form>

<script>
    // Focus on username field
    document.getElementById('username').focus();
    
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    togglePassword.addEventListener('click', function() {
        // Toggle password visibility
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon
        if (type === 'password') {
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    });
    
    // Prevent form submission if fields are empty
    document.querySelector('form').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        
        if (!username || !password) {
            e.preventDefault();
            alert('Username dan Password harus diisi!');
        }
    });
</script>

<?= $this->endSection() ?>