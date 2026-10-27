<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion administrative - Centre Thérapeutique Privé">
    <title>CONNEXION ADMINISTRATIVE </title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@300;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body class="lang-fr">

    <div class="login-split-container">
        
        <!-- LEFT SIDE: Information & Mockup (Hidden on mobile) -->
        <div class="login-left-panel">
            {{-- Language Selector in Left Panel corner --}}
            <div class="login-header-left">
                <div class="lang-switch left-lang-switch">
                    <button id="fr-left" class="active" onclick="setLang('fr')">FR</button>
                    <button id="ar-left" onclick="setLang('ar')">AR</button>
                </div>
            </div>
            
            <div class="left-panel-content">
                {{-- Logo container --}}
                <div class="logo-wrapper-white">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="left-logo dynamic-logo">
                </div>
                
                <h2 class="left-title">
                    <span class="fr">Système de Gestion — Centre Théarapeutique Privé</span>
                    <span class="ar">نظام التسيير الداخلي - المركز الاستشفائي الخاص</span>
                </h2>
                
                <p class="left-subtitle">
                    <span class="fr">Plateforme interne conçue pour gérer l'ensemble des activités du centre : rendez-vous, fiches patients, services et suivi thérapeutique.</span>
                    <span class="ar">منصة داخلية مخصصة لتسيير جميع أنشطة المركز: المواعيد، ملفات المرضى، الخدمات والمتابعة الطبية.</span>
                </p>
                
                <div class="why-section">
                    <h3 class="why-title">
                        <span class="fr">Pourquoi ce système ?</span>
                        <span class="ar">لماذا هذا النظام ؟</span>
                    </h3>
                    
                    <ul class="why-list">
                        <li>
                            <span class="check-icon">✓</span>
                            <span class="fr">Centralisation complète des rendez-vous</span>
                            <span class="ar">التسيير المركزي والشامل للمواعيد</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span class="fr">Suivi en temps réel des patients et soins</span>
                            <span class="ar">متابعة دقيقة وحية للمرضى والعلاجات</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span class="fr">Gestion simplifiée des cartes de services</span>
                            <span class="ar">إدارة مبسطة لبطاقات الخدمات الطبية</span>
                        </li>
                        <li>
                            <span class="check-icon">✓</span>
                            <span class="fr">Organisation efficace et sécurisée</span>
                            <span class="ar">تنظيم عملي، فعال ومحمي بالكامل</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        
        <!-- RIGHT SIDE: Login form -->
        <div class="login-right-panel">
            {{-- Language Selector --}}
            <div class="login-header">
                <div class="lang-switch">
                    <button id="fr-right" class="active" onclick="setLang('fr')">FR</button>
                    <button id="ar-right" onclick="setLang('ar')">AR</button>
                </div>
            </div>
            
            <div class="login-card-container">
                <div class="login-card">
                    
                    {{-- User Avatar Icon --}}
                    <div class="user-avatar-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    
                    <h3 class="login-card-title">
                        <span class="fr">Connexion au Centre</span>
                        <span class="ar">تسجيل الدخول للمركز</span>
                    </h3>
                    
                    <p class="login-card-subtitle">
                        <span class="fr">Entrez vos identifiants autorisés pour continuer</span>
                        <span class="ar">أدخل بيانات الاعتماد الخاصة بك للمتابعة</span>
                    </p>
                    
                    <form id="loginForm" onsubmit="handleLoginSubmit(event)">
                        
                        {{-- Error Banner --}}
                        <div id="loginErrorBanner" class="login-error-banner" style="display: none;"></div>

                        <div class="form-group">
                            <label for="email">
                                <span class="fr">Adresse e-mail professionnelle</span>
                                <span class="ar">البريد الإلكتروني المهني</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="email" id="email" class="form-control" placeholder="nom@gmail.com" required autocomplete="username">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="label-row">
                                <label for="password">
                                    <span class="fr">Mot de passe</span>
                                    <span class="ar">كلمة المرور</span>
                                </label>
                                <a href="#" class="forgot-pwd-link" onclick="handleForgotPwd(event)">
                                    <span class="fr">Mot de passe oublié ?</span>
                                    <span class="ar">نسيت كلمة المرور؟</span>
                                </a>
                            </div>
                            <div class="input-wrapper">
                                <input type="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <button type="button" class="password-toggle-btn" id="passwordToggleBtn" aria-label="Afficher le mot de passe" onclick="togglePasswordVisibility()">
                                    <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="remember-me">
                                <input type="checkbox" id="remember" name="remember">
                                <span class="checkbox-label">
                                    <span class="fr">Garder ma session active</span>
                                    <span class="ar">تذكرني</span>
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="login-submit-btn" id="loginSubmitBtn">
                            <span class="btn-text">
                                <span class="fr">Se connecter &rarr;</span>
                                <span class="ar">دخول &larr;</span>
                            </span>
                            <div class="btn-spinner" style="display: none;"></div>
                        </button>
                        
                    </form>

                    <div class="login-footer-text">
                        <span class="fr">&copy; 2026 Centre Thérapeutique Privé — Plateforme Interne<br>Tous droits réservés</span>
                        <span class="ar">&copy; 2026 المركز الاستشفائي الخاص — المنصة الداخلية<br>جميع الحقوق محفوظة</span>
                    </div>

                    <div class="back-home-wrapper">
                        <a href="{{ url('/') }}" class="back-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                            <span class="fr">Retour au site</span>
                            <span class="ar">العودة للموقع</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
