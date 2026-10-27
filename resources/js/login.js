import './logo-rotator.js';

// Language Switch System for Login Page
window.setLang = function (lang) {
    const frBtns = document.querySelectorAll('.lang-switch button[id^="fr"]');
    const arBtns = document.querySelectorAll('.lang-switch button[id^="ar"]');

    frBtns.forEach(btn => btn.classList.remove('active'));
    arBtns.forEach(btn => btn.classList.remove('active'));

    if (lang === 'ar') {
        document.documentElement.lang = "ar";
        document.body.style.direction = "rtl";
        document.body.classList.remove('lang-fr');
        document.body.classList.add('lang-ar');
        arBtns.forEach(btn => btn.classList.add('active'));
    } else {
        document.documentElement.lang = "fr";
        document.body.style.direction = "ltr";
        document.body.classList.remove('lang-ar');
        document.body.classList.add('lang-fr');
        frBtns.forEach(btn => btn.classList.add('active'));
    }
}

// Password show/hide toggle
window.togglePasswordVisibility = function () {
    const pwdInput = document.getElementById('password');
    const toggleBtn = document.getElementById('passwordToggleBtn');
    if (!pwdInput || !toggleBtn) return;
    
    if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        toggleBtn.classList.add('visible');
    } else {
        pwdInput.type = 'password';
        toggleBtn.classList.remove('visible');
    }
}

// Forgot Password Handler
window.handleForgotPwd = function (event) {
    event.preventDefault();
    const currentLang = document.documentElement.lang || 'fr';
    const msg = currentLang === 'ar' 
        ? 'الرجاء الاتصال بمسؤول النظام لاستعادة كلمة المرور الخاصة بك.' 
        : 'Veuillez contacter l\'administrateur système pour réinitialiser votre mot de passe.';
    alert(msg);
}

// Form Submit Handler
window.handleLoginSubmit = function (event) {
    event.preventDefault();

    const form = event.target;
    const submitBtn = document.getElementById('loginSubmitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');
    const errorBanner = document.getElementById('loginErrorBanner');

    // Reset UI state
    errorBanner.style.display = 'none';
    errorBanner.innerText = '';
    form.querySelectorAll('.form-control').forEach(el => el.style.borderColor = '');

    // Disable button and show spinner
    submitBtn.disabled = true;
    btnText.style.display = 'none';
    btnSpinner.style.display = 'block';

    const currentLang = document.documentElement.lang || 'fr';
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    const data = {
        email: email,
        password: password,
        remember: remember,
        lang: currentLang
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json().then(json => ({ status: response.status, body: json })))
    .then(({ status, body }) => {
        // Restore button state
        submitBtn.disabled = false;
        btnText.style.display = 'block';
        btnSpinner.style.display = 'none';

        if (status === 200 && body.success) {
            // Redirect to admin panel
            window.location.href = body.redirect;
        } else {
            // Handle error messages
            let displayError = body.message || (currentLang === 'ar' ? 'حدث خطأ ما. يرجى المحاولة مرة أخرى.' : 'Une erreur est survenue. Veuillez réessayer.');
            
            // Extract validation errors if present
            if (body.errors) {
                const firstField = Object.keys(body.errors)[0];
                if (firstField && body.errors[firstField] && body.errors[firstField][0]) {
                    displayError = body.errors[firstField][0];
                }
                
                // Highlight input fields
                Object.keys(body.errors).forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        input.style.borderColor = '#e53e3e';
                    }
                });
            }

            // Show error banner with a shake animation
            errorBanner.innerText = displayError;
            errorBanner.style.display = 'block';
            
            // Trigger animation reflow
            errorBanner.style.animation = 'none';
            errorBanner.offsetHeight; // trigger reflow
            errorBanner.style.animation = null;
        }
    })
    .catch(error => {
        // Restore button state
        submitBtn.disabled = false;
        btnText.style.display = 'block';
        btnSpinner.style.display = 'none';
        
        console.error('Error:', error);
        alert(currentLang === 'ar' ? 'فشل الاتصال. يرجى التحقق من اتصالك بالإنترنت والمحاولة مرة أخرى.' : 'Erreur de connexion. Veuillez vérifier votre connexion internet et réessayer.');
    });
}
