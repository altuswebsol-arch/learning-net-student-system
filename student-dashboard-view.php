<!-- Learning Net: Student Dashboard | Strictly UK English, zero Urdu -->
<div id="ln-dash">
  <style>
    #ln-dash { font-family:'DM Sans','Manrope',-apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; color:#102422; max-width:1240px; margin:0 auto; }
    #ln-dash .dash-shell { display:flex; background:#fff; border:1px solid #dce7e3; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,111,96,.10); min-height:560px; }
    #ln-dash .dash-side { width:268px; flex:none; background:linear-gradient(175deg,#005449 0%,#006f60 55%,#58c7ab 100%); padding:28px 16px; color:#fff; }
    #ln-dash .dash-brand { font-weight:800; color:#fff; font-size:18px; line-height:1.35; letter-spacing:.2px; }
    #ln-dash .dash-brand small { display:block; font-weight:400; color:rgba(255,255,255,.78); font-size:12.5px; margin-top:3px; letter-spacing:.6px; text-transform:uppercase; }
    #ln-dash .dash-user { display:flex; align-items:center; gap:12px; margin:20px 2px 22px; padding:12px; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:12px; }
    #ln-dash .dash-ava { width:44px; height:44px; flex:none; border-radius:50%; background:linear-gradient(135deg,#006f60,#006f60); color:#fff; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,.25); }
    #ln-dash .dash-uname { font-weight:700; font-size:15.5px; color:#fff; }
    #ln-dash .dash-hello { font-size:12.5px; color:rgba(255,255,255,.72); margin:2px 0 0; line-height:1.45; }
    #ln-dash .stat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
    #ln-dash .stat-card { background:#fff; border:1px solid #e8ecf3; border-radius:14px; padding:18px 20px 18px 22px; box-shadow:0 2px 12px rgba(16,36,34,.06); position:relative; overflow:hidden; }
    #ln-dash .stat-card::before { content:""; position:absolute; left:0; top:0; bottom:0; width:4px; background:linear-gradient(180deg,#006f60,#006f60); }
    #ln-dash .stat-num { font-size:26px; font-weight:800; color:#102422; line-height:1.15; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    #ln-dash .stat-lbl { font-size:12px; color:#526663; margin-top:5px; letter-spacing:.5px; text-transform:uppercase; font-weight:600; }
    #ln-dash .dash-nav button { display:flex; align-items:center; gap:10px; width:100%; text-align:left; background:rgba(255,255,255,.10); border:none; padding:11px 14px; border-radius:10px; font-size:15px; font-weight:600; color:#fff; cursor:pointer; margin-bottom:6px; font-family:inherit; transition:background .15s ease; }
    #ln-dash .dash-nav button:hover { background:rgba(255,255,255,.22); }
    #ln-dash .dash-nav button.active { background:#fff; color:#005449; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,.18); }
    #ln-dash .dash-nav button svg { width:17px; height:17px; flex:none; }
    #ln-dash .dash-main { flex:1; min-width:0; padding:30px 34px; background:#f7faf8; }
    #ln-dash .dash-sec { display:none; }
    #ln-dash .dash-sec.active { display:block; }
    #ln-dash h2.dash-h { color:#102422 !important; font-size:22px; margin:0 0 4px; }
    #ln-dash .dash-pagehead { margin:0 0 18px; }
    #ln-dash h1.dash-pagetitle { color:#102422 !important; font-size:28px; line-height:1.2; margin:0 0 4px; font-family:'Manrope','DM Sans',sans-serif; }
    #ln-dash .dash-pagesub { color:#526663 !important; margin:0; font-size:14px; }
    #ln-dash .dash-sub { color:#526663; font-size:14.5px; margin:0 0 18px; line-height:1.55; }
    #ln-dash .dash-card { background:#fff; border:1px solid #dce7e3; border-radius:12px; padding:18px; margin-bottom:14px; }
    #ln-dash .dash-card h3 { color:#102422 !important; font-size:16.5px; margin:0 0 12px; }
    #ln-dash .dash-empty { background:#f2faf6; border:1px dashed #aed9c8; border-radius:12px; padding:24px 20px; text-align:center; color:#526663; font-size:14.5px; line-height:1.6; margin-bottom:14px; }
    #ln-dash .dash-in { padding:10px 12px; border:1px solid #c4d4cc; border-radius:8px; font-size:15px; color:#102422; background:#fff; font-family:inherit; }
    #ln-dash .dash-form { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
    #ln-dash .dash-form label { display:block; font-size:13px; color:#526663; margin-bottom:5px; }
    #ln-dash .dash-btn { display:inline-block; border:none; cursor:pointer; border-radius:8px; font-size:15px; font-weight:700; padding:11px 24px; background:#006f60; color:#fff; font-family:inherit; }
    #ln-dash .dash-btn:hover { opacity:.93; }
    #ln-dash .dash-btn.ghost { background:#eef9f5; color:#006f60; }
    #ln-dash .msg-tab.active { background:#006f60; color:#fff; }
    #ln-dash .dash-linkbtn { display:inline-block; background:#006f60; color:#fff !important; font-weight:700; padding:12px 28px; border-radius:8px; text-decoration:none; font-size:15.5px; }
    #ln-dash .dash-flash { display:none; background:#eef9f5; border:1px solid #aed9c8; color:#005449; border-radius:10px; padding:11px 15px; font-size:14px; margin-bottom:14px; }
    #ln-dash .les-row { display:flex; align-items:center; gap:12px; background:#f2faf6; border:1px solid #cde9db; border-radius:10px; padding:12px 15px; margin-bottom:10px; flex-wrap:wrap; }
    #ln-dash .les-info { flex:1; min-width:150px; }
    #ln-dash .les-subj { font-weight:700; font-size:15.5px; }
    #ln-dash .les-when { color:#526663; font-size:13.5px; }
    #ln-dash .les-join { background:#006f60; color:#fff; border:none; border-radius:8px; padding:9px 20px; font-weight:700; font-size:14px; cursor:pointer; font-family:inherit; }
    #ln-dash .meet-banner { display:flex; align-items:center; gap:14px; background:linear-gradient(135deg,#005449,#006f60); color:#fff; border-radius:12px; padding:16px 18px; margin-bottom:14px; flex-wrap:wrap; }
    #ln-dash .meet-banner strong { font-size:16px; }
    #ln-dash .meet-banner .meet-sub { font-size:13.5px; color:rgba(255,255,255,.82); margin-top:2px; }
    #ln-dash .meet-banner .dash-btn { margin-left:auto; background:#f5c64f; color:#102422; text-decoration:none; }
    #ln-dash .les-del, #ln-dash .x-del { background:none; border:none; color:#a9bcb4; font-size:19px; cursor:pointer; padding:4px 6px; line-height:1; font-family:inherit; }
    #ln-dash .les-del:hover, #ln-dash .x-del:hover { color:#f2709c; }
    #ln-dash .bar-row { display:flex; align-items:center; gap:10px; margin-bottom:11px; }
    #ln-dash .bar-label { width:130px; flex:none; font-size:13.5px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    #ln-dash .bar-track { flex:1; background:#edf4ef; border-radius:7px; height:24px; overflow:hidden; }
    #ln-dash .bar-fill { height:100%; background:linear-gradient(90deg,#006f60,#58c7ab); border-radius:7px; display:flex; align-items:center; justify-content:flex-end; padding-right:8px; color:#fff; font-size:12.5px; font-weight:700; min-width:36px; box-sizing:border-box; }
    #ln-dash .score-row { display:flex; align-items:center; gap:10px; padding:9px 4px; border-bottom:1px solid #f0f0f0; font-size:14.5px; }
    #ln-dash .score-row:last-child { border-bottom:none; }
    #ln-dash .score-date { color:#8aa39c; font-size:13px; margin-left:auto; }
    #ln-dash .msg-thread { max-height:340px; overflow-y:auto; padding:6px 2px 12px; }
    #ln-dash .msg { max-width:78%; padding:10px 14px; border-radius:14px; margin-bottom:10px; font-size:14.5px; line-height:1.5; word-wrap:break-word; }
    #ln-dash .msg.me { background:#006f60; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    #ln-dash .msg.them { background:#e9f0ec; color:#102422; border-bottom-left-radius:4px; }
    #ln-dash .msg.sys { background:#f2faf6; color:#526663; margin:0 auto 12px; text-align:center; max-width:92%; font-size:13.5px; }
    #ln-dash .msg-meta { display:block; font-size:11.5px; opacity:.75; margin-top:4px; }
    #ln-dash .msg-form { display:flex; gap:8px; }
    #ln-dash .msg-form input { flex:1; min-width:0; }
    #ln-dash .res-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:14px; }
    #ln-dash .res-card { border:1px solid #dce7e3; border-radius:12px; padding:20px 18px; background:#fff; display:flex; flex-direction:column; }
    #ln-dash .res-card:hover { border-color:#aed9c8; box-shadow:0 4px 14px rgba(0,111,96,.08); }
    #ln-dash .res-badge { align-self:flex-start; background:#006f60; color:#fff; font-weight:700; font-size:11px; letter-spacing:1px; padding:4px 12px; border-radius:20px; margin-bottom:10px; }
    #ln-dash .res-card h3 { color:#102422 !important; font-size:16.5px; margin:0 0 8px; }
    #ln-dash .res-card p { color:#526663; font-size:14px; margin:0 0 14px; flex:1; line-height:1.55; }
    #ln-dash .res-card a { color:#006f60; font-weight:700; text-decoration:none; font-size:14.5px; }
    #ln-dash .chk-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(170px,1fr)); gap:8px; margin:6px 0 16px; }
    #ln-dash .chk-grid label { display:flex; align-items:center; gap:8px; font-size:14.5px; background:#f2faf6; border:1px solid #dce7e3; border-radius:8px; padding:8px 10px; cursor:pointer; }
    #ln-dash .dash-note { font-size:13px; color:#1e6b1e; background:#eefbef; border:1px solid #bfe3bd; border-radius:8px; padding:9px 13px; display:none; margin-top:12px; }
    #ln-dash .dash-disc { font-size:12.5px; color:#8aa39c; margin-top:14px; line-height:1.55; }
    @media (max-width:720px){
      #ln-dash .dash-shell { flex-direction:column; }
      #ln-dash .dash-side { width:auto; padding:18px 12px 14px; }
      #ln-dash .dash-hello { margin-bottom:12px; }
      #ln-dash .dash-nav { display:flex; overflow-x:auto; gap:6px; padding-bottom:4px; }
      #ln-dash .dash-nav button { width:auto; white-space:nowrap; margin-bottom:0; flex:none; }
      #ln-dash .dash-main { padding:20px 14px; }
      #ln-dash .bar-label { width:96px; }
      #ln-dash .stat-grid { grid-template-columns:1fr; }
    }
  #ln-dash h2,#ln-dash h3{font-family:'Manrope','DM Sans',sans-serif;}</style>

  <div class="dash-shell">
    <aside class="dash-side">
      <div class="dash-brand">The Learning Net<small>Student Dashboard</small></div>
      <div class="dash-user"><span class="dash-ava" id="dashAva">S</span><div><div class="dash-uname" id="dashUname">Student</div><div class="dash-hello" id="dashHello">Welcome to your learning hub.</div></div></div>
      <nav class="dash-nav">
        <button type="button" data-tab="lessons" class="active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>My Lessons</button>
        <button type="button" data-tab="book"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>Book a Lesson</button>
        <button type="button" data-tab="progress"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>Progress Reports</button>
        <button type="button" data-tab="messages"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>Messages</button>
        <button type="button" data-tab="resources"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>Learning Resources</button>
        <button type="button" data-tab="account"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Account</button>
      </nav>
    </aside>
    <main class="dash-main">
      <div class="dash-pagehead">
        <h1 class="dash-pagetitle">Student Dashboard</h1>
        <p class="dash-pagesub">Your lessons, timetable, progress and messages in one place.</p>
      </div>

      <section class="dash-sec active" id="dash-sec-lessons">
        <h2 class="dash-h">My Lessons</h2>
        <p class="dash-sub">Your upcoming 1-to-1 lessons, all in one place.</p>
        <div class="stat-grid">
          <div class="stat-card"><div class="stat-num" id="statLessons">0</div><div class="stat-lbl">Lessons booked</div></div>
          <div class="stat-card"><div class="stat-num" id="statAvg">&ndash;</div><div class="stat-lbl">Practice average</div></div>
          <div class="stat-card"><div class="stat-num" id="statFocus">&ndash;</div><div class="stat-lbl">Focus area</div></div>
        </div>
        <div class="dash-card">
          <h3>My timetable</h3>
          <p class="dash-sub" style="margin-bottom:12px;">Your official lesson timetable, set by your tutor.</p>
          <div id="dashTimetable"></div>
        </div>
        <div class="dash-flash" id="dashLesFlash"></div>
        <div id="dashLesList"></div>
        <div class="dash-card">
          <h3>Add a lesson reminder</h3>
          <div class="dash-form">
            <div><label for="dashLesSubj">Subject</label><select class="dash-in" id="dashLesSubj"></select></div>
            <div><label for="dashLesDay">Day</label><select class="dash-in" id="dashLesDay"></select></div>
            <div><label for="dashLesTime">Time</label><input class="dash-in" type="time" id="dashLesTime"></div>
            <div><button class="dash-btn ghost" id="dashLesAdd" type="button">Add lesson</button></div>
          </div>
        </div>
      </section>

      <section class="dash-sec" id="dash-sec-book">
        <h2 class="dash-h">Book a Lesson</h2>
        <p class="dash-sub">Tell us what you need &mdash; we will arrange your tutor and confirm your first lesson.</p>
        <div class="dash-card">
          <div class="dash-form">
            <div><label for="dashBkSubj">Subject</label><select class="dash-in" id="dashBkSubj"></select></div>
            <div><label for="dashBkDay">Preferred day</label><select class="dash-in" id="dashBkDay"></select></div>
            <div><label for="dashBkTime">Preferred time</label><input class="dash-in" type="time" id="dashBkTime"></div>
            <div><button class="dash-btn" id="dashBkGo" type="button">Continue</button></div>
          </div>
        </div>
        <div id="dashBkOut"></div>
      </section>

      <section class="dash-sec" id="dash-sec-progress">
        <h2 class="dash-h">Progress Reports</h2>
        <p class="dash-sub">Written feedback from your tutor, plus your own practice scores.</p>
        <div class="dash-empty">Your tutor&rsquo;s written reports will appear here after your first few lessons.</div>
        <div class="dash-card">
          <h3>My practice scores</h3>
          <p class="dash-sub" style="margin-bottom:12px;">Log scores from our free tools to watch your progress grow.</p>
          <div class="dash-flash" id="dashScoreFlash"></div>
          <div id="dashScoreChart"></div>
          <div id="dashFocus" style="margin-top:10px;"></div>
          <div class="dash-form" style="margin-top:14px;">
            <div><label for="dashScoreSubj">Subject</label><select class="dash-in" id="dashScoreSubj"></select></div>
            <div><label for="dashScoreVal">Score (%)</label><input class="dash-in" type="number" id="dashScoreVal" min="0" max="100" placeholder="e.g. 72"></div>
            <div><button class="dash-btn ghost" id="dashScoreAdd" type="button">Log score</button></div>
          </div>
          <div id="dashScoreList" style="margin-top:10px;"></div>
        </div>
        <div class="dash-card" style="margin-top:14px;">
          <h3>Predicted grades</h3>
          <p class="dash-sub" style="margin-bottom:12px;">See your predicted GCSE grades before the real exams &mdash; free, takes two minutes.</p>
          <a class="dash-btn" href="https://thelearningnet.org/tools/gcse-grade-predictor/" style="text-decoration:none;display:inline-block;">Open Grade Predictor</a>
        </div>
      </section>

      <section class="dash-sec" id="dash-sec-messages">
        <h2 class="dash-h">Messages</h2>
        <p class="dash-sub">A direct line to your tutor and the school office.</p>
        <div class="dash-card">
          <div style="margin-bottom:12px;">
            <button type="button" class="dash-btn ghost msg-tab active" data-with="teacher">My teacher</button>
            <button type="button" class="dash-btn ghost msg-tab" data-with="admin" style="margin-left:8px;">School admin</button>
          </div>
          <div class="msg-thread" id="dashMsgThread"></div>
          <div class="msg-form">
            <input class="dash-in" id="dashMsgIn" type="text" placeholder="Write a message&hellip;" maxlength="500" aria-label="Write a message">
            <button class="dash-btn" id="dashMsgSend" type="button">Send</button>
          </div>
        </div>
      </section>

      <section class="dash-sec" id="dash-sec-resources">
        <h2 class="dash-h">Learning Resources</h2>
        <p class="dash-sub">Free tools to support your lessons.</p>
        <div class="res-grid">
          <div class="res-card"><span class="res-badge">FREE</span><h3>GCSE Grade Predictor</h3><p>Enter mock scores and see predicted GCSE grades, plus where the gaps are.</p><a href="https://thelearningnet.org/tools/gcse-grade-predictor/">Open free tool &rarr;</a></div>
          <div class="res-card"><span class="res-badge">FREE</span><h3>11+ Readiness Checker</h3><p>A short quiz to check how ready you are for the 11+ exams.</p><a href="https://thelearningnet.org/tools/11-plus-readiness-checker/">Open free tool &rarr;</a></div>
          <div class="res-card"><span class="res-badge">FREE</span><h3>Revision Timetable Generator</h3><p>Build a printable weekly revision timetable around your exam dates.</p><a href="https://thelearningnet.org/tools/revision-timetable-generator/">Open free tool &rarr;</a></div>
        </div>
        <p class="dash-disc">These are optional practice tools to support your child&rsquo;s lessons; they do not replace their taught course.</p>
      </section>

      <section class="dash-sec" id="dash-sec-account">
        <h2 class="dash-h">My Account</h2>
        <p class="dash-sub">Your details are saved on this device only.</p>
        <div class="dash-card">
          <div style="margin-bottom:14px;"><label for="dashAcName" style="display:block;font-size:13px;color:#526663;margin-bottom:5px;">Your name</label><input class="dash-in" id="dashAcName" type="text" placeholder="e.g. Ayesha" maxlength="60" style="width:100%;max-width:340px;box-sizing:border-box;"></div>
          <h3>Subjects</h3>
          <div class="chk-grid" id="dashAcSubjects"></div>
          <button class="dash-btn" id="dashAcSave" type="button">Save details</button>
          <div class="dash-note" id="dashAcNote">Details saved.</div>
        </div>
      </section>

    </main>
  </div>

  <script>
  (function(){
    "use strict";
    var SUBJECTS = (window.LN_SUBJECTS && window.LN_SUBJECTS.length) ? window.LN_SUBJECTS : ["Mathematics","English Language","English Literature","Biology","Chemistry","Physics","Combined Science","History","Geography","French","Spanish","German","Computer Science","Business Studies","Religious Studies","Art & Design","Drama","Music","Design & Technology","Food Preparation","Statistics"];
    var MEET = (window.LN_MEETING && window.LN_MEETING.link) ? { link: window.LN_MEETING.link, label: window.LN_MEETING.label || "MS Teams" } : null;
    var DAYS = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

    function esc(s){ return String(s===null||s===undefined?"":s).replace(/[&<>"']/g,function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]; }); }
    function $(id){ return document.getElementById(id); }
    function fmtDate(ts){ try{ return new Date(ts).toLocaleDateString("en-GB",{day:"numeric",month:"short",year:"numeric"}); }catch(e){ return ""; } }

    /* ---------- per-student state (server when logged in, browser fallback) ---------- */
    var D = { lessons:[], scores:[], timetable:[], student_name:"" };
    function lnPost(action, extra, cb){
      try{
        var fd = new FormData();
        fd.append('action', action);
        fd.append('nonce', window.LN_DASH.nonce);
        if(extra){ for(var k in extra){ fd.append(k, extra[k]); } }
        fetch(window.LN_DASH.ajax, {method:'POST', body:fd, credentials:'same-origin'})
          .then(function(r){ return r.json(); })
          .then(function(j){ cb(j && j.success ? j.data : null); })
          .catch(function(){ cb(null); });
      }catch(e){ cb(null); }
    }
    function loadState(done){
      if(window.LN_DASH && window.LN_DASH.ajax){
        lnPost('ln_get_state', null, function(d){
          if(d){
            D.lessons = d.lessons || [];
            D.scores = d.scores || [];
            D.timetable = d.timetable || [];
            D.student_name = d.student_name || "";
            MEET = (d.meeting && d.meeting.link) ? { link: d.meeting.link, label: d.meeting.label || "MS Teams" } : null;
          }
          done();
        });
      } else {
        try{
          D.lessons = JSON.parse(localStorage.getItem("ln_dash_lessons") || "[]");
          D.scores = JSON.parse(localStorage.getItem("ln_dash_scores") || "[]");
        }catch(e){}
        done();
      }
    }
    function saveState(){
      if(window.LN_DASH && window.LN_DASH.ajax){
        lnPost('ln_save_state', {state: JSON.stringify({lessons:D.lessons, scores:D.scores})}, function(){});
      } else {
        try{
          localStorage.setItem("ln_dash_lessons", JSON.stringify(D.lessons));
          localStorage.setItem("ln_dash_scores", JSON.stringify(D.scores));
        }catch(e){}
      }
    }

    var store = {
      get:function(k,fb){ try{ var v=localStorage.getItem("ln_dash_"+k); return v===null?fb:JSON.parse(v); }catch(e){ return fb; } },
      set:function(k,v){ try{ localStorage.setItem("ln_dash_"+k,JSON.stringify(v)); }catch(e){} }
    };

    function fillSelect(el, items){
      var h = "";
      for(var i=0;i<items.length;i++){ h += '<option value="'+esc(items[i])+'">'+esc(items[i])+'</option>'; }
      el.innerHTML = h;
    }

    /* ---------- tab switching ---------- */
    var navBtns = document.querySelectorAll("#ln-dash .dash-nav button");
    function showTab(name){
      var i;
      for(i=0;i<navBtns.length;i++){ navBtns[i].classList.toggle("active", navBtns[i].getAttribute("data-tab")===name); }
      var secs = document.querySelectorAll("#ln-dash .dash-sec");
      for(i=0;i<secs.length;i++){ secs[i].classList.toggle("active", secs[i].id==="dash-sec-"+name); }
      if(name==="messages"){ loadMsgs(); }
    }
    for(var n=0;n<navBtns.length;n++){
      (function(b){ b.addEventListener("click", function(){ showTab(b.getAttribute("data-tab")); }); })(navBtns[n]);
    }
    setInterval(function(){
      if(document.hidden) return;
      var sec = $("dash-sec-messages");
      if(sec && sec.classList.contains("active")) loadMsgs();
    }, 30000);

    function flashBox(el, msg){
      el.textContent = msg;
      el.style.display = "block";
      setTimeout(function(){ el.style.display = "none"; }, 4000);
    }

    /* ---------- my timetable (official, set by tutor) ---------- */
    function renderTimetable(){
      var box = $("dashTimetable"), h = "", i, t = D.timetable;
      if(MEET){
        h += '<div class="meet-banner"><div><strong>Lesson meeting link</strong><div class="meet-sub">Join your 1-to-1 lessons on '+esc(MEET.label)+'.</div></div><a class="dash-btn" href="'+esc(MEET.link)+'" target="_blank" rel="noopener">Join lesson</a></div>';
      }
      if(!t.length){
        h += '<div class="dash-empty">Your timetable will appear here once your lessons are arranged.</div>';
      } else {
        for(i=0;i<t.length;i++){
          h += '<div class="les-row"><div class="les-info"><div class="les-subj">'+esc(t[i].subject)+'</div>'
             + '<div class="les-when">'+esc(t[i].day)+' at '+esc(t[i].time)+'</div></div>'
             + '<button class="les-join" type="button" data-tt="'+i+'">Join</button></div>';
        }
      }
      box.innerHTML = h;
    }
    $("dashTimetable").addEventListener("click", function(e){
      var t = e.target;
      if(t && t.classList && t.classList.contains("les-join")){
        if(MEET){ window.open(MEET.link, "_blank", "noopener"); return; }
        flashBox($("dashLesFlash"), "Your lesson link will appear here shortly before the lesson starts.");
      }
    });

    /* ---------- my lessons (personal reminders) ---------- */
    function getLessons(){ return D.lessons; }
    function renderLessons(){
      var list = getLessons(), box = $("dashLesList"), h = "", i;
      if(!list.length){
        h = '<div class="dash-empty">You have no lessons booked yet. Once your first lesson is arranged, it will appear here.</div>';
      } else {
        for(i=0;i<list.length;i++){
          h += '<div class="les-row"><div class="les-info"><div class="les-subj">'+esc(list[i].subject)+'</div>'
             + '<div class="les-when">'+esc(list[i].day)+' at '+esc(list[i].time)+'</div></div>'
             + '<button class="les-join" type="button" data-act="join" data-i="'+i+'">Join</button>'
             + '<button class="les-del" type="button" data-act="del" data-i="'+i+'" title="Remove">&times;</button></div>';
        }
      }
      box.innerHTML = h;
      renderStats();
    }
    $("dashLesList").addEventListener("click", function(e){
      var t = e.target;
      if(!t || !t.getAttribute) return;
      var act = t.getAttribute("data-act");
      if(!act) return;
      if(act==="join"){ flashBox($("dashLesFlash"), "Your lesson link will appear here shortly before the lesson starts."); return; }
      if(act==="del"){
        var i = parseInt(t.getAttribute("data-i"), 10), list = getLessons();
        if(list[i]){ list.splice(i,1); D.lessons = list; saveState(); renderLessons(); }
      }
    });
    $("dashLesAdd").addEventListener("click", function(){
      var s = $("dashLesSubj").value, d = $("dashLesDay").value, t = $("dashLesTime").value;
      if(!s || !d || !t){ flashBox($("dashLesFlash"), "Please choose a subject, day and time first."); return; }
      var list = getLessons();
      list.push({subject:s, day:d, time:t});
      D.lessons = list; saveState();
      renderLessons();
      $("dashLesTime").value = "";
      flashBox($("dashLesFlash"), "Lesson reminder added.");
    });

    /* ---------- book a lesson ---------- */
    $("dashBkGo").addEventListener("click", function(){
      var s = $("dashBkSubj").value, d = $("dashBkDay").value, t = $("dashBkTime").value, out = $("dashBkOut");
      if(!s || !d || !t){ out.innerHTML = '<div class="dash-empty">Please choose a subject, preferred day and time.</div>'; return; }
      out.innerHTML = '<div class="dash-card"><h3>Your booking request</h3>'
        + '<p style="font-size:15px;margin:0 0 6px;"><strong>'+esc(s)+'</strong> &mdash; '+esc(d)+' at '+esc(t)+'</p>'
        + '<p class="dash-sub" style="margin-bottom:14px;">This is a request summary, not a confirmed booking. Complete the registration form and we will match you with a tutor and confirm your first lesson.</p>'
        + '<a class="dash-linkbtn" href="https://thelearningnet.org/registration/">Continue to registration</a></div>';
    });

    /* ---------- progress: practice scores ---------- */
    function getScores(){ return D.scores; }
    function renderScores(){
      var scores = getScores(), chart = $("dashScoreChart"), list = $("dashScoreList");
      var order = [], latest = {}, i, h = "";
      for(i=0;i<scores.length;i++){
        var r = scores[i];
        if(!(r.s in latest)){ order.push(r.s); latest[r.s] = r; }
        if(r.t >= latest[r.s].t){ latest[r.s] = r; }
      }
      if(order.length){
        for(i=0;i<order.length;i++){
          var p = latest[order[i]].p;
          h += '<div class="bar-row"><div class="bar-label">'+esc(order[i])+'</div><div class="bar-track"><div class="bar-fill" style="width:'+p+'%">'+p+'%</div></div></div>';
        }
      } else {
        h = '<div class="dash-empty">No practice scores logged yet. Log your first score below to start your chart.</div>';
      }
      chart.innerHTML = h;
      var foc = $("dashFocus");
      if(order.length > 1){
        var low = order[0];
        for(i=1;i<order.length;i++){ if(latest[order[i]].p < latest[low].p) low = order[i]; }
        foc.innerHTML = '<div style="background:#f2faf6;border:1px solid #cde9db;border-radius:8px;padding:10px 12px;font-size:13.5px;color:#102422;"><strong>Focus area:</strong> '
          + esc(low) + ' (' + latest[low].p + '%) &mdash; your lowest recent score. Worth mentioning to your tutor in your next lesson.</div>';
      } else { foc.innerHTML = ""; }
      var rows = [];
      for(i=0;i<scores.length;i++){ rows.push({r:scores[i], i:i}); }
      rows.sort(function(a,b){ return b.r.t - a.r.t; });
      var lh = "";
      for(i=0;i<rows.length;i++){
        lh += '<div class="score-row"><strong>'+esc(rows[i].r.s)+'</strong><span>'+rows[i].r.p+'%</span>'
            + '<span class="score-date">'+esc(fmtDate(rows[i].r.t))+'</span>'
            + '<button class="x-del" type="button" data-i="'+rows[i].i+'" title="Remove">&times;</button></div>';
      }
      list.innerHTML = lh;
      renderStats();
    }
    $("dashScoreAdd").addEventListener("click", function(){
      var s = $("dashScoreSubj").value, v = parseFloat($("dashScoreVal").value);
      if(!s || isNaN(v) || v<0 || v>100){ flashBox($("dashScoreFlash"), "Please choose a subject and enter a score between 0 and 100."); return; }
      var scores = getScores();
      scores.push({s:s, p:Math.round(v), t:Date.now()});
      D.scores = scores; saveState();
      renderScores();
      $("dashScoreVal").value = "";
    });
    $("dashScoreList").addEventListener("click", function(e){
      var t = e.target;
      if(!t || !t.getAttribute) return;
      var di = t.getAttribute("data-i");
      if(di===null) return;
      var scores = getScores(), i = parseInt(di, 10);
      if(scores[i]){ scores.splice(i,1); D.scores = scores; saveState(); renderScores(); }
    });

    /* ---------- messages (server threads: allotted teacher + school admin) ---------- */
    function fmtDT(s){ try{ var d=new Date(String(s).replace(" ","T")); if(isNaN(d)) return ""; return d.toLocaleDateString("en-GB",{day:"numeric",month:"short"})+" "+d.toLocaleTimeString("en-GB",{hour:"2-digit",minute:"2-digit"}); }catch(e){ return ""; } }
    var msgWith = "teacher";
    function renderThread(msgs, me, assigned){
      var box = $("dashMsgThread"), h = "", i;
      if(msgWith==="admin"){
        if(!msgs.length){ h += '<div class="msg sys">No messages yet. Write to the school office here.</div>'; }
      } else if(!assigned){
        h += '<div class="msg sys">Messages from your tutor will appear here once your lessons begin.</div>';
      } else if(!msgs.length){
        h += '<div class="msg sys">No messages yet. Say hello to your tutor.</div>';
      }
      for(i=0;i<msgs.length;i++){
        var m = msgs[i], mine = parseInt(m.sender_id,10)===parseInt(me,10);
        h += '<div class="msg '+(mine?"me":"them")+'">'+esc(m.body)+'<span class="msg-meta">'+esc(fmtDT(m.created_at))+'</span></div>';
      }
      box.innerHTML = h;
      box.scrollTop = box.scrollHeight;
    }
    function loadMsgs(){
      if(window.LN_DASH && window.LN_DASH.ajax){
        lnPost("ln_get_messages", {with:msgWith}, function(d){
          if(d){ renderThread(d.messages||[], d.me, d.teacher_assigned); }
        });
      }
    }
    function renderMsgs(){ loadMsgs(); }
    function sendMsg(){
      var inp = $("dashMsgIn"), v = inp.value.replace(/^\s+|\s+$/g, "");
      if(!v) return;
      if(window.LN_DASH && window.LN_DASH.ajax){
        inp.disabled = true;
        lnPost("ln_send_message", {text:v, to:msgWith}, function(d){
          inp.disabled = false; inp.value = ""; inp.focus();
          if(d){ renderThread(d.messages||[], d.me, true); } else { loadMsgs(); }
        });
      }
    }
    $("dashMsgSend").addEventListener("click", sendMsg);
    $("dashMsgIn").addEventListener("keydown", function(e){ if(e.key==="Enter"){ e.preventDefault(); sendMsg(); } });
    var msgTabs = document.querySelectorAll(".msg-tab");
    for(var mti=0; mti<msgTabs.length; mti++){
      msgTabs[mti].addEventListener("click", function(){
        msgWith = this.getAttribute("data-with");
        for(var j=0;j<msgTabs.length;j++){ msgTabs[j].classList.toggle("active", msgTabs[j]===this); }
        loadMsgs();
      });
    }

    /* ---------- overview stats ---------- */
    function latestScores(){
      var scores = getScores(), latest = {}, order = [], i;
      for(i=0;i<scores.length;i++){
        var r = scores[i];
        if(!(r.s in latest)){ order.push(r.s); latest[r.s] = r; }
        if(r.t >= latest[r.s].t){ latest[r.s] = r; }
      }
      return {order:order, latest:latest};
    }
    function renderStats(){
      $("statLessons").textContent = D.timetable.length || D.lessons.length;
      var ls = latestScores();
      if(ls.order.length){
        var sum = 0, low = ls.order[0], i;
        for(i=0;i<ls.order.length;i++){
          var p = ls.latest[ls.order[i]].p; sum += p;
          if(p < ls.latest[low].p) low = ls.order[i];
        }
        $("statAvg").textContent = Math.round(sum/ls.order.length) + "%";
        $("statFocus").textContent = low;
      } else {
        $("statAvg").textContent = "\u2013";
        $("statFocus").textContent = "\u2013";
      }
    }

    /* ---------- account ---------- */
    function updateHello(name){
      $("dashHello").textContent = name ? "Here is your learning hub." : "Welcome to your learning hub.";
      $("dashUname").textContent = name || "Student";
      var initial = (name || "S").replace(/^\s+/, "").charAt(0).toUpperCase() || "S";
      $("dashAva").textContent = initial;
    }
    function renderAccount(){
      var a = store.get("account", {name:"", subjects:[]});
      var nm = a.name || D.student_name || "";
      $("dashAcName").value = nm;
      var box = $("dashAcSubjects"), h = "";
      for(var i=0;i<SUBJECTS.length;i++){
        var checked = (a.subjects && a.subjects.indexOf(SUBJECTS[i])!==-1) ? " checked" : "";
        h += '<label><input type="checkbox" value="'+esc(SUBJECTS[i])+'"'+checked+'> '+esc(SUBJECTS[i])+'</label>';
      }
      box.innerHTML = h;
      updateHello(nm);
    }
    $("dashAcSave").addEventListener("click", function(){
      var name = $("dashAcName").value.replace(/^\s+|\s+$/g, ""), subs = [];
      var boxes = $("dashAcSubjects").querySelectorAll('input[type="checkbox"]');
      for(var i=0;i<boxes.length;i++){ if(boxes[i].checked){ subs.push(boxes[i].value); } }
      store.set("account", {name:name, subjects:subs});
      updateHello(name);
      var note = $("dashAcNote");
      note.style.display = "block";
      setTimeout(function(){ note.style.display = "none"; }, 3000);
    });

    /* ---------- init ---------- */
    fillSelect($("dashLesSubj"), SUBJECTS);
    fillSelect($("dashLesDay"), DAYS);
    fillSelect($("dashBkSubj"), SUBJECTS);
    fillSelect($("dashBkDay"), DAYS);
    fillSelect($("dashScoreSubj"), SUBJECTS);
    loadState(function(){
      renderTimetable();
      renderLessons();
      renderScores();
      renderMsgs();
      renderAccount();
    });
  })();
  </script>
</div>
<!-- /ln-dash -->
