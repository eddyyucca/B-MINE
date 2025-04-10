@extends('layouts.main')

@section('content')
    <style>
        /* Hero Section Styles */
        .hero-section {
            background: linear-gradient(135deg, #3f6791 0%, #1a2a3a 100%);
            color: #fff;
            padding: 80px 0;
            text-align: center;
            border-radius: 0 0 50% 50% / 20px;
            margin-bottom: 60px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .language-switch {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 5px;
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .lang-btn {
            border: none;
            background: transparent;
            color: #fff;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lang-btn.active {
            background: #28a745;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .countdown {
            background: rgba(255, 255, 255, 0.1);
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
            font-size: 1.2rem;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* About Content Styles */
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 2rem;
            color: #3f6791;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #28a745;
        }

        .about-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
            margin-bottom: 40px;
            text-align: justify;
        }

        .highlight {
            color: #28a745;
            font-weight: 600;
        }

        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .feature-card {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: #3f6791;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #343a40;
        }

        .feature-description {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .developer-section {
            background: #f8f9fa;
            padding: 50px 0;
            margin-top: 50px;
            text-align: center;
            border-radius: 10px;
        }

        .developer-title {
            font-size: 1.5rem;
            color: #343a40;
            margin-bottom: 30px;
        }

        .developer-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        .developer-info {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .developer-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 30px;
            border: 5px solid #3f6791;
        }

        .developer-details {
            text-align: left;
        }

        .developer-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #3f6791;
        }

        .developer-role {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .social-links {
            margin-top: 15px;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            text-decoration: none;
            color: #495057;
            transition: color 0.3s ease;
        }

        .social-link:hover {
            color: #3f6791;
        }

        .social-icon {
            margin-right: 5px;
            font-size: 1.2rem;
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="language-switch">
                <button id="en-btn" class="lang-btn active">English</button>
                <button id="id-btn" class="lang-btn">Indonesia</button>
            </div>
            <h1 class="hero-title">Welcome to B'MINE</h1>
            <p class="hero-subtitle">Advanced Mining Identity and Permit Management System</p>
            <div id="countdown-timer" class="countdown">Enhancing Safety and Efficiency in Mining Operations</div>
        </div>
    </div>

    <!-- About Content -->
    <div class="about-container">
        <h2 class="section-title">About B'MINE</h2>
        <p class="about-content">
            <span class="highlight">B'MINE</span> (Mining Identity Number Electronic) is an innovative solution
            specifically designed to streamline and enhance the management of <span class="highlight">SIMPER</span> (Safety,
            Identity, and Permit) and <span class="highlight">Mine Permit</span> systems in mining operations.

            Developed to support the operational excellence of <span class="highlight">Bukit Makmur Mandiri Utama
                (BUMA)</span>, one of Indonesia's largest mining contractors, B'MINE represents the next generation of
            digital transformation in the mining industry.
        </p>

        <p class="about-content">
            Our platform integrates advanced digital solutions with practical, on-site requirements to create a seamless,
            efficient, and secure permit management system. By digitalizing traditional permit processes, B'MINE reduces
            administrative overhead, minimizes errors, and provides real-time insights into compliance status across mining
            operations.
        </p>

        <!-- Features Section -->
        <div class="features-section">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Enhanced Safety</h3>
                <p class="feature-description">Ensures all personnel have proper documentation and qualifications before
                    accessing mining areas, significantly reducing safety risks.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h3 class="feature-title">Operational Efficiency</h3>
                <p class="feature-description">Streamlines permit application, review, and approval processes, reducing wait
                    times and administrative bottlenecks.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Data Analytics</h3>
                <p class="feature-description">Provides comprehensive insights through real-time dashboards showing permit
                    status, compliance levels, and operational metrics.</p>
            </div>
        </div>
    </div>

    <!-- Developer Section -->
    <div class="developer-section">
        <div class="about-container">
            <h2 class="developer-title">Meet the Developer</h2>
            <div class="developer-card">
                <div class="developer-info">
                    {{-- <img src="/api/placeholder/120/120" alt="Eddy Adha Saputra" class="developer-photo"> --}}
                    <div class="developer-details">
                        <h3 class="developer-name">Eddy Adha Saputra</h3>
                        <p class="developer-role">Lead Application Developer</p>
                        <p>Passionate about creating innovative solutions for the mining industry with a focus on safety and
                            operational excellence.</p>
                        <div class="social-links">
                            <a href="https://github.com/eddyyucca" target="_blank" class="social-link">
                                <i class="fab fa-github social-icon"></i> github.com/eddyyucca
                            </a>
                            <a href="https://www.linkedin.com/in/eddyyucca/" target="_blank" class="social-link">
                                <i class="fab fa-linkedin social-icon"></i> linkedin.com/in/eddyyucca
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Language switch functionality
            const enBtn = document.getElementById('en-btn');
            const idBtn = document.getElementById('id-btn');

            // Text content for both languages
            const content = {
                en: {
                    heroTitle: "Welcome to B'MINE",
                    heroSubtitle: "Advanced Mining Identity and Permit Management System",
                    messages: [
                        "Enhancing Safety and Efficiency in Mining Operations",
                        "Streamlining Permit Management Processes",
                        "Ensuring Compliance and Security"
                    ],
                    sectionTitle: "About B'MINE",
                    aboutContent1: "<span class=\"highlight\">B'MINE</span> (Mining Identity Number Electronic) is an innovative solution specifically designed to streamline and enhance the management of <span class=\"highlight\">SIMPER</span> (Safety, Identity, and Permit) and <span class=\"highlight\">Mine Permit</span> systems in mining operations. Developed to support the operational excellence of <span class=\"highlight\">Bukit Makmur Mandiri Utama (BUMA)</span>, one of Indonesia's largest mining contractors, B'MINE represents the next generation of digital transformation in the mining industry.",
                    aboutContent2: "Our platform integrates advanced digital solutions with practical, on-site requirements to create a seamless, efficient, and secure permit management system. By digitalizing traditional permit processes, B'MINE reduces administrative overhead, minimizes errors, and provides real-time insights into compliance status across mining operations.",
                    featureTitle1: "Enhanced Safety",
                    featureDesc1: "Ensures all personnel have proper documentation and qualifications before accessing mining areas, significantly reducing safety risks.",
                    featureTitle2: "Operational Efficiency",
                    featureDesc2: "Streamlines permit application, review, and approval processes, reducing wait times and administrative bottlenecks.",
                    featureTitle3: "Data Analytics",
                    featureDesc3: "Provides comprehensive insights through real-time dashboards showing permit status, compliance levels, and operational metrics.",
                    developerTitle: "Meet the Developer",
                    developerName: "Eddy Adha Saputra",
                    developerRole: "Lead Application Developer",
                    developerDesc: "Passionate about creating innovative solutions for the mining industry with a focus on safety and operational excellence."
                },
                id: {
                    heroTitle: "Selamat Datang di B'MINE",
                    heroSubtitle: "Sistem Pengelolaan Identitas dan Perizinan Tambang Terdepan",
                    messages: [
                        "Meningkatkan Keselamatan dan Efisiensi Operasi Tambang",
                        "Menyederhanakan Proses Manajemen Perizinan",
                        "Memastikan Kepatuhan dan Keamanan"
                    ],
                    sectionTitle: "Tentang B'MINE",
                    aboutContent1: "<span class=\"highlight\">B'MINE</span> (Mining Identity Number Electronic) adalah solusi inovatif yang dirancang khusus untuk menyederhanakan dan meningkatkan pengelolaan sistem <span class=\"highlight\">SIMPER</span> (Safety, Identity, and Permit) dan <span class=\"highlight\">Mine Permit</span> di operasi pertambangan. Dikembangkan untuk mendukung keunggulan operasional <span class=\"highlight\">Bukit Makmur Mandiri Utama (BUMA)</span>, salah satu kontraktor tambang terbesar di Indonesia, B'MINE mewakili transformasi digital generasi berikutnya dalam industri pertambangan.",
                    aboutContent2: "Platform kami mengintegrasikan solusi digital canggih dengan kebutuhan praktis di lokasi untuk menciptakan sistem manajemen perizinan yang mulus, efisien, dan aman. Dengan mendigitalkan proses perizinan tradisional, B'MINE mengurangi beban administratif, meminimalkan kesalahan, dan memberikan wawasan real-time tentang status kepatuhan di seluruh operasi pertambangan.",
                    featureTitle1: "Keamanan Ditingkatkan",
                    featureDesc1: "Memastikan semua personel memiliki dokumentasi dan kualifikasi yang tepat sebelum mengakses area tambang, secara signifikan mengurangi risiko keselamatan.",
                    featureTitle2: "Efisiensi Operasional",
                    featureDesc2: "Menyederhanakan proses aplikasi, peninjauan, dan persetujuan izin, mengurangi waktu tunggu dan hambatan administratif.",
                    featureTitle3: "Analisis Data",
                    featureDesc3: "Memberikan wawasan komprehensif melalui dashboard real-time yang menunjukkan status izin, tingkat kepatuhan, dan metrik operasional.",
                    developerTitle: "Kenali Pengembang",
                    developerName: "Eddy Adha Saputra",
                    developerRole: "Pengembang Aplikasi Utama",
                    developerDesc: "Bersemangat dalam menciptakan solusi inovatif untuk industri pertambangan dengan fokus pada keselamatan dan keunggulan operasional."
                }
            };

            // Elements to update
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle');
            const sectionTitle = document.querySelector('.section-title');
            const aboutContent = document.querySelectorAll('.about-content');
            const featureTitles = document.querySelectorAll('.feature-title');
            const featureDescs = document.querySelectorAll('.feature-description');
            const developerTitle = document.querySelector('.developer-title');
            const developerName = document.querySelector('.developer-name');
            const developerRole = document.querySelector('.developer-role');
            const developerDesc = document.querySelector('.developer-details p:not(.developer-role)');

            // Switch to Indonesian
            idBtn.addEventListener('click', function() {
                enBtn.classList.remove('active');
                idBtn.classList.add('active');

                heroTitle.textContent = content.id.heroTitle;
                heroSubtitle.textContent = content.id.heroSubtitle;
                sectionTitle.textContent = content.id.sectionTitle;

                aboutContent[0].innerHTML = content.id.aboutContent1;
                aboutContent[1].innerHTML = content.id.aboutContent2;

                featureTitles[0].textContent = content.id.featureTitle1;
                featureTitles[1].textContent = content.id.featureTitle2;
                featureTitles[2].textContent = content.id.featureTitle3;

                featureDescs[0].textContent = content.id.featureDesc1;
                featureDescs[1].textContent = content.id.featureDesc2;
                featureDescs[2].textContent = content.id.featureDesc3;

                developerTitle.textContent = content.id.developerTitle;
                developerName.textContent = content.id.developerName;
                developerRole.textContent = content.id.developerRole;
                developerDesc.textContent = content.id.developerDesc;

                // Update countdown messages
                messages = content.id.messages;
                countdownElement.textContent = messages[currentIndex];
            });

            // Switch to English
            enBtn.addEventListener('click', function() {
                idBtn.classList.remove('active');
                enBtn.classList.add('active');

                heroTitle.textContent = content.en.heroTitle;
                heroSubtitle.textContent = content.en.heroSubtitle;
                sectionTitle.textContent = content.en.sectionTitle;

                aboutContent[0].innerHTML = content.en.aboutContent1;
                aboutContent[1].innerHTML = content.en.aboutContent2;

                featureTitles[0].textContent = content.en.featureTitle1;
                featureTitles[1].textContent = content.en.featureTitle2;
                featureTitles[2].textContent = content.en.featureTitle3;

                featureDescs[0].textContent = content.en.featureDesc1;
                featureDescs[1].textContent = content.en.featureDesc2;
                featureDescs[2].textContent = content.en.featureDesc3;

                developerTitle.textContent = content.en.developerTitle;
                developerName.textContent = content.en.developerName;
                developerRole.textContent = content.en.developerRole;
                developerDesc.textContent = content.en.developerDesc;

                // Update countdown messages
                messages = content.en.messages;
                countdownElement.textContent = messages[currentIndex];
            });

            // Rotating messages for countdown timer
            const countdownElement = document.getElementById('countdown-timer');
            let messages = content.en.messages;
            let currentIndex = 0;

            // Change message every 5 seconds
            setInterval(() => {
                currentIndex = (currentIndex + 1) % messages.length;
                // Fade out
                countdownElement.style.opacity = 0;

                // Change text and fade in after a short delay
                setTimeout(() => {
                    countdownElement.textContent = messages[currentIndex];
                    countdownElement.style.opacity = 1;
                }, 500);
            }, 5000);

            // Initialize with fade in
            countdownElement.style.transition = "opacity 0.5s ease";
            countdownElement.style.opacity = 1;
        });
    </script>
@endsection
