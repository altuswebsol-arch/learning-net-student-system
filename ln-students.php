<?php
/**
 * Plugin Name: Learning Net Students
 * Description: Student registration with fee-slip verification, login protection for the student dashboard, per-student data storage, and teacher dashboards with student allotment and messaging.
 * Version: 1.2.4
 * Author: The Learning Net
 * Text Domain: ln-students
 */

if (!defined('ABSPATH')) exit;

define('LN_STU_VER', '1.2.4');
define('LN_STU_ADMIN_EMAIL', 'info@thelearningnet.org');
define('LN_STU_DASHBOARD_SLUG', 'student-dashboard');
define('LN_STU_LOGIN_SLUG', 'student-signin');
define('LN_TEACH_DASHBOARD_SLUG', 'teacher-dashboard');
define('LN_TEACH_LOGIN_SLUG', 'teacher-signin');
define('LN_LOGIN_SLUG', 'login');         // unified login hub (students + teachers)
define('LN_DASHBOARD_SLUG', 'dashboard'); // role router: sends each user to their own dashboard
define('LN_ADMIN_DASHBOARD_SLUG', 'admin-dashboard');

/* ============================================================
 * 1. ROLES
 * ============================================================ */
function ln_stu_ensure_roles() {
    if (!get_role('ln_pending')) {
        add_role('ln_pending', 'Pending Student', array('read' => true));
    }
    if (!get_role('ln_student')) {
        add_role('ln_student', 'Student', array('read' => true));
    }
    // Teacher role: the site may already have one (slug 'teacher' from the theme);
    // only create ours if no teacher role exists at all.
    if (!get_role('teacher') && !get_role('ln_teacher')) {
        add_role('ln_teacher', 'Teacher', array('read' => true));
    }
}
register_activation_hook(__FILE__, 'ln_stu_ensure_roles');
add_action('init', 'ln_stu_ensure_roles');

function ln_stu_is_teacher($user = null) {
    if (!$user) $user = wp_get_current_user();
    if (!$user || !$user->ID) return false;
    $roles = (array) $user->roles;
    return in_array('teacher', $roles, true) || in_array('ln_teacher', $roles, true) || in_array('administrator', $roles, true);
}

function ln_stu_teacher_user_ids() {
    // All users that count as teachers (either teacher slug), for admin dropdowns.
    $ids = array();
    foreach (array('teacher', 'ln_teacher') as $role) {
        $q = get_users(array('role' => $role, 'fields' => 'ID', 'number' => 500));
        if ($q) $ids = array_merge($ids, $q);
    }
    return array_values(array_unique(array_map('intval', $ids)));
}

/* Student roles: the plugin's own ln_student plus the older 'student' role
   some accounts still carry. Every school list, allotment, message target
   and dashboard check honours both, so the whole school is visible. */
function ln_stu_student_roles() { return array('ln_student', 'student'); }
function ln_stu_has_student_role($roles) {
    foreach ((array) $roles as $r) { if (in_array($r, ln_stu_student_roles(), true)) return true; }
    return false;
}

function ln_stu_is_student($user = null) {
    if (!$user) $user = wp_get_current_user();
    if (!$user || !$user->ID) return false;
    $roles = (array) $user->roles;
    return ln_stu_has_student_role($roles) || in_array('administrator', $roles, true);
}

function ln_stu_is_pending($user = null) {
    if (!$user) $user = wp_get_current_user();
    if (!$user || !$user->ID) return false;
    return in_array('ln_pending', (array) $user->roles, true);
}

/* ============================================================
 * 2. REGISTRATION FORM  [ln_student_register]
 * ============================================================ */
function ln_stu_register_shortcode() {
    if (is_user_logged_in()) {
        $u = wp_get_current_user();
        if (ln_stu_is_student($u)) {
            return '<div class="ln-stu-box"><p>You are already logged in as a student.</p><p><a class="ln-stu-btn" href="' . esc_url(home_url('/' . LN_STU_DASHBOARD_SLUG . '/')) . '">Open my dashboard</a></p></div>';
        }
        if (ln_stu_is_pending($u)) {
            return '<div class="ln-stu-box"><p>Your registration is awaiting verification. We will email you as soon as your account is approved.</p></div>';
        }
        return '<div class="ln-stu-box"><p>You are logged in with an account that cannot access student registration.</p></div>';
    }

    $err = get_transient('ln_stu_reg_err_' . md5($_SERVER['REMOTE_ADDR'] ?? 'x'));
    delete_transient('ln_stu_reg_err_' . md5($_SERVER['REMOTE_ADDR'] ?? 'x'));
    $ok = isset($_GET['ln_registered']);

    ob_start();
    ?>
    <div class="ln-stu-wrap" id="ln-register">
      <style>
        #ln-register{font-family:'DM Sans','Manrope',-apple-system,'Segoe UI',Roboto,Arial,sans-serif;color:#102422;max-width:640px;margin:0 auto}
        #ln-register h2{font-family:'Manrope','DM Sans',sans-serif}
        #ln-register .ln-f{margin-bottom:14px}
        #ln-register label{display:block;font-weight:700;font-size:14px;margin-bottom:6px}
        #ln-register input[type=text],#ln-register input[type=email],#ln-register input[type=password],#ln-register input[type=file]{width:100%;padding:11px 13px;border:1.5px solid #dce7e3;border-radius:10px;font-size:15px;background:#fff;box-sizing:border-box}
        #ln-register input:focus{outline:none;border-color:#006f60;box-shadow:0 0 0 3px rgba(0,111,96,.12)}
        #ln-register .ln-hint{font-size:13px;color:#526663;margin-top:5px}
        #ln-register .ln-err{background:#fdecea;border:1px solid #f5c6c0;color:#a33b32;padding:12px 15px;border-radius:10px;margin-bottom:16px;font-size:14px}
        #ln-register .ln-ok{background:#eef9f5;border:1px solid #aed9c8;color:#005449;padding:14px 16px;border-radius:10px;font-size:15px}
        #ln-register .ln-btn{display:inline-block;background:#006f60;color:#fff;border:none;border-radius:10px;padding:13px 30px;font-size:16px;font-weight:800;cursor:pointer}
        #ln-register .ln-btn:hover{background:#005449}
        #ln-register .ln-safe{font-size:12.5px;color:#8aa39c;margin-top:14px}
      </style>
      <?php if ($ok): ?>
        <div class="ln-ok"><strong>Registration received.</strong> We are verifying your payment slip now. You will receive an email as soon as your account is approved — then you can log in and open your dashboard.</div>
      <?php else: ?>
        <h2>Dashboard registration</h2>
        <p style="color:#526663">Register for your Learning Net student account. After we verify your fee payment, your dashboard access will be activated.</p>
        <?php if ($err): ?><div class="ln-err"><?php echo esc_html($err); ?></div><?php endif; ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
          <input type="hidden" name="action" value="ln_student_register">
          <?php wp_nonce_field('ln_stu_register', 'ln_stu_nonce'); ?>
          <input type="text" name="ln_website" value="" style="display:none" tabindex="-1" autocomplete="off">
          <div class="ln-f"><label for="ln_sname">Student full name</label><input type="text" id="ln_sname" name="ln_sname" required maxlength="100"></div>
          <div class="ln-f"><label for="ln_pname">Parent or guardian full name</label><input type="text" id="ln_pname" name="ln_pname" required maxlength="100"></div>
          <div class="ln-f"><label for="ln_email">Parent email (used for account updates)</label><input type="email" id="ln_email" name="ln_email" required maxlength="100"></div>
          <div class="ln-f"><label for="ln_uname">Choose a username</label><input type="text" id="ln_uname" name="ln_uname" required maxlength="60" pattern="[A-Za-z0-9._-]+" title="Letters, numbers, dots, dashes and underscores only"><div class="ln-hint">Letters, numbers, dots, dashes and underscores only.</div></div>
          <div class="ln-f"><label for="ln_pass">Choose a password</label><input type="password" id="ln_pass" name="ln_pass" required minlength="8"><div class="ln-hint">At least 8 characters.</div></div>
          <div class="ln-f"><label for="ln_slip">Fee payment slip (screenshot or photo)</label><input type="file" id="ln_slip" name="ln_slip" accept=".jpg,.jpeg,.png,.webp,.pdf" required><div class="ln-hint">Upload a clear screenshot or photo of your fee payment (JPG, PNG, WEBP or PDF, max 5MB). Your dashboard is activated only after we verify this payment.</div></div>
          <div class="ln-f"><button type="submit" class="ln-btn">Submit registration</button></div>
          <p class="ln-safe">By registering you agree to be contacted about your application. Tuition from £39.50 per hour — fees are paid by bank transfer.</p>
        </form>
      <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ln_student_register', 'ln_stu_register_shortcode');

/* Registration handler */
function ln_stu_handle_register() {
    if (!isset($_POST['ln_stu_nonce']) || !wp_verify_nonce($_POST['ln_stu_nonce'], 'ln_stu_register')) {
        wp_die('Security check failed. Please go back and try again.');
    }
    // Honeypot
    if (!empty($_POST['ln_website'])) {
        wp_redirect(home_url('/student-registration/?ln_registered=1'));
        exit;
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'x';
    $fail = function($msg) use ($ip) {
        set_transient('ln_stu_reg_err_' . md5($ip), $msg, 300);
        wp_redirect(home_url('/student-registration/'));
        exit;
    };

    $sname = sanitize_text_field($_POST['ln_sname'] ?? '');
    $pname = sanitize_text_field($_POST['ln_pname'] ?? '');
    $email = sanitize_email($_POST['ln_email'] ?? '');
    $uname = sanitize_user($_POST['ln_uname'] ?? '', true);
    $pass  = $_POST['ln_pass'] ?? '';

    if (strlen($sname) < 2) $fail('Please enter the student full name.');
    if (strlen($pname) < 2) $fail('Please enter the parent or guardian name.');
    if (!is_email($email)) $fail('Please enter a valid parent email address.');
    if (strlen($uname) < 4) $fail('Username must be at least 4 characters (letters, numbers, dots, dashes, underscores).');
    if (username_exists($uname)) $fail('That username is already taken. Please choose another.');
    if (email_exists($email)) $fail('An account is already registered with that email address.');
    if (strlen($pass) < 8) $fail('Password must be at least 8 characters.');

    // Fee slip upload
    if (empty($_FILES['ln_slip']) || $_FILES['ln_slip']['error'] !== UPLOAD_ERR_OK) {
        $fail('Please upload your fee payment slip (screenshot or photo).');
    }
    $file = $_FILES['ln_slip'];
    if ($file['size'] > 5 * 1024 * 1024) $fail('The uploaded file is too large — maximum 5MB.');
    $allowed = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'pdf' => 'application/pdf');
    $check = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $allowed);
    if (!$check['type']) $fail('Only JPG, PNG, WEBP or PDF files are accepted.');

    $user_id = wp_create_user($uname, $pass, $email);
    if (is_wp_error($user_id)) $fail('Could not create your account: ' . $user_id->get_error_message());

    $user = new WP_User($user_id);
    $user->set_role('ln_pending');
    update_user_meta($user_id, 'ln_student_name', $sname);
    update_user_meta($user_id, 'ln_parent_name', $pname);
    update_user_meta($user_id, 'ln_status', 'pending');

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $att_id = media_handle_upload('ln_slip', 0);
    if (is_wp_error($att_id)) {
        // keep the account but flag the missing slip
        update_user_meta($user_id, 'ln_fee_slip_error', $att_id->get_error_message());
    } else {
        update_user_meta($user_id, 'ln_fee_slip', $att_id);
    }

    // Notify admin
    $slip_url = $att_id && !is_wp_error($att_id) ? wp_get_attachment_url($att_id) : '(upload failed)';
    $verify_url = admin_url('users.php?page=ln-verifications');
    wp_mail(
        LN_STU_ADMIN_EMAIL,
        'New student registration — verification needed',
        "A new student registration needs verification.\n\nStudent: {$sname}\nParent: {$pname}\nParent email: {$email}\nUsername: {$uname}\nFee slip: {$slip_url}\n\nReview and approve here: {$verify_url}\n"
    );

    wp_redirect(home_url('/student-registration/?ln_registered=1'));
    exit;
}
add_action('admin_post_nopriv_ln_student_register', 'ln_stu_handle_register');
add_action('admin_post_ln_student_register', 'ln_stu_handle_register');

/* ============================================================
 * 3. ADMIN VERIFICATION (backend)
 * ============================================================ */
function ln_stu_admin_menu() {
    add_submenu_page(
        'users.php',
        'Student Verifications',
        'Student Verifications',
        'list_users',
        'ln-verifications',
        'ln_stu_verifications_page'
    );
}
add_action('admin_menu', 'ln_stu_admin_menu');

function ln_stu_verifications_page() {
    if (!current_user_can('list_users')) wp_die('You do not have permission to view this page.');
    $notice = '';
    if (isset($_GET['ln_approved'])) $notice = '<div class="notice notice-success is-dismissible"><p>Student approved — dashboard access is now active. The student has been emailed.</p></div>';
    if (isset($_GET['ln_rejected'])) $notice = '<div class="notice notice-success is-dismissible"><p>Registration rejected and the pending account removed.</p></div>';

    $pending = get_users(array('role' => 'ln_pending', 'orderby' => 'registered', 'order' => 'ASC'));
    ?>
    <div class="wrap">
      <h1>Student Verifications</h1>
      <p>New student registrations appear here after they upload their fee payment slip. Review the slip, then <strong>Approve</strong> to activate dashboard access or <strong>Reject</strong> to remove the registration.</p>
      <?php echo $notice; ?>
      <?php if (!$pending): ?>
        <p><em>No pending registrations right now.</em></p>
      <?php else: ?>
        <table class="widefat striped">
          <thead><tr>
            <th>Student</th><th>Parent</th><th>Username</th><th>Parent email</th><th>Registered</th><th>Fee slip</th><th>Actions</th>
          </tr></thead>
          <tbody>
          <?php foreach ($pending as $u):
              $slip_id = get_user_meta($u->ID, 'ln_fee_slip', true);
              $slip_url = $slip_id ? wp_get_attachment_url($slip_id) : '';
              $is_img = $slip_id && wp_attachment_is_image($slip_id);
              $approve = wp_nonce_url(admin_url('admin-post.php?action=ln_approve_student&uid=' . $u->ID), 'ln_verify_' . $u->ID);
              $reject  = wp_nonce_url(admin_url('admin-post.php?action=ln_reject_student&uid=' . $u->ID), 'ln_verify_' . $u->ID);
          ?>
            <tr>
              <td><strong><?php echo esc_html(get_user_meta($u->ID, 'ln_student_name', true)); ?></strong></td>
              <td><?php echo esc_html(get_user_meta($u->ID, 'ln_parent_name', true)); ?></td>
              <td><?php echo esc_html($u->user_login); ?></td>
              <td><a href="mailto:<?php echo esc_attr($u->user_email); ?>"><?php echo esc_html($u->user_email); ?></a></td>
              <td><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($u->user_registered))); ?></td>
              <td>
                <?php if ($slip_url): ?>
                  <a href="<?php echo esc_url($slip_url); ?>" target="_blank" rel="noopener">
                    <?php if ($is_img): ?>
                      <img src="<?php echo esc_url(wp_get_attachment_image_url($slip_id, 'thumbnail')); ?>" alt="Fee slip" style="max-width:90px;height:auto;border:1px solid #ccc">
                    <?php else: ?>
                      View PDF
                    <?php endif; ?>
                  </a>
                <?php else: ?>
                  <em style="color:#a00">Missing</em>
                <?php endif; ?>
              </td>
              <td>
                <a class="button button-primary" href="<?php echo esc_url($approve); ?>">Approve</a>
                <a class="button" style="margin-top:4px" href="<?php echo esc_url($reject); ?>" onclick="return confirm('Reject this registration and delete the pending account?')">Reject</a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

      <h2 style="margin-top:32px">Active students</h2>
      <?php $active = get_users(array('role__in' => ln_stu_student_roles(), 'orderby' => 'display_name', 'order' => 'ASC', 'number' => 200)); ?>
      <?php if (!$active): ?>
        <p><em>No active students yet.</em></p>
      <?php else: ?>
        <table class="widefat striped">
          <thead><tr><th>Student</th><th>Username</th><th>Parent email</th><th>Timetable</th></tr></thead>
          <tbody>
          <?php foreach ($active as $u):
              $tt = get_user_meta($u->ID, 'ln_timetable', true);
              $lines = $tt ? count(array_filter(array_map('trim', explode("\n", $tt)))) : 0;
          ?>
            <tr>
              <td><strong><?php echo esc_html(get_user_meta($u->ID, 'ln_student_name', true) ?: $u->display_name); ?></strong></td>
              <td><?php echo esc_html($u->user_login); ?></td>
              <td><?php echo esc_html($u->user_email); ?></td>
              <td><?php echo $lines ? esc_html($lines . ' lessons set') : '<em style="color:#a00">Not set</em>'; ?> — <a href="<?php echo esc_url(get_edit_user_link($u->ID)); ?>#ln-timetable">edit</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
    <?php
}

function ln_stu_handle_approve() {
    if (!current_user_can('list_users')) wp_die('Permission denied.');
    $uid = intval($_GET['uid'] ?? 0);
    if (!$uid || !check_admin_referer('ln_verify_' . $uid)) wp_die('Security check failed.');
    $u = new WP_User($uid);
    if (!in_array('ln_pending', (array) $u->roles, true)) wp_die('This account is not pending verification.');
    $u->set_role('ln_student');
    update_user_meta($uid, 'ln_status', 'approved');
    $sname = get_user_meta($uid, 'ln_student_name', true);
    wp_mail(
        $u->user_email,
        'Your Learning Net student account is approved',
        "Dear parent/guardian,\n\nGood news — " . ($sname ?: 'your child') . "'s Learning Net student account has been approved.\n\nLog in here: " . home_url('/' . LN_STU_LOGIN_SLUG . '/') . "\nUsername: {$u->user_login}\n\nAfter logging in you can open the student dashboard.\n\nThe Learning Net"
    );
    wp_redirect(admin_url('users.php?page=ln-verifications&ln_approved=1'));
    exit;
}
add_action('admin_post_ln_approve_student', 'ln_stu_handle_approve');

function ln_stu_handle_reject() {
    if (!current_user_can('list_users')) wp_die('Permission denied.');
    $uid = intval($_GET['uid'] ?? 0);
    if (!$uid || !check_admin_referer('ln_verify_' . $uid)) wp_die('Security check failed.');
    $u = new WP_User($uid);
    if (!in_array('ln_pending', (array) $u->roles, true)) wp_die('This account is not pending verification.');
    $email = $u->user_email;
    $slip_id = get_user_meta($uid, 'ln_fee_slip', true);
    require_once ABSPATH . 'wp-admin/includes/post.php';
    if ($slip_id) wp_delete_attachment($slip_id, true);
    wp_delete_user($uid);
    wp_mail($email, 'Your Learning Net registration', "Thank you for registering with The Learning Net.\n\nWe could not approve your registration at this time. If you believe this is a mistake, please contact us at " . LN_STU_ADMIN_EMAIL . ".\n\nThe Learning Net");
    wp_redirect(admin_url('users.php?page=ln-verifications&ln_rejected=1'));
    exit;
}
add_action('admin_post_ln_reject_student', 'ln_stu_handle_reject');

/* ============================================================
 * 4. LOGIN  [ln_student_login]
 * ============================================================ */
function ln_stu_login_shortcode() {
    ob_start();
    ?>
    <div class="ln-stu-wrap" id="ln-login">
      <style>
        #ln-login{font-family:'DM Sans','Manrope',-apple-system,'Segoe UI',Roboto,Arial,sans-serif;color:#102422;max-width:480px;margin:0 auto}
        #ln-login h2{font-family:'Manrope','DM Sans',sans-serif}
        #ln-login label{display:block;font-weight:700;font-size:14px;margin:0 0 6px}
        #ln-login input[type=text],#ln-login input[type=password]{width:100%;padding:11px 13px;border:1.5px solid #dce7e3;border-radius:10px;font-size:15px;box-sizing:border-box;margin-bottom:14px}
        #ln-login input:focus{outline:none;border-color:#006f60;box-shadow:0 0 0 3px rgba(0,111,96,.12)}
        #ln-login .ln-btn{display:inline-block;background:#006f60;color:#fff;border:none;border-radius:10px;padding:13px 30px;font-size:16px;font-weight:800;cursor:pointer;text-decoration:none}
        #ln-login .ln-btn:hover{background:#005449}
        #ln-login .ln-note{background:#eef9f5;border:1px solid #aed9c8;color:#005449;padding:14px 16px;border-radius:10px;font-size:15px}
        #ln-login .ln-error{background:#fdecea;border:1px solid #f5b5ac;color:#a4261a;padding:12px 16px;border-radius:10px;font-size:15px;margin-bottom:16px}
        #ln-login .login-remember{margin-bottom:14px;font-size:14px}
        #ln-login p.lost{font-size:14px;margin-top:12px}
      </style>
      <?php
      if (is_user_logged_in()) {
          $u = wp_get_current_user();
          if (ln_stu_is_student($u)) {
              echo '<div class="ln-note"><p>You are logged in as <strong>' . esc_html($u->user_login) . '</strong>.</p><p><a class="ln-btn" href="' . esc_url(home_url('/' . LN_STU_DASHBOARD_SLUG . '/')) . '">Open my dashboard</a></p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_STU_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
          } elseif (ln_stu_is_pending($u)) {
              echo '<div class="ln-note"><p>Your registration is <strong>awaiting verification</strong>. We will email you as soon as your account is approved.</p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_STU_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
          } else {
              echo '<div class="ln-note"><p>You are logged in as <strong>' . esc_html($u->user_login) . '</strong>, which is not a student account.</p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_STU_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
          }
      } else {
          echo '<h2>Student login</h2>';
          echo '<p style="color:#526663">Log in to open your student dashboard.</p>';
          if (isset($_GET['ln_login']) && $_GET['ln_login'] === 'failed') {
              echo '<div class="ln-error">Incorrect username or password. Please try again.</div>';
          } elseif (isset($_GET['ln_login']) && $_GET['ln_login'] === 'empty') {
              echo '<div class="ln-error">Please enter both your username and password.</div>';
          }
          wp_login_form(array(
              'redirect' => home_url('/' . LN_STU_DASHBOARD_SLUG . '/'),
              'label_username' => 'Username',
              'label_password' => 'Password',
              'label_remember' => 'Remember me',
              'label_log_in' => 'Log in',
          ));
          echo '<p class="lost"><a href="' . esc_url(wp_lostpassword_url()) . '">Forgot your password?</a></p>';
          echo '<p class="lost">No account yet? <a href="' . esc_url(home_url('/student-registration/')) . '">Register here</a>.</p>';
      }
      ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ln_student_login', 'ln_stu_login_shortcode');

/* ---------- Teacher login shortcode [ln_teacher_login] ---------- */
function ln_stu_teacher_login_shortcode() {
    ob_start();
    ?>
    <div class="ln-stu-wrap" id="ln-login">
      <style>
        #ln-login{font-family:'DM Sans','Manrope',-apple-system,'Segoe UI',Roboto,Arial,sans-serif;color:#102422;max-width:480px;margin:0 auto}
        #ln-login h2{font-family:'Manrope','DM Sans',sans-serif}
        #ln-login label{display:block;font-weight:700;font-size:14px;margin:0 0 6px}
        #ln-login input[type=text],#ln-login input[type=password]{width:100%;padding:11px 13px;border:1.5px solid #dce7e3;border-radius:10px;font-size:15px;box-sizing:border-box;margin-bottom:14px}
        #ln-login input:focus{outline:none;border-color:#006f60;box-shadow:0 0 0 3px rgba(0,111,96,.12)}
        #ln-login .ln-btn{display:inline-block;background:#006f60;color:#fff;border:none;border-radius:10px;padding:13px 30px;font-size:16px;font-weight:800;cursor:pointer;text-decoration:none}
        #ln-login .ln-btn:hover{background:#005449}
        #ln-login .ln-note{background:#eef9f5;border:1px solid #aed9c8;color:#005449;padding:14px 16px;border-radius:10px;font-size:15px}
        #ln-login .ln-error{background:#fdecea;border:1px solid #f5b5ac;color:#a4261a;padding:12px 16px;border-radius:10px;font-size:15px;margin-bottom:16px}
        #ln-login .login-remember{margin-bottom:14px;font-size:14px}
        #ln-login p.lost{font-size:14px;margin-top:12px}
      </style>
      <?php
      if (is_user_logged_in()) {
          $u = wp_get_current_user();
          if (ln_stu_is_teacher($u)) {
              echo '<div class="ln-note"><p>You are logged in as <strong>' . esc_html($u->user_login) . '</strong>.</p><p><a class="ln-btn" href="' . esc_url(home_url('/' . LN_TEACH_DASHBOARD_SLUG . '/')) . '">Open my dashboard</a></p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_TEACH_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
          } else {
              echo '<div class="ln-note"><p>You are logged in as <strong>' . esc_html($u->user_login) . '</strong>, which is not a teacher account.</p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_TEACH_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
          }
      } else {
          echo '<h2>Teacher login</h2>';
          echo '<p style="color:#526663">Log in to open your teacher dashboard.</p>';
          if (isset($_GET['ln_login']) && $_GET['ln_login'] === 'failed') {
              echo '<div class="ln-error">Incorrect username or password. Please try again.</div>';
          } elseif (isset($_GET['ln_login']) && $_GET['ln_login'] === 'empty') {
              echo '<div class="ln-error">Please enter both your username and password.</div>';
          }
          wp_login_form(array(
              'redirect' => home_url('/' . LN_TEACH_DASHBOARD_SLUG . '/'),
              'label_username' => 'Username',
              'label_password' => 'Password',
              'label_remember' => 'Remember me',
              'label_log_in' => 'Log in',
          ));
          echo '<p class="lost"><a href="' . esc_url(wp_lostpassword_url()) . '">Forgot your password?</a></p>';
      }
      ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ln_teacher_login', 'ln_stu_teacher_login_shortcode');

/* ---------- Unified login [ln_login]: one form for students + teachers ---------- */
function ln_stu_role_dashboard_url($user = null) {
    if (!$user) $user = wp_get_current_user();
    if ($user && $user->ID && user_can($user->ID, 'manage_options')) return home_url('/' . LN_ADMIN_DASHBOARD_SLUG . '/');
    if (ln_stu_is_teacher($user)) return home_url('/' . LN_TEACH_DASHBOARD_SLUG . '/');
    return home_url('/' . LN_STU_DASHBOARD_SLUG . '/');
}
function ln_stu_unified_login_shortcode() {
    ob_start();
    ?>
    <div class="ln-stu-wrap" id="ln-login">
      <style>
        #ln-login{font-family:'DM Sans','Manrope',-apple-system,'Segoe UI',Roboto,Arial,sans-serif;color:#102422;max-width:480px;margin:0 auto}
        #ln-login h2{font-family:'Manrope','DM Sans',sans-serif}
        #ln-login label{display:block;font-weight:700;font-size:14px;margin:0 0 6px}
        #ln-login input[type=text],#ln-login input[type=password]{width:100%;padding:11px 13px;border:1.5px solid #dce7e3;border-radius:10px;font-size:15px;box-sizing:border-box;margin-bottom:14px}
        #ln-login input:focus{outline:none;border-color:#006f60;box-shadow:0 0 0 3px rgba(0,111,96,.12)}
        #ln-login .ln-btn{display:inline-block;background:#006f60;color:#fff;border:none;border-radius:10px;padding:13px 30px;font-size:16px;font-weight:800;cursor:pointer;text-decoration:none}
        #ln-login .ln-btn:hover{background:#005449}
        #ln-login .ln-note{background:#eef9f5;border:1px solid #aed9c8;color:#005449;padding:14px 16px;border-radius:10px;font-size:15px}
        #ln-login .ln-error{background:#fdecea;border:1px solid #f5b5ac;color:#a4261a;padding:12px 16px;border-radius:10px;font-size:15px;margin-bottom:16px}
        #ln-login .login-remember{margin-bottom:14px;font-size:14px}
        #ln-login p.lost{font-size:14px;margin-top:12px}
      </style>
      <?php
      if (is_user_logged_in()) {
          $u = wp_get_current_user();
          echo '<div class="ln-note"><p>You are logged in as <strong>' . esc_html($u->user_login) . '</strong>.</p><p><a class="ln-btn" href="' . esc_url(ln_stu_role_dashboard_url($u)) . '">Open my dashboard</a></p><p style="margin-top:10px;font-size:14px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_LOGIN_SLUG . '/'))) . '">Log out</a></p></div>';
      } else {
          echo '<h2>Login</h2>';
          echo '<p style="color:#526663">Log in to access your dashboard.</p>';
          if (isset($_GET['ln_login']) && $_GET['ln_login'] === 'failed') {
              echo '<div class="ln-error">Incorrect username or password. Please try again.</div>';
          } elseif (isset($_GET['ln_login']) && $_GET['ln_login'] === 'empty') {
              echo '<div class="ln-error">Please enter both your username and password.</div>';
          }
          wp_login_form(array(
              'redirect' => home_url('/' . LN_DASHBOARD_SLUG . '/'),
              'label_username' => 'Username',
              'label_password' => 'Password',
              'label_remember' => 'Remember me',
              'label_log_in' => 'Log in',
          ));
          echo '<p class="lost"><a href="' . esc_url(wp_lostpassword_url()) . '">Forgot your password?</a></p>';
          echo '<p class="lost">No account yet? <a href="' . esc_url(home_url('/student-registration/')) . '">Register here</a>.</p>';
      }
      ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ln_login', 'ln_stu_unified_login_shortcode');

/* ---------- Role router: /dashboard/ sends each user to their own dashboard ---------- */
function ln_stu_role_router() {
    if (is_page(LN_DASHBOARD_SLUG)) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/' . LN_LOGIN_SLUG . '/'));
            exit;
        }
        wp_redirect(ln_stu_role_dashboard_url());
        exit;
    }
    if (is_page(LN_LOGIN_SLUG) && is_user_logged_in()) {
        wp_redirect(ln_stu_role_dashboard_url());
        exit;
    }
}
add_action('template_redirect', 'ln_stu_role_router');

/* Keep failed logins on the custom sign-in pages instead of wp-login.php */
function ln_stu_login_fail_target() {
    $ref = wp_get_referer();
    if (!$ref) return false;
    foreach (array(LN_STU_LOGIN_SLUG, LN_TEACH_LOGIN_SLUG, LN_LOGIN_SLUG) as $slug) {
        if (false !== strpos($ref, '/' . $slug . '/')) {
            return home_url('/' . $slug . '/');
        }
    }
    return false;
}
add_action('wp_login_failed', function($username){
    if ($to = ln_stu_login_fail_target()) {
        wp_safe_redirect(add_query_arg('ln_login', 'failed', $to));
        exit;
    }
});
/* Empty username/password never reach wp_login_failed; catch them early */
add_filter('authenticate', function($user, $username, $password){
    if ((empty($username) || empty($password)) && ($to = ln_stu_login_fail_target())) {
        wp_safe_redirect(add_query_arg('ln_login', 'empty', $to));
        exit;
    }
    return $user;
}, 1, 3);

/* ============================================================
 * 5. DASHBOARD PROTECTION
 * ============================================================ */
function ln_stu_protect_dashboard() {
    if (is_page(LN_STU_DASHBOARD_SLUG) && !is_user_logged_in()) {
        wp_redirect(home_url('/' . LN_STU_LOGIN_SLUG . '/'));
        exit;
    }
}
add_action('template_redirect', 'ln_stu_protect_dashboard');

function ln_stu_dashboard_content($content) {
    if (!is_page(LN_STU_DASHBOARD_SLUG) || !in_the_loop() || !is_main_query()) return $content;
    if (!is_user_logged_in()) return $content; // template_redirect already sent them away
    $u = wp_get_current_user();
    if (ln_stu_is_student($u)) return $content;
    if (ln_stu_is_pending($u)) {
        return '<div class="ln-stu-wrap" style="font-family:\'DM Sans\',sans-serif;color:#102422;max-width:640px;margin:40px auto;text-align:center"><div style="background:#eef9f5;border:1px solid #aed9c8;color:#005449;padding:26px;border-radius:14px"><h2 style="font-family:Manrope,sans-serif">Verification in progress</h2><p>Your registration is awaiting verification. We will email you as soon as your account is approved and your dashboard is ready.</p><p style="margin-top:12px"><a href="' . esc_url(wp_logout_url(home_url('/' . LN_STU_LOGIN_SLUG . '/'))) . '">Log out</a></p></div></div>';
    }
    return '<div class="ln-stu-wrap" style="font-family:\'DM Sans\',sans-serif;color:#102422;max-width:640px;margin:40px auto;text-align:center"><p>This page is for Learning Net students. <a href="' . esc_url(home_url('/' . LN_STU_LOGIN_SLUG . '/')) . '">Log in</a> to continue.</p></div>';
}
add_filter('the_content', 'ln_stu_dashboard_content', 1);

/* ============================================================
 * 6. TIMETABLE (per student, set by admin on the user profile)
 *    One lesson per line:  Subject | Day | Time
 *    e.g.  Mathematics | Monday | 14:30
 * ============================================================ */
/* ---- Subjects: admin-editable list (option ln_subjects), with defaults ---- */
function ln_stu_default_subjects() {
    return array('Mathematics','English Language','English Literature','Biology','Chemistry','Physics','Combined Science','History','Geography','French','Spanish','German','Computer Science','Business Studies','Religious Studies','Art & Design','Drama','Music','Design & Technology','Food Preparation','Statistics');
}
function ln_stu_subjects() {
    $s = get_option('ln_subjects', null);
    if (is_array($s)) {
        $s = array_values(array_filter(array_map('trim', $s), function($v){ return $v !== ''; }));
        if ($s) return $s;
    }
    return ln_stu_default_subjects();
}
/* ---- Admin user helpers (for admin messaging threads) ---- */
function ln_stu_admin_user_id() {
    $admins = get_users(array('role' => 'administrator', 'number' => 1, 'orderby' => 'ID', 'order' => 'ASC', 'fields' => 'ID'));
    return $admins ? intval($admins[0]) : 0;
}
function ln_stu_admin_ids() {
    $admins = get_users(array('role' => 'administrator', 'number' => 100, 'orderby' => 'ID', 'order' => 'ASC', 'fields' => 'ID'));
    return array_map('intval', (array) $admins);
}
/* Pooled admin thread: conversation between a person and ANY administrator.
   Used so every admin sees the full conversation no matter which admin account sent what. */
function ln_stu_get_admin_thread($person_id, $viewer_id = 0) {
    global $wpdb;
    $t = ln_stu_messages_table();
    $p = intval($person_id);
    $aids = ln_stu_admin_ids();
    if (!$p || !$aids) return array();
    $in = implode(',', $aids);
    $rows = $wpdb->get_results(
        "SELECT id, sender_id, body, created_at FROM $t WHERE ((sender_id = $p AND receiver_id IN ($in)) OR (sender_id IN ($in) AND receiver_id = $p)) ORDER BY id ASC LIMIT 200",
        ARRAY_A
    );
    if ($viewer_id) {
        $v = intval($viewer_id);
        $wpdb->query("UPDATE $t SET is_read = 1 WHERE receiver_id = $v AND is_read = 0 AND (sender_id = $p OR sender_id IN ($in))");
    }
    return $rows ? $rows : array();
}
function ln_stu_pooled_unread_counts() {
    global $wpdb;
    $t = ln_stu_messages_table();
    $aids = ln_stu_admin_ids();
    if (!$aids) return array();
    $in = implode(',', $aids);
    $rows = $wpdb->get_results("SELECT sender_id, COUNT(*) AS c FROM $t WHERE receiver_id IN ($in) AND is_read = 0 GROUP BY sender_id", ARRAY_A);
    $out = array();
    foreach ((array) $rows as $r) $out[intval($r['sender_id'])] = intval($r['c']);
    return $out;
}
/* ---- Unified "Login" link: every frontend "Student login" link becomes "Login" -> /login/ ---- */
function ln_stu_unify_login_links() {
    if (is_admin()) return;
    ?>
    <script>
    (function(){
      function run(){
        var as=document.querySelectorAll('a'), i, a;
        for(i=0;i<as.length;i++){
          a=as[i];
          if(a.textContent && a.textContent.trim()==='Student login'){
            a.textContent='Login';
            a.setAttribute('href','<?php echo esc_url(home_url('/' . LN_LOGIN_SLUG . '/')); ?>');
          }
        }
      }
      if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded', run); } else { run(); }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'ln_stu_unify_login_links');
/* ---- Meeting links: per-student MS Teams / Zoom link set by admin ---- */
function ln_stu_get_meeting($student_id) {
    $link = trim((string) get_user_meta(intval($student_id), 'ln_meeting_link', true));
    if ($link === '') return null;
    $label = (string) get_user_meta(intval($student_id), 'ln_meeting_label', true);
    if (!in_array($label, array('MS Teams', 'Zoom'), true)) $label = 'MS Teams';
    return array('link' => esc_url_raw($link), 'label' => $label);
}
function ln_stu_profile_fields($user) {
    if (!current_user_can('manage_options')) return;
    $roles = (array) $user->roles;
    if (!ln_stu_has_student_role($roles) && !in_array('ln_pending', $roles, true) && !in_array('administrator', $roles, true)) return;
    $tt = get_user_meta($user->ID, 'ln_timetable', true);
    $slip_id = get_user_meta($user->ID, 'ln_fee_slip', true);
    ?>
    <h2 id="ln-timetable">Learning Net student details</h2>
    <table class="form-table">
      <?php if ($slip_id && ($url = wp_get_attachment_url($slip_id))): ?>
      <tr><th>Fee slip</th><td><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">View uploaded fee slip</a></td></tr>
      <?php endif; ?>
      <tr>
        <th><label for="ln_timetable">Lesson timetable</label></th>
        <td>
          <textarea name="ln_timetable" id="ln_timetable" rows="6" cols="50" class="large-text"><?php echo esc_textarea($tt); ?></textarea>
          <p class="description">One lesson per line, in this exact format:<br><code>Mathematics | Monday | 14:30</code><br>This is the official timetable the student sees on their dashboard. Each student has their own.</p>
        </td>
      </tr>
      <?php do_action('ln_stu_profile_extra_rows', $user); ?>
    </table>
    <?php
}
add_action('show_user_profile', 'ln_stu_profile_fields');
add_action('edit_user_profile', 'ln_stu_profile_fields');

function ln_stu_save_profile($user_id) {
    if (!current_user_can('manage_options')) return;
    if (isset($_POST['ln_timetable'])) {
        $lines = array();
        foreach (explode("\n", wp_unslash($_POST['ln_timetable'])) as $line) {
            $line = trim(sanitize_text_field($line));
            if ($line !== '') $lines[] = $line;
        }
        update_user_meta($user_id, 'ln_timetable', implode("\n", $lines));
    }
    if (isset($_POST['ln_teacher_id'])) {
        update_user_meta($user_id, 'ln_teacher_id', intval($_POST['ln_teacher_id']));
    }
}
add_action('personal_options_update', 'ln_stu_save_profile');
add_action('edit_user_profile_update', 'ln_stu_save_profile');

function ln_stu_parse_timetable($user_id) {
    $tt = get_user_meta($user_id, 'ln_timetable', true);
    $out = array();
    if (!$tt) return $out;
    foreach (explode("\n", $tt) as $line) {
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) >= 3 && $parts[0] !== '') {
            $out[] = array('subject' => $parts[0], 'day' => $parts[1], 'time' => $parts[2]);
        }
    }
    return $out;
}

/* ============================================================
 * 7. PER-STUDENT DATA (AJAX, replaces browser localStorage)
 * ============================================================ */
function ln_stu_ajax_data() {
    // Expose ajax URL + nonce to logged-in students on the frontend
    if (!is_user_logged_in() || is_admin()) return;
    $u = wp_get_current_user();
    if (!ln_stu_is_student($u) && !ln_stu_is_pending($u)) return;
    echo '<script>window.LN_DASH={ajax:"' . esc_url(admin_url('admin-ajax.php')) . '",nonce:"' . wp_create_nonce('ln-dash') . '"};</script>' . "\n";
}
add_action('wp_head', 'ln_stu_ajax_data');

function ln_stu_get_state() {
    check_ajax_referer('ln-dash', 'nonce');
    $uid = get_current_user_id();
    if (!$uid || !ln_stu_is_student(wp_get_current_user())) wp_send_json_error('not_authorised', 403);
    $state = get_user_meta($uid, 'ln_dash_state', true);
    if (!is_array($state)) $state = array();
    $state['lessons'] = isset($state['lessons']) && is_array($state['lessons']) ? array_values($state['lessons']) : array();
    $state['scores']  = isset($state['scores']) && is_array($state['scores']) ? array_values($state['scores']) : array();
    $state['timetable'] = ln_stu_parse_timetable($uid);
    $state['student_name'] = get_user_meta($uid, 'ln_student_name', true);
    $state['meeting'] = ln_stu_get_meeting($uid); /* fresh each load: never served stale from page cache */
    wp_send_json_success($state);
}
add_action('wp_ajax_ln_get_state', 'ln_stu_get_state');

function ln_stu_save_state() {
    check_ajax_referer('ln-dash', 'nonce');
    $uid = get_current_user_id();
    if (!$uid || !ln_stu_is_student(wp_get_current_user())) wp_send_json_error('not_authorised', 403);
    $raw = isset($_POST['state']) ? wp_unslash($_POST['state']) : '';
    $data = json_decode($raw, true);
    if (!is_array($data)) wp_send_json_error('bad_data', 400);
    // Whitelist keys; sanitise values
    $clean = array('lessons' => array(), 'scores' => array());
    if (!empty($data['lessons']) && is_array($data['lessons'])) {
        foreach (array_slice($data['lessons'], 0, 100) as $l) {
            if (!is_array($l)) continue;
            $clean['lessons'][] = array(
                'subject' => sanitize_text_field($l['subject'] ?? ''),
                'day'     => sanitize_text_field($l['day'] ?? ''),
                'time'    => sanitize_text_field($l['time'] ?? ''),
            );
        }
    }
    if (!empty($data['scores']) && is_array($data['scores'])) {
        foreach (array_slice($data['scores'], 0, 200) as $s) {
            if (!is_array($s)) continue;
            $clean['scores'][] = array(
                's' => sanitize_text_field($s['s'] ?? ''),
                'p' => max(0, min(100, intval($s['p'] ?? 0))),
                't' => intval($s['t'] ?? time()),
            );
        }
    }
    update_user_meta($uid, 'ln_dash_state', $clean);
    wp_send_json_success(array('saved' => true));
}
add_action('wp_ajax_ln_save_state', 'ln_stu_save_state');

/* ============================================================
 * 8. TEACHER SYSTEM
 *    - Teacher role (reuses the site's existing 'teacher' role when present)
 *    - Admin allots students to teachers (ln_teacher_id user meta)
 *    - Teacher dashboard: allotted students, their data, messaging,
 *      timetable editing. Teachers see ONLY their allotted students.
 * ============================================================ */

/* ---- Messages table ---- */
function ln_stu_messages_table() {
    global $wpdb;
    return $wpdb->prefix . 'ln_messages';
}
function ln_stu_ensure_tables() {
    global $wpdb;
    $table = ln_stu_messages_table();
    if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table) return;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        sender_id BIGINT UNSIGNED NOT NULL,
        receiver_id BIGINT UNSIGNED NOT NULL,
        body TEXT NOT NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY sender (sender_id),
        KEY receiver (receiver_id)
    ) $charset;";
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'ln_stu_ensure_tables');
add_action('init', 'ln_stu_ensure_tables');

/* ---- Teacher dashboard protection ---- */
function ln_stu_protect_teacher_dashboard() {
    if (is_page(LN_TEACH_DASHBOARD_SLUG) && !is_user_logged_in()) {
        wp_redirect(home_url('/' . LN_TEACH_LOGIN_SLUG . '/'));
        exit;
    }
}
add_action('template_redirect', 'ln_stu_protect_teacher_dashboard');

function ln_stu_teacher_dashboard_content($content) {
    if (!is_page(LN_TEACH_DASHBOARD_SLUG) || !in_the_loop() || !is_main_query()) return $content;
    if (!is_user_logged_in()) return $content; // template_redirect already sent them away
    $u = wp_get_current_user();
    if (ln_stu_is_teacher($u)) return $content;
    return '<div class="ln-stu-wrap" style="font-family:\'DM Sans\',sans-serif;color:#102422;max-width:640px;margin:40px auto;text-align:center"><p>This page is for Learning Net teachers. <a href="' . esc_url(home_url('/' . LN_TEACH_LOGIN_SLUG . '/')) . '">Log in</a> to continue.</p></div>';
}
add_filter('the_content', 'ln_stu_teacher_dashboard_content', 1);

/* ---- Allotment helpers ---- */
function ln_stu_get_teacher_students($teacher_id) {
    $teacher_id = intval($teacher_id);
    if (!$teacher_id) return array();
    $q = get_users(array(
        'role__in' => ln_stu_student_roles(),
        'meta_key' => 'ln_teacher_id',
        'meta_value' => $teacher_id,
        'number' => 500,
    ));
    return $q ? $q : array();
}
function ln_stu_can_teacher_view_student($teacher_id, $student_id) {
    $teacher_id = intval($teacher_id);
    $student_id = intval($student_id);
    if (!$teacher_id || !$student_id) return false;
    if (user_can($teacher_id, 'manage_options')) return true; // admin sees all
    return intval(get_user_meta($student_id, 'ln_teacher_id', true)) === $teacher_id;
}

/* ---- Messages: storage ---- */
function ln_stu_add_message($sender_id, $receiver_id, $body) {
    global $wpdb;
    $body = trim(mb_substr(wp_unslash($body), 0, 2000));
    $sender_id = intval($sender_id);
    $receiver_id = intval($receiver_id);
    if ($body === '' || !$sender_id || !$receiver_id) return false;
    $wpdb->insert(ln_stu_messages_table(), array(
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'body' => $body,
        'is_read' => 0,
        'created_at' => current_time('mysql'),
    ));
    return $wpdb->insert_id ? intval($wpdb->insert_id) : false;
}
function ln_stu_get_thread($viewer_id, $other_id) {
    global $wpdb;
    $t = ln_stu_messages_table();
    $v = intval($viewer_id);
    $o = intval($other_id);
    if (!$v || !$o) return array();
    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT id, sender_id, body, created_at FROM $t WHERE (sender_id=%d AND receiver_id=%d) OR (sender_id=%d AND receiver_id=%d) ORDER BY id ASC LIMIT 200",
        $v, $o, $o, $v
    ), ARRAY_A);
    $wpdb->query($wpdb->prepare(
        "UPDATE $t SET is_read=1 WHERE receiver_id=%d AND sender_id=%d AND is_read=0",
        $v, $o
    ));
    return $rows ? $rows : array();
}
function ln_stu_unread_counts($receiver_id) {
    global $wpdb;
    $t = ln_stu_messages_table();
    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT sender_id, COUNT(*) AS c FROM $t WHERE receiver_id=%d AND is_read=0 GROUP BY sender_id",
        intval($receiver_id)
    ), ARRAY_A);
    $out = array();
    foreach ((array) $rows as $r) $out[intval($r['sender_id'])] = intval($r['c']);
    return $out;
}

/* ---- Teacher AJAX: auth + data ---- */
function ln_stu_teach_ajax_data() {
    if (!is_user_logged_in() || is_admin()) return;
    $u = wp_get_current_user();
    if (!ln_stu_is_teacher($u)) return;
    echo '<script>window.LN_TEACH={ajax:"' . esc_url(admin_url('admin-ajax.php')) . '",nonce:"' . wp_create_nonce('ln-teach') . '",teacher_name:"' . esc_js($u->display_name ? $u->display_name : $u->user_login) . '",is_admin:' . (current_user_can('manage_options') ? '1' : '0') . '};</script>' . "\n";
}
add_action('wp_head', 'ln_stu_teach_ajax_data');

function ln_stu_teach_check() {
    check_ajax_referer('ln-teach', 'nonce');
    $u = wp_get_current_user();
    if (!$u || !$u->ID || !ln_stu_is_teacher($u)) wp_send_json_error('not_authorised', 403);
    return $u;
}
function ln_stu_student_public_name($sid) {
    $name = get_user_meta($sid, 'ln_student_name', true);
    if ($name) return $name;
    $su = get_userdata($sid);
    return $su ? ($su->display_name ? $su->display_name : $su->user_login) : ('Student #' . $sid);
}

add_action('wp_ajax_ln_teacher_get_students', function() {
    $u = ln_stu_teach_check();
    if (user_can($u->ID, 'manage_options')) {
        $students = get_users(array('role__in' => ln_stu_student_roles(), 'number' => 500));
    } else {
        $students = ln_stu_get_teacher_students($u->ID);
    }
    $unread = ln_stu_unread_counts($u->ID);
    $out = array();
    foreach ((array) $students as $s) {
        $sid = intval($s->ID);
        $out[] = array(
            'id' => $sid,
            'name' => ln_stu_student_public_name($sid),
            'username' => $s->user_login,
            'unread' => isset($unread[$sid]) ? $unread[$sid] : 0,
        );
    }
    wp_send_json_success(array('students' => $out));
});

add_action('wp_ajax_ln_teacher_get_student', function() {
    $u = ln_stu_teach_check();
    $sid = intval($_POST['student_id'] ?? 0);
    if (!ln_stu_can_teacher_view_student($u->ID, $sid)) wp_send_json_error('not_authorised', 403);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    $state = get_user_meta($sid, 'ln_dash_state', true);
    if (!is_array($state)) $state = array();
    wp_send_json_success(array(
        'id' => $sid,
        'name' => ln_stu_student_public_name($sid),
        'username' => $su->user_login,
        'timetable_text' => (string) get_user_meta($sid, 'ln_timetable', true),
        'timetable' => ln_stu_parse_timetable($sid),
        'lessons' => isset($state['lessons']) && is_array($state['lessons']) ? array_values($state['lessons']) : array(),
        'scores' => isset($state['scores']) && is_array($state['scores']) ? array_values($state['scores']) : array(),
        'meeting' => ln_stu_get_meeting($sid),
    ));
});

add_action('wp_ajax_ln_teacher_save_timetable', function() {
    $u = ln_stu_teach_check();
    $sid = intval($_POST['student_id'] ?? 0);
    if (!ln_stu_can_teacher_view_student($u->ID, $sid)) wp_send_json_error('not_authorised', 403);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    $lines = array();
    foreach (explode("\n", wp_unslash($_POST['timetable'] ?? '')) as $line) {
        $line = trim(sanitize_text_field($line));
        if ($line !== '') $lines[] = $line;
    }
    update_user_meta($sid, 'ln_timetable', implode("\n", $lines));
    wp_send_json_success(array('timetable' => ln_stu_parse_timetable($sid)));
});

add_action('wp_ajax_ln_teacher_get_messages', function() {
    $u = ln_stu_teach_check();
    $sid = intval($_POST['student_id'] ?? 0);
    if (!ln_stu_can_teacher_view_student($u->ID, $sid)) wp_send_json_error('not_authorised', 403);
    wp_send_json_success(array('messages' => ln_stu_get_thread($u->ID, $sid), 'me' => intval($u->ID)));
});

add_action('wp_ajax_ln_teacher_send_message', function() {
    $u = ln_stu_teach_check();
    $sid = intval($_POST['student_id'] ?? 0);
    if (!ln_stu_can_teacher_view_student($u->ID, $sid)) wp_send_json_error('not_authorised', 403);
    $id = ln_stu_add_message($u->ID, $sid, $_POST['text'] ?? '');
    if (!$id) wp_send_json_error('empty', 400);
    wp_send_json_success(array('messages' => ln_stu_get_thread($u->ID, $sid), 'me' => intval($u->ID)));
});

/* ---- Student AJAX: messages with their allotted teacher, or the school admin ---- */
add_action('wp_ajax_ln_get_messages', function() {
    check_ajax_referer('ln-dash', 'nonce');
    $u = wp_get_current_user();
    if (!$u || !$u->ID || !ln_stu_is_student($u)) wp_send_json_error('not_authorised', 403);
    $with = isset($_POST['with']) ? sanitize_key($_POST['with']) : 'teacher';
    if ($with === 'admin') {
        wp_send_json_success(array('messages' => ln_stu_get_admin_thread($u->ID, $u->ID), 'me' => intval($u->ID), 'with' => 'admin'));
    }
    $tid = intval(get_user_meta($u->ID, 'ln_teacher_id', true));
    if (!$tid) wp_send_json_success(array('messages' => array(), 'teacher_assigned' => false, 'me' => intval($u->ID), 'with' => 'teacher'));
    wp_send_json_success(array('messages' => ln_stu_get_thread($u->ID, $tid), 'teacher_assigned' => true, 'me' => intval($u->ID), 'with' => 'teacher'));
});

add_action('wp_ajax_ln_send_message', function() {
    check_ajax_referer('ln-dash', 'nonce');
    $u = wp_get_current_user();
    if (!$u || !$u->ID || !ln_stu_is_student($u)) wp_send_json_error('not_authorised', 403);
    $to = isset($_POST['to']) ? sanitize_key($_POST['to']) : 'teacher';
    if ($to === 'admin') {
        $aid = ln_stu_admin_user_id();
        if (!$aid) wp_send_json_error('no_admin', 400);
        $id = ln_stu_add_message($u->ID, $aid, $_POST['text'] ?? '');
        if (!$id) wp_send_json_error('empty', 400);
        wp_send_json_success(array('messages' => ln_stu_get_admin_thread($u->ID, $u->ID), 'me' => intval($u->ID), 'with' => 'admin'));
    }
    $tid = intval(get_user_meta($u->ID, 'ln_teacher_id', true));
    if (!$tid) wp_send_json_error('no_teacher', 400);
    $id = ln_stu_add_message($u->ID, $tid, $_POST['text'] ?? '');
    if (!$id) wp_send_json_error('empty', 400);
    wp_send_json_success(array('messages' => ln_stu_get_thread($u->ID, $tid), 'me' => intval($u->ID), 'with' => 'teacher'));
});

/* ---- Teacher AJAX: messages with the school admin ---- */
add_action('wp_ajax_ln_teacher_get_admin_messages', function() {
    $u = ln_stu_teach_check();
    if (in_array('administrator', (array) $u->roles, true)) wp_send_json_error('not_teacher', 403);
    wp_send_json_success(array('messages' => ln_stu_get_admin_thread($u->ID, $u->ID), 'me' => intval($u->ID)));
});
add_action('wp_ajax_ln_teacher_send_admin_message', function() {
    $u = ln_stu_teach_check();
    if (in_array('administrator', (array) $u->roles, true)) wp_send_json_error('not_teacher', 403);
    $aid = ln_stu_admin_user_id();
    if (!$aid) wp_send_json_error('no_admin', 400);
    $id = ln_stu_add_message($u->ID, $aid, $_POST['text'] ?? '');
    if (!$id) wp_send_json_error('empty', 400);
    wp_send_json_success(array('messages' => ln_stu_get_admin_thread($u->ID, $u->ID), 'me' => intval($u->ID)));
});

/* ---- Admin: allot students to teachers on the student profile ---- */
function ln_stu_profile_teacher_field($user) {
    if (!current_user_can('manage_options')) return;
    $roles = (array) $user->roles;
    if (!ln_stu_has_student_role($roles)) return;
    $teachers = ln_stu_teacher_user_ids();
    $cur = intval(get_user_meta($user->ID, 'ln_teacher_id', true));
    ?>
    <tr>
      <th><label for="ln_teacher_id">Assigned teacher</label></th>
      <td>
        <select name="ln_teacher_id" id="ln_teacher_id">
          <option value="0">&mdash; Not assigned &mdash;</option>
          <?php foreach ($teachers as $tid):
              $tu = get_userdata($tid);
              if (!$tu) continue;
              $tname = trim($tu->display_name) ? $tu->display_name : $tu->user_login;
          ?>
          <option value="<?php echo intval($tid); ?>" <?php selected($cur, intval($tid)); ?>><?php echo esc_html($tname . ' (' . $tu->user_login . ')'); ?></option>
          <?php endforeach; ?>
        </select>
        <p class="description">The teacher who can see this student's dashboard data, message them and update their timetable. A teacher's dashboard shows only their allotted students.</p>
      </td>
    </tr>
    <?php
}
add_action('ln_stu_profile_extra_rows', 'ln_stu_profile_teacher_field');

function ln_stu_teacher_profile_students($user) {
    if (!current_user_can('manage_options')) return;
    if (!ln_stu_is_teacher($user) || in_array('administrator', (array) $user->roles, true)) return;
    $students = ln_stu_get_teacher_students($user->ID);
    ?>
    <h2>Allotted students</h2>
    <table class="form-table">
      <tr><th>Students</th><td>
        <?php if (!$students): ?>
          <em>No students allotted yet. Allot students from each student's profile (Assigned teacher).</em>
        <?php else: ?>
          <ul style="margin:0">
          <?php foreach ($students as $s): ?>
            <li><a href="<?php echo esc_url(get_edit_user_link($s->ID)); ?>"><?php echo esc_html(ln_stu_student_public_name($s->ID) . ' (' . $s->user_login . ')'); ?></a></li>
          <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </td></tr>
    </table>
    <?php
}
add_action('show_user_profile', 'ln_stu_teacher_profile_students');
add_action('edit_user_profile', 'ln_stu_teacher_profile_students');

/* ============================================================
 * 8b. ADMIN DASHBOARD  [ln_admin_dashboard]
 *      Full school control for administrators only:
 *      students, teachers, timetables, subjects, messages, meeting links.
 * ============================================================ */

/* ---- Admin AJAX bootstrap ---- */
function ln_stu_admin_ajax_data() {
    if (!is_user_logged_in() || is_admin()) return;
    if (!current_user_can('manage_options')) return;
    $u = wp_get_current_user();
    echo '<script>window.LN_ADMIN={ajax:"' . esc_url(admin_url('admin-ajax.php')) . '",nonce:"' . wp_create_nonce('ln-admin') . '",admin_name:"' . esc_js($u->display_name ? $u->display_name : $u->user_login) . '"};</script>' . "\n";
}
add_action('wp_head', 'ln_stu_admin_ajax_data');

function ln_stu_admin_check() {
    check_ajax_referer('ln-admin', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error('not_authorised', 403);
    return wp_get_current_user();
}

function ln_stu_admin_student_row($s) {
    $sid = intval($s->ID);
    $tid = intval(get_user_meta($sid, 'ln_teacher_id', true));
    $tname = '';
    if ($tid) {
        $tu = get_userdata($tid);
        $tname = $tu ? ($tu->display_name ? $tu->display_name : $tu->user_login) : '';
    }
    return array(
        'id' => $sid,
        'name' => ln_stu_student_public_name($sid),
        'username' => $s->user_login,
        'email' => $s->user_email,
        'teacher_id' => $tid,
        'teacher_name' => $tname,
        'tt_count' => count(ln_stu_parse_timetable($sid)),
    );
}
function ln_stu_admin_teacher_option($tid) {
    $tu = get_userdata($tid);
    if (!$tu) return null;
    return array('id' => intval($tid), 'name' => trim($tu->display_name) ? $tu->display_name : $tu->user_login, 'username' => $tu->user_login);
}

add_action('wp_ajax_ln_admin_get_overview', function() {
    $u = ln_stu_admin_check();
    $students = get_users(array('role__in' => ln_stu_student_roles(), 'fields' => 'ID', 'number' => 2000));
    $teachers = ln_stu_teacher_user_ids();
    $pending = get_users(array('role' => 'ln_pending', 'fields' => 'ID', 'number' => 2000));
    $unread = array_sum(ln_stu_pooled_unread_counts());
    wp_send_json_success(array(
        'students' => count($students),
        'teachers' => count($teachers),
        'pending' => count($pending),
        'unread' => intval($unread),
    ));
});

add_action('wp_ajax_ln_admin_get_students', function() {
    ln_stu_admin_check();
    $students = get_users(array('role__in' => ln_stu_student_roles(), 'number' => 1000));
    $out = array();
    foreach ((array) $students as $s) $out[] = ln_stu_admin_student_row($s);
    $teachers = array();
    foreach (ln_stu_teacher_user_ids() as $tid) {
        $t = ln_stu_admin_teacher_option($tid);
        if ($t) $teachers[] = $t;
    }
    wp_send_json_success(array('students' => $out, 'teachers' => $teachers));
});

add_action('wp_ajax_ln_admin_set_teacher', function() {
    ln_stu_admin_check();
    $sid = intval($_POST['student_id'] ?? 0);
    $tid = intval($_POST['teacher_id'] ?? 0);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    if ($tid) {
        $tu = get_userdata($tid);
        if (!$tu || !ln_stu_is_teacher($tu) || in_array('administrator', (array) $tu->roles, true)) wp_send_json_error('bad_teacher', 400);
    }
    update_user_meta($sid, 'ln_teacher_id', $tid);
    wp_send_json_success(array('ok' => true));
});

add_action('wp_ajax_ln_admin_add_user', function() {
    ln_stu_admin_check();
    $role = sanitize_key($_POST['role'] ?? '');
    if (!in_array($role, array('ln_student', 'teacher'), true)) wp_send_json_error('bad_role', 400);
    $username = sanitize_user(wp_unslash($_POST['username'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $password = wp_unslash($_POST['password'] ?? '');
    $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    if ($username === '' || $email === '' || $password === '') wp_send_json_error('missing', 400);
    if (username_exists($username) || email_exists($email)) wp_send_json_error('exists', 400);
    $uid = wp_insert_user(array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass' => $password,
        'display_name' => $name !== '' ? $name : $username,
        'role' => $role,
    ));
    if (is_wp_error($uid)) wp_send_json_error('create_failed', 500);
    if ($role === 'ln_student' && $name !== '') update_user_meta(intval($uid), 'ln_student_name', $name);
    wp_send_json_success(array('id' => intval($uid)));
});

add_action('wp_ajax_ln_admin_get_teachers', function() {
    ln_stu_admin_check();
    $out = array();
    foreach (ln_stu_teacher_user_ids() as $tid) {
        $tu = get_userdata($tid);
        if (!$tu) continue;
        $out[] = array(
            'id' => intval($tid),
            'name' => trim($tu->display_name) ? $tu->display_name : $tu->user_login,
            'username' => $tu->user_login,
            'email' => $tu->user_email,
            'student_count' => count(ln_stu_get_teacher_students($tid)),
        );
    }
    wp_send_json_success(array('teachers' => $out));
});

add_action('wp_ajax_ln_admin_get_timetable', function() {
    ln_stu_admin_check();
    $sid = intval($_POST['student_id'] ?? 0);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    wp_send_json_success(array(
        'name' => ln_stu_student_public_name($sid),
        'timetable_text' => (string) get_user_meta($sid, 'ln_timetable', true),
        'timetable' => ln_stu_parse_timetable($sid),
    ));
});

add_action('wp_ajax_ln_admin_save_timetable', function() {
    ln_stu_admin_check();
    $sid = intval($_POST['student_id'] ?? 0);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    $lines = array();
    foreach (explode("\n", wp_unslash($_POST['timetable'] ?? '')) as $line) {
        $line = trim(sanitize_text_field($line));
        if ($line !== '') $lines[] = $line;
    }
    update_user_meta($sid, 'ln_timetable', implode("\n", $lines));
    wp_send_json_success(array('timetable' => ln_stu_parse_timetable($sid)));
});

add_action('wp_ajax_ln_admin_get_subjects', function() {
    ln_stu_admin_check();
    wp_send_json_success(array('subjects' => ln_stu_subjects()));
});

add_action('wp_ajax_ln_admin_save_subjects', function() {
    ln_stu_admin_check();
    $subs = array();
    foreach (explode("\n", wp_unslash($_POST['subjects'] ?? '')) as $line) {
        $line = trim(sanitize_text_field($line));
        if ($line !== '') $subs[] = mb_substr($line, 0, 80);
    }
    if (!$subs) wp_send_json_error('empty', 400);
    update_option('ln_subjects', array_values(array_unique($subs)));
    wp_send_json_success(array('subjects' => ln_stu_subjects()));
});

add_action('wp_ajax_ln_admin_get_people', function() {
    $u = ln_stu_admin_check();
    $unread = ln_stu_pooled_unread_counts();
    $out = array();
    $students = get_users(array('role__in' => ln_stu_student_roles(), 'number' => 1000));
    foreach ((array) $students as $s) {
        $sid = intval($s->ID);
        $out[] = array('id' => $sid, 'name' => ln_stu_student_public_name($sid), 'kind' => 'Student', 'unread' => isset($unread[$sid]) ? $unread[$sid] : 0);
    }
    foreach (ln_stu_teacher_user_ids() as $tid) {
        $tu = get_userdata($tid);
        if (!$tu) continue;
        $out[] = array('id' => intval($tid), 'name' => trim($tu->display_name) ? $tu->display_name : $tu->user_login, 'kind' => 'Teacher', 'unread' => isset($unread[$tid]) ? $unread[$tid] : 0);
    }
    wp_send_json_success(array('people' => $out));
});

add_action('wp_ajax_ln_admin_get_messages', function() {
    $u = ln_stu_admin_check();
    $oid = intval($_POST['other_id'] ?? 0);
    $ou = get_userdata($oid);
    if (!$ou) wp_send_json_error('not_found', 404);
    $roles = (array) $ou->roles;
    if (!ln_stu_has_student_role($roles) && !in_array('teacher', $roles, true) && !in_array('ln_teacher', $roles, true)) wp_send_json_error('bad_person', 400);
    wp_send_json_success(array('messages' => ln_stu_get_admin_thread($oid, $u->ID), 'me' => intval($u->ID)));
});

add_action('wp_ajax_ln_admin_send_message', function() {
    $u = ln_stu_admin_check();
    $oid = intval($_POST['other_id'] ?? 0);
    $ou = get_userdata($oid);
    if (!$ou) wp_send_json_error('not_found', 404);
    $id = ln_stu_add_message($u->ID, $oid, $_POST['text'] ?? '');
    if (!$id) wp_send_json_error('empty', 400);
    wp_send_json_success(array('messages' => ln_stu_get_admin_thread($oid, $u->ID), 'me' => intval($u->ID)));
});

add_action('wp_ajax_ln_admin_get_meeting', function() {
    ln_stu_admin_check();
    $sid = intval($_POST['student_id'] ?? 0);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    $m = ln_stu_get_meeting($sid);
    wp_send_json_success(array('name' => ln_stu_student_public_name($sid), 'meeting' => $m ? $m : null));
});

add_action('wp_ajax_ln_admin_save_meeting', function() {
    ln_stu_admin_check();
    $sid = intval($_POST['student_id'] ?? 0);
    $su = get_userdata($sid);
    if (!$su || !ln_stu_has_student_role($su->roles)) wp_send_json_error('not_found', 404);
    $link = trim(esc_url_raw(wp_unslash($_POST['link'] ?? '')));
    $label = wp_unslash($_POST['label'] ?? '');
    if (!in_array($label, array('MS Teams', 'Zoom'), true)) $label = 'MS Teams';
    if ($link === '') {
        delete_user_meta($sid, 'ln_meeting_link');
        delete_user_meta($sid, 'ln_meeting_label');
    } else {
        update_user_meta($sid, 'ln_meeting_link', $link);
        update_user_meta($sid, 'ln_meeting_label', $label);
    }
    wp_send_json_success(array('meeting' => ln_stu_get_meeting($sid)));
});

/* ---- Admin dashboard shortcode + protection ---- */
function ln_stu_admin_dashboard_shortcode() {
    if (!current_user_can('manage_options')) {
        return '<div class="ln-stu-wrap" style="font-family:\'DM Sans\',sans-serif;color:#102422;max-width:640px;margin:40px auto;text-align:center"><p>This page is for Learning Net administrators. <a href="' . esc_url(home_url('/' . LN_LOGIN_SLUG . '/')) . '">Log in</a> to continue.</p></div>';
    }
    ob_start();
    include plugin_dir_path(__FILE__) . 'admin-dashboard-view.php';
    return ob_get_clean();
}
add_shortcode('ln_admin_dashboard', 'ln_stu_admin_dashboard_shortcode');

function ln_stu_protect_admin_dashboard() {
    if (is_page(LN_ADMIN_DASHBOARD_SLUG) && !is_user_logged_in()) {
        wp_redirect(home_url('/' . LN_LOGIN_SLUG . '/'));
        exit;
    }
}
add_action('template_redirect', 'ln_stu_protect_admin_dashboard');

/* ============================================================
 * 9. DASHBOARD VIEW SHORTCODES
 *    Page content stays a tiny shortcode; the markup lives in
 *    view files inside the plugin so updates deploy cleanly.
 * ============================================================ */
function ln_stu_student_dashboard_shortcode() {
    $u = wp_get_current_user();
    if (!$u || !$u->ID || !ln_stu_is_student($u)) return '';
    ob_start();
    echo '<script>window.LN_SUBJECTS=' . wp_json_encode(ln_stu_subjects()) . ';';
    $lm = ln_stu_get_meeting($u->ID);
    echo 'window.LN_MEETING=' . wp_json_encode($lm ? $lm : null) . ';</script>' . "\n";
    include plugin_dir_path(__FILE__) . 'student-dashboard-view.php';
    return ob_get_clean();
}
add_shortcode('ln_student_dashboard', 'ln_stu_student_dashboard_shortcode');

function ln_stu_teacher_dashboard_shortcode() {
    $u = wp_get_current_user();
    if (!$u || !$u->ID || !ln_stu_is_teacher($u)) {
        return '<div class="ln-stu-wrap" style="font-family:\'DM Sans\',sans-serif;color:#102422;max-width:640px;margin:40px auto;text-align:center"><p>This page is for Learning Net teachers. <a href="' . esc_url(home_url('/' . LN_TEACH_LOGIN_SLUG . '/')) . '">Log in</a> to continue.</p></div>';
    }
    ob_start();
    include plugin_dir_path(__FILE__) . 'teacher-dashboard-view.php';
    return ob_get_clean();
}
add_shortcode('ln_teacher_dashboard', 'ln_stu_teacher_dashboard_shortcode');
