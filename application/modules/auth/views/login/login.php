<!DOCTYPE html>
<html lang="en">

<head>
  <title>Africa CDC Prioritisation Tool - Sign In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="<?php echo setting()->site_description; ?>" />
  <meta name="robots" content="noindex">
  <meta name="author" content="Africa CDC" />

  <!-- Favicon icon -->
  <link href="<?php echo base_url() ?>assets/img/favicon.png" rel="icon">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/fonts/fontawesome/css/fontawesome-all.min.css">
  <!-- Animation CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/animation/css/animate.min.css">
  <!-- Style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">

         <!-- Lobibox CSS -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/notifications/css/lobibox.min.css" />
  
  <style>
    :root {
      --primary-color: #2c3e50;
      --primary-dark: #1a252f;
      --secondary-color: #27ae60;
      --accent-color: #2ecc71;
      --success-color: #27ae60;
      --danger-color: #e74c3c;
      --warning-color: #f39c12;
      --info-color: #3498db;
      --light-color: #ecf0f1;
      --dark-color: #2c3e50;
      --white: #ffffff;
      --au-maroon: #8B0000;
      --border-radius: 12px;
      --box-shadow: 0 10px 30px rgba(44, 62, 80, 0.15);
      --transition: all 0.3s ease;
    }

    * {
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, rgba(44, 62, 80, 0.95), rgba(26, 37, 47, 0.9)), 
                  url('<?php echo base_url(); ?>assets/images/image_cdc.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
    }

    .auth-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
      position: relative;
    }

    .auth-container {
      width: 100%;
      max-width: 420px;
      position: relative;
    }

    .card {
      background: var(--white);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(44, 62, 80, 0.1), 0 0 0 1px rgba(44, 62, 80, 0.05);
      border: none;
      border-top: 4px solid var(--secondary-color);
      overflow: hidden;
      animation: slideUp 0.6s ease-out;
      position: relative;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: var(--white);
      text-align: center;
      padding: 2rem 2rem 1.5rem;
      position: relative;
      border-radius: 20px 20px 0 0;
    }

    .card-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
      opacity: 0.3;
    }

    .logo-container {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .logo-container img {
      width: 150px;
      height: 150px;
      object-fit: contain;
      margin-bottom: 1rem;
      filter: none;
      background: var(--white);
      border-radius: 50%;
      padding: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1);
      border: 3px solid rgba(255, 255, 255, 0.3);
      transition: var(--transition);
    }

    .logo-container img:hover {
      transform: scale(1.05);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.2);
    }

    .card-title {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      letter-spacing: 0.5px;
      color: var(--white);
    }

    .card-subtitle {
      font-size: 1rem;
      opacity: 1;
      margin: 0.5rem 0 0;
      font-weight: 600;
      letter-spacing: 0.3px;
      color: var(--white);
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      background: rgba(139, 0, 0, 0.8);
      padding: 0.5rem 1rem;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-body {
      padding: 2.5rem 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-label {
      display: block;
      margin-bottom: 0.75rem;
      font-weight: 600;
      color: var(--dark-color);
      font-size: 0.95rem;
      letter-spacing: 0.3px;
    }

    .input-group {
      position: relative;
      margin-bottom: 0.75rem;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
      transition: var(--transition);
      border: 2px solid #e1e5e9;
    }

    .input-group:hover {
      border-color: #d1d5db;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.04);
    }

    .input-group:focus-within {
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.12), 0 4px 12px rgba(39, 174, 96, 0.08);
      transform: translateY(-1px);
    }

    .input-group-prepend {
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      z-index: 3;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      color: var(--secondary-color);
      font-size: 1.2rem;
      transition: var(--transition);
    }

    .form-control {
      width: 100%;
      padding: 1.25rem 1.25rem 1.25rem 4rem;
      border: none;
      border-radius: 16px;
      font-size: 1rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: transparent;
      font-weight: 400;
      position: relative;
    }

    .form-control::placeholder {
      color: #9ca3af;
      font-weight: 400;
      opacity: 0.9;
      transition: var(--transition);
    }

    .form-control:focus::placeholder {
      opacity: 0.6;
      transform: translateY(-2px);
    }

    .form-control:focus {
      outline: none;
      background: transparent;
    }

    .input-group:focus-within {
      box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.12), 0 4px 12px rgba(39, 174, 96, 0.08);
      transform: translateY(-2px);
    }

    .form-control.is-invalid {
      background: transparent;
    }

    .input-group.has-error {
      border-color: var(--danger-color);
      box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.12), 0 4px 12px rgba(231, 76, 60, 0.08);
      transform: translateY(-1px);
    }

    .form-control.is-valid {
      background: transparent;
    }

    .input-group.has-success {
      border-color: var(--success-color);
      box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.12), 0 4px 12px rgba(39, 174, 96, 0.08);
      transform: translateY(-1px);
    }

    .password-toggle {
      position: absolute;
      right: 1.5rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #9ca3af;
      cursor: pointer;
      z-index: 3;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-size: 1.2rem;
      padding: 0.75rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .password-toggle:hover {
      color: var(--secondary-color);
      background: rgba(39, 174, 96, 0.08);
      transform: translateY(-50%) scale(1.1);
    }

    .invalid-feedback {
      display: block;
      width: 100%;
      margin-top: 0.25rem;
      font-size: 0.875rem;
      color: var(--danger-color);
      animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    .valid-feedback {
      display: block;
      width: 100%;
      margin-top: 0.25rem;
      font-size: 0.875rem;
      color: var(--success-color);
    }

    .form-check {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
      padding: 0;
      background: transparent;
      border: none;
      transition: var(--transition);
    }

    .form-check-input {
      width: 1.2rem;
      height: 1.2rem;
      margin-right: 0.75rem;
      accent-color: var(--secondary-color);
      cursor: pointer;
      border-radius: 4px;
      border: 2px solid #d1d5db;
      background: #ffffff;
      transition: var(--transition);
    }

    .form-check-input:checked {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
    }

    .form-check-input:hover {
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.1);
    }

    .form-check-input:focus {
      outline: none;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
    }

    .form-check-label {
      font-size: 0.9rem;
      color: var(--dark-color);
      cursor: pointer;
      user-select: none;
      font-weight: 500;
      transition: var(--transition);
    }

    .form-check-label:hover {
      color: var(--secondary-color);
    }

    .btn-login {
      width: 100%;
      padding: 1rem 1.5rem;
      background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
      border: none;
      border-radius: var(--border-radius);
      color: var(--white);
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(39, 174, 96, 0.2);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(39, 174, 96, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .btn-login .spinner {
      display: none;
      width: 20px;
      height: 20px;
      border: 2px solid transparent;
      border-top: 2px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-right: 0.5rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .forgot-password {
      text-align: center;
      margin-top: 1rem;
    }

    .forgot-password a {
      color: var(--secondary-color);
      text-decoration: none;
      font-size: 0.9rem;
      transition: var(--transition);
    }

    .forgot-password a:hover {
      color: var(--primary-color);
      text-decoration: underline;
    }

    .alert {
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      border: 1px solid transparent;
      border-radius: var(--border-radius);
      font-size: 0.9rem;
      animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-danger {
      color: #721c24;
      background-color: #f8d7da;
      border-color: #f5c6cb;
    }

    .alert-success {
      color: #0f5132;
      background-color: #d1e7dd;
      border-color: #badbcc;
    }

    .strength-meter {
      height: 4px;
      background: #e9ecef;
      border-radius: 2px;
      margin-top: 0.5rem;
      overflow: hidden;
    }

    .strength-meter-fill {
      height: 100%;
      width: 0%;
      transition: var(--transition);
      border-radius: 2px;
    }

    .strength-weak { background-color: var(--danger-color); }
    .strength-medium { background-color: var(--warning-color); }
    .strength-strong { background-color: var(--secondary-color); }

    /* Responsive Design */
    @media (max-width: 576px) {
      .auth-wrapper {
        padding: 0.5rem;
      }
      
      .card-header {
        padding: 1.5rem 1.5rem 1rem;
      }
      
      .card-body {
        padding: 1.5rem;
      }
      
      .card-title {
        font-size: 1.25rem;
      }
    }

    /* Loading overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-top: 4px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    /* Accessibility improvements */
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }

    .focus-visible {
      outline: 2px solid var(--secondary-color);
      outline-offset: 2px;
    }
  </style>
</head>

<body>

  <div class="auth-wrapper">
    <div class="auth-container">
          <div class="card">
        <div class="card-header">
          <div class="logo-container">
            <img src="<?php echo base_url() ?>assets/images/logo.png" alt="Africa CDC Logo" style="width: 180px; height: 180px;">
          </div>
        </div>
        
            <div class="card-body">
          <h2 class="text-center mb-4" style="color: var(--dark-color); font-size: 1.5rem; font-weight: 600;">Sign In</h2>
          
          <!-- Error/Success Messages -->
          <?php if ($this->session->flashdata('error_message')): ?>
            <div class="alert alert-danger" role="alert">
              <i class="fa fa-exclamation-circle me-2"></i>
              <?php echo $this->session->flashdata('error_message'); ?>
            </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('success_message')): ?>
            <div class="alert alert-success" role="alert">
              <i class="fa fa-check-circle me-2"></i>
              <?php echo $this->session->flashdata('success_message'); ?>
            </div>
          <?php endif; ?>

          <?php echo form_open(base_url('auth/login'), array('id' => 'loginForm', 'class' => 'needs-validation', 'novalidate' => '')); ?>
          
          <!-- Hidden Fields -->
          <input type="hidden" name="route" value="<?php echo $this->uri->segment(1) ?>/<?php echo $this->uri->segment(2) ?>">

          <!-- Email Field -->
          <div class="form-group">
            <label for="email" class="form-label">
              <i class="fa fa-envelope me-1"></i>Email Address
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fa fa-envelope"></i>
                </span>
              </div>
              <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Enter your email address" 
                required 
                autocomplete="email"
                aria-describedby="emailHelp"
                value="<?php echo set_value('email'); ?>"
              >
            </div>
            <div class="invalid-feedback" id="emailError">
              Please provide a valid email address.
            </div>
            <div class="valid-feedback" id="emailValid" style="display: none;">
              ✓ Valid email address
                </div>
              </div>

          <!-- Password Field -->
          <div class="form-group">
            <label for="password" class="form-label">
              <i class="fa fa-lock me-1"></i>Password
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fa fa-lock"></i>
                </span>
              </div>
              <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                placeholder="Enter your password" 
                required 
                autocomplete="current-password"
                aria-describedby="passwordHelp"
              >
              <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                <i class="fa fa-eye" id="toggleIcon"></i>
              </button>
            </div>
            <div class="invalid-feedback" id="passwordError">
              Please enter your password.
            </div>
            <div class="valid-feedback" id="passwordValid" style="display: none;">
              ✓ Password entered
                </div>
              </div>

          <!-- Remember Me -->
          <div class="form-check">
            <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input" value="1">
            <label for="remember_me" class="form-check-label">
              Remember me for 30 days
            </label>
          </div>

          <!-- Login Button -->
          <button type="submit" class="btn-login" id="loginBtn">
            <span class="spinner" id="loginSpinner"></span>
            <span id="loginText">Sign In</span>
          </button>

              </form>

          <!-- Forgot Password -->
          <div class="forgot-password">
            <a href="#" id="forgotPasswordLink" onclick="showForgotPassword()">
              <i class="fa fa-question-circle me-1"></i>Forgot your password?
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading Overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
  </div>

  <!-- Required JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="<?php echo base_url() ?>assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/notifications/js/notifications.min.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize form validation
      initializeFormValidation();
      
      // Initialize password toggle
      initializePasswordToggle();
      
      // Initialize remember me functionality
      initializeRememberMe();
      
      // Show notifications if any
      <?php if ($this->session->flashdata('error_message')): ?>
        showNotification('error', "<?php echo addslashes($this->session->flashdata('error_message')); ?>");
      <?php endif; ?>

      <?php if ($this->session->flashdata('success_message')): ?>
        showNotification('success', "<?php echo addslashes($this->session->flashdata('success_message')); ?>");
      <?php endif; ?>
    });

    // Form validation
    function initializeFormValidation() {
      const form = document.getElementById('loginForm');
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      
      // Real-time validation
      emailInput.addEventListener('input', function() {
        validateEmail(this);
      });
      
      passwordInput.addEventListener('input', function() {
        validatePassword(this);
      });
      
      // Form submission
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const isEmailValid = validateEmail(emailInput);
        const isPasswordValid = validatePassword(passwordInput);
        
        if (isEmailValid && isPasswordValid) {
          submitForm();
        } else {
          showNotification('error', 'Please correct the errors below.');
        }
      });
    }
    
    function validateEmail(input) {
      const email = input.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const isValid = emailRegex.test(email) && email.length > 0;
      const inputGroup = input.closest('.input-group');
      
      if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        inputGroup.classList.remove('has-error');
        inputGroup.classList.add('has-success');
        document.getElementById('emailError').style.display = 'none';
        document.getElementById('emailValid').style.display = 'block';
      } else if (email.length > 0) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        inputGroup.classList.remove('has-success');
        inputGroup.classList.add('has-error');
        document.getElementById('emailValid').style.display = 'none';
        document.getElementById('emailError').style.display = 'block';
      } else {
        input.classList.remove('is-valid', 'is-invalid');
        inputGroup.classList.remove('has-success', 'has-error');
        document.getElementById('emailValid').style.display = 'none';
        document.getElementById('emailError').style.display = 'none';
      }
      
      return isValid;
    }
    
    function validatePassword(input) {
      const password = input.value;
      const isValid = password.length >= 6;
      const inputGroup = input.closest('.input-group');
      
      if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        inputGroup.classList.remove('has-error');
        inputGroup.classList.add('has-success');
        document.getElementById('passwordError').style.display = 'none';
        document.getElementById('passwordValid').style.display = 'block';
      } else if (password.length > 0) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        inputGroup.classList.remove('has-success');
        inputGroup.classList.add('has-error');
        document.getElementById('passwordValid').style.display = 'none';
        document.getElementById('passwordError').style.display = 'block';
      } else {
        input.classList.remove('is-valid', 'is-invalid');
        inputGroup.classList.remove('has-success', 'has-error');
        document.getElementById('passwordValid').style.display = 'none';
        document.getElementById('passwordError').style.display = 'none';
      }
      
      return isValid;
    }
    
    // Password toggle functionality
    function initializePasswordToggle() {
      const toggleButton = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      toggleButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
          toggleIcon.classList.remove('fa-eye');
          toggleIcon.classList.add('fa-eye-slash');
          toggleButton.setAttribute('aria-label', 'Hide password');
        } else {
          toggleIcon.classList.remove('fa-eye-slash');
          toggleIcon.classList.add('fa-eye');
          toggleButton.setAttribute('aria-label', 'Show password');
        }
      });
    }
    
    // Remember me functionality
    function initializeRememberMe() {
      const rememberCheckbox = document.getElementById('remember_me');
      const emailInput = document.getElementById('email');
      
      // Load saved credentials
      const savedEmail = localStorage.getItem('remembered_email');
      if (savedEmail && rememberCheckbox.checked) {
        emailInput.value = savedEmail;
        rememberCheckbox.checked = true;
      }
      
      // Save credentials when checkbox is checked
      rememberCheckbox.addEventListener('change', function() {
        if (this.checked) {
          localStorage.setItem('remembered_email', emailInput.value);
        } else {
          localStorage.removeItem('remembered_email');
        }
      });
    }
    
    // Form submission with loading state
    function submitForm() {
      const loginBtn = document.getElementById('loginBtn');
      const loginSpinner = document.getElementById('loginSpinner');
      const loginText = document.getElementById('loginText');
      const loadingOverlay = document.getElementById('loadingOverlay');
      
      // Show loading state
      loginBtn.disabled = true;
      loginSpinner.style.display = 'inline-block';
      loginText.textContent = 'Signing In...';
      loadingOverlay.style.display = 'flex';
      
      // Submit form
      document.getElementById('loginForm').submit();
    }
    
    // Notification system
    function showNotification(type, message) {
      if (typeof Lobibox !== 'undefined') {
        Lobibox.notify(type, {
          pauseDelayOnHover: true,
          continueDelayOnInactiveTab: false,
          position: 'top center',
          icon: type === 'error' ? 'fa fa-times-circle' : 'fa fa-check-circle',
          msg: message
        });
      } else {
        // Fallback to alert if Lobibox is not available
        alert(message);
      }
    }
    
    // Forgot password functionality
    function showForgotPassword() {
      showNotification('info', 'Password reset functionality will be implemented soon. Please contact your administrator.');
    }
    
    // Keyboard accessibility
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
        const form = document.getElementById('loginForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
          submitBtn.click();
        }
      }
    });
    
    // Focus management for accessibility
    document.getElementById('email').focus();
  </script>

</body>

</html>