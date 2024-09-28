 <style>
     /* Global styles */
     body {
         font-family: 'Arial', sans-serif;
         background-color: #f4f6f9;
     }

     /* About header with background */
     .about-header {
         background: url('{{ asset('adminlte/img/bg-m.gif') }}') no-repeat center center;
         background-size: cover;
         color: white;
         padding: 100px 0;
         text-align: center;
     }

     .about-header h1 {
         font-size: 3.5rem;
         font-weight: bold;
         text-transform: uppercase;
     }

     .about-header p {
         font-size: 1.25rem;
         font-style: italic;
     }

     .about-section {
         padding: 60px 0;
     }

     .about-section h2 {
         text-align: center;
         font-size: 2.5rem;
         font-weight: bold;
         margin-bottom: 40px;
     }

     .about-content {
         font-size: 1.1rem;
         line-height: 1.8;
         color: #555;
     }

     /* Features section */
     .features-section {
         background-color: #f9f9f9;
         padding: 60px 0;
     }

     .features-section h2 {
         text-align: center;
         font-size: 2.5rem;
         font-weight: bold;
         margin-bottom: 40px;
     }

     .feature-box {
         padding: 20px;
         border-radius: 10px;
         background-color: white;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         transition: transform 0.3s ease;
     }

     .feature-box:hover {
         transform: translateY(-10px);
     }

     .feature-icon {
         font-size: 3rem;
         color: #f39c12;
     }

     .feature-title {
         margin-top: 15px;
         font-size: 1.5rem;
         font-weight: bold;
     }

     .feature-description {
         margin-top: 10px;
         color: #666;
         font-size: 1rem;
     }

     /* Team section */
     .team-section {
         padding: 60px 0;
     }

     .team-member {
         text-align: center;
     }

     .team-member img {
         border-radius: 50%;
         width: 150px;
         height: 150px;
     }

     .team-member h5 {
         margin-top: 15px;
         font-size: 1.25rem;
         font-weight: bold;
     }

     .team-member p {
         color: #666;
         font-size: 1rem;
     }

     /* Loading screen */
     .loading-screen {
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgb(255, 255, 255);
         z-index: 9999;
     }

     .logo {
         width: 150px;
         margin-bottom: 20px;
     }

     .progress-text {
         font-size: 2rem;
         margin-bottom: 20px;
     }

     .progress-bar {
         width: 80%;
         height: 20px;
         background-color: #e0e0e0;
         border-radius: 10px;
         overflow: hidden;
     }

     .progress-bar-fill {
         height: 100%;
         background-color: #3498db;
         width: 0;
         transition: width 0.2s;
     }

     #content {
         visibility: hidden;
     }
 </style>
 @extends('layouts.main')

 @section('content')
     <!-- About Section -->
     <div class="about-header" id="content">
         <h1>Welcome to B'MINE</h1>
         <p>Your trusted solution for Mining Identity and Number Management</p>
         <div id="countdown-timer" class="countdown"></div>
     </div>

     <div class="container-fluid about-section">
         <h2>About B'MINE</h2>
         <p class="about-content text-center">
             <strong>B'Mine</strong> adalah sebuah aplikasi inovatif yang dirancang khusus untuk mempermudah pengelolaan
             <strong>SIPER</strong> (Safety, Identity, and Permit) serta <strong>Mine Permit</strong> di area pertambangan.
             Aplikasi ini dikembangkan untuk mendukung operasional kontraktor <strong>Bukit Makmur Mandiri Utama
                 (BUMA)</strong>, salah satu kontraktor tambang terbesar di Indonesia.

         </p>
     </div>
 @endsection

 @section('scripts')
 @endsection
