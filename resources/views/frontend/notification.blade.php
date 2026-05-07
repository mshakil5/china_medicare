
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Site Unavailable</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  
    <style>
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        @keyframes scanline { 0%{top:-10%} 100%{top:110%} }
        @keyframes glitch1 { 0%,100%{clip-path:inset(0 0 95% 0)} 25%{clip-path:inset(30% 0 50% 0)} 50%{clip-path:inset(60% 0 20% 0)} 75%{clip-path:inset(10% 0 80% 0)} }
        @keyframes pulse-red { 0%,100%{box-shadow:0 0 0 0 rgba(226,75,74,0.4)} 50%{box-shadow:0 0 0 20px rgba(226,75,74,0)} }
        @keyframes typewriter { from{width:0} to{width:100%} }
        @keyframes fadeup { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        body { margin:0; background:#0a0a0a; font-family: monospace; color:#e24b4a; min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; overflow:hidden; position:relative; }
        .scanline { position:fixed; left:0; width:100%; height:3px; background:rgba(226,75,74,0.08); animation:scanline 4s linear infinite; pointer-events:none; z-index:10; }
        .grid-bg { position:fixed; inset:0; background-image: linear-gradient(rgba(226,75,74,0.04) 1px,transparent 1px), linear-gradient(90deg,rgba(226,75,74,0.04) 1px,transparent 1px); background-size:40px 40px; z-index:0; }
        .container { position:relative; z-index:2; text-align:center; max-width:640px; padding:2rem; }
        .skull-icon { font-size:72px; display:block; animation:blink 2s ease-in-out infinite; margin-bottom:1rem; }
        .badge { display:inline-flex; align-items:center; gap:8px; background:#500; border:1px solid #a32d2d; color:#f09595; font-size:11px; padding:4px 14px; border-radius:4px; letter-spacing:2px; text-transform:uppercase; margin-bottom:1.5rem; animation:pulse-red 2s infinite; }
        .badge-dot { width:7px; height:7px; border-radius:50%; background:#e24b4a; animation:blink 1s infinite; }
        .main-title { font-size:clamp(22px,5vw,36px); font-weight:700; color:#f09595; letter-spacing:4px; text-transform:uppercase; margin:0 0 0.5rem; font-family:monospace; position:relative; overflow:hidden; }
        .glitch { position:relative; }
        .glitch::before { content:attr(data-text); position:absolute; inset:0; color:#e24b4a; animation:glitch1 3s steps(1) infinite; opacity:0.7; }
        .sub { font-size:13px; color:#791f1f; letter-spacing:3px; text-transform:uppercase; margin-bottom:2rem; }
        .divider { border:none; border-top:1px solid #a32d2d; margin:1.5rem 0; opacity:0.5; }
        .message { background:#150000; border:1px solid #500; border-radius:6px; padding:1.25rem 1.5rem; text-align:left; margin-bottom:1.5rem; animation:fadeup 0.8s ease 0.3s both; }
        .msg-line { font-size:13px; color:#f09595; line-height:2; }
        .msg-line span { color:#791f1f; margin-right:8px; }
        .counter-label { font-size:11px; color:#791f1f; letter-spacing:2px; text-transform:uppercase; margin-bottom:6px; }
        .counter { font-size:11px; color:#a32d2d; font-family:monospace; letter-spacing:1px; }
        .contact-box { border:1px solid #500; border-radius:6px; padding:1rem 1.5rem; display:inline-flex; align-items:center; gap:12px; margin-top:1rem; animation:fadeup 0.8s ease 0.6s both; }
        .contact-box i { font-size:20px; color:#e24b4a; }
        .contact-text { text-align:left; }
        .contact-label { font-size:10px; color:#791f1f; letter-spacing:2px; text-transform:uppercase; }
        .contact-val { font-size:14px; color:#f09595; }
        .footer-note { font-size:10px; color:#3a1010; letter-spacing:2px; text-transform:uppercase; margin-top:2rem; }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
<div class="scanline"></div>

<div class="container">
  <span class="skull-icon">⚠️</span>

  <div class="badge">
    <span class="badge-dot"></span>
    Critical Alert — Access Suspended
  </div>

  <h1 class="main-title glitch" data-text="SITE LOCKED">SITE LOCKED</h1>
  <p class="sub">Unauthorized access blocked</p>

  <div class="message">
    <div class="msg-line"><span>›</span> This domain has been suspended by the administrator.</div>
    <div class="msg-line"><span>›</span> All requests are being logged and monitored.</div>
    <div class="msg-line"><span>›</span> Unauthorized attempts may be reported to authorities.</div>
    <div class="msg-line"><span>›</span> Service will resume upon issue resolution.</div>
  </div>

  <hr class="divider">

  <div class="counter-label">Incident ID</div>
  <div class="counter" id="incident">Generating...</div>

  <div class="contact-box">
    <i class="ti ti-mail" aria-hidden="true"></i>
    <div class="contact-text">
      <div class="contact-label">Contact administrator</div>
    </div>
  </div>

  <div class="footer-note">© chinamedicare.net — All rights reserved</div>
</div>

<script>
  const id = 'INC-' + Date.now().toString(36).toUpperCase() + '-' + Math.random().toString(36).substr(2,6).toUpperCase();
  document.getElementById('incident').textContent = id;
</script>

</body>
</html>