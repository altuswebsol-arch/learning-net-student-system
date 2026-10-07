<!-- Learning Net: Admin Dashboard | Strictly UK English, zero Urdu -->
<div id="ln-admindash">
  <style>
    #ln-admindash { font-family:'DM Sans','Manrope',-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif; color:#102422; max-width:1240px; margin:0 auto; }
    #ln-admindash .adash-shell { display:flex; background:#fff; border:1px solid #dce7e3; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,111,96,.10); min-height:600px; }
    #ln-admindash .adash-side { width:270px; flex:none; background:linear-gradient(175deg,#0b2e29 0%,#005449 60%,#006f60 100%); padding:28px 16px; color:#fff; }
    #ln-admindash .adash-brand { font-weight:800; color:#fff; font-size:18px; line-height:1.35; letter-spacing:.2px; }
    #ln-admindash .adash-brand small { display:block; font-weight:400; color:rgba(255,255,255,.78); font-size:12.5px; margin-top:3px; letter-spacing:.6px; text-transform:uppercase; }
    #ln-admindash .adash-user { display:flex; align-items:center; gap:12px; margin:20px 2px 22px; padding:12px; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:12px; }
    #ln-admindash .adash-ava { width:44px; height:44px; flex:none; border-radius:50%; background:linear-gradient(135deg,#f5c64f,#e0a92e); color:#102422; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; }
    #ln-admindash .adash-uname { font-weight:700; font-size:15.5px; color:#fff; }
    #ln-admindash .adash-hello { font-size:12.5px; color:rgba(255,255,255,.72); margin:2px 0 0; line-height:1.45; }
    #ln-admindash .adash-tabbtn { display:flex; align-items:center; gap:10px; width:100%; text-align:left; background:rgba(255,255,255,.08); border:none; padding:11px 14px; border-radius:10px; font-size:15px; font-weight:600; color:#fff; cursor:pointer; margin-bottom:6px; font-family:inherit; transition:background .15s ease; }
    #ln-admindash .adash-tabbtn:hover { background:rgba(255,255,255,.20); }
    #ln-admindash .adash-tabbtn.active { background:#fff; color:#005449; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,.18); }
    #ln-admindash .adash-tabbtn .bdg { margin-left:auto; min-width:22px; height:22px; padding:0 6px; border-radius:11px; background:#f5c64f; color:#102422; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; }
    #ln-admindash .adash-main { flex:1; min-width:0; padding:30px 34px; background:#f7faf8; }
    #ln-admindash h2.adash-h { color:#102422 !important; font-size:22px; margin:0 0 4px; }
    #ln-admindash .adash-sub { color:#526663; font-size:14.5px; margin:0 0 18px; line-height:1.55; }
    #ln-admindash .adash-card { background:#fff; border:1px solid #dce7e3; border-radius:12px; padding:18px; margin-bottom:14px; }
    #ln-admindash .adash-card h3 { color:#102422 !important; font-size:16.5px; margin:0 0 12px; }
    #ln-admindash .adash-empty { background:#f2faf6; border:1px dashed #aed9c8; border-radius:12px; padding:40px 20px; text-align:center; color:#526663; font-size:15px; line-height:1.6; }
    #ln-admindash .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
    #ln-admindash .stat-card { background:#fff; border:1px solid #e8ecf3; border-radius:14px; padding:18px 20px; box-shadow:0 2px 12px rgba(16,36,34,.06); position:relative; overflow:hidden; }
    #ln-admindash .stat-card::before { content:""; position:absolute; left:0; top:0; bottom:0; width:4px; background:linear-gradient(180deg,#006f60,#58c7ab); }
    #ln-admindash .stat-num { font-size:26px; font-weight:800; color:#102422; line-height:1.15; }
    #ln-admindash .stat-lbl { font-size:12px; color:#526663; margin-top:5px; letter-spacing:.5px; text-transform:uppercase; font-weight:600; }
    #ln-admindash .adash-in, #ln-admindash textarea.adash-in, #ln-admindash select.adash-in { padding:10px 12px; border:1px solid #c4d4cc; border-radius:8px; font-size:14.5px; color:#102422; background:#fff; font-family:inherit; width:100%; box-sizing:border-box; }
    #ln-admindash textarea.adash-in { min-height:120px; resize:vertical; line-height:1.6; }
    #ln-admindash .adash-hint { font-size:13px; color:#526663; margin:8px 0 12px; line-height:1.55; }
    #ln-admindash .adash-btn { display:inline-block; border:none; cursor:pointer; border-radius:8px; font-size:15px; font-weight:700; padding:11px 24px; background:#006f60; color:#fff; font-family:inherit; }
    #ln-admindash .adash-btn:hover { opacity:.93; }
    #ln-admindash .adash-btn:disabled { opacity:.55; cursor:default; }
    #ln-admindash .adash-btn.ghost { background:#eef9f5; color:#005449; border:1px solid #aed9c8; }
    #ln-admindash .adash-btn.small { padding:7px 14px; font-size:13.5px; }
    #ln-admindash .adash-flash { display:none; background:#eef9f5; border:1px solid #aed9c8; color:#005449; border-radius:10px; padding:11px 15px; font-size:14px; margin-bottom:14px; }
    #ln-admindash .adash-flash.err { background:#fdecea; border-color:#f5b5ac; color:#a4261a; }
    #ln-admindash table.adash-table { width:100%; border-collapse:collapse; font-size:14.5px; }
    #ln-admindash table.adash-table th { text-align:left; font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:#526663; padding:10px 12px; border-bottom:2px solid #dce7e3; }
    #ln-admindash table.adash-table td { padding:11px 12px; border-bottom:1px solid #eef2f0; vertical-align:middle; }
    #ln-admindash table.adash-table tr:last-child td { border-bottom:none; }
    #ln-admindash .adash-form { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    #ln-admindash .adash-form label { display:block; font-weight:700; font-size:13.5px; margin:0 0 6px; }
    #ln-admindash .msg-wrap { display:flex; gap:14px; }
    #ln-admindash .msg-list { width:250px; flex:none; max-height:480px; overflow-y:auto; }
    #ln-admindash .msg-person { display:block; width:100%; text-align:left; background:#fff; border:1px solid #dce7e3; border-radius:10px; padding:10px 12px; margin-bottom:8px; cursor:pointer; font-family:inherit; font-size:14.5px; color:#102422; }
    #ln-admindash .msg-person:hover { border-color:#006f60; }
    #ln-admindash .msg-person.active { border-color:#006f60; box-shadow:0 0 0 2px rgba(0,111,96,.15); font-weight:700; }
    #ln-admindash .msg-person .kind { display:block; font-size:12px; color:#526663; font-weight:400; }
    #ln-admindash .msg-person .bdg { float:right; min-width:22px; height:22px; padding:0 6px; border-radius:11px; background:#f5c64f; color:#102422; font-size:12px; font-weight:800; text-align:center; line-height:22px; }
    #ln-admindash .msg-main { flex:1; min-width:0; }
    #ln-admindash .msg-thread { max-height:340px; overflow-y:auto; padding:6px 2px 12px; }
    #ln-admindash .msg { max-width:78%; padding:10px 14px; border-radius:14px; margin-bottom:10px; font-size:14.5px; line-height:1.5; word-wrap:break-word; }
    #ln-admindash .msg.me { background:#006f60; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    #ln-admindash .msg.them { background:#e9f0ec; color:#102422; border-bottom-left-radius:4px; }
    #ln-admindash .msg.sys { background:#f2faf6; color:#526663; margin:0 auto 12px; text-align:center; max-width:92%; font-size:13.5px; }
    #ln-admindash .msg-meta { display:block; font-size:11.5px; opacity:.75; margin-top:4px; }
    #ln-admindash .msg-form { display:flex; gap:8px; }
    #ln-admindash .msg-form input { flex:1; min-width:0; }
    #ln-admindash .meet-link { word-break:break-all; font-size:14px; }
    @media (max-width:960px){
      #ln-admindash .adash-shell { flex-direction:column; }
      #ln-admindash .adash-side { width:auto; }
      #ln-admindash .stat-grid { grid-template-columns:1fr 1fr; }
      #ln-admindash .adash-form { grid-template-columns:1fr; }
      #ln-admindash .msg-wrap { flex-direction:column; }
      #ln-admindash .msg-list { width:auto; max-height:220px; }
    }
  </style>
  <div class="adash-shell">
    <aside class="adash-side">
      <div class="adash-brand">The Learning Net<small>Admin Dashboard</small></div>
      <div class="adash-user">
        <div class="adash-ava" id="adAva">A</div>
        <div><div class="adash-uname" id="adUname">Admin</div><p class="adash-hello">Full control of your school.</p></div>
      </div>
      <button type="button" class="adash-tabbtn active" data-tab="overview">Overview</button>
      <button type="button" class="adash-tabbtn" data-tab="students">Students</button>
      <button type="button" class="adash-tabbtn" data-tab="teachers">Teachers</button>
      <button type="button" class="adash-tabbtn" data-tab="timetables">Timetables</button>
      <button type="button" class="adash-tabbtn" data-tab="subjects">Subjects</button>
      <button type="button" class="adash-tabbtn" data-tab="messages">Messages<span class="bdg" id="adMsgBdg" style="display:none">0</span></button>
      <button type="button" class="adash-tabbtn" data-tab="meetings">Meeting Links</button>
    </aside>
    <div class="adash-main">

      <section class="adash-sec" id="adsec-overview">
        <h2 class="adash-h">Overview</h2>
        <p class="adash-sub">Your whole school at a glance.</p>
        <div class="stat-grid">
          <div class="stat-card"><div class="stat-num" id="adStatStudents">&ndash;</div><div class="stat-lbl">Students</div></div>
          <div class="stat-card"><div class="stat-num" id="adStatTeachers">&ndash;</div><div class="stat-lbl">Teachers</div></div>
          <div class="stat-card"><div class="stat-num" id="adStatPending">&ndash;</div><div class="stat-lbl">Pending Verifications</div></div>
          <div class="stat-card"><div class="stat-num" id="adStatUnread">&ndash;</div><div class="stat-lbl">Unread Messages</div></div>
        </div>
        <div class="adash-card">
          <h3>Quick actions</h3>
          <p class="adash-sub" style="margin-bottom:12px;">Jump straight to the task you need.</p>
          <button type="button" class="adash-btn ghost small" data-goto="students" style="margin:0 8px 8px 0;">Manage students</button>
          <button type="button" class="adash-btn ghost small" data-goto="teachers" style="margin:0 8px 8px 0;">Manage teachers</button>
          <button type="button" class="adash-btn ghost small" data-goto="messages" style="margin:0 8px 8px 0;">Read messages</button>
          <button type="button" class="adash-btn ghost small" data-goto="meetings" style="margin:0 8px 8px 0;">Set meeting links</button>
        </div>
      </section>

      <section class="adash-sec" id="adsec-students" style="display:none">
        <h2 class="adash-h">Students</h2>
        <p class="adash-sub">Every student, their teacher, and their timetable. Use the dropdown to allot or move a student.</p>
        <div class="adash-flash" id="adStuFlash"></div>
        <div class="adash-card">
          <button type="button" class="adash-btn" id="adStuAddToggle">Add student</button>
          <div id="adStuAddForm" style="display:none;margin-top:16px;">
            <div class="adash-form">
              <div><label for="adStuName">Full name</label><input class="adash-in" id="adStuName" type="text" autocomplete="off"></div>
              <div><label for="adStuUser">Username</label><input class="adash-in" id="adStuUser" type="text" autocomplete="off"></div>
              <div><label for="adStuEmail">Email</label><input class="adash-in" id="adStuEmail" type="email" autocomplete="off"></div>
              <div><label for="adStuPass">Password</label><input class="adash-in" id="adStuPass" type="text" autocomplete="new-password"></div>
            </div>
            <p style="margin:12px 0 0;"><button type="button" class="adash-btn" id="adStuAddGo">Create student account</button></p>
            <p class="adash-hint">The student can log in straight away with this username and password.</p>
          </div>
        </div>
        <div class="adash-card" style="padding:6px 18px;">
          <div style="overflow-x:auto;">
          <table class="adash-table">
            <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Assigned teacher</th><th>Timetable</th><th></th></tr></thead>
            <tbody id="adStuRows"><tr><td colspan="6">Loading students&hellip;</td></tr></tbody>
          </table>
          </div>
        </div>
      </section>

      <section class="adash-sec" id="adsec-teachers" style="display:none">
        <h2 class="adash-h">Teachers</h2>
        <p class="adash-sub">Every teacher and how many students are allotted to them.</p>
        <div class="adash-flash" id="adTeachFlash"></div>
        <div class="adash-card">
          <button type="button" class="adash-btn" id="adTeachAddToggle">Add teacher</button>
          <div id="adTeachAddForm" style="display:none;margin-top:16px;">
            <div class="adash-form">
              <div><label for="adTeachName">Full name</label><input class="adash-in" id="adTeachName" type="text" autocomplete="off"></div>
              <div><label for="adTeachUser">Username</label><input class="adash-in" id="adTeachUser" type="text" autocomplete="off"></div>
              <div><label for="adTeachEmail">Email</label><input class="adash-in" id="adTeachEmail" type="email" autocomplete="off"></div>
              <div><label for="adTeachPass">Password</label><input class="adash-in" id="adTeachPass" type="text" autocomplete="new-password"></div>
            </div>
            <p style="margin:12px 0 0;"><button type="button" class="adash-btn" id="adTeachAddGo">Create teacher account</button></p>
            <p class="adash-hint">The teacher logs in at the login page and sees only the students you allot to them.</p>
          </div>
        </div>
        <div class="adash-card" style="padding:6px 18px;">
          <div style="overflow-x:auto;">
          <table class="adash-table">
            <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Students</th><th></th></tr></thead>
            <tbody id="adTeachRows"><tr><td colspan="5">Loading teachers&hellip;</td></tr></tbody>
          </table>
          </div>
        </div>
      </section>

      <section class="adash-sec" id="adsec-timetables" style="display:none">
        <h2 class="adash-h">Timetables</h2>
        <p class="adash-sub">Set any student's official timetable. The student sees it on their dashboard.</p>
        <div class="adash-flash" id="adTTFlash"></div>
        <div class="adash-card">
          <label for="adTTStudent" style="display:block;font-weight:700;font-size:13.5px;margin:0 0 6px;">Student</label>
          <select class="adash-in" id="adTTStudent" style="max-width:420px;"><option value="0">Select a student&hellip;</option></select>
        </div>
        <div class="adash-card" id="adTTCard" style="display:none">
          <h3 id="adTTName">Timetable</h3>
          <p class="adash-sub" style="margin-bottom:12px;">One lesson per line: <strong>Subject | Day | Time</strong>.</p>
          <div id="adTTView" style="margin-bottom:12px;"></div>
          <textarea class="adash-in" id="adTTEdit" aria-label="Edit timetable"></textarea>
          <p class="adash-hint">Example: <code>Mathematics | Monday | 14:30</code></p>
          <button class="adash-btn" id="adTTSave" type="button">Save timetable</button>
        </div>
      </section>

      <section class="adash-sec" id="adsec-subjects" style="display:none">
        <h2 class="adash-h">Subjects</h2>
        <p class="adash-sub">The subject list used across the school &mdash; lesson booking, practice scores and timetables.</p>
        <div class="adash-flash" id="adSubjFlash"></div>
        <div class="adash-card">
          <label for="adSubjEdit" style="display:block;font-weight:700;font-size:13.5px;margin:0 0 6px;">Subjects (one per line)</label>
          <textarea class="adash-in" id="adSubjEdit" rows="12" aria-label="Edit subjects"></textarea>
          <p style="margin:12px 0 0;"><button class="adash-btn" id="adSubjSave" type="button">Save subjects</button></p>
        </div>
      </section>

      <section class="adash-sec" id="adsec-messages" style="display:none">
        <h2 class="adash-h">Messages</h2>
        <p class="adash-sub">Message any student or teacher. They will see it on their dashboard.</p>
        <div class="adash-flash" id="adMsgFlash"></div>
        <div class="msg-wrap">
          <div class="msg-list" id="adMsgList"><div class="adash-empty" style="padding:20px;">Loading people&hellip;</div></div>
          <div class="msg-main">
            <div class="adash-card">
              <h3 id="adMsgName">Select someone on the left</h3>
              <div class="msg-thread" id="adMsgThread"><div class="msg sys">Choose a student or teacher to start messaging.</div></div>
              <div class="msg-form">
                <input class="adash-in" id="adMsgIn" type="text" placeholder="Write a message&hellip;" maxlength="2000" aria-label="Write a message">
                <button class="adash-btn" id="adMsgSend" type="button">Send</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="adash-sec" id="adsec-meetings" style="display:none">
        <h2 class="adash-h">Meeting Links</h2>
        <p class="adash-sub">Set the MS Teams or Zoom link each student uses for lessons. The student and their teacher both see a &ldquo;Join lesson&rdquo; button.</p>
        <div class="adash-flash" id="adMeetFlash"></div>
        <div class="adash-card">
          <label for="adMeetStudent" style="display:block;font-weight:700;font-size:13.5px;margin:0 0 6px;">Student</label>
          <select class="adash-in" id="adMeetStudent" style="max-width:420px;"><option value="0">Select a student&hellip;</option></select>
        </div>
        <div class="adash-card" id="adMeetCard" style="display:none">
          <h3 id="adMeetName">Meeting link</h3>
          <div id="adMeetCurrent" style="margin-bottom:14px;"></div>
          <div class="adash-form">
            <div><label for="adMeetLabel">Platform</label>
              <select class="adash-in" id="adMeetLabel"><option>MS Teams</option><option>Zoom</option></select>
            </div>
            <div><label for="adMeetLink">Meeting link (URL)</label><input class="adash-in" id="adMeetLink" type="url" placeholder="https://&hellip;" autocomplete="off"></div>
          </div>
          <p style="margin:12px 0 0;">
            <button class="adash-btn" id="adMeetSave" type="button">Save meeting link</button>
            <button class="adash-btn ghost" id="adMeetClear" type="button" style="margin-left:8px;">Remove link</button>
          </p>
          <p class="adash-hint">Leave the link empty and save to remove it. The student and teacher join through this link.</p>
        </div>
      </section>

    </div>
  </div>
  <script>
  (function(){
    "use strict";
    function esc(s){ return String(s===null||s===undefined?"":s).replace(/[&<>"']/g,function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]; }); }
    function $(id){ return document.getElementById(id); }
    function fmtDT(s){ try{ var d=new Date(String(s).replace(" ","T")); if(isNaN(d)) return ""; return d.toLocaleDateString("en-GB",{day:"numeric",month:"short"})+" "+d.toLocaleTimeString("en-GB",{hour:"2-digit",minute:"2-digit"}); }catch(e){ return ""; } }
    function flash(id,msg,isErr){ var f=$(id); f.textContent=msg; f.className="adash-flash"+(isErr?" err":""); f.style.display="block"; setTimeout(function(){ f.style.display="none"; },4000); }

    function aPost(action, extra, cb){
      if(!(window.LN_ADMIN && window.LN_ADMIN.ajax)){ cb(null); return; }
      try{
        var fd=new FormData();
        fd.append("action", action);
        fd.append("nonce", window.LN_ADMIN.nonce);
        if(extra){ for(var k in extra){ fd.append(k, extra[k]); } }
        fetch(window.LN_ADMIN.ajax,{method:"POST",body:fd,credentials:"same-origin"})
          .then(function(r){ return r.json(); })
          .then(function(j){ cb(j && j.success ? j.data : null); })
          .catch(function(){ cb(null); });
      }catch(e){ cb(null); }
    }

    /* ---------- tabs ---------- */
    var tabBtns=document.querySelectorAll(".adash-tabbtn");
    function showTab(name){
      for(var i=0;i<tabBtns.length;i++){ tabBtns[i].classList.toggle("active", tabBtns[i].getAttribute("data-tab")===name); }
      var secs=document.querySelectorAll(".adash-sec");
      for(var j=0;j<secs.length;j++){ secs[j].style.display = (secs[j].id==="adsec-"+name) ? "block" : "none"; }
      if(name==="overview") loadOverview();
      if(name==="students") loadStudents();
      if(name==="teachers") loadTeachers();
      if(name==="subjects") loadSubjects();
      if(name==="messages") loadPeople();
      if(window.innerWidth<961){ document.getElementById("ln-admindash").scrollIntoView({behavior:"smooth"}); }
    }
    for(var t=0;t<tabBtns.length;t++){ tabBtns[t].addEventListener("click", function(){ showTab(this.getAttribute("data-tab")); }); }
    var gotoBtns=document.querySelectorAll("[data-goto]");
    for(var g=0;g<gotoBtns.length;g++){ gotoBtns[g].addEventListener("click", function(){ showTab(this.getAttribute("data-goto")); }); }

    var teachersCache=[], studentsCache=[], peopleCache=[];
    var curTTStudent=0, curMsgPerson=0, curMeetStudent=0, msgPoll=null;

    /* ---------- overview ---------- */
    function loadOverview(){
      aPost("ln_admin_get_overview", null, function(d){
        if(!d) return;
        $("adStatStudents").textContent=d.students;
        $("adStatTeachers").textContent=d.teachers;
        $("adStatPending").textContent=d.pending;
        $("adStatUnread").textContent=d.unread;
        var b=$("adMsgBdg");
        if(d.unread>0){ b.textContent=d.unread; b.style.display="flex"; } else { b.style.display="none"; }
      });
    }

    /* ---------- students ---------- */
    function teacherOptions(sel){
      var h='<option value="0">&mdash; Not assigned &mdash;</option>';
      for(var i=0;i<teachersCache.length;i++){ var t=teachersCache[i]; h+='<option value="'+t.id+'"'+(parseInt(sel,10)===t.id?' selected':'')+'>'+esc(t.name)+'</option>'; }
      return h;
    }
    function loadStudents(){
      aPost("ln_admin_get_students", null, function(d){
        var tb=$("adStuRows");
        if(!d){ tb.innerHTML='<tr><td colspan="6">Could not load students.</td></tr>'; return; }
        studentsCache=d.students||[]; teachersCache=d.teachers||[];
        fillStudentSelects();
        if(!studentsCache.length){ tb.innerHTML='<tr><td colspan="6">No students yet. Add your first student above.</td></tr>'; return; }
        var h="";
        for(var i=0;i<studentsCache.length;i++){
          var s=studentsCache[i];
          h+='<tr><td><strong>'+esc(s.name)+'</strong></td><td>'+esc(s.username)+'</td><td>'+esc(s.email)+'</td>'
            +'<td><select class="adash-in ad-teachsel" data-sid="'+s.id+'" style="min-width:170px;">'+teacherOptions(s.teacher_id)+'</select></td>'
            +'<td>'+s.tt_count+' lesson'+(s.tt_count===1?'':'s')+'</td>'
            +'<td style="white-space:nowrap;"><button type="button" class="adash-btn ghost small ad-goto-tt" data-sid="'+s.id+'">Timetable</button> '
            +'<button type="button" class="adash-btn ghost small ad-goto-msg" data-pid="'+s.id+'">Message</button></td></tr>';
        }
        tb.innerHTML=h;
        var sels=tb.querySelectorAll(".ad-teachsel");
        for(var j=0;j<sels.length;j++){
          sels[j].addEventListener("change", function(){
            var sid=this.getAttribute("data-sid"), tid=this.value, el=this;
            el.disabled=true;
            aPost("ln_admin_set_teacher",{student_id:sid,teacher_id:tid},function(r){
              el.disabled=false;
              if(r){ flash("adStuFlash","Teacher updated."); loadStudents(); }
              else { flash("adStuFlash","Could not update teacher. Please try again.",true); }
            });
          });
        }
        bindGoto(tb);
      });
    }
    function bindGoto(scope){
      var tts=scope.querySelectorAll(".ad-goto-tt");
      for(var i=0;i<tts.length;i++){ tts[i].addEventListener("click", function(){ showTab("timetables"); setTTStudent(this.getAttribute("data-sid")); }); }
      var ms=scope.querySelectorAll(".ad-goto-msg");
      for(var j=0;j<ms.length;j++){ ms[j].addEventListener("click", function(){ showTab("messages"); selectPerson(parseInt(this.getAttribute("data-pid"),10)); }); }
    }
    function fillStudentSelects(){
      var h='<option value="0">Select a student&hellip;</option>';
      for(var i=0;i<studentsCache.length;i++){ h+='<option value="'+studentsCache[i].id+'">'+esc(studentsCache[i].name)+' ('+esc(studentsCache[i].username)+')</option>'; }
      $("adTTStudent").innerHTML=h;
      $("adMeetStudent").innerHTML=h;
      if(curTTStudent) $("adTTStudent").value=curTTStudent;
      if(curMeetStudent) $("adMeetStudent").value=curMeetStudent;
    }
    $("adStuAddToggle").addEventListener("click", function(){
      var f=$("adStuAddForm"); f.style.display = (f.style.display==="none") ? "block" : "none";
    });
    $("adStuAddGo").addEventListener("click", function(){
      var btn=this; btn.disabled=true;
      aPost("ln_admin_add_user",{role:"ln_student",name:$("adStuName").value,username:$("adStuUser").value,email:$("adStuEmail").value,password:$("adStuPass").value},function(d){
        btn.disabled=false;
        if(d){ flash("adStuFlash","Student account created."); $("adStuName").value="";$("adStuUser").value="";$("adStuEmail").value="";$("adStuPass").value="";$("adStuAddForm").style.display="none"; loadStudents(); }
        else { flash("adStuFlash","Could not create the account. Check the username and email are unique and all fields are filled.",true); }
      });
    });

    /* ---------- teachers ---------- */
    function loadTeachers(){
      aPost("ln_admin_get_teachers", null, function(d){
        var tb=$("adTeachRows");
        if(!d){ tb.innerHTML='<tr><td colspan="5">Could not load teachers.</td></tr>'; return; }
        var ts=d.teachers||[];
        if(!ts.length){ tb.innerHTML='<tr><td colspan="5">No teachers yet. Add your first teacher above.</td></tr>'; return; }
        var h="";
        for(var i=0;i<ts.length;i++){
          var t=ts[i];
          h+='<tr><td><strong>'+esc(t.name)+'</strong></td><td>'+esc(t.username)+'</td><td>'+esc(t.email)+'</td><td>'+t.student_count+'</td>'
            +'<td><button type="button" class="adash-btn ghost small ad-goto-msg" data-pid="'+t.id+'">Message</button></td></tr>';
        }
        tb.innerHTML=h;
        bindGoto(tb);
      });
    }
    $("adTeachAddToggle").addEventListener("click", function(){
      var f=$("adTeachAddForm"); f.style.display = (f.style.display==="none") ? "block" : "none";
    });
    $("adTeachAddGo").addEventListener("click", function(){
      var btn=this; btn.disabled=true;
      aPost("ln_admin_add_user",{role:"teacher",name:$("adTeachName").value,username:$("adTeachUser").value,email:$("adTeachEmail").value,password:$("adTeachPass").value},function(d){
        btn.disabled=false;
        if(d){ flash("adTeachFlash","Teacher account created. Allot students to them from the Students tab."); $("adTeachName").value="";$("adTeachUser").value="";$("adTeachEmail").value="";$("adTeachPass").value="";$("adTeachAddForm").style.display="none"; loadTeachers(); loadStudents(); }
        else { flash("adTeachFlash","Could not create the account. Check the username and email are unique and all fields are filled.",true); }
      });
    });

    /* ---------- timetables ---------- */
    function setTTStudent(id){
      curTTStudent=parseInt(id,10)||0;
      $("adTTStudent").value=curTTStudent;
      loadTT();
    }
    $("adTTStudent").addEventListener("change", function(){ setTTStudent(this.value); });
    function loadTT(){
      var card=$("adTTCard");
      if(!curTTStudent){ card.style.display="none"; return; }
      aPost("ln_admin_get_timetable",{student_id:curTTStudent},function(d){
        if(!d) return;
        card.style.display="block";
        $("adTTName").textContent="Timetable — "+d.name;
        var th="";
        var tt=d.timetable||[];
        if(!tt.length){ th='<p class="adash-sub" style="margin:0;">No timetable set yet.</p>'; }
        for(var j=0;j<tt.length;j++){ th+='<div style="background:#f2faf6;border:1px solid #cde9db;border-radius:10px;padding:10px 14px;margin-bottom:8px;"><strong>'+esc(tt[j].subject)+'</strong> <span style="color:#526663;">'+esc(tt[j].day)+' at '+esc(tt[j].time)+'</span></div>'; }
        $("adTTView").innerHTML=th;
        $("adTTEdit").value=d.timetable_text||"";
      });
    }
    $("adTTSave").addEventListener("click", function(){
      if(!curTTStudent) return;
      var btn=this; btn.disabled=true; btn.textContent="Saving\u2026";
      aPost("ln_admin_save_timetable",{student_id:curTTStudent,timetable:$("adTTEdit").value},function(d){
        btn.disabled=false; btn.textContent="Save timetable";
        if(d){ loadTT(); flash("adTTFlash","Timetable saved. The student now sees the updated timetable."); }
        else { flash("adTTFlash","Could not save. Please try again.",true); }
      });
    });

    /* ---------- subjects ---------- */
    function loadSubjects(){
      aPost("ln_admin_get_subjects", null, function(d){
        if(!d) return;
        $("adSubjEdit").value=(d.subjects||[]).join("\n");
      });
    }
    $("adSubjSave").addEventListener("click", function(){
      var btn=this; btn.disabled=true; btn.textContent="Saving\u2026";
      aPost("ln_admin_save_subjects",{subjects:$("adSubjEdit").value},function(d){
        btn.disabled=false; btn.textContent="Save subjects";
        if(d){ flash("adSubjFlash","Subjects saved."); }
        else { flash("adSubjFlash","Could not save. Add at least one subject.",true); }
      });
    });

    /* ---------- messages ---------- */
    function loadPeople(){
      aPost("ln_admin_get_people", null, function(d){
        var box=$("adMsgList");
        if(!d){ box.innerHTML='<div class="adash-empty" style="padding:20px;">Could not load people.</div>'; return; }
        peopleCache=d.people||[];
        if(!peopleCache.length){ box.innerHTML='<div class="adash-empty" style="padding:20px;">No students or teachers yet.</div>'; return; }
        var h="";
        for(var i=0;i<peopleCache.length;i++){
          var p=peopleCache[i];
          h+='<button type="button" class="msg-person'+(p.id===curMsgPerson?' active':'')+'" data-pid="'+p.id+'">'+(p.unread>0?'<span class="bdg">'+p.unread+'</span>':'')+esc(p.name)+'<span class="kind">'+esc(p.kind)+'</span></button>';
        }
        box.innerHTML=h;
        var btns=box.querySelectorAll(".msg-person");
        for(var j=0;j<btns.length;j++){ btns[j].addEventListener("click", function(){ selectPerson(parseInt(this.getAttribute("data-pid"),10)); }); }
        loadOverview();
      });
    }
    function personName(id){
      for(var i=0;i<peopleCache.length;i++){ if(peopleCache[i].id===id) return peopleCache[i].name; }
      return "";
    }
    function selectPerson(id){
      curMsgPerson=id;
      var btns=$("adMsgList").querySelectorAll(".msg-person");
      for(var i=0;i<btns.length;i++){ btns[i].classList.toggle("active", parseInt(btns[i].getAttribute("data-pid"),10)===id); }
      $("adMsgName").textContent=personName(id)||"Messages";
      loadMsgs(); startMsgPoll();
    }
    function loadMsgs(){
      if(!curMsgPerson) return;
      aPost("ln_admin_get_messages",{other_id:curMsgPerson},function(d){
        if(!d) return;
        renderMsgs(d.messages||[], d.me); loadPeopleQuiet();
      });
    }
    function loadPeopleQuiet(){
      aPost("ln_admin_get_people", null, function(d){
        if(!d) return;
        peopleCache=d.people||[];
        var box=$("adMsgList"), h="";
        for(var i=0;i<peopleCache.length;i++){
          var p=peopleCache[i];
          h+='<button type="button" class="msg-person'+(p.id===curMsgPerson?' active':'')+'" data-pid="'+p.id+'">'+(p.unread>0?'<span class="bdg">'+p.unread+'</span>':'')+esc(p.name)+'<span class="kind">'+esc(p.kind)+'</span></button>';
        }
        box.innerHTML=h;
        var btns=box.querySelectorAll(".msg-person");
        for(var j=0;j<btns.length;j++){ btns[j].addEventListener("click", function(){ selectPerson(parseInt(this.getAttribute("data-pid"),10)); }); }
      });
    }
    function renderMsgs(msgs, me){
      var box=$("adMsgThread"), h="";
      if(!msgs.length){ h+='<div class="msg sys">No messages yet. Say hello.</div>'; }
      for(var i=0;i<msgs.length;i++){
        var m=msgs[i], mine=parseInt(m.sender_id,10)===parseInt(me,10);
        h+='<div class="msg '+(mine?"me":"them")+'">'+esc(m.body)+'<span class="msg-meta">'+esc(fmtDT(m.created_at))+'</span></div>';
      }
      box.innerHTML=h;
      box.scrollTop=box.scrollHeight;
    }
    function sendMsg(){
      var inp=$("adMsgIn"), v=inp.value.replace(/^\s+|\s+$/g,"");
      if(!v || !curMsgPerson){ if(!curMsgPerson) flash("adMsgFlash","Select a student or teacher first.",true); return; }
      inp.disabled=true;
      aPost("ln_admin_send_message",{other_id:curMsgPerson,text:v},function(d){
        inp.disabled=false; inp.value=""; inp.focus();
        if(d){ renderMsgs(d.messages||[], d.me); loadPeopleQuiet(); }
        else { flash("adMsgFlash","Could not send. Please try again.",true); }
      });
    }
    $("adMsgSend").addEventListener("click", sendMsg);
    $("adMsgIn").addEventListener("keydown", function(e){ if(e.key==="Enter"){ e.preventDefault(); sendMsg(); } });
    function startMsgPoll(){ stopMsgPoll(); msgPoll=setInterval(function(){ if(document.hidden) return; if(curMsgPerson) loadMsgs(); }, 20000); }
    function stopMsgPoll(){ if(msgPoll){ clearInterval(msgPoll); msgPoll=null; } }

    /* ---------- meetings ---------- */
    function setMeetStudent(id){
      curMeetStudent=parseInt(id,10)||0;
      $("adMeetStudent").value=curMeetStudent;
      loadMeeting();
    }
    $("adMeetStudent").addEventListener("change", function(){ setMeetStudent(this.value); });
    function renderMeeting(m){
      var box=$("adMeetCurrent");
      if(m && m.link){
        box.innerHTML='<p style="margin:0 0 6px;"><strong>Current link:</strong> <span class="meet-link"><a href="'+esc(m.link)+'" target="_blank" rel="noopener">'+esc(m.link)+'</a></span></p><p class="adash-sub" style="margin:0;">Platform: '+esc(m.label)+'</p>';
        $("adMeetLabel").value=m.label;
        $("adMeetLink").value=m.link;
      } else {
        box.innerHTML='<p class="adash-sub" style="margin:0;">No meeting link set for this student yet.</p>';
        $("adMeetLink").value="";
      }
    }
    function loadMeeting(){
      var card=$("adMeetCard");
      if(!curMeetStudent){ card.style.display="none"; return; }
      aPost("ln_admin_get_meeting",{student_id:curMeetStudent},function(d){
        if(!d) return;
        card.style.display="block";
        $("adMeetName").textContent="Meeting link — "+d.name;
        renderMeeting(d.meeting);
      });
    }
    $("adMeetSave").addEventListener("click", function(){
      if(!curMeetStudent) return;
      var btn=this; btn.disabled=true; btn.textContent="Saving\u2026";
      aPost("ln_admin_save_meeting",{student_id:curMeetStudent,label:$("adMeetLabel").value,link:$("adMeetLink").value},function(d){
        btn.disabled=false; btn.textContent="Save meeting link";
        if(d){ renderMeeting(d.meeting); flash("adMeetFlash","Meeting link saved. The student and teacher now see the Join button."); }
        else { flash("adMeetFlash","Could not save. Please try again.",true); }
      });
    });
    $("adMeetClear").addEventListener("click", function(){
      if(!curMeetStudent) return;
      var btn=this; btn.disabled=true;
      aPost("ln_admin_save_meeting",{student_id:curMeetStudent,label:"MS Teams",link:""},function(d){
        btn.disabled=false;
        if(d){ renderMeeting(d.meeting); flash("adMeetFlash","Meeting link removed."); }
        else { flash("adMeetFlash","Could not remove. Please try again.",true); }
      });
    });

    var nm=(window.LN_ADMIN&&window.LN_ADMIN.admin_name)||"";
    if(nm){ $("adUname").textContent=nm; $("adAva").textContent=nm.charAt(0).toUpperCase(); }
    loadOverview();
    loadStudents();
  })();
  </script>
</div>
