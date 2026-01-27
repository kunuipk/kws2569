<!doctype html>
<html lang="th" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HFMD WEB - ระบบตรวจโรคมือ เท้า ปาก</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="/_sdk/data_sdk.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <style>
        body {
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #FFE5B4 0%, #FFCCE5 25%, #E5CCFF 50%, #CCE5FF 75%, #CCFFE5 100%);
        }
        
        .card-gradient {
            background: linear-gradient(145deg, rgba(255,255,255,0.95) 0%, rgba(255,240,245,0.9) 100%);
        }
        
        .btn-hand {
            background: linear-gradient(135deg, #FF9A8B 0%, #FF6B95 100%);
        }
        
        .btn-foot {
            background: linear-gradient(135deg, #89CFF0 0%, #5DADE2 100%);
        }
        
        .btn-mouth {
            background: linear-gradient(135deg, #98FB98 0%, #66CDAA 100%);
        }
        
        .btn-start {
            background: linear-gradient(135deg, #FFD93D 0%, #FF9500 100%);
        }
        
        .btn-stop {
            background: linear-gradient(135deg, #FF6B6B 0%, #EE5A5A 100%);
        }
        
        .webcam-container {
            background: linear-gradient(145deg, #2D3748 0%, #1A202C 100%);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
                        inset 0 0 0 4px rgba(255,255,255,0.1);
        }
        
        .result-card {
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-5px);
        }
        
        .timer-display {
            background: linear-gradient(145deg, #667EEA 0%, #764BA2 100%);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .rainbow-border {
            background: linear-gradient(90deg, #FF6B6B, #FFD93D, #66CDAA, #5DADE2, #9B59B6, #FF6B6B);
            background-size: 400% 400%;
            animation: gradient 3s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .tab-active {
            background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
            color: white;
            transform: scale(1.05);
        }
        
        .status-safe {
            background: linear-gradient(135deg, #66CDAA 0%, #3CB371 100%);
        }
        
        .status-warning {
            background: linear-gradient(135deg, #FFD93D 0%, #FFA500 100%);
        }
        
        .status-danger {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 100%);
        }
        
        .instructions-card {
            background: linear-gradient(145deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }
    </style>
  <style>@view-transition { navigation: auto; }</style>
 </head>
 <body class="h-full gradient-bg">
  <div class="h-full w-full overflow-auto">
   <div class="min-h-full flex flex-col px-4 py-6"><!-- Header -->
    <header class="text-center mb-6"><img id="logo-img" src=" https://drive.google.com/file/d/1tVP2kh5nd5DLXNkTn10U1f_nK59kEzWS/view?usp=sharing" alt="HFMD Logo" class="mx-auto float-animation" style="max-width: 140px;" loading="lazy" onerror="console.error('Image failed to load:', this.src); this.style.background='linear-gradient(135deg, #667EEA 0%, #764BA2 100%)'; this.style.borderRadius='20px'; this.style.padding='20px'; this.alt='HFMD WEB';">
     <h1 id="system-title" class="text-3xl md:text-4xl font-bold mt-4 bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 bg-clip-text text-transparent">HFMD WEB</h1>
     <p class="text-gray-600 mt-2 text-lg">ระบบตรวจคัดกรองโรคมือ เท้า ปาก ด้วย AI</p><!-- User Counter -->
     <div class="mt-3 inline-flex items-center gap-2 bg-white/80 px-4 py-2 rounded-full shadow-md"><span class="text-gray-700">จำนวนผู้ใช้งาน:</span> <span id="user-count" class="font-bold text-purple-600 text-xl">0</span> <span class="text-gray-700">คน</span>
     </div>
    </header><!-- Main Content -->
    <main class="flex-1 max-w-6xl mx-auto w-full"><!-- Tab Navigation -->
     <div class="flex justify-center gap-2 md:gap-4 mb-6 flex-wrap"><button onclick="switchTab('hand')" id="tab-hand" class="tab-btn px-6 py-3 rounded-full font-semibold text-white shadow-lg transition-all duration-300 btn-hand"> ตรวจมือ </button> <button onclick="switchTab('foot')" id="tab-foot" class="tab-btn px-6 py-3 rounded-full font-semibold text-white shadow-lg transition-all duration-300 btn-foot"> ตรวจเท้า </button> <button onclick="switchTab('mouth')" id="tab-mouth" class="tab-btn px-6 py-3 rounded-full font-semibold text-white shadow-lg transition-all duration-300 btn-mouth"> ตรวจปาก </button>
     </div><!-- Timer Display -->
     <div class="text-center mb-6">
      <div class="timer-display inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white shadow-xl"><span class="text-lg">เวลา:</span> <span id="timer" class="text-4xl font-bold tabular-nums">00</span> <span class="text-lg">วินาที</span>
      </div>
     </div><!-- Camera Section -->
     <div class="flex flex-col lg:flex-row gap-6 items-center justify-center"><!-- Webcam -->
      <div class="webcam-container p-4 rounded-3xl">
       <div class="relative">
        <div id="webcam-placeholder" class="w-[300px] h-[300px] md:w-[400px] md:h-[400px] lg:w-[500px] lg:h-[500px] bg-gray-800 rounded-2xl flex flex-col items-center justify-center text-white">
         <p class="text-lg">กดปุ่ม "เริ่มตรวจ" เพื่อเปิดกล้อง</p>
        </div>
        <div id="webcam-container" class="hidden">
         <canvas id="canvas" class="rounded-2xl"></canvas>
        </div><!-- Current Mode Indicator -->
        <div id="mode-indicator" class="absolute top-4 left-4 bg-white/90 px-4 py-2 rounded-full shadow-lg"><span id="mode-text" class="font-semibold text-gray-700">กำลังตรวจ: มือ</span>
        </div>
       </div>
      </div><!-- Results Panel -->
      <div class="w-full lg:w-80 space-y-4"><!-- Hand Result -->
       <div id="result-hand" class="result-card card-gradient p-4 rounded-2xl shadow-lg border-l-4 border-pink-400">
        <div class="flex items-center gap-3 mb-2">
         <h3 class="font-bold text-lg text-gray-700">ผลตรวจมือ</h3>
        </div>
        <div id="hand-status" class="text-center py-3 rounded-xl bg-gray-100 text-gray-500">
         รอการตรวจ...
        </div>
        <div id="hand-confidence" class="mt-2 text-sm text-gray-500 text-center">
         ความมั่นใจ: --%
        </div>
       </div><!-- Foot Result -->
       <div id="result-foot" class="result-card card-gradient p-4 rounded-2xl shadow-lg border-l-4 border-blue-400">
        <div class="flex items-center gap-3 mb-2">
         <h3 class="font-bold text-lg text-gray-700">ผลตรวจเท้า</h3>
        </div>
        <div id="foot-status" class="text-center py-3 rounded-xl bg-gray-100 text-gray-500">
         รอการตรวจ...
        </div>
        <div id="foot-confidence" class="mt-2 text-sm text-gray-500 text-center">
         ความมั่นใจ: --%
        </div>
       </div><!-- Mouth Result -->
       <div id="result-mouth" class="result-card card-gradient p-4 rounded-2xl shadow-lg border-l-4 border-green-400">
        <div class="flex items-center gap-3 mb-2">
         <h3 class="font-bold text-lg text-gray-700">ผลตรวจปาก</h3>
        </div>
        <div id="mouth-status" class="text-center py-3 rounded-xl bg-gray-100 text-gray-500">
         รอการตรวจ...
        </div>
        <div id="mouth-confidence" class="mt-2 text-sm text-gray-500 text-center">
         ความมั่นใจ: --%
        </div>
       </div><!-- Overall Result -->
       <div id="overall-result" class="result-card bg-gradient-to-r from-purple-500 to-pink-500 p-4 rounded-2xl shadow-lg text-white">
        <div class="flex items-center gap-3 mb-2">
         <h3 class="font-bold text-lg">ผลสรุปรวม</h3>
        </div>
        <div id="overall-status" class="text-center py-3 rounded-xl bg-white/20 font-bold text-xl">
         รอผลการตรวจ
        </div>
       </div>
      </div>
     </div><!-- Control Buttons -->
     <div class="flex justify-center gap-4 mt-8 flex-wrap"><button onclick="startDetection()" id="btn-start" class="btn-start px-8 py-4 rounded-full font-bold text-white text-xl shadow-lg hover:scale-105 transition-all duration-300"> เริ่มตรวจ </button> <button onclick="stopDetection()" id="btn-stop" class="btn-stop px-8 py-4 rounded-full font-bold text-white text-xl shadow-lg hover:scale-105 transition-all duration-300 opacity-50 cursor-not-allowed" disabled> หยุด </button> <button onclick="resetAll()" class="bg-gradient-to-r from-gray-400 to-gray-500 px-8 py-4 rounded-full font-bold text-white text-xl shadow-lg hover:scale-105 transition-all duration-300"> เริ่มใหม่ </button>
     </div><!-- Instructions -->
     <div class="instructions-card mt-8 p-6 rounded-2xl border-2 border-purple-200">
      <h3 class="text-xl font-bold text-purple-700 mb-4">วิธีใช้งาน</h3>
      <div class="grid md:grid-cols-3 gap-4">
       <div class="bg-white/80 p-4 rounded-xl">
        <div class="text-2xl font-bold text-purple-600 mb-2">
         ขั้นตอนที่ 1
        </div>
        <p class="text-gray-700">กดปุ่ม <span class="font-bold text-orange-500">"เริ่มตรวจ"</span> เพื่อเปิดกล้อง</p>
       </div>
       <div class="bg-white/80 p-4 rounded-xl">
        <div class="text-2xl font-bold text-purple-600 mb-2">
         ขั้นตอนที่ 2
        </div>
        <p class="text-gray-700">เลือกตำแหน่งที่ต้องการตรวจ <span class="font-bold text-purple-500">มือ / เท้า / ปาก</span></p>
       </div>
       <div class="bg-white/80 p-4 rounded-xl">
        <div class="text-2xl font-bold text-purple-600 mb-2">
         ขั้นตอนที่ 3
        </div>
        <p class="text-gray-700">ส่องกล้องไปที่บริเวณที่เลือก <span class="font-bold text-green-500">รอผลวิเคราะห์</span></p>
       </div>
      </div>
      <div class="mt-4 bg-yellow-100 p-4 rounded-xl">
       <p class="text-yellow-800"><span class="font-bold">หมายเหตุ:</span> ระบบนี้เป็นเพียงการคัดกรองเบื้องต้น กรุณาพบแพทย์เพื่อการวินิจฉัยที่แม่นยำ</p>
      </div>
     </div><!-- Detection History -->
     <div class="mt-8 bg-white/80 p-6 rounded-2xl shadow-lg">
      <h3 class="text-xl font-bold text-gray-700 mb-4">ประวัติการตรวจล่าสุด</h3>
      <div id="history-container" class="space-y-2 max-h-60 overflow-y-auto">
       <p class="text-gray-500 text-center py-4">ยังไม่มีประวัติการตรวจ</p>
      </div>
     </div><!-- Evaluation Form -->
     <div class="mt-8 bg-gradient-to-br from-purple-100 via-pink-100 to-yellow-100 p-6 rounded-2xl shadow-lg border-2 border-purple-300">
      <h3 class="text-2xl font-bold text-purple-700 mb-4 text-center">แบบประเมินความพึงพอใจ</h3>
      <p class="text-center text-gray-600 mb-6">กรุณาประเมินความพึงพอใจในการใช้งานระบบ (ไม่ต้องระบุตัวตน)</p>
      <form id="evaluation-form" class="space-y-6"><!-- Question 1: Ease of Use -->
       <div class="bg-white/80 p-5 rounded-xl shadow-md"><label class="block text-lg font-semibold text-gray-700 mb-3"> 1. ระบบใช้งานง่ายเข้าใจหรือไม่? </label>
        <div class="flex flex-wrap gap-3 justify-center"><button type="button" onclick="selectRating('ease_of_use', 5)" class="rating-btn px-6 py-3 rounded-full bg-green-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มากที่สุด </button> <button type="button" onclick="selectRating('ease_of_use', 4)" class="rating-btn px-6 py-3 rounded-full bg-lime-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มาก </button> <button type="button" onclick="selectRating('ease_of_use', 3)" class="rating-btn px-6 py-3 rounded-full bg-yellow-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> ปานกลาง </button> <button type="button" onclick="selectRating('ease_of_use', 2)" class="rating-btn px-6 py-3 rounded-full bg-orange-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อย </button> <button type="button" onclick="selectRating('ease_of_use', 1)" class="rating-btn px-6 py-3 rounded-full bg-red-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อยที่สุด </button>
        </div><input type="hidden" id="ease_of_use" name="ease_of_use" required>
       </div><!-- Question 2: Accuracy -->
       <div class="bg-white/80 p-5 rounded-xl shadow-md"><label class="block text-lg font-semibold text-gray-700 mb-3"> 2. ผลการตรวจมีความแม่นยำหรือไม่? </label>
        <div class="flex flex-wrap gap-3 justify-center"><button type="button" onclick="selectRating('accuracy', 5)" class="rating-btn px-6 py-3 rounded-full bg-green-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มากที่สุด </button> <button type="button" onclick="selectRating('accuracy', 4)" class="rating-btn px-6 py-3 rounded-full bg-lime-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มาก </button> <button type="button" onclick="selectRating('accuracy', 3)" class="rating-btn px-6 py-3 rounded-full bg-yellow-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> ปานกลาง </button> <button type="button" onclick="selectRating('accuracy', 2)" class="rating-btn px-6 py-3 rounded-full bg-orange-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อย </button> <button type="button" onclick="selectRating('accuracy', 1)" class="rating-btn px-6 py-3 rounded-full bg-red-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อยที่สุด </button>
        </div><input type="hidden" id="accuracy" name="accuracy" required>
       </div><!-- Question 3: Design -->
       <div class="bg-white/80 p-5 rounded-xl shadow-md"><label class="block text-lg font-semibold text-gray-700 mb-3"> 3. การออกแบบหน้าเว็บสวยงามหรือไม่? </label>
        <div class="flex flex-wrap gap-3 justify-center"><button type="button" onclick="selectRating('design', 5)" class="rating-btn px-6 py-3 rounded-full bg-green-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มากที่สุด </button> <button type="button" onclick="selectRating('design', 4)" class="rating-btn px-6 py-3 rounded-full bg-lime-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มาก </button> <button type="button" onclick="selectRating('design', 3)" class="rating-btn px-6 py-3 rounded-full bg-yellow-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> ปานกลาง </button> <button type="button" onclick="selectRating('design', 2)" class="rating-btn px-6 py-3 rounded-full bg-orange-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อย </button> <button type="button" onclick="selectRating('design', 1)" class="rating-btn px-6 py-3 rounded-full bg-red-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อยที่สุด </button>
        </div><input type="hidden" id="design" name="design" required>
       </div><!-- Question 4: Overall Satisfaction -->
       <div class="bg-white/80 p-5 rounded-xl shadow-md"><label class="block text-lg font-semibold text-gray-700 mb-3"> 4. ความพึงพอใจโดยรวมต่อระบบ </label>
        <div class="flex flex-wrap gap-3 justify-center"><button type="button" onclick="selectRating('overall', 5)" class="rating-btn px-6 py-3 rounded-full bg-green-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มากที่สุด </button> <button type="button" onclick="selectRating('overall', 4)" class="rating-btn px-6 py-3 rounded-full bg-lime-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> มาก </button> <button type="button" onclick="selectRating('overall', 3)" class="rating-btn px-6 py-3 rounded-full bg-yellow-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> ปานกลาง </button> <button type="button" onclick="selectRating('overall', 2)" class="rating-btn px-6 py-3 rounded-full bg-orange-400 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อย </button> <button type="button" onclick="selectRating('overall', 1)" class="rating-btn px-6 py-3 rounded-full bg-red-500 text-white font-bold shadow-lg hover:scale-110 transition-all duration-300"> น้อยที่สุด </button>
        </div><input type="hidden" id="overall" name="overall" required>
       </div><!-- Additional Comments -->
       <div class="bg-white/80 p-5 rounded-xl shadow-md"><label for="comments" class="block text-lg font-semibold text-gray-700 mb-3"> 5. ข้อเสนอแนะเพิ่มเติม (ถ้ามี) </label> <textarea id="comments" name="comments" rows="4" class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:border-purple-500 focus:outline-none resize-none" placeholder="พิมพ์ข้อเสนอแนะของคุณที่นี่..."></textarea>
       </div><!-- Submit Button -->
       <div class="text-center"><button type="submit" id="submit-evaluation" class="bg-gradient-to-r from-purple-500 to-pink-500 px-10 py-4 rounded-full font-bold text-white text-xl shadow-lg hover:scale-105 transition-all duration-300 mx-auto"> ส่งแบบประเมิน </button>
       </div>
      </form><!-- Evaluation Statistics -->
      <div id="evaluation-stats" class="mt-8 bg-white/80 p-5 rounded-xl shadow-md">
       <h4 class="text-lg font-bold text-gray-700 mb-3">สถิติการประเมิน</h4>
       <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center">
         <div class="text-3xl font-bold text-purple-600" id="eval-count">
          0
         </div>
         <div class="text-sm text-gray-600">
          จำนวนการประเมิน
         </div>
        </div>
        <div class="text-center">
         <div class="text-3xl font-bold text-green-600" id="avg-ease">
          -
         </div>
         <div class="text-sm text-gray-600">
          ค่าเฉลี่ยใช้งาน
         </div>
        </div>
        <div class="text-center">
         <div class="text-3xl font-bold text-blue-600" id="avg-accuracy">
          -
         </div>
         <div class="text-sm text-gray-600">
          ค่าเฉลี่ยแม่นยำ
         </div>
        </div>
        <div class="text-center">
         <div class="text-3xl font-bold text-pink-600" id="avg-overall">
          -
         </div>
         <div class="text-sm text-gray-600">
          ค่าเฉลี่ยโดยรวม
         </div>
        </div>
       </div>
      </div>
     </div>
    </main><!-- Footer -->
    <footer class="text-center mt-8 py-4">
     <p id="footer-text" class="text-gray-600 font-medium">© KHUNHANWITTAYASAN SCHOOL</p>
     <p class="text-gray-500 text-sm mt-1">พัฒนาเพื่อสุขภาพที่ดีของนักเรียน</p>
    </footer>
   </div>
  </div><!-- Toast Notification -->
  <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl transform translate-x-full transition-transform duration-300 z-50"><span id="toast-message">ข้อความแจ้งเตือน</span>
  </div>
  <script>
        // Configuration
        const defaultConfig = {
            system_title: 'HFMD WEB',
            footer_text: '© KHUNHANWITTAYASAN SCHOOL',
            primary_color: '#667EEA',
            secondary_color: '#764BA2',
            accent_color: '#FF6B6B'
        };

        let config = { ...defaultConfig };
        
        // App State
        let currentTab = 'hand';
        let isRunning = false;
        let timer = 0;
        let timerInterval = null;
        let webcam = null;
        let model = null;
        let animationFrameId = null;
        let userCount = 0;
        let historyData = [];
        let evaluationData = [];
        let selectedRatings = {};
        
        // Results storage
        let results = {
            hand: { status: null, confidence: 0, checked: false },
            foot: { status: null, confidence: 0, checked: false },
            mouth: { status: null, confidence: 0, checked: false }
        };

        // Model URLs (placeholder - replace with actual Teachable Machine model URLs)
        const modelURLs = {
            hand: 'https://teachablemachine.withgoogle.com/models/your-hand-model/',
            foot: 'https://teachablemachine.withgoogle.com/models/your-foot-model/',
            mouth: 'https://teachablemachine.withgoogle.com/models/your-mouth-model/'
        };

        // Speech synthesis
        const synth = window.speechSynthesis;

        function speak(text) {
            if (synth.speaking) {
                synth.cancel();
            }
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'th-TH';
            utterance.rate = 0.9;
            synth.speak(utterance);
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toast.className = 'fixed top-4 right-4 text-white px-6 py-4 rounded-xl shadow-2xl transform transition-transform duration-300 z-50';
            
            if (type === 'success') {
                toast.classList.add('bg-green-500');
            } else if (type === 'warning') {
                toast.classList.add('bg-yellow-500');
            } else if (type === 'danger') {
                toast.classList.add('bg-red-500');
            } else {
                toast.classList.add('bg-blue-500');
            }
            
            toastMessage.textContent = message;
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
            
            setTimeout(() => {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-full');
            }, 3000);
        }

        // Tab switching
        function switchTab(tab) {
            currentTab = tab;
            
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('tab-active', 'ring-4', 'ring-white');
            });
            document.getElementById(`tab-${tab}`).classList.add('tab-active', 'ring-4', 'ring-white');
            
            // Update mode indicator
            const texts = { hand: 'มือ', foot: 'เท้า', mouth: 'ปาก' };
            document.getElementById('mode-text').textContent = `กำลังตรวจ: ${texts[tab]}`;
            
            // Highlight current result card
            document.querySelectorAll('.result-card').forEach(card => {
                card.classList.remove('ring-4', 'ring-purple-400', 'pulse-animation');
            });
            document.getElementById(`result-${tab}`).classList.add('ring-4', 'ring-purple-400', 'pulse-animation');
        }

        // Timer functions
        function startTimer() {
            timer = 0;
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                timer++;
                updateTimerDisplay();
            }, 1000);
        }

        function stopTimer() {
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
        }

        function updateTimerDisplay() {
            document.getElementById('timer').textContent = timer.toString().padStart(2, '0');
        }

        // Start detection
        async function startDetection() {
            if (isRunning) return;
            
            try {
                // Increment user count
                userCount++;
                document.getElementById('user-count').textContent = userCount;
                
                isRunning = true;
                document.getElementById('btn-start').classList.add('opacity-50', 'cursor-not-allowed');
                document.getElementById('btn-start').disabled = true;
                document.getElementById('btn-stop').classList.remove('opacity-50', 'cursor-not-allowed');
                document.getElementById('btn-stop').disabled = false;
                
                // Hide placeholder, show webcam container
                document.getElementById('webcam-placeholder').classList.add('hidden');
                document.getElementById('webcam-container').classList.remove('hidden');
                
                // Setup webcam
                const canvas = document.getElementById('canvas');
                const size = Math.min(500, window.innerWidth - 60);
                canvas.width = size;
                canvas.height = size;
                
                // Create webcam
                const flip = true;
                webcam = new tmImage.Webcam(size, size, flip);
                await webcam.setup();
                await webcam.play();
                
                // Start timer
                startTimer();
                
                // Start prediction loop
                predict();
                
                showToast('เริ่มการตรวจแล้ว กรุณาส่องกล้องไปที่บริเวณที่ต้องการตรวจ', 'info');
                speak('เริ่มการตรวจแล้ว กรุณาส่องกล้องไปที่บริเวณที่ต้องการตรวจ');
                
            } catch (error) {
                console.error('Error starting detection:', error);
                showToast('ไม่สามารถเปิดกล้องได้ กรุณาอนุญาตการเข้าถึงกล้อง', 'danger');
                resetDetectionState();
            }
        }

        // Stop detection
        function stopDetection() {
            if (!isRunning) return;
            
            isRunning = false;
            stopTimer();
            
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
            }
            
            if (webcam) {
                webcam.stop();
                webcam = null;
            }
            
            document.getElementById('btn-start').classList.remove('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-start').disabled = false;
            document.getElementById('btn-stop').classList.add('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-stop').disabled = true;
            
            // Save results if any checks were completed
            if (results.hand.checked || results.foot.checked || results.mouth.checked) {
                saveResults();
            }
            
            showToast('หยุดการตรวจแล้ว', 'warning');
        }

        function resetDetectionState() {
            isRunning = false;
            document.getElementById('btn-start').classList.remove('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-start').disabled = false;
            document.getElementById('btn-stop').classList.add('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-stop').disabled = true;
        }

        // Reset all
        function resetAll() {
            stopDetection();
            
            // Reset results
            results = {
                hand: { status: null, confidence: 0, checked: false },
                foot: { status: null, confidence: 0, checked: false },
                mouth: { status: null, confidence: 0, checked: false }
            };
            
            // Reset UI
            ['hand', 'foot', 'mouth'].forEach(part => {
                document.getElementById(`${part}-status`).textContent = 'รอการตรวจ...';
                document.getElementById(`${part}-status`).className = 'text-center py-3 rounded-xl bg-gray-100 text-gray-500';
                document.getElementById(`${part}-confidence`).textContent = 'ความมั่นใจ: --%';
            });
            
            document.getElementById('overall-status').textContent = 'รอผลการตรวจ';
            document.getElementById('overall-result').className = 'result-card bg-gradient-to-r from-purple-500 to-pink-500 p-4 rounded-2xl shadow-lg text-white';
            
            // Reset timer
            timer = 0;
            updateTimerDisplay();
            
            // Show placeholder
            document.getElementById('webcam-placeholder').classList.remove('hidden');
            document.getElementById('webcam-container').classList.add('hidden');
            
            // Reset tabs
            switchTab('hand');
            
            showToast('รีเซ็ตระบบแล้ว พร้อมเริ่มตรวจใหม่', 'info');
        }

        // Prediction loop
        async function predict() {
            if (!isRunning || !webcam) return;
            
            webcam.update();
            
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            ctx.drawImage(webcam.canvas, 0, 0, canvas.width, canvas.height);
            
            // Simulate AI prediction (replace with actual model prediction)
            simulatePrediction();
            
            animationFrameId = requestAnimationFrame(predict);
        }

        // Simulate prediction (replace with actual Teachable Machine model)
        function simulatePrediction() {
            // This simulates random predictions for demo purposes
            // Replace this with actual model.predict() when you have the model
            
            const random = Math.random();
            let status, confidence;
            
            if (random < 0.7) {
                status = 'ปกติ';
                confidence = 70 + Math.random() * 25;
            } else if (random < 0.9) {
                status = 'สงสัย';
                confidence = 50 + Math.random() * 30;
            } else {
                status = 'พบอาการ';
                confidence = 60 + Math.random() * 35;
            }
            
            updateResult(currentTab, status, confidence);
        }

        // Update result display
        function updateResult(part, status, confidence) {
            const confidencePercent = Math.round(confidence);
            
            results[part] = {
                status: status,
                confidence: confidencePercent,
                checked: true
            };
            
            const statusEl = document.getElementById(`${part}-status`);
            const confEl = document.getElementById(`${part}-confidence`);
            
            statusEl.textContent = status;
            confEl.textContent = `ความมั่นใจ: ${confidencePercent}%`;
            
            // Update status styling
            if (status === 'ปกติ') {
                statusEl.className = 'text-center py-3 rounded-xl status-safe text-white font-bold';
            } else if (status === 'สงสัย') {
                statusEl.className = 'text-center py-3 rounded-xl status-warning text-white font-bold';
            } else {
                statusEl.className = 'text-center py-3 rounded-xl status-danger text-white font-bold';
            }
            
            // Update overall result
            updateOverallResult();
        }

        // Update overall result
        function updateOverallResult() {
            const checkedParts = Object.values(results).filter(r => r.checked);
            
            if (checkedParts.length === 0) return;
            
            const overallEl = document.getElementById('overall-status');
            const overallCard = document.getElementById('overall-result');
            
            const hasDanger = checkedParts.some(r => r.status === 'พบอาการ');
            const hasWarning = checkedParts.some(r => r.status === 'สงสัย');
            
            let overallStatus, message;
            
            if (hasDanger) {
                overallStatus = 'พบความเสี่ยง - ควรพบแพทย์';
                overallCard.className = 'result-card p-4 rounded-2xl shadow-lg text-white status-danger';
                message = 'ระบบตรวจพบความผิดปกติ กรุณาพบแพทย์เพื่อตรวจวินิจฉัย';
            } else if (hasWarning) {
                overallStatus = 'มีข้อสงสัย - ควรเฝ้าระวัง';
                overallCard.className = 'result-card p-4 rounded-2xl shadow-lg text-white status-warning';
                message = 'ระบบตรวจพบข้อสงสัย กรุณาเฝ้าระวังอาการ';
            } else {
                overallStatus = 'ปกติ';
                overallCard.className = 'result-card p-4 rounded-2xl shadow-lg text-white status-safe';
                message = 'ผลการตรวจปกติ';
            }
            
            overallEl.textContent = overallStatus;
            
            // Announce result every 5 seconds
            if (timer % 5 === 0 && timer > 0) {
                speak(message);
            }
        }

        // Save results to data store
        async function saveResults() {
            const resultRecord = {
                id: Date.now().toString(),
                timestamp: new Date().toISOString(),
                hand_result: results.hand.checked ? `${results.hand.status} (${results.hand.confidence}%)` : 'ไม่ได้ตรวจ',
                foot_result: results.foot.checked ? `${results.foot.status} (${results.foot.confidence}%)` : 'ไม่ได้ตรวจ',
                mouth_result: results.mouth.checked ? `${results.mouth.status} (${results.mouth.confidence}%)` : 'ไม่ได้ตรวจ',
                overall_status: determineOverallStatus()
            };
            
            if (window.dataSdk) {
                if (historyData.length >= 999) {
                    showToast('ข้อมูลเต็มแล้ว กรุณาลบข้อมูลเก่า', 'warning');
                    return;
                }
                
                const result = await window.dataSdk.create(resultRecord);
                if (result.isOk) {
                    showToast('บันทึกผลการตรวจเรียบร้อย', 'success');
                } else {
                    console.error('Failed to save results:', result.error);
                }
            }
        }

        function determineOverallStatus() {
            const checkedParts = Object.values(results).filter(r => r.checked);
            if (checkedParts.length === 0) return 'ไม่ได้ตรวจ';
            
            const hasDanger = checkedParts.some(r => r.status === 'พบอาการ');
            const hasWarning = checkedParts.some(r => r.status === 'สงสัย');
            
            if (hasDanger) return 'พบความเสี่ยง';
            if (hasWarning) return 'มีข้อสงสัย';
            return 'ปกติ';
        }

        // Update history display
        function updateHistoryDisplay(data) {
            const container = document.getElementById('history-container');
            
            if (!data || data.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">ยังไม่มีประวัติการตรวจ</p>';
                return;
            }
            
            const sortedData = [...data].sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp)).slice(0, 10);
            
            container.innerHTML = sortedData.map(record => {
                const date = new Date(record.timestamp);
                const timeStr = date.toLocaleString('th-TH');
                
                let statusClass = 'bg-green-100 text-green-700';
                if (record.overall_status === 'พบความเสี่ยง') {
                    statusClass = 'bg-red-100 text-red-700';
                } else if (record.overall_status === 'มีข้อสงสัย') {
                    statusClass = 'bg-yellow-100 text-yellow-700';
                }
                
                return `
                    <div class="bg-gray-50 p-3 rounded-xl flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 text-sm">${timeStr}</span>
                        </div>
                        <div class="flex gap-2 text-xs">
                            <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded">มือ: ${record.hand_result}</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">เท้า: ${record.foot_result}</span>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">ปาก: ${record.mouth_result}</span>
                        </div>
                        <span class="${statusClass} px-3 py-1 rounded-full text-sm font-medium">${record.overall_status}</span>
                    </div>
                `;
            }).join('');
        }

        // Rating selection
        function selectRating(category, value) {
            selectedRatings[category] = value;
            document.getElementById(category).value = value;
            
            // Update button styles
            const buttons = document.querySelectorAll(`button[onclick*="${category}"]`);
            buttons.forEach(btn => {
                btn.classList.remove('ring-4', 'ring-white', 'scale-110');
                btn.style.opacity = '0.6';
            });
            
            const selectedBtn = document.querySelector(`button[onclick="selectRating('${category}', ${value})"]`);
            if (selectedBtn) {
                selectedBtn.classList.add('ring-4', 'ring-white', 'scale-110');
                selectedBtn.style.opacity = '1';
            }
        }

        // Handle evaluation form submission
        document.addEventListener('DOMContentLoaded', () => {
            const evaluationForm = document.getElementById('evaluation-form');
            if (evaluationForm) {
                evaluationForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    // Check if all ratings are selected
                    const requiredRatings = ['ease_of_use', 'accuracy', 'design', 'overall'];
                    const missingRatings = requiredRatings.filter(r => !selectedRatings[r]);
                    
                    if (missingRatings.length > 0) {
                        showToast('กรุณาประเมินทุกข้อก่อนส่งแบบประเมิน', 'warning');
                        return;
                    }
                    
                    // Show loading state
                    const submitBtn = document.getElementById('submit-evaluation');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'กำลังบันทึก...';
                    
                    const evaluationRecord = {
                        id: Date.now().toString(),
                        timestamp: new Date().toISOString(),
                        ease_of_use: selectedRatings.ease_of_use,
                        accuracy: selectedRatings.accuracy,
                        design: selectedRatings.design,
                        overall_satisfaction: selectedRatings.overall,
                        comments: document.getElementById('comments').value || 'ไม่มี',
                        type: 'evaluation'
                    };
                    
                    if (window.dataSdk) {
                        if (evaluationData.length >= 999) {
                            showToast('ข้อมูลเต็มแล้ว ไม่สามารถบันทึกได้', 'warning');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                            return;
                        }
                        
                        const result = await window.dataSdk.create(evaluationRecord);
                        
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                        
                        if (result.isOk) {
                            showToast('ขอบคุณสำหรับการประเมิน', 'success');
                            speak('ขอบคุณสำหรับการประเมินค่ะ');
                            
                            // Reset form
                            evaluationForm.reset();
                            selectedRatings = {};
                            
                            // Reset button styles
                            document.querySelectorAll('.rating-btn').forEach(btn => {
                                btn.classList.remove('ring-4', 'ring-white', 'scale-110');
                                btn.style.opacity = '1';
                            });
                            
                            // Scroll to stats
                            document.getElementById('evaluation-stats').scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'nearest' 
                            });
                        } else {
                            showToast('เกิดข้อผิดพลาดในการบันทึก กรุณาลองใหม่', 'danger');
                        }
                    }
                });
            }
        });

        // Update evaluation statistics
        function updateEvaluationStats(data) {
            const evaluations = data.filter(item => item.type === 'evaluation');
            
            if (evaluations.length === 0) {
                document.getElementById('eval-count').textContent = '0';
                document.getElementById('avg-ease').textContent = '-';
                document.getElementById('avg-accuracy').textContent = '-';
                document.getElementById('avg-overall').textContent = '-';
                return;
            }
            
            const avgEase = (evaluations.reduce((sum, e) => sum + parseInt(e.ease_of_use), 0) / evaluations.length).toFixed(1);
            const avgAccuracy = (evaluations.reduce((sum, e) => sum + parseInt(e.accuracy), 0) / evaluations.length).toFixed(1);
            const avgOverall = (evaluations.reduce((sum, e) => sum + parseInt(e.overall_satisfaction), 0) / evaluations.length).toFixed(1);
            
            document.getElementById('eval-count').textContent = evaluations.length;
            document.getElementById('avg-ease').textContent = avgEase;
            document.getElementById('avg-accuracy').textContent = avgAccuracy;
            document.getElementById('avg-overall').textContent = avgOverall;
        }

        // Data handler for SDK
        const dataHandler = {
            onDataChanged(data) {
                const allData = data || [];
                
                // Separate detection history and evaluations
                historyData = allData.filter(item => !item.type || item.type !== 'evaluation');
                evaluationData = allData.filter(item => item.type === 'evaluation');
                
                // Update user count (only detection records)
                userCount = historyData.length;
                document.getElementById('user-count').textContent = userCount;
                
                // Update displays
                updateHistoryDisplay(historyData);
                updateEvaluationStats(allData);
            }
        };

        // Config change handler
        async function onConfigChange(cfg) {
            document.getElementById('system-title').textContent = cfg.system_title || defaultConfig.system_title;
            document.getElementById('footer-text').textContent = cfg.footer_text || defaultConfig.footer_text;
        }

        // Map to capabilities
        function mapToCapabilities(cfg) {
            return {
                recolorables: [],
                borderables: [],
                fontEditable: undefined,
                fontSizeable: undefined
            };
        }

        // Map to edit panel values
        function mapToEditPanelValues(cfg) {
            return new Map([
                ['system_title', cfg.system_title || defaultConfig.system_title],
                ['footer_text', cfg.footer_text || defaultConfig.footer_text]
            ]);
        }

        // Initialize
        async function init() {
            // Initialize Element SDK
            if (window.elementSdk) {
                window.elementSdk.init({
                    defaultConfig,
                    onConfigChange,
                    mapToCapabilities,
                    mapToEditPanelValues
                });
            }
            
            // Initialize Data SDK
            if (window.dataSdk) {
                const result = await window.dataSdk.init(dataHandler);
                if (!result.isOk) {
                    console.error('Failed to initialize data SDK');
                }
            }
            
            // Set initial tab
            switchTab('hand');
            
            // Apply initial config
            onConfigChange(config);
        }

        init();
    </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9c36b72e642e45b8',t:'MTc2OTMzMzA0NS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
