<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin | Centre Thérapeutique Privé</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@300;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Quill WYSIWYG Editor CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    
    <!-- html2canvas and jsPDF CDNs for Bilans PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="lang-fr">

    <div class="admin-layout">
        
        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="sidebar-logo-section">
                <img src="{{ asset('images/logos/logo1.png') }}" alt="Logo" class="sidebar-logo dynamic-logo">
                <h2 class="sidebar-title">
                    <span class="fr">Centre Thérapeutique Privé </span>
                    <span class="ar">المركز الاستشفائي الخاص</span>
                </h2>
            </div>
            
            <nav class="sidebar-nav">
                <button class="nav-item active" data-tab="overview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                    <span class="fr">Vue d'ensemble</span>
                    <span class="ar">نظرة عامة</span>
                </button>
                <button class="nav-item" data-tab="appointments">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span class="fr">Rendez-vous</span>
                    <span class="ar">المواعيد</span>
                </button>
                <button class="nav-item" data-tab="services">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    <span class="fr">Services</span>
                    <span class="ar">الخدمات</span>
                </button>
                <button class="nav-item" data-tab="pages-services">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="fr">Pages Services</span>
                    <span class="ar">صفحات الخدمات</span>
                </button>
                <button class="nav-item" data-tab="clients">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="fr">Clients</span>
                    <span class="ar">الزبائن</span>
                </button>
                <button class="nav-item" data-tab="bilans">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    <span class="fr">Bilans</span>
                    <span class="ar">التقارير / الفحوصات</span>
                </button>
            </nav>
            
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Voulez-vous vous déconnecter ?');">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="nav-icon"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span class="fr">Déconnexion</span>
                        <span class="ar">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- MAIN AREA -->
        <main class="admin-main">
            
            <!-- HEADER -->
            <header class="admin-header">
                <div class="header-welcome">
                    <h1>
                        <span class="fr">Bonjour, Dr. Salma El Amrani</span>
                        <span class="ar">مرحباً بك، دكتورة سلمى العمراني</span>
                    </h1>
                    <p class="header-date" id="currentDate"></p>
                </div>
                
                <div class="header-actions">
                    <div class="lang-switch">
                        <button id="fr" class="active" onclick="setLang('fr')">FR</button>
                        <button id="ar" onclick="setLang('ar')">AR</button>
                    </div>
                </div>
            </header>
            
            <!-- FLASH MESSAGES -->
            @if(session('success'))
                <div class="alert-banner success">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert-banner danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
            
            <!-- TAB CONTENTS -->
            <div class="tab-container">
                
                <!-- TAB 1: OVERVIEW -->
                <div class="tab-pane active" id="overview">
                    <div class="grid-stats">
                        <div class="stat-card">
                            <div class="stat-icon rdv-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <span class="fr">Total Rendez-vous</span>
                                    <span class="ar">إجمالي المواعيد</span>
                                </h3>
                                <p class="stat-number" id="stats_appointments_count">{{ $stats['appointments_count'] }}</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon services-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <span class="fr">Total Services</span>
                                    <span class="ar">إجمالي الخدمات</span>
                                </h3>
                                <p class="stat-number">{{ $stats['services_count'] }}</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon clients-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <span class="fr">Total Clients</span>
                                    <span class="ar">إجمالي الزبائن</span>
                                </h3>
                                <p class="stat-number">{{ $stats['clients_count'] }}</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon pages-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="stat-info">
                                <h3>
                                    <span class="fr">Pages (Complets / Vides)</span>
                                    <span class="ar">الصفحات (المكتملة / الفارغة)</span>
                                </h3>
                                <p class="stat-number" style="font-size: 1.5rem;">{{ $stats['complete_pages_count'] }} / {{ $stats['incomplete_pages_count'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SECTION: ACTIVITÉ DES DERNIÈRES 24 HEURES -->
                    <div style="margin-top: 30px; margin-bottom: 20px;">
                        <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--navy-dark); margin-bottom: 5px;">
                            <span class="fr">Activité des dernières 24 heures</span>
                            <span class="ar">نشاط آخر 24 ساعة</span>
                        </h2>
                        <p style="color: var(--text-gray); font-size: 0.88rem;">
                            <span class="fr">Modifications et nouveaux enregistrements survenus durant les dernières 24 heures.</span>
                            <span class="ar">التغييرات والسجلات الجديدة التي تمت خلال الـ 24 ساعة الماضية.</span>
                        </p>
                    </div>

                    <!-- 1. Rendez-vous récents (créés dans les dernières 24h) -->
                    <div class="card-section" id="recent24hSection" style="display: {{ count($recentAppointments24h) > 0 ? 'block' : 'none' }};">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Nouveaux Rendez-vous (Dernières 24h)</span>
                                <span class="ar">المواعيد الجديدة (آخر 24 ساعة)</span>
                            </h2>
                            <button class="text-link" onclick="switchTab('appointments')">
                                <span class="fr">Voir tout &rarr;</span>
                                <span class="ar">عرض الكل &larr;</span>
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Patient</span>
                                            <span class="ar">المريض</span>
                                        </th>
                                        <th>
                                            <span class="fr">Date & Heure</span>
                                            <span class="ar">التاريخ والوقت</span>
                                        </th>
                                        <th>
                                            <span class="fr">Téléphone</span>
                                            <span class="ar">الهاتف</span>
                                        </th>
                                        <th>
                                            <span class="fr">Services</span>
                                            <span class="ar">الخدمات المطلوبة</span>
                                        </th>
                                        <th>
                                            <span class="fr">Description</span>
                                            <span class="ar">الوصف</span>
                                        </th>
                                        <th>
                                            <span class="fr">État Date</span>
                                            <span class="ar">حالة التاريخ</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="recent24hTableBody">
                                    @foreach($recentAppointments24h as $rdv)
                                        @include('admin_partials.recent_24h_row', ['rdv' => $rdv])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 2. Patients traités : Acceptés ou Annulés (Dernières 24h) -->
                    @if(count($processedAppointments24h) > 0)
                    <div class="card-section">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Patients Acceptés ou Annulés (Dernières 24h)</span>
                                <span class="ar">المرضى المقبولين أو الملغيين (آخر 24 ساعة)</span>
                            </h2>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Patient & Infos</span>
                                            <span class="ar">المريض والمعلومات</span>
                                        </th>
                                        <th>
                                            <span class="fr">Contact</span>
                                            <span class="ar">الاتصال</span>
                                        </th>
                                        <th>
                                            <span class="fr">Date & Heure</span>
                                            <span class="ar">التاريخ والوقت</span>
                                        </th>
                                        <th>
                                            <span class="fr">Statut</span>
                                            <span class="ar">الحالة</span>
                                        </th>
                                        <th>
                                            <span class="fr">Action effectuée</span>
                                            <span class="ar">الإجراء المتخذ</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($processedAppointments24h as $rdv)
                                        <tr class="clickable-row" onclick="openDetailAppointmentModal({{ json_encode($rdv) }})">
                                            <td class="font-bold">
                                                <div>{{ $rdv->firstname }} {{ $rdv->lastname }}</div>
                                                <div class="patient-details" style="font-weight: normal; font-size: 0.8rem; color: var(--text-gray); margin-top: 4px;">
                                                    <span>{{ $rdv->age }} ans / {{ $rdv->gender === 'homme' ? 'Homme' : 'Femme' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-details">
                                                    <span class="phone">{{ $rdv->phone }}</span>
                                                    <span class="email" style="font-size: 0.82rem; color: var(--text-gray);">{{ $rdv->email ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-time-cell">
                                                    <span class="date">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</span>
                                                    <span class="time">{{ \Carbon\Carbon::parse($rdv->time)->format('H:i') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($rdv->status === 'accepte')
                                                    <span class="status-badge status-accepted">
                                                        <span class="fr">Accepté</span>
                                                        <span class="ar">مقبول</span>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-cancelled">
                                                        <span class="fr">Annulé</span>
                                                        <span class="ar">ملغى</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span style="font-size: 0.88rem; color: var(--text-gray);">{{ $rdv->updated_at->diffForHumans() }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- 3. Pages services remplies/modifiées (Dernières 24h) -->
                    @if(count($filledPages24h) > 0)
                    <div class="card-section">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Détails de Services Remplis/Modifiés (Dernières 24h)</span>
                                <span class="ar">تفاصيل الخدمات المكتملة/المعدلة (آخر 24 ساعة)</span>
                            </h2>
                            <button class="text-link" onclick="switchTab('pages-services')">
                                <span class="fr">Gérer &rarr;</span>
                                <span class="ar">إدارة &larr;</span>
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Service</span>
                                            <span class="ar">الخدمة</span>
                                        </th>
                                        <th>
                                            <span class="fr">Dernière modification</span>
                                            <span class="ar">آخر تعديل</span>
                                        </th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filledPages24h as $service)
                                        <tr>
                                            <td class="font-bold">
                                                <span class="fr">{{ $service->title_fr }}</span>
                                                <span class="ar">{{ $service->title_ar }}</span>
                                            </td>
                                            <td>
                                                <span style="font-size: 0.88rem; color: var(--text-gray);">{{ $service->updated_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-teal" onclick="openConfigurePageModal({{ json_encode($service) }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon-svg" style="width: 14px; height: 14px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    <span class="fr">Remplir la page</span>
                                                    <span class="ar">تعديل محتوى الصفحة</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Fallback si aucune activité récente -->
                    <div id="noRecentActivityBanner" style="display: {{ (count($recentAppointments24h) === 0 && count($processedAppointments24h) === 0 && count($filledPages24h) === 0) ? 'block' : 'none' }};">
                        <div class="card-section" style="text-align: center; padding: 50px 20px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#a0aec0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 64px; height: 64px; margin-bottom: 15px; display: inline-block;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                            </svg>
                            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--navy-dark); margin-bottom: 8px;">
                                <span class="fr">Aucune activité récente (Dernières 24h)</span>
                                <span class="ar">لا توجد أنشطة أخيرة (آخر 24 ساعة)</span>
                            </h2>
                            <p style="color: var(--text-gray); font-size: 0.95rem; line-height: 1.6;">
                                <span class="fr">Tout est calme. Aucun rendez-vous, traitement de patient ou modification de page n'a été enregistré au cours des dernières 24 heures.</span>
                                <span class="ar">كل شيء هادئ. لم يتم تسجيل أي موعد أو معالجة مريض أو تعديل صفحة خلال الـ 24 ساعة الماضية.</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- TAB 2: APPOINTMENTS -->
                <div class="tab-pane" id="appointments">
                    <div class="card-section">
                        <div class="section-header" style="display: flex !important; flex-direction: row !important; justify-content: space-between !important; align-items: center !important; flex-wrap: nowrap !important; gap: 20px; margin-bottom: 25px;">
                            <h2>
                                <span class="fr">Gestion des Rendez-vous</span>
                                <span class="ar">إدارة المواعيد</span>
                            </h2>
                            <div style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 15px !important; flex-wrap: nowrap !important;">
                                <div class="search-wrapper" style="margin-bottom: 0;">
                                    <input type="text" id="appointmentSearch" placeholder="Rechercher un patient, téléphone..." onkeyup="filterAppointments()">
                                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <button class="btn btn-teal" onclick="openAddAppointmentModal()" style="padding: 10px 18px; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px; height: 38px; white-space: nowrap;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon-svg" style="width: 15px; height: 15px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    <span class="fr">Ajouter manuellement</span>
                                    <span class="ar">إضافة موعد يدوياً</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table" id="appointmentsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Patient & Infos</span>
                                            <span class="ar">المريض والمعلومات</span>
                                        </th>
                                        <th>
                                            <span class="fr">Contact</span>
                                            <span class="ar">الاتصال</span>
                                        </th>
                                        <th>
                                            <span class="fr">Date & Heure</span>
                                            <span class="ar">التاريخ والوقت</span>
                                        </th>
                                        <th>
                                            <span class="fr">Services</span>
                                            <span class="ar">الخدمات</span>
                                        </th>
                                        <th>
                                            <span class="fr">Description</span>
                                            <span class="ar">الوصف</span>
                                        </th>
                                        <th>
                                            <span class="fr">Statut</span>
                                            <span class="ar">الحالة</span>
                                        </th>
                                        <th>
                                            <span class="fr">État Date</span>
                                            <span class="ar">حالة التاريخ</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="appointmentsTableBody">
                                    @forelse($appointments as $rdv)
                                        @include('admin_partials.appointment_row', ['rdv' => $rdv])
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-gray py-4">
                                                <span class="fr">Aucun rendez-vous trouvé</span>
                                                <span class="ar">لا توجد مواعيد</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- TAB 3: SERVICES -->
                <div class="tab-pane" id="services">
                    <div class="card-section">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Gestion des Services</span>
                                <span class="ar">إدارة الخدمات</span>
                            </h2>
                            <button class="btn btn-teal" onclick="openAddServiceModal()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon-svg"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                <span class="fr">Ajouter un Service</span>
                                <span class="ar">إضافة خدمة</span>
                            </button>
                        </div>
                        
                        <!-- Tabs inside Services for Phases -->
                        <div class="phase-selector-tabs">
                            <button class="phase-tab active" onclick="filterServicesPhase(1)">
                                <span class="fr">Phase 1: Kinésithérapie</span>
                                <span class="ar">المرحلة 1: الترويض الطبي</span>
                            </button>
                            <button class="phase-tab" onclick="filterServicesPhase(2)">
                                <span class="fr">Phase 2: Rééducation Spécialisée</span>
                                <span class="ar">المرحلة 2: التأهيل المتخصص</span>
                            </button>
                            <button class="phase-tab" onclick="filterServicesPhase(3)">
                                <span class="fr">Phase 3: Diagnostic & Suivi</span>
                                <span class="ar">المرحلة 3: التشخيص والمتابعة</span>
                            </button>
                        </div>
                        
                        <!-- Services Grid -->
                        <div class="services-grid" id="servicesGrid">
                            @foreach($services as $service)
                                <div class="service-card-item" data-service-id="{{ $service->id }}" data-phase="{{ $service->phase }}">
                                    <div class="service-card-img-wrapper">
                                        <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->title_fr }}" onerror="this.src='{{ asset('images/doctor_placeholder.png') }}'">
                                        <span class="phase-badge">Phase {{ $service->phase }}</span>
                                    </div>
                                    <div class="service-card-info">
                                        <h3 class="service-card-title">
                                            <span class="fr">{{ $service->title_fr }}</span>
                                            <span class="ar">{{ $service->title_ar }}</span>
                                        </h3>
                                        <p class="service-card-desc">
                                            <span class="fr">{{ $service->desc_fr }}</span>
                                            <span class="ar">{{ $service->desc_ar }}</span>
                                        </p>
                                        
                                        <div class="service-card-actions">
                                            <button class="btn btn-edit-service" onclick="openEditServiceModal({{ json_encode($service) }})">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                <span class="fr">Modifier</span>
                                                <span class="ar">تعديل</span>
                                            </button>
                                            
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette carte de service ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete-service">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    <span class="fr">Supprimer</span>
                                                    <span class="ar">حذف</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 4: PAGES SERVICES -->
                <div class="tab-pane" id="pages-services">
                    <div class="card-section">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Gestion des Pages de Détails des Services</span>
                                <span class="ar">إدارة صفحات تفاصيل الخدمات</span>
                            </h2>
                            <div class="search-wrapper" style="width: 320px; max-width: 100%; position: relative;">
                                <input type="text" id="pagesServicesSearchInput" class="search-input" placeholder="Rechercher un service..." style="width: 100%; border: 1.5px solid var(--border-color); border-radius: var(--radius-sm); padding: 10px 15px 10px 40px; font-size: 0.95rem; color: var(--navy-dark); outline: none; transition: border-color 0.25s ease, box-shadow 0.25s ease; box-shadow: var(--shadow-sm);">
                                <svg class="search-icon" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-light); pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Service</span>
                                            <span class="ar">الخدمة</span>
                                        </th>
                                        <th>
                                            <span class="fr">Statut de la Page</span>
                                            <span class="ar">حالة الصفحة</span>
                                        </th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="pagesServicesTableBody">
                                    @forelse($services as $service)
                                        <tr class="page-service-row" data-name-fr="{{ strtolower($service->title_fr) }}" data-name-ar="{{ strtolower($service->title_ar) }}">
                                            <td class="font-bold">
                                                <span class="fr">{{ $service->title_fr }}</span>
                                                <span class="ar">{{ $service->title_ar }}</span>
                                            </td>
                                            <td>
                                                @if(!empty($service->content_fr) || !empty($service->content_ar))
                                                    <span class="status-badge status-accepted">
                                                        <span class="fr">Remplie</span>
                                                        <span class="ar">مكتملة</span>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-pending">
                                                        <span class="fr">Vide (Description par défaut)</span>
                                                        <span class="ar">فارغة (الوصف الافتراضي)</span>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-teal" onclick="openConfigurePageModal({{ json_encode($service) }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon-svg" style="width: 14px; height: 14px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    <span class="fr">Remplir la page</span>
                                                    <span class="ar">تعديل محتوى الصفحة</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-gray py-4">Aucun service disponible</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: CLIENTS -->
                <div class="tab-pane" id="clients">
                    <div class="card-section">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Liste des Clients (Rendez-vous Acceptés)</span>
                                <span class="ar">قائمة الزبائن (المواعيد المقبولة)</span>
                            </h2>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="fr">Client</span>
                                            <span class="ar">الزبون</span>
                                        </th>
                                        <th>
                                            <span class="fr">Infos</span>
                                            <span class="ar">المعلومات</span>
                                        </th>
                                        <th>
                                            <span class="fr">Contact</span>
                                            <span class="ar">الاتصال</span>
                                        </th>
                                        <th>
                                            <span class="fr">Services Réalisés</span>
                                            <span class="ar">الخدمات المستفاد منها</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clients as $client)
                                        <tr>
                                            <td class="font-bold">{{ $client->firstname }} {{ $client->lastname }}</td>
                                            <td>
                                                <div class="patient-details">
                                                    <span>{{ $client->age }} ans / سنة</span>
                                                    <span class="gender-tag">{{ $client->gender === 'homme' ? 'Homme' : 'Femme' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-details">
                                                    <span class="phone">{{ $client->phone }}</span>
                                                    <span class="email" style="font-size: 0.82rem; color: var(--text-gray);">{{ $client->email ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if(is_array($client->services) && count($client->services) > 0)
                                                    <div class="badges-wrapper">
                                                        @foreach($client->services as $s)
                                                            <span class="badge badge-teal">{{ $s }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-gray py-4">
                                                <span class="fr">Aucun client trouvé avec un rendez-vous accepté</span>
                                                <span class="ar">لا يوجد زبائن لديهم مواعيد مقبولة</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 6: BILANS -->
                <div class="tab-pane" id="bilans">
                    <div class="card-section">
                        <div class="section-header" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                <h2 style="margin: 0; font-size: 1.35rem; font-weight: 700; color: var(--navy-dark);">
                                    <span class="fr">Bilans Cliniques & Schémas Anatomiques</span>
                                    <span class="ar">التقارير الطبية والمخططات التشريحية</span>
                                </h2>
                                <p style="font-size: 0.88rem; color: var(--text-gray); margin-top: 4px;">
                                    Sélectionnez un schéma diagnostique ci-dessous pour ouvrir l'éditeur clinique professionnel.
                                </p>
                            </div>
                            
                            <!-- Search Bar & Add Button for Schémas -->
                            <div style="display: flex; gap: 10px; align-items: center; justify-content: flex-end; flex-shrink: 0;">
                                <div style="position: relative; width: 260px;">
                                    <input type="text" id="bilanSchemaSearch" class="form-control" placeholder="Rechercher un schéma (ex: d5, d12)..." style="padding: 10px 15px 10px 35px; border-radius: 8px; border: 1.5px solid var(--border-color); font-size: 0.88rem; width: 100%; box-sizing: border-box;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: var(--text-gray); pointer-events: none;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                </div>
                                <button type="button" class="btn btn-teal" onclick="openUploadSchemaModal()" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; font-size: 0.85rem; height: auto; border-radius: 8px; font-weight: 600; white-space: nowrap;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 15px; height: 15px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    <span class="fr">Ajouter un Schéma</span>
                                    <span class="ar">إضافة مخطط</span>
                                </button>
                            </div>
                        </div>

                        <!-- Catalog Grid -->
                        <div class="schemas-catalog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; max-height: 520px; overflow-y: auto; padding: 5px; border: 1px solid #edf2f7; border-radius: 8px; background: #fdfdfd; margin-bottom: 25px;">
                            @php
                                $schemaFiles = [];
                                $diagnoPath = public_path('images/Diagno');
                                if (File::exists($diagnoPath)) {
                                    $files = File::files($diagnoPath);
                                    foreach ($files as $file) {
                                        $filename = $file->getFilename();
                                        $ext = strtolower($file->getExtension());
                                        if (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp', 'jfif'])) {
                                            $name = pathinfo($filename, PATHINFO_FILENAME);
                                            // Human-friendly title conversion
                                            $displayLabel = str_replace('_', ' ', $name);
                                            $displayLabel = ucwords($displayLabel);
                                            
                                            // Handle d[number] case (e.g. d12 -> D12)
                                            if (preg_match('/^d(\d+)$/i', $name, $matches)) {
                                                $displayLabel = 'D' . $matches[1];
                                            }
                                            
                                            $schemaFiles[] = [
                                                'filename' => $filename,
                                                'name' => $name,
                                                'label' => $displayLabel,
                                                'src' => asset('images/Diagno/' . $filename)
                                            ];
                                        }
                                    }
                                    
                                    // Sort naturally: d1, d2, d3...
                                    usort($schemaFiles, function($a, $b) {
                                        return strnatcasecmp($a['name'], $b['name']);
                                    });
                                }
                            @endphp
                            
                            @forelse($schemaFiles as $schema)
                                <div class="schema-card" data-name="{{ $schema['name'] }}" data-src="{{ $schema['src'] }}" data-filename="{{ $schema['filename'] }}" style="background: white; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 12px; box-shadow: var(--shadow-sm); transition: all 0.22s ease-in-out; cursor: pointer; text-align: center; box-sizing: border-box;">
                                    <div style="width: 100%; aspect-ratio: 1; display: flex; align-items: center; justify-content: center; background: #fafafa; border-radius: 6px; overflow: hidden; margin-bottom: 10px;">
                                        <img src="{{ $schema['src'] }}" alt="Schéma {{ $schema['label'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.2s;">
                                    </div>
                                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--navy-dark); text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 100%;">Schéma {{ $schema['label'] }}</span>
                                    <button type="button" class="btn btn-teal" style="width: 100%; margin-top: 8px; padding: 6px 12px; font-size: 0.78rem; height: auto;">Ouvrir l'Éditeur</button>
                                    <div style="display: flex; gap: 4px; width: 100%; margin-top: 4px;">
                                        <button type="button" class="btn btn-action-rename" onclick="event.stopPropagation(); renameSchemaPrompt('{{ $schema['filename'] }}', '{{ $schema['label'] }}')" title="Renommer" style="flex: 1; padding: 6px; font-size: 0.72rem; height: 30px; background: var(--navy-dark); color: white; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 4px; cursor: pointer;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 13px; height: 13px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"/></svg>
                                        </button>
                                        <button type="button" class="btn btn-action-delete" onclick="event.stopPropagation(); deleteSchemaConfirm('{{ $schema['filename'] }}', '{{ $schema['label'] }}')" title="Supprimer" style="flex: 1; padding: 6px; font-size: 0.72rem; height: 30px; background: #e53e3e; color: white; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 4px; cursor: pointer;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 13px; height: 13px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--text-gray);">
                                    Aucun schéma disponible
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Bilan Archive History Section -->
                    <div class="card-section" style="margin-top: 25px;">
                        <div class="section-header">
                            <h2>
                                <span class="fr">Historique des Bilans Enregistrés</span>
                                <span class="ar">سجل الفحوصات المحفوظة</span>
                            </h2>
                        </div>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Pathologie</th>
                                        <th>Notes</th>
                                        <th class="text-center">Aperçu</th>
                                        <th class="text-center" style="width: 250px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="bilansHistoryTableBody">
                                    @forelse($bilans as $b)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($b->date)->format('d/m/Y') }}</td>
                                            <td class="font-bold">{{ $b->patient_name }}</td>
                                            <td><span class="badge badge-teal">{{ $b->pathology ?? '-' }}</span></td>
                                            <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $b->notes }}">{{ $b->notes ?? '-' }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn-action-preview" 
                                                        data-patient-name="{{ $b->patient_name }}"
                                                        data-date="{{ $b->date }}"
                                                        data-pathology="{{ $b->pathology ?? '' }}"
                                                        data-notes="{{ $b->notes ?? '' }}"
                                                        data-image-path="{{ asset($b->image_path) }}"
                                                        style="background: none; border: none; padding: 0; cursor: pointer; outline: none;"
                                                        title="Aperçu du bilan en PDF">
                                                    <img src="{{ asset($b->image_path) }}" alt="Aperçu" style="height: 40px; border-radius: 4px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); cursor: pointer;">
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <div style="display: flex; gap: 8px; justify-content: center;">
                                                    <button type="button" class="btn btn-action-download" 
                                                            data-patient-name="{{ $b->patient_name }}"
                                                            data-date="{{ $b->date }}"
                                                            data-pathology="{{ $b->pathology ?? '' }}"
                                                            data-notes="{{ $b->notes ?? '' }}"
                                                            data-image-path="{{ asset($b->image_path) }}"
                                                            style="background: #2b6cb0; color: white; padding: 6px 12px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px; border: none; border-radius: 4px; cursor: pointer;">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 13px; height: 13px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                                        Télécharger
                                                    </button>
                                                    <form action="{{ route('admin.bilans.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce bilan définitivement ?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn" style="background: #e53e3e; color: white; padding: 6px 12px; font-size: 0.8rem;">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="no-records-row">
                                            <td colspan="6" class="text-center text-gray py-4">
                                                <span class="fr">Aucun bilan enregistré dans la base de données.</span>
                                                <span class="ar">لم يتم تسجيل أي تقرير في قاعدة البيانات.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
        
    </div>

    <!-- MODAL: ADD SERVICE -->
    <div class="admin-modal" id="addServiceModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeAddServiceModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <span class="fr">Ajouter un nouveau service</span>
                    <span class="ar">إضافة خدمة جديدة</span>
                </h2>
                <button class="close-modal-btn" onclick="closeAddServiceModal()">&times;</button>
            </div>
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="add_title_fr">Titre (Français)</label>
                            <input type="text" name="title_fr" id="add_title_fr" class="form-control" required placeholder="Ex: Rééducation Neurologique">
                        </div>
                        <div class="form-group">
                            <label for="add_title_ar">العنوان (العربية)</label>
                            <input type="text" name="title_ar" id="add_title_ar" class="form-control" required placeholder="مثال: ترويض الجهاز العصبي">
                        </div>
                        <div class="form-group full-width">
                            <label for="add_desc_fr">Description (Français)</label>
                            <textarea name="desc_fr" id="add_desc_fr" class="form-control text-area" required placeholder="Courte description en français..."></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="add_desc_ar">الوصف (العربية)</label>
                            <textarea name="desc_ar" id="add_desc_ar" class="form-control text-area" required placeholder="وصف قصير باللغة العربية..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="add_phase">Phase</label>
                            <select name="phase" id="add_phase" class="form-control" required>
                                <option value="1">Phase 1: Kinésithérapie</option>
                                <option value="2">Phase 2: Rééducation Spécialisée</option>
                                <option value="3">Phase 3: Diagnostic & Suivi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_image">Image</label>
                            <input type="file" name="image" id="add_image" class="form-control file-input" required accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" onclick="closeAddServiceModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Créer</span>
                        <span class="ar">إضافة</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT SERVICE -->
    <div class="admin-modal" id="editServiceModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeEditServiceModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <span class="fr">Modifier la carte de service</span>
                    <span class="ar">تعديل الخدمة</span>
                </h2>
                <button class="close-modal-btn" onclick="closeEditServiceModal()">&times;</button>
            </div>
            <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_title_fr">Titre (Français)</label>
                            <input type="text" name="title_fr" id="edit_title_fr" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_title_ar">العنوان (العربية)</label>
                            <input type="text" name="title_ar" id="edit_title_ar" class="form-control" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="edit_desc_fr">Description (Français)</label>
                            <textarea name="desc_fr" id="edit_desc_fr" class="form-control text-area" required></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="edit_desc_ar">الوصف (العربية)</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control text-area" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_phase">Phase</label>
                            <select name="phase" id="edit_phase" class="form-control" required>
                                <option value="1">Phase 1: Kinésithérapie</option>
                                <option value="2">Phase 2: Rééducation Spécialisée</option>
                                <option value="3">Phase 3: Diagnostic & Suivi</option>
                            </select>
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 6px;">
                            <label for="edit_image">Image du Service</label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img id="edit_service_img_preview" src="" alt="Aperçu" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color); background: #f7fafc;">
                                <div style="flex: 1;">
                                    <input type="file" name="image" id="edit_image" class="form-control file-input" accept="image/*" style="width: 100%;">
                                    <small style="color: var(--text-gray); font-size: 0.72rem; margin-top: 4px; display: block;">L'image sera automatiquement téléchargée et mise à jour.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" onclick="closeEditServiceModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Enregistrer</span>
                        <span class="ar">حفظ التعديلات</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: CONFIGURE SERVICE DETAIL PAGE -->
    <div class="admin-modal" id="configurePageModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeConfigurePageModal()"></div>
        <div class="modal-content" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h2>
                    <span class="fr">Remplir la page de service</span>
                    <span class="ar">تعديل محتوى الصفحة التفصيلية</span>
                </h2>
                <button class="close-modal-btn" onclick="closeConfigurePageModal()">&times;</button>
            </div>
            <form id="configurePageForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div style="grid-column: 1 / -1; margin-bottom: 10px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                            <h3 style="color: var(--teal); font-size: 1.1rem; font-weight: 600; margin: 0;">En-tête de la Page (Hero Section)</h3>
                        </div>
                        <div class="form-group">
                            <label for="page_hero_title_fr">Titre Principal de l'En-tête (Français)</label>
                            <input type="text" name="hero_title_fr" id="page_hero_title_fr" class="form-control" placeholder="ex: Rééducation Fonctionnelle">
                        </div>
                        <div class="form-group">
                            <label for="page_hero_title_ar">العنوان الرئيسي للغلاف (العربية)</label>
                            <input type="text" name="hero_title_ar" id="page_hero_title_ar" class="form-control" placeholder="مثال: إعادة التأهيل الوظيفي" style="direction: rtl;">
                        </div>
                        <div class="form-group full-width">
                            <label for="page_hero_image">Image de l'En-tête (Hero Cover Image) - Laissez vide pour utiliser l'image de la carte</label>
                            <input type="file" name="hero_image" id="page_hero_image" class="form-control file-input" accept="image/*">
                            <div class="gallery-preview-wrapper" id="page_hero_image_preview"></div>
                        </div>
                        
                        <div class="form-group full-width" style="display: flex; align-items: center; gap: 10px; margin-top: 10px; margin-bottom: 15px;">
                            <input type="checkbox" name="show_rdv_btn" id="page_show_rdv_btn" value="1" style="width: 20px; height: 20px; cursor: pointer;">
                            <label for="page_show_rdv_btn" style="font-weight: 600; cursor: pointer; color: var(--navy-dark); user-select: none;">Activer le bouton de prise de Rendez-vous en bas de page</label>
                        </div>

                        <div style="grid-column: 1 / -1; margin-top: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                            <h3 style="color: var(--teal); font-size: 1.1rem; font-weight: 600; margin: 0;">Blocs de Présentation (Alternés Image / Texte)</h3>
                            <button type="button" class="btn btn-teal" onclick="addNewBlockRow()" style="padding: 6px 15px; font-size: 0.85rem; height: auto;">+ Ajouter un bloc</button>
                        </div>

                        <div id="blocks_container" class="full-width" style="grid-column: 1 / -1; display: flex; flex-direction: column; gap: 20px; margin-top: 15px;">
                            <!-- Dynamic block rows will be appended here via admin.js -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" onclick="closeConfigurePageModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Enregistrer</span>
                        <span class="ar">حفظ التعديلات</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT APPOINTMENT DATE/TIME -->
    <div class="admin-modal" id="editAppointmentModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeEditAppointmentModal()"></div>
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h2>
                    <span class="fr">Modifier la date/heure du rendez-vous</span>
                    <span class="ar">تعديل تاريخ/وقت الموعد</span>
                </h2>
                <button class="close-modal-btn" onclick="closeEditAppointmentModal()">&times;</button>
            </div>
            <form id="editAppointmentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grid" style="grid-template-columns: 1fr;">
                        <div class="form-group">
                            <label for="edit_appt_date">Date validée / التاريخ المؤكد</label>
                            <input type="date" name="date" id="edit_appt_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_appt_time">Heure validée / الوقت المؤكد</label>
                            <input type="time" name="time" id="edit_appt_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" onclick="closeEditAppointmentModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Enregistrer</span>
                        <span class="ar">حفظ</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: DETAILED APPOINTMENT VIEW & EDIT -->
    <div class="admin-modal" id="detailAppointmentModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeDetailAppointmentModal()"></div>
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h2>
                    <span class="fr">Détails et Modification du Rendez-vous</span>
                    <span class="ar">تفاصيل وتعديل الموعد</span>
                </h2>
                <button class="close-modal-btn" onclick="closeDetailAppointmentModal()">&times;</button>
            </div>
            
            <!-- Hidden Forms for inner actions -->
            <form id="modalAcceptForm" method="POST" style="display:none;">@csrf</form>
            <form id="modalDeleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>

            <form id="detailAppointmentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="det_firstname">Prénom / الاسم الشخصي</label>
                            <input type="text" name="firstname" id="det_firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="det_lastname">Nom / الاسم العائلي</label>
                            <input type="text" name="lastname" id="det_lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="det_age">Âge / السن</label>
                            <input type="number" name="age" id="det_age" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="det_gender">Genre / الجنس</label>
                            <select name="gender" id="det_gender" class="form-control" required>
                                <option value="homme">Homme / رجل</option>
                                <option value="femme">Femme / امرأة</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="det_phone">Téléphone / الهاتف</label>
                            <input type="text" name="phone" id="det_phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="det_email">Adresse E-mail / البريد الإلكتروني</label>
                            <input type="email" name="email" id="det_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="det_date">Date validée / التاريخ المؤكد</label>
                            <input type="date" name="date" id="det_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="det_time">Heure validée / الوقت المؤكد</label>
                            <input type="time" name="time" id="det_time" class="form-control" required>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Services demandés / الخدمات المطلوبة</label>
                            <div id="det_services_list" style="margin-top: 5px; display: flex; flex-wrap: wrap; gap: 8px;"></div>
                        </div>

                        <div class="form-group full-width">
                            <label for="det_description">Description / تفاصيل الإضافة</label>
                            <textarea name="description" id="det_description" class="form-control text-area" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; gap: 10px; justify-content: space-between; width: 100%;">
                    <div>
                        <button type="button" class="btn btn-blue" onclick="closeDetailAppointmentModal()">
                            <span class="fr">Annuler</span>
                            <span class="ar">إلغاء</span>
                        </button>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="btn" style="background-color: #e53e3e; color: white;" onclick="submitModalDelete()">
                            <span class="fr">Supprimer</span>
                            <span class="ar">حذف</span>
                        </button>
                        <button type="button" class="btn" style="background-color: #48bb78; color: white;" id="modalAcceptBtn" onclick="submitModalAccept()">
                            <span class="fr">Accepter & Client</span>
                            <span class="ar">قبول وإضافة كزبون</span>
                        </button>
                        <button type="submit" class="btn btn-teal">
                            <span class="fr">Enregistrer</span>
                            <span class="ar">حفظ التغييرات</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: ADD APPOINTMENT MANUALLY -->
    <div class="admin-modal" id="addAppointmentModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeAddAppointmentModal()"></div>
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h2>
                    <span class="fr">Ajouter un nouveau rendez-vous</span>
                    <span class="ar">إضافة موعد جديد</span>
                </h2>
                <button class="close-modal-btn" onclick="closeAddAppointmentModal()">&times;</button>
            </div>
            <form action="{{ route('admin.appointments.store_manual') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="add_appt_firstname">Prénom / الاسم الشخصي</label>
                            <input type="text" name="firstname" id="add_appt_firstname" class="form-control" required placeholder="Prénom">
                        </div>
                        <div class="form-group">
                            <label for="add_appt_lastname">Nom / الاسم العائلي</label>
                            <input type="text" name="lastname" id="add_appt_lastname" class="form-control" required placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <label for="add_appt_age">Âge / السن</label>
                            <input type="number" name="age" id="add_appt_age" class="form-control" required placeholder="Âge">
                        </div>
                        <div class="form-group">
                            <label for="add_appt_gender">Genre / الجنس</label>
                            <select name="gender" id="add_appt_gender" class="form-control" required>
                                <option value="homme">Homme / رجل</option>
                                <option value="femme">Femme / امرأة</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_appt_phone">Téléphone / الهاتف</label>
                            <input type="text" name="phone" id="add_appt_phone" class="form-control" required placeholder="Téléphone">
                        </div>
                        <div class="form-group">
                            <label for="add_appt_email">Adresse E-mail / البريد الإلكتروني</label>
                            <input type="email" name="email" id="add_appt_email" class="form-control" placeholder="Email (facultatif)">
                        </div>
                        <div class="form-group">
                            <label for="add_appt_date">Date / التاريخ</label>
                            <input type="date" name="date" id="add_appt_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="add_appt_time">Heure / الوقت</label>
                            <input type="time" name="time" id="add_appt_time" class="form-control" required>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Services demandés / الخدمات المطلوبة</label>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; margin-top: 5px; max-height: 150px; overflow-y: auto; padding: 5px; border: 1px solid var(--border-color); border-radius: 6px;">
                                @foreach($services as $svc)
                                    <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; color: var(--navy-dark);">
                                        <input type="checkbox" name="services[]" value="{{ $svc->title_fr }}">
                                        <span>{{ $svc->title_fr }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="add_appt_description">Description / تفاصيل إضافية</label>
                            <textarea name="description" id="add_appt_description" class="form-control text-area" rows="3" placeholder="Description (facultatif)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" onclick="closeAddAppointmentModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Créer</span>
                        <span class="ar">إضافة</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>

    <!-- MODAL: CLINICAL BILAN EDITOR STUDIO -->
    <div class="admin-modal" id="bilanEditorModal" style="display: none; z-index: 1100;">
        <div class="modal-backdrop Bilan-modal-close-trigger"></div>
        <div class="modal-content" style="max-width: 95vw; width: 1200px; height: 90vh; display: flex; flex-direction: column; padding: 0; overflow: hidden; border-radius: 12px; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            
            <!-- Header bar of Bilan Studio -->
            <div class="modal-header" style="background: var(--navy-dark); color: white; padding: 15px 25px; border-bottom: 2px solid var(--teal); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="background: rgba(26,188,156,0.15); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--teal-primary); flex-shrink: 0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 22px; height: 22px;">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: white;">
                            <span class="fr">Studio d'Édition Clinique</span>
                            <span class="ar">استوديو التخطيط الطبي</span>
                        </h2>
                        <span id="loaded_schema_name" style="font-size: 0.8rem; font-weight: 600; color: var(--teal); background: rgba(26,188,156,0.15); padding: 2px 8px; border-radius: 12px; margin-top: 4px; display: inline-block;">d1.jfif</span>
                    </div>
                </div>
                <button class="close-modal-btn Bilan-modal-close-trigger" style="color: white; font-size: 2rem; background: none; border: none; cursor: pointer; line-height: 1; transition: color 0.2s;">&times;</button>
            </div>

            <!-- Body of Bilan Studio (Split layout: Left = Form & Tools, Right = Large Workspace Canvas) -->
            <div class="modal-body" style="display: grid; grid-template-columns: 380px 1fr; flex: 1; min-height: 0; padding: 0; background: #f8fafc; overflow: hidden;">
                
                <!-- Left panel: Patient Form, Canvas Tools & Actions -->
                <div style="background: white; border-right: 1px solid var(--border-color); padding: 20px; display: flex; flex-direction: column; gap: 18px; overflow-y: auto; height: 100%; box-sizing: border-box;">
                    
                    <!-- Section: Patient Form -->
                    <div style="border-bottom: 1px solid #edf2f7; padding-bottom: 15px;">
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: var(--navy-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px;">Fiche Patient</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; display: block;">Nom & Prénom du Patient / الاسم</label>
                                <input type="text" id="bilan_patient_name" class="form-control" style="padding: 8px 12px; font-size: 0.9rem;" placeholder="Nom Complet du Patient (Facultatif)">
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; display: block;">Date du Bilan / التاريخ</label>
                                <input type="date" id="bilan_date" class="form-control" style="padding: 8px 12px; font-size: 0.9rem;" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; display: block;">Pathologie / التشخيص</label>
                                <input type="text" id="bilan_pathology" class="form-control" style="padding: 8px 12px; font-size: 0.9rem;" placeholder="Sciatique, Hémiplégie, Rhumatisme... (Facultatif)">
                            </div>
                            <div class="form-group" style="margin: 0;">
                                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; display: block;">Notes Cliniques / ملاحظات طبية</label>
                                <textarea id="bilan_notes" class="form-control text-area" style="padding: 8px 12px; font-size: 0.9rem;" rows="3" placeholder="Saisir vos observations cliniques ici... (Facultatif)"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Toolbar Options -->
                    <div style="border-bottom: 1px solid #edf2f7; padding-bottom: 15px;">
                        <h3 style="font-size: 0.9rem; font-weight: 700; color: var(--navy-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px;">Boîte à Outils</h3>
                        
                        <div class="tools-selector" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 12px;">
                            <button type="button" class="btn btn-blue tool-btn active" id="tool_draw" style="padding: 8px;">
                                <span class="fr">Dessin</span>
                                <span class="ar">رسم</span>
                            </button>
                            <button type="button" class="btn btn-blue tool-btn" id="tool_text" style="padding: 8px;">
                                <span class="fr">Texte</span>
                                <span class="ar">نص</span>
                            </button>
                            <button type="button" class="btn btn-blue tool-btn" id="tool_check" style="padding: 8px;">
                                <span class="fr">Cocher</span>
                                <span class="ar">تأشير</span>
                            </button>
                        </div>

                        <!-- Config Panel: Drawing -->
                        <div id="config_draw" class="tool-config-panel" style="display: block;">
                            <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 10px;">
                                <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-gray);">Couleur :</span>
                                <button type="button" class="color-dot active" data-color="red" style="background: red; border: 2px solid white; outline: 1px solid red; width: 18px; height: 18px; border-radius: 50%; cursor: pointer;"></button>
                                <button type="button" class="color-dot" data-color="blue" style="background: blue; border: 2px solid white; outline: none; width: 18px; height: 18px; border-radius: 50%; cursor: pointer;"></button>
                                <button type="button" class="color-dot" data-color="green" style="background: green; border: 2px solid white; outline: none; width: 18px; height: 18px; border-radius: 50%; cursor: pointer;"></button>
                                <button type="button" class="color-dot" data-color="black" style="background: black; border: 2px solid white; outline: none; width: 18px; height: 18px; border-radius: 50%; cursor: pointer;"></button>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600;">
                                    <span>Pinceau :</span>
                                    <span><span id="brush_val">3</span>px</span>
                                </div>
                                <input type="range" id="brush_size" min="1" max="15" value="3" style="width: 100%; cursor: pointer;">
                            </div>
                        </div>

                        <!-- Config Panel: Text -->
                        <div id="config_text" class="tool-config-panel" style="display: none;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div>
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-gray); display: block; margin-bottom: 4px;">Note à écrire (cliquez sur le schéma) :</label>
                                    <input type="text" id="text_input_val" class="form-control" style="padding: 6px 10px; font-size: 0.85rem;" value="Douleur" placeholder="ex: Sensibilité, Douleur">
                                </div>
                                <div>
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-gray); display: block; margin-bottom: 4px;">Police (Font) :</label>
                                    <select id="text_font_family" class="form-control" style="padding: 6px 10px; font-size: 0.85rem; cursor: pointer;">
                                        <option value="'Inter', sans-serif" style="font-family: 'Inter', sans-serif;">Inter</option>
                                        <option value="'Poppins', sans-serif" style="font-family: 'Poppins', sans-serif;">Poppins</option>
                                        <option value="'Cairo', sans-serif" style="font-family: 'Cairo', sans-serif;">Cairo</option>
                                        <option value="Arial, sans-serif" style="font-family: Arial, sans-serif;">Arial</option>
                                        <option value="'Times New Roman', serif" style="font-family: 'Times New Roman', serif;">Times New Roman</option>
                                        <option value="Georgia, serif" style="font-family: Georgia, serif;">Georgia</option>
                                        <option value="'Courier New', monospace" style="font-family: 'Courier New', monospace;">Courier New</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-gray); display: block; margin-bottom: 4px;">Style d'écriture :</label>
                                    <select id="text_font_style" class="form-control" style="padding: 6px 10px; font-size: 0.85rem; cursor: pointer;">
                                        <option value="bold">Gras (Bold)</option>
                                        <option value="normal">Normal (Regular)</option>
                                        <option value="italic">Italique (Italic)</option>
                                        <option value="bold italic">Gras Italique</option>
                                    </select>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600; margin-bottom: 2px;">
                                        <span>Taille :</span>
                                        <span><span id="text_size_val">16</span>px</span>
                                    </div>
                                    <input type="range" id="text_size_slider" min="10" max="40" value="16" style="width: 100%; cursor: pointer;">
                                </div>
                            </div>
                        </div>

                        <!-- Config Panel: Checkmarks -->
                        <div id="config_check" class="tool-config-panel" style="display: none;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-gray);">Type :</span>
                                <label style="display: flex; align-items: center; gap: 4px; font-weight: 600; cursor: pointer; color: green; font-size: 1rem;">
                                    <input type="radio" name="check_type" value="check" checked style="width: 16px; height: 16px;"> ✓
                                </label>
                                <label style="display: flex; align-items: center; gap: 4px; font-weight: 600; cursor: pointer; color: red; font-size: 1rem;">
                                    <input type="radio" name="check_type" value="cross" style="width: 16px; height: 16px;"> ✗
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: auto;">
                        <button type="button" id="btn_clear_canvas" class="btn btn-blue" style="background: #e53e3e; color: white; padding: 10px;">Réinitialiser le dessin</button>
                        <button type="button" id="btn_save_bilan" class="btn btn-teal" style="padding: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px;"><path d="M19 21H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            <span class="fr">Enregistrer le Bilan</span>
                            <span class="ar">حفظ التقرير</span>
                        </button>
                        <button type="button" id="btn_export_image" class="btn" style="background: #2b6cb0; color: white; padding: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            <span class="fr">Télécharger le PDF</span>
                            <span class="ar">تحميل PDF</span>
                        </button>
                    </div>
                </div>

                <!-- Right panel: Interactive Workspace -->
                <div style="display: flex; align-items: flex-start; justify-content: center; padding: 25px; overflow: auto; height: 100%; box-sizing: border-box; background: #e2e8f0; position: relative;">
                    
                    <!-- Statically Floating Undo & Redo Toolbar (Always visible in top-right) -->
                    <div style="position: absolute; top: 20px; right: 20px; z-index: 100; display: flex; gap: 10px; background: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.12); border: 1px solid var(--border-color);">
                        <button type="button" id="btn_undo" class="btn-undo-redo" title="Annuler (Retour en arrière) / Undo" style="background: #edf2f7; border: 1px solid #cbd5e0; border-radius: 8px; width: 46px; height: 46px; display: inline-flex; align-items: center; justify-content: center; cursor: not-allowed; opacity: 0.4; transition: all 0.2s; padding: 0;" disabled>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 24px; height: 24px; color: #4a5568;"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
                        </button>
                        <button type="button" id="btn_redo" class="btn-undo-redo" title="Rétablir (Aller en avant) / Redo" style="background: #edf2f7; border: 1px solid #cbd5e0; border-radius: 8px; width: 46px; height: 46px; display: inline-flex; align-items: center; justify-content: center; cursor: not-allowed; opacity: 0.4; transition: all 0.2s; padding: 0;" disabled>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 24px; height: 24px; color: #4a5568;"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </div>

                    <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); display: inline-block; margin-top: 40px; margin-bottom: 40px;">
                        <!-- Dynamic Canvas -->
                        <canvas id="bilanCanvas" width="600" height="650" style="background: white; border: 1px solid #cbd5e0; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: block; cursor: crosshair;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Print Layout Container for pdf generation -->
    <div id="bilanPrintWrapper" style="position: fixed; left: 0; top: 0; width: 750px; height: 0; overflow: hidden; z-index: -9999; opacity: 0; pointer-events: none; direction: ltr;">
        <div id="bilanPrintContainer" style="width: 750px; background: white; padding: 20px; font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif; box-sizing: border-box; color: #1a202c; line-height: 1.5; direction: ltr;">
            <!-- Clinique Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #319795; padding-bottom: 10px; margin-bottom: 15px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset('images/logos/logo1.png') }}" style="height: 60px; object-fit: contain;">
                    <div>
                        <h1 style="font-size: 1.15rem; font-weight: 800; color: #2d3748; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Centre Thérapeutique Privé </h1>
                        <p style="font-size: 0.85rem; font-weight: 700; color: #319795; margin: 2px 0 0 0;">Expérience de +20 ans</p>
                    </div>
                </div>
                <div style="text-align: right; font-size: 0.75rem; color: #718096; line-height: 1.3;">
                    <p style="margin: 0; font-weight: 600;">36, Av Mohammed V, 2ème étg, N° 3, Fès, Maroc</p>
                    <p style="margin: 2px 0 0 0;">Tél : 0535 94 18 08 / 0661 93 65 00</p>
                    <p style="margin: 2px 0 0 0;">E-mail : therapeutiquecentre@gmail.com</p>
                </div>
            </div>

            <!-- PDF Title -->
            <div style="text-align: center; margin-bottom: 15px;">
                <h2 style="font-size: 1.45rem; font-weight: 800; color: #1a202c; border: 1.5px solid #2d3748; padding: 6px 20px; display: inline-block; border-radius: 4px; background: #f7fafc; margin: 0; text-transform: uppercase;">Bilan Kinésithérapique</h2>
            </div>

            <!-- Patient info grid -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 0.88rem;">
                <tr>
                    <td style="padding: 4px 10px; border: 1px solid #cbd5e0; font-weight: 700; background: #edf2f7; width: 180px;">Nom & Prénom :</td>
                    <td style="padding: 4px 10px; border: 1px solid #cbd5e0; color: #2d3748;" id="pdf_patient_name">Jean Dupont</td>
                    <td style="padding: 4px 10px; border: 1px solid #cbd5e0; font-weight: 700; background: #edf2f7; width: 140px;">Date :</td>
                    <td style="padding: 4px 10px; border: 1px solid #cbd5e0; color: #2d3748; width: 160px;" id="pdf_date">06/07/2026</td>
                </tr>
                <tr>
                    <td style="padding: 4px 10px; border: 1px solid #cbd5e0; font-weight: 700; background: #edf2f7;">Pathologie / Diagnostic :</td>
                    <td colspan="3" style="padding: 4px 10px; border: 1px solid #cbd5e0; color: #2d3748;" id="pdf_pathology">Sciatique L5-S1 gauche</td>
                </tr>
            </table>

            <!-- Bilan Image diagram -->
            <div style="display: flex; justify-content: center; margin-bottom: 15px; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 5px;">
                <img id="pdf_bilan_image" src="" style="width: 100%; max-height: 650px; object-fit: contain;">
            </div>

            <!-- Clinical notes -->
            <div style="margin-bottom: 15px;" id="pdf_notes_container">
                <h3 style="font-size: 0.95rem; font-weight: 700; border-bottom: 1.5px solid #cbd5e0; padding-bottom: 2px; margin: 0 0 5px 0; color: #2d3748;">Observations cliniques & Plan de traitement</h3>
                <div style="font-size: 0.88rem; color: #2d3748; white-space: pre-line; background: #f7fafc; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7; min-height: 40px;" id="pdf_notes">
                    - Douleurs importantes à la pression.
                    - Plan de traitement à base de physiothérapie.
                </div>
            </div>

            <!-- Signature -->
            <div style="display: flex; justify-content: flex-end; margin-top: 15px; padding-right: 20px;">
                <div style="text-align: center; width: 220px;">
                    <p style="font-size: 0.82rem; font-weight: 700; margin: 0 0 50px 0; color: #4a5568;">Signature & Cachet du Praticien</p>
                    <div style="border-top: 1.5px solid #cbd5e0; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: UPLOAD SCHEMA -->
    <div class="admin-modal" id="uploadSchemaModal" style="display: none;">
        <div class="modal-backdrop" onclick="closeUploadSchemaModal()"></div>
        <div class="modal-content" style="max-width: 480px;">
            <div class="modal-header">
                <h2>
                    <span class="fr">Ajouter un nouveau schéma</span>
                    <span class="ar">إضافة مخطط جديد</span>
                </h2>
                <button class="close-modal-btn" onclick="closeUploadSchemaModal()">&times;</button>
            </div>
            <form action="{{ route('admin.schemas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="form-group">
                            <label for="schema_name">Nom du schéma (ex: Genou Gauche, d43)</label>
                            <input type="text" name="name" id="schema_name" class="form-control" required placeholder="Ex: Colonne Cervicale">
                        </div>
                        <div class="form-group">
                            <label for="schema_image">Image du schéma</label>
                            <input type="file" name="image" id="schema_image" class="form-control" required accept="image/*">
                            <span style="font-size: 0.75rem; color: var(--text-gray); margin-top: 4px; display: block;">Formats acceptés: PNG, JPG, JPEG, WEBP, JFIF. Taille max: 4Mo.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" class="btn btn-blue" onclick="closeUploadSchemaModal()">
                        <span class="fr">Annuler</span>
                        <span class="ar">إلغاء</span>
                    </button>
                    <button type="submit" class="btn btn-teal">
                        <span class="fr">Enregistrer</span>
                        <span class="ar">حفظ</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
