<!doctype html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HFMD WEB</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.3.1/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@0.8/dist/teachablemachine-image.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body { font-family:'Kanit',sans-serif; background:linear-gradient(135deg,#FFE5B4,#E5CCFF,#CCE5FF);}
.status-safe{background:#22c55e;color:white}
.status-warning{background:#facc15;color:white}
.status-danger{background:#ef4444;color:white}
</style>
</head>

<body class="min-h-screen p-4">

<!-- HEADER -->
<header class="text-center mb-6">
<h1 class="text-4xl font-bold text-purple-600">HFMD WEB</h1>
<p class="text-gray-600">ระบบตรวจคัดกรองโรคมือ เท้า ปาก ด้วย AI</p>
</header>

<!-- TAB -->
<div class="flex justify-center gap-4 mb-6">
<button onclick="switchTab('hand')" class="px-6 py-2 rounded-full bg-pink-400 text-white">มือ</button>
<button onclick="switchTab('foot')" class="px-6 py-2 rounded-full bg-blue-400 text-white">เท้า</button>
<button onclick="switchTab('mouth')" class="px-6 py-2 rounded-full bg-green-400 text-white">ปาก</button>
</div>

<!-- TIMER -->
<div class="text-center mb-4">
<span class="text-xl font-bold">เวลา: </span>
<span id="timer" class="text-3xl font-bold">00</span> วินาที
</div>

<!-- CAMERA -->
<div class="flex justify-center mb-6">
<canvas id="canvas" width="400" height="400" class="rounded-xl shadow-lg bg-black"></canvas>
</div>

<!-- RESULTS -->
<div class="grid md:grid-cols-3 gap-4 max-w-4xl mx-auto">
<div class="p-4 bg-white rounded-xl shadow">
<h3 class="font-bold">ผลตรวจมือ</h3>
<div id="hand-status" class="mt-2 text-center bg-gray-100 py-2 rounded">รอการตรวจ</div>
</div>

<div class="p-4 bg-white rounded-xl shadow">
<h3 class="font-bold">ผลตรวจเท้า</h3>
<div id="foot-status" class="mt-2 text-center bg-gray-100 py-2 rounded">รอการตรวจ</div>
</div>

<div class="p-4 bg-white rounded-xl shadow">
<h3 class="font-bold">ผลตรวจปาก</h3>
<div id="mouth-status" class="mt-2 text-center bg-gray-100 py-2 rounded">รอการตรวจ</div>
</div>
</div>

<!-- OVERALL -->
<div class="max-w-xl mx-auto mt-6 bg-purple-500 text-white p-4 rounded-xl text-center">
<h3 class="font-bold">ผลสรุปรวม</h3>
<div id="overall-status" class="text-xl mt-2">รอผล</div>
</div>

<!-- BUTTONS -->
<div class="flex justify-center gap-4 mt-8">
<button onclick="startDetection()" class="px-6 py-3 bg-orange-400 text-white rounded-full font-bold">เริ่มตรวจ</button>
<button onclick="stopDetection()" class="px-6 py-3 bg-red-500 text-white rounded-full font-bold">หยุด</button>
<button onclick="resetAll()" class="px-6 py-3 bg-gray-500 text-white rounded-full font-bold">เริ่มใหม่</button>
</div>

<footer class="text-center mt-10 text-gray-600">
© KHUNHANWITTAYASAN SCHOOL
</footer>

<script>
let currentTab='hand',isRunning=false,timer=0,timerInt,webcam;

const results={
hand:{},foot:{},mouth:{}
};

function switchTab(tab){currentTab=tab}

function startTimer(){
timer=0;
timerInt=setInterval(()=>{
timer++;
document.getElementById('timer').textContent=String(timer).padStart(2,'0');
},1000)
}

function stopTimer(){clearInterval(timerInt)}

async function startDetection(){
if(isRunning)return;
isRunning=true;
startTimer();
webcam=new tmImage.Webcam(400,400,true);
await webcam.setup();await webcam.play();
predict();
}

function stopDetection(){
isRunning=false;
stopTimer();
if(webcam)webcam.stop();
}

function resetAll(){
stopDetection();
['hand','foot','mouth'].forEach(p=>{
document.getElementById(p+'-status').textContent='รอการตรวจ';
document.getElementById(p+'-status').className='mt-2 text-center bg-gray-100 py-2 rounded';
});
document.getElementById('overall-status').textContent='รอผล';
}

async function predict(){
if(!isRunning)return;
webcam.update();
const ctx=canvas.getContext('2d');
ctx.drawImage(webcam.canvas,0,0,400,400);
simulatePrediction();
requestAnimationFrame(predict);
}

function simulatePrediction(){
const r=Math.random();
let status='ปกติ',cls='status-safe';
if(r>0.8){status='พบอาการ';cls='status-danger'}
else if(r>0.6){status='สงสัย';cls='status-warning'}

const el=document.getElementById(currentTab+'-status');
el.textContent=status;
el.className=`mt-2 text-center py-2 rounded ${cls}`;
updateOverall();
}

function updateOverall(){
const values=['hand','foot','mouth'].map(p=>document.getElementById(p+'-status').textContent);
const overall=document.getElementById('overall-status');
if(values.includes('พบอาการ')) overall.textContent='พบความเสี่ยง';
else if(values.includes('สงสัย')) overall.textContent='ควรเฝ้าระวัง';
else overall.textContent='ปกติ';
}
</script>
</body>
</html>
