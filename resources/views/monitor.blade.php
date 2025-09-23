<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Absensi Real-time</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Vue.js untuk reaktivitas frontend --}}
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    {{-- Laravel Echo & Pusher JS untuk komunikasi real-time --}}
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Rajdhani', sans-serif; }
        .orbitron { font-family: 'Orbitron', monospace; }

        /* Cyber Background - Responsif */
        body {
            background: radial-gradient(ellipse at center, #0f0f23 0%, #000000 70%);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Animated Grid Background - Responsif */
        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(0, 255, 255, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 25px 25px; /* Dikecilkan untuk layar kecil */
            animation: gridMove 20s linear infinite;
            opacity: 0.3;
        }

        @media (min-width: 768px) {
            .cyber-grid {
                background-size: 50px 50px;
            }
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(25px, 25px); }
        }

        @media (min-width: 768px) {
            @keyframes gridMove {
                0% { transform: translate(0, 0); }
                100% { transform: translate(50px, 50px); }
            }
        }

        /* Elegant Glow Effects - Responsif */
        .neon-cyan {
            color: #64e5e5;
            text-shadow: 0 0 4px rgba(100, 229, 229, 0.4), 0 0 8px rgba(100, 229, 229, 0.2);
            background: linear-gradient(135deg, #64e5e5, #4dd0d0);
            background-clip: text;
            -webkit-background-clip: text;
            animation: gentleGlow 3s ease-in-out infinite;
        }

        @media (min-width: 768px) {
            .neon-cyan {
                text-shadow: 0 0 8px rgba(100, 229, 229, 0.4), 0 0 16px rgba(100, 229, 229, 0.2);
            }
        }

        .neon-pink {
            color: #e064e5;
            text-shadow: 0 0 4px rgba(224, 100, 229, 0.3), 0 0 8px rgba(224, 100, 229, 0.15);
            background: linear-gradient(135deg, #e064e5, #d04dd0);
            background-clip: text;
            -webkit-background-clip: text;
            animation: gentleGlow 3.5s ease-in-out infinite;
        }

        @media (min-width: 768px) {
            .neon-pink {
                text-shadow: 0 0 8px rgba(224, 100, 229, 0.3), 0 0 16px rgba(224, 100, 229, 0.15);
            }
        }

        .neon-green {
            color: #64e564;
            text-shadow: 0 0 4px rgba(100, 229, 100, 0.3), 0 0 8px rgba(100, 229, 100, 0.15);
            background: linear-gradient(135deg, #64e564, #4dd04d);
            background-clip: text;
            -webkit-background-clip: text;
        }

        @media (min-width: 768px) {
            .neon-green {
                text-shadow: 0 0 8px rgba(100, 229, 100, 0.3), 0 0 16px rgba(100, 229, 100, 0.15);
            }
        }

        .neon-orange {
            color: #e5a564;
            text-shadow: 0 0 4px rgba(229, 165, 100, 0.3), 0 0 8px rgba(229, 165, 100, 0.15);
            background: linear-gradient(135deg, #e5a564, #d0904d);
            background-clip: text;
            -webkit-background-clip: text;
        }

        @media (min-width: 768px) {
            .neon-orange {
                text-shadow: 0 0 8px rgba(229, 165, 100, 0.3), 0 0 16px rgba(229, 165, 100, 0.15);
            }
        }

        @keyframes timeGlow {
            0%, 100% {
                text-shadow: 0 0 5px rgba(100, 229, 229, 0.5), 0 0 10px rgba(100, 229, 229, 0.2);
            }
            50% {
                text-shadow: 0 0 8px rgba(100, 229, 229, 0.7), 0 0 15px rgba(100, 229, 229, 0.3);
            }
        }

        @media (min-width: 768px) {
            @keyframes timeGlow {
                0%, 100% {
                    text-shadow: 0 0 10px rgba(100, 229, 229, 0.5), 0 0 20px rgba(100, 229, 229, 0.2);
                }
                50% {
                    text-shadow: 0 0 15px rgba(100, 229, 229, 0.7), 0 0 30px rgba(100, 229, 229, 0.3);
                }
            }
        }

        /* Holographic Card - Responsif */
        .holo-card {
            background: linear-gradient(145deg,
                rgba(0, 255, 255, 0.05) 0%,
                rgba(255, 0, 255, 0.05) 25%,
                rgba(0, 255, 0, 0.05) 50%,
                rgba(255, 102, 0, 0.05) 75%,
                rgba(0, 255, 255, 0.05) 100%
            );
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 255, 0.3);
            box-shadow:
                0 0 10px rgba(0, 255, 255, 0.2),
                inset 0 0 10px rgba(255, 255, 255, 0.05);
            position: relative;
        }

        @media (min-width: 768px) {
            .holo-card {
                backdrop-filter: blur(15px);
                box-shadow:
                    0 0 20px rgba(0, 255, 255, 0.2),
                    inset 0 0 20px rgba(255, 255, 255, 0.05);
            }
        }

        .holo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Scanner Animation - Responsif */
        .scanner-line {
            position: relative;
            overflow: hidden;
        }

        .scanner-line::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            animation: scannerMove 2s ease-in-out infinite;
        }

        @keyframes scannerMove {
            0% { transform: translateY(-10px); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(80px); opacity: 0; }
        }

        @media (min-width: 768px) {
            @keyframes scannerMove {
                0% { transform: translateY(-10px); opacity: 0; }
                50% { opacity: 1; }
                100% { transform: translateY(120px); opacity: 0; }
            }
        }

        /* Popup Animations */
        .popup-enter-active {
            animation: popupEnter 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .popup-leave-active {
            animation: popupLeave 0.4s cubic-bezier(0.55, 0.06, 0.68, 0.19);
        }

        @keyframes popupEnter {
            0% {
                opacity: 0;
                transform: scale(0.3) rotateX(-90deg);
                filter: blur(10px);
            }
            50% {
                transform: scale(1.05) rotateX(-45deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotateX(0deg);
                filter: blur(0px);
            }
        }

        @keyframes popupLeave {
            0% {
                opacity: 1;
                transform: scale(1) rotateY(0deg);
            }
            100% {
                opacity: 0;
                transform: scale(0.7) rotateY(90deg);
                filter: blur(5px);
            }
        }

        /* Data Stream Effect - Hide on very small screens */
        .data-stream {
            position: fixed;
            top: 0;
            right: 0;
            width: 150px;
            height: 100vh;
            overflow: hidden;
            opacity: 0.1;
            pointer-events: none;
            display: none;
        }

        @media (min-width: 768px) {
            .data-stream {
                display: block;
                width: 200px;
            }
        }

        .stream-text {
            color: #00ff00;
            font-family: 'Courier New', monospace;
            font-size: 8px;
            animation: streamFlow 10s linear infinite;
        }

        @media (min-width: 768px) {
            .stream-text {
                font-size: 10px;
            }
        }

        @keyframes streamFlow {
            0% { transform: translateY(-100vh); }
            100% { transform: translateY(100vh); }
        }

        /* Status Indicators */
        .status-online {
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(0, 255, 0, 0.7);
            }
            50% {
                box-shadow: 0 0 0 5px rgba(0, 255, 0, 0);
            }
        }

        @media (min-width: 768px) {
            @keyframes pulse-green {
                0%, 100% {
                    box-shadow: 0 0 0 0 rgba(0, 255, 0, 0.7);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(0, 255, 0, 0);
                }
            }
        }

        /* Floating Particles - Hide on small screens */
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #00ffff;
            border-radius: 50%;
            animation: float-particle 8s linear infinite;
            display: none;
        }

        @media (min-width: 768px) {
            .particle {
                display: block;
            }
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* Logo Glow Effect */
        .logo-glow {
            filter: drop-shadow(0 0 5px rgba(0, 255, 255, 0.5));
            animation: logoFloat 3s ease-in-out infinite;
        }

        @media (min-width: 768px) {
            .logo-glow {
                filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.5));
            }
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        /* Responsive Text Sizes */
        .responsive-title {
            font-size: 1.5rem;
        }

        @media (min-width: 640px) {
            .responsive-title {
                font-size: 2rem;
            }
        }

        @media (min-width: 768px) {
            .responsive-title {
                font-size: 2.5rem;
            }
        }

        @media (min-width: 1024px) {
            .responsive-title {
                font-size: 3rem;
            }
        }

        @media (min-width: 1280px) {
            .responsive-title {
                font-size: 4rem;
            }
        }

        .responsive-subtitle {
            font-size: 1rem;
        }

        @media (min-width: 640px) {
            .responsive-subtitle {
                font-size: 1.25rem;
            }
        }

        @media (min-width: 768px) {
            .responsive-subtitle {
                font-size: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .responsive-subtitle {
                font-size: 2rem;
            }
        }

        @media (min-width: 1280px) {
            .responsive-subtitle {
                font-size: 2.5rem;
            }
        }

        /* Scanner Display Responsive */
        .scanner-display {
            width: 240px;
            height: 180px;
        }

        @media (min-width: 640px) {
            .scanner-display {
                width: 280px;
                height: 200px;
            }
        }

        @media (min-width: 768px) {
            .scanner-display {
                width: 320px;
                height: 220px;
            }
        }

        @media (min-width: 1024px) {
            .scanner-display {
                width: 320px;
                height: 224px;
            }
        }

        /* Responsive time display */
        .time-display {
            font-size: 1.25rem;
        }

        @media (min-width: 640px) {
            .time-display {
                font-size: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .time-display {
                font-size: 1.75rem;
            }
        }

        @media (min-width: 1024px) {
            .time-display {
                font-size: 2rem;
            }
        }

        /* Responsive popup */
        .popup-image {
            width: 80px;
            height: 80px;
        }

        @media (min-width: 640px) {
            .popup-image {
                width: 100px;
                height: 100px;
            }
        }

        @media (min-width: 768px) {
            .popup-image {
                width: 128px;
                height: 128px;
            }
        }

        .popup-time {
            font-size: 1.5rem;
        }

        @media (min-width: 640px) {
            .popup-time {
                font-size: 2rem;
            }
        }

        @media (min-width: 768px) {
            .popup-time {
                font-size: 2.5rem;
            }
        }

        /* Hide overflow on small screens */
        @media (max-width: 639px) {
            body {
                overflow-x: hidden;
            }
        }
    </style>
</head>
<body>
    <!-- Cyber Grid Background -->
    <div class="cyber-grid"></div>

    <!-- Floating Particles -->
    <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
    <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
    <div class="particle" style="left: 70%; animation-delay: 6s;"></div>
    <div class="particle" style="left: 90%; animation-delay: 1s;"></div>

    <!-- Data Stream -->
    <div class="data-stream">
        <div class="stream-text">
            01001000 01100101 01101100<br>
            01101100 01101111 00100000<br>
            01010111 01101111 01110010<br>
            01101100 01100100 00100001<br>
            11010011 10110101 01010101<br>
            10101010 11111000 00001111<br>
        </div>
    </div>

    <div id="app" class="relative z-10 min-h-screen flex flex-col justify-center p-2 sm:p-3 lg:p-4">
        <div class="w-full max-w-7xl mx-auto flex-1 flex flex-col justify-center">

            <!-- Main Header -->
            <header class="text-center mb-3 sm:mb-4 lg:mb-6">
                <div class="holo-card rounded-xl lg:rounded-2xl p-3 sm:p-4 lg:p-6 mb-3 sm:mb-4 lg:mb-6 relative">
                    <!-- Status Bar -->
                    <div class="absolute top-2 sm:top-4 right-2 sm:right-4 flex items-center space-x-1 sm:space-x-2">
                        <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-400 rounded-full status-online"></div>
                        <span class="text-green-400 text-xs sm:text-sm orbitron">SYSTEM ONLINE</span>
                    </div>

                    <!-- Logo Section -->
                    <div class="flex items-center justify-center mb-2 sm:mb-3 lg:mb-4">
                        <!-- Logo SMK Mahardhika -->
                        <img src="{{ asset('images/logo-smk-mahardhika.png') }}"
                             alt="Logo SMK Mahardhika"
                             class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 logo-glow">
                    </div>

                    <h1 class="orbitron text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black neon-cyan mb-1">SMK</h1>
                    <h1 class="orbitron text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black neon-cyan mb-1">MAHARDHIKA</h1>
                    <h2 class="orbitron text-xl sm:text-2xl lg:text-3xl font-bold neon-pink mb-2 sm:mb-3">SURABAYA</h2>
                    <div class="inline-block px-3 sm:px-4 lg:px-6 py-1 sm:py-2 border border-cyan-400 rounded-full">
                        <p class="neon-green text-xs sm:text-sm lg:text-base font-semibold">QUANTUM ATTENDANCE SYSTEM</p>
                    </div>
                </div>
            </header>

            <!-- Main Interface -->
            <main class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 flex-1">

                <!-- Scanner Interface -->
                <div class="lg:col-span-2">
                    <div class="holo-card rounded-xl lg:rounded-2xl p-3 sm:p-4 lg:p-6 scanner-line relative h-full">
                        <div class="text-center">
                            <h3 class="orbitron text-base sm:text-lg lg:text-xl font-bold neon-orange mb-3 sm:mb-4">RFID READER SCANNER</h3>

                            <!-- Scanner Display -->
                            <div class="relative mb-4 sm:mb-6">
                                <div class="w-60 h-44 sm:w-72 sm:h-52 lg:w-80 lg:h-56 mx-auto bg-black rounded-lg lg:rounded-xl border-2 border-cyan-400 relative overflow-hidden">
                                    <!-- Scanner Grid -->
                                    <div class="absolute inset-2 sm:inset-4 border border-cyan-400 rounded-lg opacity-50">
                                        <div class="w-full h-full relative">
                                            <!-- Crosshairs -->
                                            <div class="absolute top-1/2 left-0 w-full h-0.5 bg-cyan-400 opacity-60"></div>
                                            <div class="absolute left-1/2 top-0 w-0.5 h-full bg-cyan-400 opacity-60"></div>
                                            <!-- Corner Brackets -->
                                            <div class="absolute top-1 sm:top-2 left-1 sm:left-2 w-4 sm:w-6 h-4 sm:h-6 border-l-2 border-t-2 border-cyan-400"></div>
                                            <div class="absolute top-1 sm:top-2 right-1 sm:right-2 w-4 sm:w-6 h-4 sm:h-6 border-r-2 border-t-2 border-cyan-400"></div>
                                            <div class="absolute bottom-1 sm:bottom-2 left-1 sm:left-2 w-4 sm:w-6 h-4 sm:h-6 border-l-2 border-b-2 border-cyan-400"></div>
                                            <div class="absolute bottom-1 sm:bottom-2 right-1 sm:right-2 w-4 sm:w-6 h-4 sm:h-6 border-r-2 border-b-2 border-cyan-400"></div>
                                        </div>
                                    </div>
                                    <!-- Status Text -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-2 sm:mb-4 border-2 border-green-400 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <p class="neon-green text-xs sm:text-sm orbitron">SCANNER READY</p>
                                            <p class="text-cyan-400 text-xs">Place your card or finger</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="space-y-1 sm:space-y-2">
                                <div class="flex items-center justify-center space-x-2 sm:space-x-3">
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                                    <span class="text-cyan-300 text-xs sm:text-sm">RFID Scanner Active</span>
                                </div>
                                <div class="flex items-center justify-center space-x-2 sm:space-x-3">
                                    <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full animate-pulse animation-delay-500"></div>
                                    <span class="text-green-300 text-xs sm:text-sm">Fingerprint Reader Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time & Status Panel -->
                <div class="space-y-3 sm:space-y-4 lg:space-y-4">
                    <!-- Current Time -->
                    <div class="holo-card rounded-xl lg:rounded-2xl p-3 sm:p-4 lg:p-5">
                        <div class="text-center">
                            <p class="text-cyan-300 text-xs orbitron mb-1 sm:mb-2">SYSTEM TIME</p>
                            <div class="orbitron text-xl sm:text-2xl lg:text-3xl font-black text-cyan-200 mb-1 sm:mb-2"
                                 style="text-shadow: 0 0 10px rgba(100, 229, 229, 0.5), 0 0 20px rgba(100, 229, 229, 0.2);
                                        animation: timeGlow 2s ease-in-out infinite;"
                                 v-text="currentTime"></div>
                            <div class="text-pink-300 text-xs" v-text="currentDate"></div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="holo-card rounded-xl lg:rounded-2xl p-3 sm:p-4 lg:p-5">
                        <h4 class="orbitron text-sm sm:text-base lg:text-lg font-bold neon-orange mb-2 sm:mb-3">SYSTEM STATUS</h4>
                        <div class="space-y-1.5 sm:space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 text-xs sm:text-sm">Database</span>
                                <span class="neon-green text-xs">CONNECTED</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 text-xs sm:text-sm">Real-time</span>
                                <span class="neon-green text-xs">ACTIVE</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 text-xs sm:text-sm">Scanner</span>
                                <span class="neon-green text-xs">READY</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 text-xs sm:text-sm">Network</span>
                                <span class="neon-green text-xs">STABLE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Attendance Popup -->
        <transition name="popup">
            <div v-if="showPopup" class="fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-50 p-2 sm:p-4">
                <div class="holo-card rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 max-w-sm sm:max-w-lg w-full text-center relative">
                    <!-- Status Header -->
                    <div class="mb-4 sm:mb-6">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 mx-auto rounded-full flex items-center justify-center mb-3 sm:mb-4 relative"
                             :class="lastAttendance && lastAttendance.status === 'in' ? 'bg-green-500/20 border-2 border-green-400' : 'bg-red-500/20 border-2 border-red-400'">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12" :class="lastAttendance && lastAttendance.status === 'in' ? 'text-green-400' : 'text-red-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="lastAttendance && lastAttendance.status === 'in'" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4"/>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            </svg>
                            <div class="absolute -top-1 sm:-top-2 -right-1 sm:-right-2 w-4 h-4 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                 :class="lastAttendance && lastAttendance.status === 'in' ? 'bg-green-500' : 'bg-red-500'">
                                ✓
                            </div>
                        </div>
                        <div class="orbitron text-lg sm:text-xl lg:text-2xl font-bold" :class="lastAttendance && lastAttendance.status === 'in' ? 'neon-green' : 'neon-orange'">
                            <span v-if="lastAttendance && lastAttendance.status === 'in'">ACCESS GRANTED</span>
                            <span v-else>EXIT LOGGED</span>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="mb-4 sm:mb-6">
                        <div class="popup-image mx-auto mb-3 sm:mb-4 relative">
                            <img :src="lastAttendance ? lastAttendance.photo_url : ''" alt="Student Photo"
                                 class="w-full h-full rounded-full object-cover border-4"
                                 :class="lastAttendance && lastAttendance.status === 'in' ? 'border-green-400' : 'border-red-400'">
                            <div class="absolute inset-0 rounded-full border-2 border-cyan-400 animate-ping"></div>
                        </div>
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-2" v-text="lastAttendance ? lastAttendance.student_name : ''"></h2>
                        <div class="inline-block px-3 sm:px-4 py-1 border border-pink-400 rounded-full">
                            <p class="text-pink-400 font-medium text-sm sm:text-base" v-text="lastAttendance ? lastAttendance.class : ''"></p>
                        </div>
                    </div>

                    <!-- Time Display -->
                    <div class="bg-black/40 rounded-xl lg:rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6">
                        <p class="text-cyan-400 text-xs sm:text-sm orbitron mb-2">TIMESTAMP</p>
                        <p class="orbitron popup-time font-bold neon-cyan" v-text="lastAttendance ? lastAttendance.time : ''"></p>
                    </div>

                    <!-- Success Message -->
                    <div class="border rounded-xl lg:rounded-2xl p-3 sm:p-4" :class="lastAttendance && lastAttendance.status === 'in' ? 'border-green-400 bg-green-500/10' : 'border-red-400 bg-red-500/10'">
                        <p class="font-bold text-sm sm:text-base" :class="lastAttendance && lastAttendance.status === 'in' ? 'text-green-400' : 'text-red-400'">
                            ATTENDANCE RECORDED SUCCESSFULLY
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </div>

    <script>
        // Mengambil variabel dari backend Laravel
        const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
        const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

        // Aktifkan log console Pusher untuk debugging
        Pusher.logToConsole = true;

        const { createApp } = Vue

        createApp({
            data() {
                return {
                    currentTime: '',
                    currentDate: '',
                    showPopup: false,
                    lastAttendance: null,
                    popupTimer: null
                }
            },
            methods: {
                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },
                listenForEvents() {
                    console.log('Mencoba menginisialisasi Echo dengan Key:', pusherKey);
                    // Inisialisasi Laravel Echo
                    window.Echo = new Echo({
                        broadcaster: 'pusher',
                        key: pusherKey,
                        cluster: pusherCluster,
                        forceTLS: true
                    });
                    console.log('Echo diinisialisasi.', window.Echo);

                    window.Echo.connector.pusher.connection.bind('state_change', function(states) {
                        // states = {previous: 'oldState', current: 'newState'}
                        console.log("Pusher state changed from " + states.previous + " to " + states.current);
                    });

                    // Mendengarkan channel dan event
                    console.log('Mencoba mendengarkan channel: attendance-channel');
                    window.Echo.channel('attendance-channel')
                        .listen('.new-attendance-event', (e) => {
                            console.log('--- EVENT DITERIMA! ---', e);
                            this.lastAttendance = e.attendanceData;
                            this.showPopup = true;

                            if (this.popupTimer) {
                                clearTimeout(this.popupTimer);
                            }

                            this.popupTimer = setTimeout(() => {
                                this.showPopup = false;
                            }, 5000);
                        });
                }
            },
            mounted() {
                this.updateTime();
                setInterval(this.updateTime, 1000);
                this.listenForEvents();
            }
        }).mount('#app')
    </script>
</body>
</html>
