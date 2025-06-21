<?php
/**
 * Template Name: User Profile
 *
 * A comprehensive user profile page incorporating advanced broker‐style features:
 *  - Profile image (via URL or Gravatar)
 *  - Basic details: Display Name, Email, Phone, Date of Birth, Address
 *  - KYC Verification Status
 *  - Account Settings: Default Leverage, Trading Preferences, Two‐Factor Auth status
 *  - Balance & Wallet
 *  - Portfolio Summary (value, open positions count)
 *  - Deposit & Withdrawal History (latest 5)
 *  - Trade Details & Logs
 *  - Support Tickets (latest 5)
 *  - API Credentials (partial display, with reset button)
 *  - Referral Program: Code & referral count
 *  - Watchlist (array of symbols)
 *  - Risk Profile & Risk Tolerance
 *  - Achievements/Badges
 *  - Recent Comments & Recently Viewed Posts
 *  - Notification Settings (email, SMS, push)
 *
 * Relies on user meta keys for storage.
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( wp_login_url( get_permalink() ) );
    exit;
}

get_header();

// Handle profile update
if ( isset( $_POST['profile_update_nonce'] ) && wp_verify_nonce( $_POST['profile_update_nonce'], 'profile_update' ) ) {
    $user_id = get_current_user_id();

    // Basic fields
    if ( isset( $_POST['display_name'] ) ) {
        wp_update_user( [
            'ID'           => $user_id,
            'display_name' => sanitize_text_field( $_POST['display_name'] ),
        ] );
    }
    if ( isset( $_POST['email'] ) && is_email( $_POST['email'] ) ) {
        wp_update_user( [
            'ID'         => $user_id,
            'user_email' => sanitize_email( $_POST['email'] ),
        ] );
    }
    if ( isset( $_POST['phone_number'] ) ) {
        update_user_meta( $user_id, 'phone_number', sanitize_text_field( $_POST['phone_number'] ) );
    }
    if ( isset( $_POST['date_of_birth'] ) ) {
        update_user_meta( $user_id, 'date_of_birth', sanitize_text_field( $_POST['date_of_birth'] ) );
    }
    if ( isset( $_POST['address'] ) ) {
        update_user_meta( $user_id, 'address', sanitize_text_field( $_POST['address'] ) );
    }
    // Avatar URL
    if ( isset( $_POST['avatar_url'] ) ) {
        update_user_meta( $user_id, 'avatar_url', esc_url_raw( $_POST['avatar_url'] ) );
    }
    // KYC Status
    if ( isset( $_POST['kyc_status'] ) ) {
        update_user_meta( $user_id, 'kyc_status', sanitize_text_field( $_POST['kyc_status'] ) );
    }
    // Default Leverage
    if ( isset( $_POST['default_leverage'] ) ) {
        update_user_meta( $user_id, 'default_leverage', sanitize_text_field( $_POST['default_leverage'] ) );
    }
    // Trading Preferences (JSON)
    if ( isset( $_POST['trading_preferences'] ) ) {
        $prefs = wp_kses_post( $_POST['trading_preferences'] );
        update_user_meta( $user_id, 'trading_preferences', wp_json_encode( explode( ',', $prefs ) ) );
    }
    // Two‐Factor Auth
    $twofa = isset( $_POST['two_factor_enabled'] ) ? 'yes' : 'no';
    update_user_meta( $user_id, 'two_factor_enabled', $twofa );

    // Balance & Wallet
    if ( isset( $_POST['balance'] ) ) {
        update_user_meta( $user_id, 'balance', floatval( $_POST['balance'] ) );
    }
    if ( isset( $_POST['wallet_address'] ) ) {
        update_user_meta( $user_id, 'wallet_address', sanitize_text_field( $_POST['wallet_address'] ) );
    }

    // Portfolio & Positions
    if ( isset( $_POST['portfolio_value'] ) ) {
        update_user_meta( $user_id, 'portfolio_value', floatval( $_POST['portfolio_value'] ) );
    }
    if ( isset( $_POST['open_positions'] ) ) {
        update_user_meta( $user_id, 'open_positions', intval( $_POST['open_positions'] ) );
    }

    // Trade Details & Logs
    if ( isset( $_POST['trade_details'] ) ) {
        update_user_meta( $user_id, 'trade_details', wp_kses_post( $_POST['trade_details'] ) );
    }
    if ( isset( $_POST['trade_logs'] ) ) {
        update_user_meta( $user_id, 'trade_logs', wp_kses_post( $_POST['trade_logs'] ) );
    }

    // Referral
    if ( isset( $_POST['referral_code'] ) ) {
        update_user_meta( $user_id, 'referral_code', sanitize_text_field( $_POST['referral_code'] ) );
    }

    // Watchlist (comma‐separated)
    if ( isset( $_POST['watchlist'] ) ) {
        $watch = array_map( 'trim', explode( ',', sanitize_text_field( $_POST['watchlist'] ) ) );
        update_user_meta( $user_id, 'watchlist', wp_json_encode( $watch ) );
    }

    // Risk Tolerance
    if ( isset( $_POST['risk_tolerance'] ) ) {
        update_user_meta( $user_id, 'risk_tolerance', sanitize_text_field( $_POST['risk_tolerance'] ) );
    }

    // Notification Settings (checkboxes)
    $notif = [
        'email' => isset( $_POST['notify_email'] ) ? true : false,
        'sms'   => isset( $_POST['notify_sms'] ) ? true : false,
        'push'  => isset( $_POST['notify_push'] ) ? true : false,
    ];
    update_user_meta( $user_id, 'notifications', wp_json_encode( $notif ) );

    // After saving, redirect to avoid resubmission
    wp_redirect( add_query_arg( 'updated', 'true', get_permalink() ) );
    exit;
}

// Fetch user data
$current_user       = wp_get_current_user();
$user_id            = $current_user->ID;
$display_name       = $current_user->display_name;
$email              = $current_user->user_email;
$phone_number       = get_user_meta( $user_id, 'phone_number', true );
$date_of_birth      = get_user_meta( $user_id, 'date_of_birth', true );
$address            = get_user_meta( $user_id, 'address', true );
$avatar_url         = get_user_meta( $user_id, 'avatar_url', true );
$kyc_status         = get_user_meta( $user_id, 'kyc_status', true );
$default_leverage   = get_user_meta( $user_id, 'default_leverage', true );
$trading_prefs_raw  = get_user_meta( $user_id, 'trading_preferences', true );
$trading_prefs      = $trading_prefs_raw ? json_decode( $trading_prefs_raw, true ) : [];
$two_factor_enabled = get_user_meta( $user_id, 'two_factor_enabled', true );
$balance            = get_user_meta( $user_id, 'balance', true );
$wallet_address     = get_user_meta( $user_id, 'wallet_address', true );
$portfolio_value    = get_user_meta( $user_id, 'portfolio_value', true );
$open_positions     = get_user_meta( $user_id, 'open_positions', true );
$trade_details      = get_user_meta( $user_id, 'trade_details', true );
$trade_logs         = get_user_meta( $user_id, 'trade_logs', true );
$referral_code      = get_user_meta( $user_id, 'referral_code', true );
$referrals_count    = get_user_meta( $user_id, 'referrals_count', true );
$watchlist_raw      = get_user_meta( $user_id, 'watchlist', true );
$watchlist          = $watchlist_raw ? json_decode( $watchlist_raw, true ) : [];
$risk_tolerance     = get_user_meta( $user_id, 'risk_tolerance', true );
$achievements_raw   = get_user_meta( $user_id, 'achievements', true );
$achievements       = $achievements_raw ? json_decode( $achievements_raw, true ) : [];
$notifications_raw  = get_user_meta( $user_id, 'notifications', true );
$notifications      = $notifications_raw ? json_decode( $notifications_raw, true ) : [ 'email' => false, 'sms' => false, 'push' => false ];

// Recent Comments (latest 5)
$comments = get_comments( [
    'user_id' => $user_id,
    'status'  => 'approve',
    'number'  => 5,
] );

// Recently Viewed Posts (latest 5)
$recent_posts = get_user_meta( $user_id, 'recent_posts', true );
$recent_posts = is_array( $recent_posts ) ? array_slice( $recent_posts, 0, 5 ) : [];

// Deposit & Withdrawal History (latest 5 each)
$deposit_history_raw    = get_user_meta( $user_id, 'deposit_history', true );
$withdrawal_history_raw = get_user_meta( $user_id, 'withdrawal_history', true );
$deposit_history        = $deposit_history_raw ? json_decode( $deposit_history_raw, true ) : [];
$withdrawal_history     = $withdrawal_history_raw ? json_decode( $withdrawal_history_raw, true ) : [];
$deposit_history        = array_slice( $deposit_history, 0, 5 );
$withdrawal_history     = array_slice( $withdrawal_history, 0, 5 );

// Support Tickets (latest 5)
$support_tickets_raw = get_user_meta( $user_id, 'support_tickets', true );
$support_tickets     = $support_tickets_raw ? json_decode( $support_tickets_raw, true ) : [];
$support_tickets     = array_slice( $support_tickets, 0, 5 );

// API Key (masked)
$api_key_full   = get_user_meta( $user_id, 'api_key', true );
$api_key_masked = $api_key_full ? substr( $api_key_full, 0, 4 ) . '********' . substr( $api_key_full, -4 ) : '';
?>

<style>
  :root {
    --bg: #212121;
    --panel-bg: #212121;
    --panel-gradient: linear-gradient(135deg, #3b3b3b 0%, #16cac4 100%);
    --light-panel: #333333;
    --accent: #16cac4;
    --text-light: #f5f5f5;
    --text-muted: #bbbbbb;
    --header-height: 90px;
    --lux-pattern: url('<?php echo get_template_directory_uri(); ?>/assets/images/temple.svg');
  }

  html, body {
    margin: 0; padding: 0;
    background: var(--bg);
    color: var(--text-light);
    font-family: 'Segoe UI', Tahoma, sans-serif;
  }

  .container-three-col {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    gap: 2rem;
    min-height: calc(100vh - var(--header-height));
    padding: 2rem;
    background: var(--bg);
  }

  .left-panel,
.right-panel {
  /* marble‐plus‐tint background */
  background-image:
    linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
    url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  background-color: #2a2a2a;       /* fallback tint */
  background-blend-mode: overlay;  /* tint over marble */

  padding: 1rem;
  border-radius: 8px;
  position: sticky;
  top: var(--header-height, 90px);
  height: calc(100vh - var(--header-height, 90px) - 2rem);
  overflow-y: auto;
}


.profile-container > div {
  background: var(--light-panel);
  padding: 1.5rem;
  margin-bottom: 2rem;         /* space between sections */
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
}

/* Give section titles a bit of breathing room */
.profile-container > div .section-title {
  margin-top: 0;
  margin-bottom: 1rem;
}

.profile-summary {
  gap: 1.5rem;
}
  .left-panel h3, .right-panel h3, .section-title {
    color: var(--accent);
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }

  /* Profile Header */
  .profile-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: var(--panel-gradient);
    padding: 1.5rem;
    border-radius: 12px;
    position: relative;
    margin-bottom: 2rem;
  }
  .profile-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--lux-pattern) repeat;
    opacity: 0.15;
    border-radius: 12px;
    pointer-events: none;
  }
  .profile-avatar {
    width: 120px; height: 120px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    border: 3px solid #0096c7;
    z-index: 1;
  }
  .profile-basic h2 {
    margin: 0; font-size: 2rem; color: #0096c7;
  }
  .profile-basic .profile-email {
    font-size: 1rem; color: rgba(255,255,255,0.8);
  }
  .kyc-status {
    margin-top: .5rem; font-weight: 600;
  }
  .kyc-status.verified { color: #4caf50; }
  .kyc-status.pending  { color: #f5a623; }
  .kyc-status.rejected { color: #f44336; }

  /* Forms */
/* Align checkbox and label text nicely */
/* Target just the two-factor line */
/* Make notification checkboxes sit in one row */
/* Stack each notification label, text left, box centered */
#notifications .profile-form {
  display: block;  /* ensure vertical stacking */
}

#notifications .profile-form label {
  display: block;
  position: relative;      /* for absolutely positioning the checkbox */
  padding-left: 0;         /* no extra indent */
  margin-bottom: 1.5rem;   /* spacing between rows */
  line-height: 1.5;        /* give some height for centering */
  text-align: left;        /* keep text flush left */
}

.profile-form input[type="checkbox"] {
  -webkit-appearance: none;
  appearance: none;
  width: 1.2em;
  height: 1.2em;
  margin: 0 0.5em 0 0;    /* keep your existing spacing */
  border: 1px solid #ddd;
  background-color: #f5f5f5;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
}

/* 3) Draw the checkmark when checked */
.profile-form input[type="checkbox"]:checked::after {
  content: "✔";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -60%);
  font-size: 0.85em;
  color: #0096c7;
}


/* Remove any inherited block-level behavior */
.profile-form .twofa-field label {
  display: inline-flex;
  align-items: center;
  margin: 0;
  padding: 0;
}

/* Tweak checkbox itself */
.profile-form .twofa-field input#two_factor_enabled {
  margin: 0;
  width: auto;
}
.profile-form .twofa-field {
  grid-column: auto;
  display: flex;
  align-items: center;
  gap: .5rem;
}

/* Push the save buttons to span both columns and center them */
.profile-form .submit-btn {
  grid-column: 1 / -1;
  justify-self: center;
  max-width: 200px;
}

.profile-form input,
.profile-form select,
.profile-form textarea {
  width: 100%;
  grid-column: auto;  background-color: #212121 !important;
  border: 1px solid #212121;
  color: #f5f5f5;
}
  .profile-form textarea { min-height: 100px; resize: vertical; }
  .submit-btn {
    margin-top: 1.5rem;
    background: var(--panel-gradient);
    color: #212121;
    padding: .75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    transition: transform .2s;
  }
  .submit-btn:hover { transform: translateY(-2px); }

  /* Summary Cards */
  .profile-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
    gap: 1rem;
    margin-top: 1rem;
    margin-bottom: 2rem;
  }
  .summary-card {
    background: var(--panel-gradient);
    padding: 1rem;
    border-radius: 12px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
  }
  .summary-card::before {
    content: '';
    position: absolute;
    bottom: -20px; right: -20px;
    width: 100px; height: 100px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }
  .summary-card h4 {
    margin: 0 0 .5rem;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: .5px;
  }
  .summary-card p {
    font-size: 1.5rem; font-weight: 700;
  }

  /* Lists */
  ul, .statement-list, .ticket-list, .comment-list, .posts-list {
    list-style: none; padding: 0; margin: 0;
  }
  .statement-list li,
.ticket-list li,
.comment-list li,
.posts-list li {
  padding: 1rem;
  border-radius: 6px;
  background: var(--panel-bg);
  margin-bottom: 0.75rem;
}
.container-three-col {
  gap: 2.5rem;
  padding: 2.5rem;
}

/* Add a bit of extra breathing room in the sticky panels */
.left-panel,
.right-panel {
  padding: 1.5rem;
}

/* Tweak form grid gutters to match overall spacing */
.profile-form {
  gap: 1.25rem;
}
  a { color: var(--text-light); text-decoration: none; transition: color .2s; }
  a:hover { color: var(--accent); }
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Navigation -->
  <aside class="left-panel">
    <h3>Profile Navigation</h3>
    <ul>
      <li><a href="#profile-info">Profile Info</a></li>
      <li><a href="#account-summary">Account Summary</a></li>
      <li><a href="#balance-wallet">Balance & Wallet</a></li>
      <li><a href="#accounts-trades">Accounts & Trades</a></li>
      <li><a href="#deposit-withdraw">Deposits & Withdrawals</a></li>
      <li><a href="#support-tickets">Support Tickets</a></li>
      <li><a href="#api-credentials">API Credentials</a></li>
      <li><a href="#referrals">Referral Program</a></li>
      <li><a href="#watchlist">Watchlist</a></li>
      <li><a href="#risk-profile">Risk Profile</a></li>
      <li><a href="#achievements">Achievements</a></li>
      <li><a href="#comments">My Comments</a></li>
      <li><a href="#recent-posts">Recently Viewed Posts</a></li>
      <li><a href="#notifications">Notifications</a></li>
    </ul>
  </aside>

  <!-- Center Panel: Profile Content -->
  <section>
    <div class="profile-container">

      <!-- Profile Header -->
      <div id="profile-info" class="profile-header">
        <div
          class="profile-avatar"
          style="background-image: url('<?php echo esc_url( $avatar_url ?: get_avatar_url( $user_id ) ); ?>');">
        </div>
        <div class="profile-basic">
          <h2><?php echo esc_html( $display_name ); ?></h2>
          <div class="profile-email"><?php echo esc_html( $email ); ?></div>
          <?php if ( $kyc_status ) : ?>
            <div class="kyc-status <?php echo esc_attr( $kyc_status ); ?>">
              KYC Status: <?php echo esc_html( ucfirst( $kyc_status ) ); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Profile Edit Form -->
      <div id="edit-profile">
        <h3 class="section-title">Edit Profile</h3>
        <?php if ( isset( $_GET['updated'] ) ) : ?>
          <div style="background: #007700; padding: .5rem; border-radius:4px; margin-bottom:1rem;">
            Profile updated successfully.
          </div>
        <?php endif; ?>
        <form method="post" class="profile-form">
          <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>

          <label for="display_name">Display Name</label>
          <input type="text" name="display_name" id="display_name" value="<?php echo esc_attr( $display_name ); ?>" required>

          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="<?php echo esc_attr( $email ); ?>" required>

          <label for="phone_number">Phone Number</label>
          <input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr( $phone_number ); ?>">

          <label for="date_of_birth">Date of Birth</label>
          <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo esc_attr( $date_of_birth ); ?>">

          <label for="address">Address</label>
          <input type="text" name="address" id="address" value="<?php echo esc_attr( $address ); ?>">

          <label for="avatar_url">Avatar URL</label>
          <input type="url" name="avatar_url" id="avatar_url" value="<?php echo esc_attr( $avatar_url ); ?>">

          <label for="kyc_status">KYC Status</label>
          <select name="kyc_status" id="kyc_status">
            <option value="pending" <?php selected( $kyc_status, 'pending' ); ?>>Pending</option>
            <option value="verified" <?php selected( $kyc_status, 'verified' ); ?>>Verified</option>
            <option value="rejected" <?php selected( $kyc_status, 'rejected' ); ?>>Rejected</option>
          </select>

          <button type="submit" class="submit-btn">Save Profile Info</button>
        </form>
      </div>

      <!-- Account Summary Section -->
      <div id="account-summary">
        <h3 class="section-title">Account Summary</h3>
        <div class="profile-summary">
          <div class="summary-card">
            <h4>Balance (USD)</h4>
            <p><?php echo esc_html( number_format( floatval( $balance ), 2 ) ); ?></p>
          </div>
          <div class="summary-card">
            <h4>Wallet</h4>
            <p><?php echo esc_html( $wallet_address ); ?></p>
          </div>
          <div class="summary-card">
            <h4>Portfolio Value</h4>
            <p><?php echo esc_html( number_format( floatval( $portfolio_value ), 2 ) ); ?></p>
          </div>
          <div class="summary-card">
            <h4>Open Positions</h4>
            <p><?php echo esc_html( intval( $open_positions ) ); ?></p>
          </div>
          <div class="summary-card">
            <h4>Default Leverage</h4>
            <p><?php echo esc_html( $default_leverage ); ?></p>
          </div>
          <div class="summary-card">
            <h4>Two‐Factor Auth</h4>
            <p><?php echo $two_factor_enabled === 'yes' ? 'Enabled' : 'Disabled'; ?></p>
          </div>
        </div>
      </div>

      <!-- Balance & Wallet Section -->
      <div id="balance-wallet">
        <h3 class="section-title">Balance & Wallet Settings</h3>
        <form method="post" class="profile-form">
          <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>

          <label for="balance">Balance (USD)</label>
          <input type="text" name="balance" id="balance" value="<?php echo esc_attr( $balance ); ?>">

          <label for="wallet_address">Wallet Address</label>
          <input type="text" name="wallet_address" id="wallet_address" value="<?php echo esc_attr( $wallet_address ); ?>">

          <button type="submit" class="submit-btn">Update Balance & Wallet</button>
        </form>
      </div>

      <!-- Accounts & Trades Section -->
      <div id="accounts-trades">
        <h3 class="section-title">Accounts & Trading Settings</h3>
        <form method="post" class="profile-form">
          <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>

          <label for="watchlist">Watchlist (comma‐separated symbols)</label>
          <input type="text" name="watchlist" id="watchlist" value="<?php echo esc_attr( implode( ', ', $watchlist ) ); ?>">

          <label for="default_leverage">Default Leverage</label>
          <input type="text" name="default_leverage" id="default_leverage" value="<?php echo esc_attr( $default_leverage ); ?>">

          <label for="trading_preferences">Trading Preferences (comma‐separated)</label>
          <input type="text" name="trading_preferences" id="trading_preferences" value="<?php echo esc_attr( implode( ', ', $trading_prefs ) ); ?>">

          <div class="twofa-field">
            <span>Enable Two-Factor Authentication</span>
            <input
              type="checkbox"
              name="two_factor_enabled"
              id="two_factor_enabled"
              <?php checked( $two_factor_enabled, 'yes' ); ?>
            >
          </div>


          <label for="trade_details">Trade Details</label>
          <textarea name="trade_details" id="trade_details"><?php echo esc_textarea( $trade_details ); ?></textarea>

          <label for="trade_logs">Trade Logs</label>
          <textarea name="trade_logs" id="trade_logs"><?php echo esc_textarea( $trade_logs ); ?></textarea>

          <button type="submit" class="submit-btn">Save Trading Settings</button>
        </form>
      </div>

      <!-- Deposit & Withdrawal History Section -->
      <div id="deposit-withdraw">
        <h3 class="section-title">Deposit & Withdrawal History</h3>

        <h4>Deposits</h4>
        <?php if ( $deposit_history ) : ?>
          <ul class="statement-list">
            <?php foreach ( $deposit_history as $dep ) : ?>
              <li>
                <div class="stmt-meta">
                  Date: <?php echo esc_html( $dep['date'] ); ?> |
                  Amount: $<?php echo esc_html( number_format( floatval( $dep['amount'] ), 2 ) ); ?> |
                  Method: <?php echo esc_html( $dep['method'] ); ?>
                </div>
                <?php if ( ! empty( $dep['notes'] ) ) : ?>
                  <div class="stmt-content"><?php echo esc_html( $dep['notes'] ); ?></div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No deposit records found.</p>
        <?php endif; ?>

        <h4 style="margin-top: 1rem;">Withdrawals</h4>
        <?php if ( $withdrawal_history ) : ?>
          <ul class="statement-list">
            <?php foreach ( $withdrawal_history as $wd ) : ?>
              <li>
                <div class="stmt-meta">
                  Date: <?php echo esc_html( $wd['date'] ); ?> |
                  Amount: $<?php echo esc_html( number_format( floatval( $wd['amount'] ), 2 ) ); ?> |
                  Method: <?php echo esc_html( $wd['method'] ); ?>
                </div>
                <?php if ( ! empty( $wd['notes'] ) ) : ?>
                  <div class="stmt-content"><?php echo esc_html( $wd['notes'] ); ?></div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No withdrawal records found.</p>
        <?php endif; ?>
      </div>

      <!-- Support Tickets Section -->
      <div id="support-tickets">
        <h3 class="section-title">Support Tickets</h3>
        <?php if ( $support_tickets ) : ?>
          <ul class="ticket-list">
            <?php foreach ( $support_tickets as $ticket ) : ?>
              <li>
                <div class="ticket-meta">
                  Ticket ID: <?php echo esc_html( $ticket['id'] ); ?> |
                  Status: <?php echo esc_html( ucfirst( $ticket['status'] ) ); ?> |
                  Date: <?php echo esc_html( $ticket['date'] ); ?>
                </div>
                <div class="ticket-content"><?php echo esc_html( $ticket['subject'] ); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No support tickets found.</p>
        <?php endif; ?>
      </div>

      <!-- API Credentials Section -->
      <div id="api-credentials">
        <h3 class="section-title">API Credentials</h3>
        <?php if ( $api_key_full ) : ?>
          <p>Your API Key: <code><?php echo esc_html( $api_key_masked ); ?></code></p>
          <form method="post">
            <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>
            <input type="hidden" name="api_key_reset" value="1">
            <button type="submit" class="submit-btn">Reset API Key</button>
          </form>
        <?php else : ?>
          <p>No API key generated yet.</p>
          <form method="post">
            <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>
            <input type="hidden" name="api_key_generate" value="1">
            <button type="submit" class="submit-btn">Generate API Key</button>
          </form>
        <?php endif; ?>
      </div>

      <!-- Referral Program Section -->
      <div id="referrals">
        <h3 class="section-title">Referral Program</h3>
        <p>Your Referral Code: <strong><?php echo esc_html( $referral_code ); ?></strong></p>
        <p>Total Referrals: <strong><?php echo esc_html( intval( $referrals_count ) ); ?></strong></p>
        <p>Your Referral Link:</p>
        <code><?php echo esc_url( home_url( '/?ref=' . $referral_code ) ); ?></code>
      </div>

      <!-- Watchlist Section -->
      <div id="watchlist">
        <h3 class="section-title">Watchlist</h3>
        <?php if ( $watchlist ) : ?>
          <ul class="posts-list">
            <?php foreach ( $watchlist as $symbol ) : ?>
              <li><?php echo esc_html( strtoupper( $symbol ) ); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>Your watchlist is empty.</p>
        <?php endif; ?>
      </div>

      <!-- Risk Profile Section -->
      <div id="risk-profile">
        <h3 class="section-title">Risk Profile</h3>
        <p>Risk Tolerance: <strong><?php echo esc_html( ucfirst( $risk_tolerance ) ); ?></strong></p>
        <form method="post" class="profile-form">
          <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>
          <label for="risk_tolerance">Update Risk Tolerance</label>
          <select name="risk_tolerance" id="risk_tolerance">
            <option value="low" <?php selected( $risk_tolerance, 'low' ); ?>>Low</option>
            <option value="medium" <?php selected( $risk_tolerance, 'medium' ); ?>>Medium</option>
            <option value="high" <?php selected( $risk_tolerance, 'high' ); ?>>High</option>
          </select>
          <button type="submit" class="submit-btn">Save Risk Profile</button>
        </form>
      </div>

      <!-- Achievements Section -->
      <div id="achievements">
        <h3 class="section-title">Achievements & Badges</h3>
        <?php if ( $achievements ) : ?>
          <div class="achievements-list">
            <?php foreach ( $achievements as $badge_url ) : ?>
              <img src="<?php echo esc_url( $badge_url ); ?>" alt="Achievement Badge" style="width:48px;height:48px;margin:4px;">
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <p>No achievements yet.</p>
        <?php endif; ?>
      </div>

      <!-- Recent Comments Section -->
      <div id="comments">
        <h3 class="section-title">My Recent Comments</h3>
        <?php if ( $comments ) : ?>
          <ul class="comment-list">
            <?php foreach ( $comments as $c ) : ?>
              <li>
                <div class="comment-meta">
                  On <a href="<?php echo esc_url( get_permalink( $c->comment_post_ID ) ); ?>" target="_blank">
                    <?php echo esc_html( get_the_title( $c->comment_post_ID ) ); ?>
                  </a> – <?php echo esc_html( get_comment_date( '', $c ) ); ?>
                </div>
                <div class="comment-content"><?php echo esc_html( $c->comment_content ); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No comments found.</p>
        <?php endif; ?>
      </div>

      <!-- Recently Viewed Posts Section -->
      <div id="recent-posts">
        <h3 class="section-title">Recently Viewed Posts</h3>
        <?php if ( $recent_posts ) : ?>
          <ul class="posts-list">
            <?php foreach ( $recent_posts as $post_id ) :
              $post_title = get_the_title( $post_id );
              $permalink  = get_permalink( $post_id );
            ?>
              <li>
                <a href="<?php echo esc_url( $permalink ); ?>" target="_blank">
                  <?php echo esc_html( $post_title ); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No recently viewed posts.</p>
        <?php endif; ?>
      </div>

      <!-- Notification Settings Section -->
      <div id="notifications">
        <h3 class="section-title">Notification Settings</h3>
        <form method="post" class="profile-form">
          <?php wp_nonce_field( 'profile_update', 'profile_update_nonce' ); ?>
          <label for="notify_email">
            <input type="checkbox" name="notify_email" id="notify_email" <?php checked( $notifications['email'], true ); ?>>
            Email Notifications
          </label>
          <label for="notify_sms">
            <input type="checkbox" name="notify_sms" id="notify_sms" <?php checked( $notifications['sms'], true ); ?>>
            SMS Notifications
          </label>
          <label for="notify_push">
            <input type="checkbox" name="notify_push" id="notify_push" <?php checked( $notifications['push'], true ); ?>>
            Push Notifications
          </label>
          <button type="submit" class="submit-btn">Save Notification Settings</button>
        </form>
      </div>

    </div>
  </section>

  <!-- Right Panel: Additional Profile Details -->
  <aside class="right-panel">
    <h3>Profile Summary</h3>
    <ul>
      <li><strong>User ID:</strong> <?php echo esc_html( $user_id ); ?></li>
      <li><strong>Registered On:</strong> <?php echo esc_html( get_the_date( '', $current_user->ID ) ); ?></li>
      <li><strong>Role:</strong> <?php echo esc_html( implode( ', ', $current_user->roles ) ); ?></li>
      <?php if ( $phone_number ) : ?>
        <li><strong>Phone:</strong> <?php echo esc_html( $phone_number ); ?></li>
      <?php endif; ?>
      <?php if ( $date_of_birth ) : ?>
        <li><strong>Date of Birth:</strong> <?php echo esc_html( $date_of_birth ); ?></li>
      <?php endif; ?>
      <?php if ( $address ) : ?>
        <li><strong>Address:</strong> <?php echo esc_html( $address ); ?></li>
      <?php endif; ?>
    </ul>

    <h3>Useful Links</h3>
    <ul>
      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
      <li><a href="<?php echo esc_url( get_edit_profile_url( $user_id ) ); ?>">WP Profile Settings</a></li>
      <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">Logout</a></li>
    </ul>
  </aside>

</main>

<?php get_footer(); ?>
