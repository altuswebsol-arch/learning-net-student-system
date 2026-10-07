<!-- Learning Net: Teacher Dashboard | Strictly UK English, zero Urdu -->
<div id="ln-teachdash">
  <style>
    #ln-teachdash { font-family:'DM Sans','Manrope',-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif; color:#102422; max-width:1240px; margin:0 auto; }
    #ln-teachdash .tdash-shell { display:flex; background:#fff; border:1px solid #dce7e3; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,111,96,.10); min-height:560px; }
    #ln-teachdash .tdash-side { width:290px; flex:none; background:linear-gradient(175deg,#005449 0%,#006f60 55%,#58c7ab 100%); padding:28px 16px; color:#fff; }
    #ln-teachdash .tdash-brand { font-weight:800; color:#fff; font-size:18px; line-height:1.35; letter-spacing:.2px; }
    #ln-teachdash .tdash-brand small { display:block; font-weight:400; color:rgba(255,255,255,.78); font-size:12.5px; margin-top:3px; letter-spacing:.6px; text-transform:uppercase; }
    #ln-teachdash .tdash-user { display:flex; align-items:center; gap:12px; margin:20px 2px 22px; padding:12px; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:12px; }
    #ln-teachdash .tdash-ava { width:44px; height:44px; flex:none; border-radius:50%; background:linear-gradient(135deg,#006f60,#006f60); color:#fff; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,.25); }
    #ln-teachdash .tdash-uname { font-weight:700; font-size:15.5px; color:#fff; }
    #ln-teachdash .tdash-hello { font-size:12.5px; color:rgba(255,255,255,.72); margin:2px 0 0; line-height:1.45; }
    #ln-teachdash .tdash-sidelabel { font-size:12px; letter-spacing:.8px; text-transform:uppercase; color:rgba(255,255,255,.65); margin:4px 4px 10px; font-weight:700; }
    #ln-teachdash .tdash-stubtn { display:flex; align-items:center; gap:10px; width:100%; text-align:left; background:rgba(255,255,255,.10); border:none; padding:11px 14px; border-radius:10px; font-size:15px; font-weight:600; color:#fff; cursor:pointer; margin-bottom:6px; font-family:inherit; transition:background .15s ease; }
    #ln-teachdash .tdash-stubtn:hover { background:rgba(255,255,255,.22); }
    #ln-teachdash .tdash-stubtn.active { background:#fff; color:#005449; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,.18); }
    #ln-teachdash .tdash-stubtn .nm { flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    #ln-teachdash .tdash-badge { flex:none; min-width:22px; height:22px; padding:0 6px; border-radius:11px; background:#f5c64f; color:#102422; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; }
    #ln-teachdash .tdash-sideempty { color:rgba(255,255,255,.75); font-size:14px; padding:8px 4px; line-height:1.55; }
    #ln-teachdash .tdash-main { flex:1; min-width:0; padding:30px 34px; background:#f7faf8; }
    #ln-teachdash h2.tdash-h { color:#102422 !important; font-size:22px; margin:0 0 4px; }
    #ln-teachdash .tdash-pagehead { margin:0 0 18px; }
    #ln-teachdash h1.tdash-pagetitle { color:#102422 !important; font-size:28px; line-height:1.2; margin:0 0 4px; font-family:'Manrope','DM Sans',sans-serif; }
    #ln-teachdash .tdash-pagesub { color:#526663 !important; margin:0; font-size:14px; }
    #ln-teachdash .tdash-sub { color:#526663; font-size:14.5px; margin:0 0 18px; line-height:1.55; }
    #ln-teachdash .tdash-card { background:#fff; border:1px solid #dce7e3; border-radius:12px; padding:18px; margin-bottom:14px; }
    #ln-teachdash .tdash-card h3 { color:#102422 !important; font-size:16.5px; margin:0 0 12px; }
    #ln-teachdash .tdash-empty { background:#f2faf6; border:1px dashed #aed9c8; border-radius:12px; padding:40px 20px; text-align:center; color:#526663; font-size:15px; line-height:1.6; }
    #ln-teachdash .stat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
    #ln-teachdash .stat-card { background:#fff; border:1px solid #e8ecf3; border-radius:14px; padding:18px 20px 18px 22px; box-shadow:0 2px 12px rgba(16,36,34,.06); position:relative; overflow:hidden; }
    #ln-teachdash .stat-card::before { content:""; position:absolute; left:0; top:0; bottom:0; width:4px; background:linear-gradient(180deg,#006f60,#006f60); }
    #ln-teachdash .stat-num { font-size:26px; font-weight:800; color:#102422; line-height:1.15; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    #ln-teachdash .stat-lbl { font-size:12px; color:#526663; margin-top:5px; letter-spacing:.5px; text-transform:uppercase; font-weight:600; }
    #ln-teachdash .tdash-in, #ln-teachdash textarea.tdash-in { padding:10px 12px; border:1px solid #c4d4cc; border-radius:8px; font-size:14.5px; color:#102422; background:#fff; font-family:inherit; width:100%; box-sizing:border-box; }
    #ln-teachdash textarea.tdash-in { min-height:110px; resize:vertical; line-height:1.6; }
    #ln-teachdash .tdash-hint { font-size:13px; color:#526663; margin:8px 0 12px; line-height:1.55; }
    #ln-teachdash .tdash-btn { display:inline-block; border:none; cursor:pointer; border-radius:8px; font-size:15px; font-weight:700; padding:11px 24px; background:#006f60; color:#fff; font-family:inherit; }
    #ln-teachdash .tdash-btn:hover { opacity:.93; }
    #ln-teachdash .tdash-btn:disabled { opacity:.55; cursor:default; }
    #ln-teachdash .tdash-flash { display:none; background:#eef9f5; border:1px solid #aed9c8; color:#005449; border-radius:10px; padding:11px 15px; font-size:14px; margin-bottom:14px; }
    #ln-teachdash .msg-thread { max-height:340px; overflow-y:auto; padding:6px 2px 12px; }
    #ln-teachdash .msg { max-width:78%; padding:10px 14px; border-radius:14px; margin-bottom:10px; font-size:14.5px; line-height:1.5; word-wrap:break-word; }
    #ln-teachdash .msg.me { background:#006f60; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    #ln-teachdash .msg.them { background:#e9f0ec; color:#102422; border-bottom-left-radius:4px; }
    #ln-teachdash .msg.sys { background:#f2faf6; color:#526663; margin:0 auto 12px; text-align:center; max-width:92%; font-size:13.5px; }
    #ln-teachdash .msg-meta { display:block; font-size:11.5px; opacity:.75; margin-top:4px; }
    #ln-teachdash .msg-form { display:flex; gap:8px; }
    #ln-teachdash .msg-form input { flex:1; min-width:0; }
    #ln-teachdash .tt-row { display:flex; align-items:center; gap:12px; background:#f2faf6; border:1px solid #cde9db; border-radius:10px; padding:12px 15px; margin-bottom:10px; flex-wrap:wrap; }
    #ln-teachdash .tt-info { flex:1; min-width:150px; }
    #ln-teachdash .tt-subj { font-weight:700; font-size:15.5px; }
    #ln-teachdash .tt-when { color:#526663; font-size:13.5px; }
    #ln-teachdash .score-row { display:flex; align-items:center; gap:10px; padding:9px 4px; border-bottom:1px solid #f0f0f0; font-size:14.5px; }
    #ln-teachdash .score-row:last-child { border-bottom:none; }
    #ln-teachdash .score-date { color:#8aa39c; font-size:13px; margin-left:auto; }
    @media (max-width:860px){
      #ln-teachdash .tdash-shell { flex-direction:column; }
      #ln-teachdash .tdash-side { width:auto; }
      #ln-teachdash .stat-grid { grid-template-columns:1fr; }
    }
  </style>
  <div class="tdash-shell">
    <aside class="tdash-side">
      <div class="tdash-brand">The Learning Net<small>Teacher Dashboard</small></div>
      <div class="tdash-user">
        <div class="tdash-ava" id="tdAva">T</div>
        <div><div class="tdash-uname" id="tdUname">Teacher</div><p class="tdash-hello">Your allotted students are listed below.</p></div>
      </div>
      <div class="tdash-sidelabel">My Students</div>
      <div id="tdStuList"><div class="tdash-sideempty">Loading students&hellip;</div></div>
    </aside>
    <div class="tdash-main">
      <div class="tdash-pagehead">
        <h1 class="tdash-pagetitle">Teacher Dashboard</h1>
        <p class="tdash-pagesub">Your allotted students, their timetables, progress and messages.</p>
      </div>
      <div id="tdEmpty">
        <h2 class="tdash-h">My Students</h2>
        <p class="tdash-sub">Select a student on the left to see their timetable, progress and messages.</p>
        <div class="tdash-empty" id="tdEmptyMsg">No student selected yet.</div>
      </div>
      <div id="tdDetail" style="display:none">
        <h2 class="tdash-h" id="tdStuName">Student</h2>
        <p class="tdash-sub" id="tdStuSub">Timetable, progress and messages.</p>
        <div class="tdash-flash" id="tdFlash"></div>
        <div class="stat-grid">
          <div class="stat-card"><div class="stat-num" id="tdStatLessons">&ndash;</div><div class="stat-lbl">Lessons Booked</div></div>
          <div class="stat-card"><div class="stat-num" id="tdStatAvg">&ndash;</div><div class="stat-lbl">Practice Average</div></div>
          <div class="stat-card"><div class="stat-num" id="tdStatTT">&ndash;</div><div class="stat-lbl">Timetable Lessons</div></div>
        </div>
        <div class="tdash-card">
          <h3>Lesson timetable</h3>
          <p class="tdash-sub" style="margin-bottom:12px;">This is the official timetable the student sees. One lesson per line: <strong>Subject | Day | Time</strong>.</p>
          <div id="tdTTView" style="margin-bottom:12px;"></div>
          <textarea class="tdash-in" id="tdTTEdit" aria-label="Edit timetable"></textarea>
          <p class="tdash-hint">Example: <code>Mathematics | Monday | 14:30</code></p>
          <button class="tdash-btn" id="tdTTSave" type="button">Save timetable</button>
        </div>
        <div class="tdash-card" id="tdMeetCard" style="display:none">
          <h3>Lesson meeting link</h3>
          <div id="tdMeetBody"></div>
        </div>
        <div class="tdash-card">
          <h3>Messages</h3>
          <div class="msg-thread" id="tdMsgThread"></div>
          <div class="msg-form">
            <input class="tdash-in" id="tdMsgIn" type="text" placeholder="Write a message&hellip;" maxlength="2000" aria-label="Write a message">
            <button class="tdash-btn" id="tdMsgSend" type="button">Send</button>
          </div>
        </div>
        <div class="tdash-card">
          <h3>Practice scores</h3>
          <div id="tdScores"><p class="tdash-sub" style="margin:0;">No practice scores recorded yet.</p></div>
        </div>
      </div>
      <div class="tdash-card" id="tdAdminMsgCard" style="margin-top:14px;">
        <h3>Messages from the school office</h3>
        <p class="tdash-sub" style="margin-bottom:12px;">A direct line between you and the admin.</p>
        <div class="msg-thread" id="tdAdminMsgThread"><div class="msg sys">Loading&hellip;</div></div>
        <div class="msg-form">
          <input class="tdash-in" id="tdAdminMsgIn" type="text" placeholder="Write a message&hellip;" maxlength="2000" aria-label="Write a message to the school office">
          <button class="tdash-btn" id="tdAdminMsgSend" type="button">Send</button>
        </div>
      </div>
    </div>
  </div>
  <script>
  (function(){
    "use strict";
    function esc(s){ return String(s===null||s===undefined?"":s).replace(/[&<>"']/g,function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]; }); }
    function $(id){ return document.getElementById(id); }
    function fmtDT(s){ try{ var d=new Date(String(s).replace(" ","T")); if(isNaN(d)) return ""; return d.toLocaleDateString("en-GB",{day:"numeric",month:"short"})+" "+d.toLocaleTimeString("en-GB",{hour:"2-digit",minute:"2-digit"}); }catch(e){ return ""; } }
    function flash(msg){ var f=$("tdFlash"); f.textContent=msg; f.style.display="block"; setTimeout(function(){ f.style.display="none"; },3500); }

    function tPost(action, extra, cb){
      if(!(window.LN_TEACH && window.LN_TEACH.ajax)){ cb(null); return; }
      try{
        var fd=new FormData();
        fd.append("action", action);
        fd.append("nonce", window.LN_TEACH.nonce);
        if(extra){ for(var k in extra){ fd.append(k, extra[k]); } }
        fetch(window.LN_TEACH.ajax,{method:"POST",body:fd,credentials:"same-origin"})
          .then(function(r){ return r.json(); })
          .then(function(j){ cb(j && j.success ? j.data : null); })
          .catch(function(){ cb(null); });
      }catch(e){ cb(null); }
    }

    var students=[], curId=0, pollTimer=null;

    function loadStudents(cb){
      tPost("ln_teacher_get_students", null, function(d){
        var box=$("tdStuList");
        if(!d || !d.students){ box.innerHTML='<div class="tdash-sideempty">Could not load students.</div>'; if(cb)cb(); return; }
        students=d.students;
        if(!students.length){ box.innerHTML='<div class="tdash-sideempty">No students have been allotted to you yet. Your admin allots students from each student\u2019s profile.</div>'; $("tdEmptyMsg").textContent="No students allotted yet."; if(cb)cb(); return; }
        var h="";
        for(var i=0;i<students.length;i++){
          var s=students[i];
          h+='<button type="button" class="tdash-stubtn'+(s.id===curId?' active':'')+'" data-sid="'+s.id+'"><span class="nm">'+esc(s.name)+'</span>'+(s.unread>0?'<span class="tdash-badge">'+s.unread+'</span>':'')+'</button>';
        }
        box.innerHTML=h;
        var btns=box.querySelectorAll(".tdash-stubtn");
        for(var j=0;j<btns.length;j++){
          btns[j].addEventListener("click", function(){ selectStudent(parseInt(this.getAttribute("data-sid"),10)); });
        }
        if(cb)cb();
      });
    }

    function selectStudent(id){
      curId=id;
      var btns=$("tdStuList").querySelectorAll(".tdash-stubtn");
      for(var i=0;i<btns.length;i++){ btns[i].classList.toggle("active", parseInt(btns[i].getAttribute("data-sid"),10)===id); }
      $("tdEmpty").style.display="none";
      $("tdDetail").style.display="block";
      loadDetail();
      loadMsgs();
      startPoll();
      if(window.innerWidth<861){ $("tdDetail").scrollIntoView({behavior:"smooth"}); }
    }

    function loadDetail(){
      tPost("ln_teacher_get_student",{student_id:curId},function(d){
        if(!d) return;
        $("tdStuName").textContent=d.name;
        $("tdStuSub").textContent="Timetable, progress and messages for "+d.name+".";
        var lessons=d.lessons||[], scores=d.scores||[], tt=d.timetable||[];
        $("tdStatLessons").textContent=lessons.length;
        var avg=null;
        if(scores.length){ var sum=0; for(var i=0;i<scores.length;i++){ sum+=parseInt(scores[i].p||0,10); } avg=Math.round(sum/scores.length)+"%"; }
        $("tdStatAvg").textContent=avg===null?"\u2013":avg;
        $("tdStatTT").textContent=tt.length;
        var th="";
        if(!tt.length){ th='<p class="tdash-sub" style="margin:0;">No timetable set yet.</p>'; }
        for(var j=0;j<tt.length;j++){ th+='<div class="tt-row"><div class="tt-info"><div class="tt-subj">'+esc(tt[j].subject)+'</div><div class="tt-when">'+esc(tt[j].day)+' at '+esc(tt[j].time)+'</div></div></div>'; }
        $("tdTTView").innerHTML=th;
        $("tdTTEdit").value=d.timetable_text||"";
        var mt=d.meeting;
        if(mt && mt.link){
          $("tdMeetCard").style.display="block";
          $("tdMeetBody").innerHTML='<p class="tdash-sub" style="margin:0 0 10px;">Join lessons on '+esc(mt.label||"MS Teams")+'. The link is set by your admin.</p><a class="tdash-btn" href="'+esc(mt.link)+'" target="_blank" rel="noopener" style="text-decoration:none;">Join lesson</a>';
        } else {
          $("tdMeetCard").style.display="none";
        }
        var sh="";
        if(scores.length){
          var ord=scores.slice().sort(function(a,b){ return (b.t||0)-(a.t||0); }).slice(0,10);
          for(var k=0;k<ord.length;k++){ sh+='<div class="score-row"><span>'+esc(ord[k].s)+'</span><strong>'+esc(ord[k].p)+'%</strong><span class="score-date">'+fmtDT(ord[k].t?new Date(ord[k].t*1000).toISOString().slice(0,19).replace("T"," "):"")+'</span></div>'; }
        } else { sh='<p class="tdash-sub" style="margin:0;">No practice scores recorded yet.</p>'; }
        $("tdScores").innerHTML=sh;
      });
    }

    function loadMsgs(){
      if(!curId) return;
      tPost("ln_teacher_get_messages",{student_id:curId},function(d){
        if(!d) return;
        renderMsgs(d.messages||[], d.me);
      });
    }
    function renderMsgs(msgs, me){
      var box=$("tdMsgThread"), h="";
      if(!msgs.length){ h+='<div class="msg sys">No messages yet. Say hello to your student.</div>'; }
      for(var i=0;i<msgs.length;i++){
        var m=msgs[i], mine=parseInt(m.sender_id,10)===parseInt(me,10);
        h+='<div class="msg '+(mine?"me":"them")+'">'+esc(m.body)+'<span class="msg-meta">'+esc(fmtDT(m.created_at))+'</span></div>';
      }
      box.innerHTML=h;
      box.scrollTop=box.scrollHeight;
    }
    function sendMsg(){
      var inp=$("tdMsgIn"), v=inp.value.replace(/^\s+|\s+$/g,"");
      if(!v || !curId) return;
      inp.disabled=true;
      tPost("ln_teacher_send_message",{student_id:curId,text:v},function(d){
        inp.disabled=false; inp.value=""; inp.focus();
        if(d) renderMsgs(d.messages||[], d.me);
        loadStudents();
      });
    }
    $("tdMsgSend").addEventListener("click", sendMsg);
    $("tdMsgIn").addEventListener("keydown", function(e){ if(e.key==="Enter"){ e.preventDefault(); sendMsg(); } });

    /* ---------- messages with the school office ---------- */
    function renderAdminMsgs(msgs, me){
      var box=$("tdAdminMsgThread"), h="";
      if(!msgs.length){ h+='<div class="msg sys">No messages yet. The school office can reach you here.</div>'; }
      for(var i=0;i<msgs.length;i++){
        var m=msgs[i], mine=parseInt(m.sender_id,10)===parseInt(me,10);
        h+='<div class="msg '+(mine?"me":"them")+'">'+esc(m.body)+'<span class="msg-meta">'+esc(fmtDT(m.created_at))+'</span></div>';
      }
      box.innerHTML=h;
      box.scrollTop=box.scrollHeight;
    }
    function loadAdminMsgs(){
      tPost("ln_teacher_get_admin_messages", null, function(d){
        if(d) renderAdminMsgs(d.messages||[], d.me);
      });
    }
    function sendAdminMsg(){
      var inp=$("tdAdminMsgIn"), v=inp.value.replace(/^\s+|\s+$/g,"");
      if(!v) return;
      inp.disabled=true;
      tPost("ln_teacher_send_admin_message",{text:v},function(d){
        inp.disabled=false; inp.value=""; inp.focus();
        if(d) renderAdminMsgs(d.messages||[], d.me);
      });
    }
    if(window.LN_TEACH && parseInt(window.LN_TEACH.is_admin,10)===1){
      $("tdAdminMsgCard").style.display="none";
    } else {
      $("tdAdminMsgSend").addEventListener("click", sendAdminMsg);
      $("tdAdminMsgIn").addEventListener("keydown", function(e){ if(e.key==="Enter"){ e.preventDefault(); sendAdminMsg(); } });
      loadAdminMsgs();
    }

    function saveTT(){
      if(!curId) return;
      var btn=$("tdTTSave"); btn.disabled=true; btn.textContent="Saving\u2026";
      tPost("ln_teacher_save_timetable",{student_id:curId,timetable:$("tdTTEdit").value},function(d){
        btn.disabled=false; btn.textContent="Save timetable";
        if(d){ loadDetail(); flash("Timetable saved. The student now sees the updated timetable."); }
        else { flash("Could not save. Please try again."); }
      });
    }
    $("tdTTSave").addEventListener("click", saveTT);

    function startPoll(){
      stopPoll();
      pollTimer=setInterval(function(){
        if(document.hidden) return;
        loadMsgs();
        loadStudents();
        if(!(window.LN_TEACH && parseInt(window.LN_TEACH.is_admin,10)===1)){ loadAdminMsgs(); }
      }, 20000);
    }
    function stopPoll(){ if(pollTimer){ clearInterval(pollTimer); pollTimer=null; } }

    var nm=(window.LN_TEACH&&window.LN_TEACH.teacher_name)||"";
    if(nm){ $("tdUname").textContent=nm; $("tdAva").textContent=nm.charAt(0).toUpperCase(); }
    loadStudents();
  })();
  </script>
</div>
