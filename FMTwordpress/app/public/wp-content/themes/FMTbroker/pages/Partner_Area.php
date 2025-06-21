<?php
/**
 * Template Name: Partner Area
 * Description: Partner dashboard with referral stats, search clients, remuneration tiers, and full navigation as shown.
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( wp_login_url( get_permalink() ) );
    exit;
}

get_header();

// Fetch current user and partner‐specific meta
$current_user             = wp_get_current_user();
$user_id                  = $current_user->ID;
$avatar_url               = get_user_meta( $user_id, 'avatar_url', true ) ?: get_avatar_url( $user_id );
$partner_code             = get_user_meta( $user_id, 'partner_code', true ) ?: 'PERSIANTRADE';
$wallet_number            = get_user_meta( $user_id, 'partner_wallet', true ) ?: '440954';
$account_type             = get_user_meta( $user_id, 'partner_account_type', true ) ?: 'Agent (IB)';
$referral_link            = esc_url( home_url( '/?ref=' . $partner_code ) );

// Example “last registrations” data (replace with dynamic query as needed)
$last_registrations = [
    ['wallet' => '2720813', 'date' => '2025.05.27', 'payments' => 'No'],
    ['wallet' => '2717900', 'date' => '2025.05.25', 'payments' => 'No'],
    ['wallet' => '2710708', 'date' => '2025.05.19', 'payments' => 'No'],
    ['wallet' => '2698716', 'date' => '2025.05.09', 'payments' => 'Yes'],
    ['wallet' => '2692600', 'date' => '2025.05.03', 'payments' => 'Yes'],
];

// Example remuneration data (replace with dynamic)
$total_remuneration       = get_user_meta( $user_id, 'partner_total_remuneration', true ) ?: 978.43;
$today_remuneration       = get_user_meta( $user_id, 'partner_today_remuneration', true ) ?: 0.0;
$new_clients_last_month   = get_user_meta( $user_id, 'partner_new_clients_last_month', true ) ?: 0;
$trading_volume_to_next   = get_user_meta( $user_id, 'partner_volume_to_next', true ) ?: 0;

// Determine current tier based on $new_clients_last_month or trading volume
if ( $new_clients_last_month >= 5 ) {
    $current_tier = 'PLATINUM';
} elseif ( $new_clients_last_month >= 3 ) {
    $current_tier = 'GOLD';
} else {
    $current_tier = 'SILVER';
}

// Generate or fetch API key
$api_key = get_user_meta( $user_id, 'partner_api_key', true );
if ( ! $api_key ) {
    $api_key = wp_generate_password( 32, false, false );
    update_user_meta( $user_id, 'partner_api_key', $api_key );
}

// Marketing banners (stored in theme folder)
$marketing_banners = [
    ['label' => 'Banner 728×90 (Light)', 'filename' => 'banner-728x90-light.png'],
    ['label' => 'Banner 728×90 (Dark)',  'filename' => 'banner-728x90-dark.png'],
    ['label' => 'Banner 300×250 (Light)', 'filename' => 'banner-300x250-light.png'],
    ['label' => 'Banner 300×250 (Dark)',  'filename' => 'banner-300x250-dark.png'],
];

// Widgets embed code examples
$widget_code = '<script src="' . esc_url( home_url( '/partner-widget.js?code=' . $partner_code ) ) . '"></script>';

// Commission statement download link (example PDF stored in uploads)
$statement_url = wp_get_attachment_url( get_option( 'partner_statement_pdf_id', 0 ) ) ?: '#';
?>

<style>
:root {
  --bg: #212121;
  --panel-bg: #2a2a2a;
  --light-panel: #333333;
  --accent: #1694ca;
  --text-light: #f5f5f5;
  --text-muted: #bbbbbb;
  --header-height: 90px;
}

html, body {
  margin: 0;
  padding: 0;
  background: var(--bg);
  color: var(--text-light);
  font-family: sans-serif;
}

/* === Container === */
.partner-area-wrapper {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 1rem;
  padding: 2rem;
  min-height: calc(100vh - var(--header-height));
}

/* === Sidebar (Right) === */
.pa-sidebar {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

/* Language selector */
.pa-languages {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-languages a {
  color: var(--text-light);
  font-size: 0.85rem;
  text-decoration: none;
  margin-right: 0.5rem;
}
.pa-languages a:hover {
  color: var(--accent);
}

/* User menu */
.pa-user-menu {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
}
.pa-user-avatar {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: var(--light-panel) center/cover no-repeat url('<?php echo esc_url( $avatar_url ); ?>');
  margin: 0 auto 1rem;
}
.pa-user-menu button.btn-deposit {
  display: block;
  width: 100%;
  background: var(--accent);
  border: none;
  color: #fff;
  padding: .75rem 0;
  border-radius: 4px;
  font-size: 1rem;
  margin-bottom: 1rem;
  cursor: pointer;
}
.pa-user-menu nav a {
  display: block;
  color: var(--text-light);
  text-decoration: none;
  font-size: 0.9rem;
  padding: 0.5rem 0;
  border-bottom: 1px solid var(--light-panel);
}
.pa-user-menu nav a:last-child {
  border-bottom: none;
  color: #e74c3c;
}
.pa-user-menu nav a:hover {
  color: var(--accent);
}

/* Support card */
.pa-support {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
  font-size: 0.9rem;
  color: var(--text-light);
}
.pa-support p {
  margin: 0.5rem 0;
}
.pa-support p:first-child {
  font-weight: 600;
  color: var(--accent);
}

/* Privacy & Links */
.pa-privacy {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
  font-size: 0.8rem;
  color: var(--text-muted);
}
.pa-privacy a {
  color: var(--accent);
  text-decoration: none;
  margin-right: 0.5rem;
  font-size: 0.9rem;
}
.pa-privacy p:last-child {
  margin-top: 0.75rem;
  font-size: 0.75rem;
  line-height: 1.3;
}

/* === Main Content (Left) === */
.pa-main {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

/* Header */
.pa-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.pa-header h2 {
  font-size: 1.75rem;
  font-weight: 700;
  margin: 0;
}
.pa-header span {
  font-size: 0.9rem;
  color: var(--text-muted);
}

/* Wallet & Account Info */
.pa-account-info {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.pa-account-info .info-block {
  flex: 1 1 200px;
}
.pa-account-info .info-block h3 {
  margin: 0 0 0.5rem;
  font-size: 1rem;
  color: var(--text-light);
}
.pa-account-info .info-block p {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--accent);
}

/* Referral Link */
.pa-referral-link {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-referral-link h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-referral-link input {
  width: calc(100% - 2px);
  padding: 0.5rem;
  background: var(--light-panel);
  border: 1px solid #444;
  border-radius: 4px;
  color: var(--text-light);
  margin-top: 0.5rem;
  box-sizing: border-box;
}
.pa-referral-link button {
  margin-top: 0.75rem;
  background: var(--accent);
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.pa-referral-link button:hover {
  background: #117a9e;
}

/* Search Clients */
.pa-search-clients {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-search-clients h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-search-clients form {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}
.pa-search-clients input[type="text"],
.pa-search-clients select {
  flex: 1 1 200px;
  padding: 0.5rem;
  background: var(--light-panel);
  border: 1px solid #444;
  border-radius: 4px;
  color: var(--text-light);
  box-sizing: border-box;
}
.pa-search-clients button {
  background: var(--accent);
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.pa-search-clients button:hover {
  background: #117a9e;
}

/* Last Registrations Table */
.pa-last-registrations {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-last-registrations h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-last-registrations table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
.pa-last-registrations th,
.pa-last-registrations td {
  padding: 0.5rem;
  font-size: 0.85rem;
  border-bottom: 1px solid #444;
  text-align: left;
}
.pa-last-registrations th {
  color: var(--text-muted);
}

/* Remuneration Section */
.pa-remuneration {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-remuneration h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-remuneration .rem-summary {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}
.pa-remuneration .rem-summary .rem-block {
  flex: 1 1 200px;
}
.pa-remuneration .rem-summary .rem-block h4 {
  margin: 0;
  font-size: 1rem;
  color: var(--text-muted);
}
.pa-remuneration .rem-summary .rem-block p {
  margin: 0.5rem 0 0;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--accent);
}
.pa-remuneration .rem-info {
  margin-top: 1rem;
  font-size: 0.9rem;
  color: var(--text-muted);
}
.pa-remuneration .tiers {
  margin-top: 1rem;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 1rem;
}
.pa-remuneration .tier-card {
  background: var(--light-panel);
  border-radius: 8px;
  padding: 1rem;
  text-align: center;
}
.pa-remuneration .tier-card h5 {
  margin: 0 0 0.5rem;
  font-size: 1rem;
  color: var(--text-light);
}
.pa-remuneration .tier-card p {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  color: <?php echo $current_tier === 'SILVER' ? 'var(--accent)' : 'var(--text-light)'; ?>;
}

/* Sub‐Partners Section */
.pa-subpartners {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-subpartners h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-subpartners table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
.pa-subpartners th,
.pa-subpartners td {
  padding: 0.5rem;
  font-size: 0.85rem;
  border-bottom: 1px solid #444;
  text-align: left;
}
.pa-subpartners th {
  color: var(--text-muted);
}

/* Payout History Section */
.pa-payouts {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-payouts h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-payouts table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
.pa-payouts th,
.pa-payouts td {
  padding: 0.5rem;
  font-size: 0.85rem;
  border-bottom: 1px solid #444;
  text-align: left;
}
.pa-payouts th {
  color: var(--text-muted);
}

/* Commission Statement Download */
.pa-statement {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-statement h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-statement a {
  display: inline-block;
  margin-top: 0.5rem;
  background: var(--accent);
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  text-decoration: none;
  transition: background-color 0.2s;
}
.pa-statement a:hover {
  background: #117a9e;
}

/* Marketing Banners Gallery */
.pa-banners {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-banners h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-banners .banner-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px,1fr));
  gap: 1rem;
  margin-top: 1rem;
}
.pa-banners .banner-item {
  text-align: center;
  background: var(--light-panel);
  border-radius: 4px;
  padding: 0.5rem;
}
.pa-banners .banner-item img {
  max-width: 100%;
  height: auto;
  border-radius: 4px;
}
.pa-banners .banner-item a {
  display: block;
  margin-top: 0.5rem;
  color: var(--accent);
  font-size: 0.85rem;
  text-decoration: none;
}
.pa-banners .banner-item a:hover {
  text-decoration: underline;
}

/* Widgets Embed Code */
.pa-widgets {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-widgets h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-widgets textarea {
  width: 100%;
  height: 80px;
  background: var(--light-panel);
  border: 1px solid #444;
  border-radius: 4px;
  color: var(--text-light);
  padding: 0.5rem;
  box-sizing: border-box;
  resize: none;
}
.pa-widgets button {
  margin-top: 0.5rem;
  background: var(--accent);
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.pa-widgets button:hover {
  background: #117a9e;
}

/* API Key Section */
.pa-api-key {
  background: var(--panel-bg);
  border-radius: 8px;
  padding: 1rem;
}
.pa-api-key h3 {
  margin-top: 0;
  font-size: 1.25rem;
  color: var(--text-light);
}
.pa-api-key input {
  width: calc(100% - 2px);
  padding: 0.5rem;
  background: var(--light-panel);
  border: 1px solid #444;
  border-radius: 4px;
  color: var(--text-light);
  margin-top: 0.5rem;
  box-sizing: border-box;
}
.pa-api-key button {
  margin-top: 0.5rem;
  background: var(--accent);
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.pa-api-key button:hover {
  background: #117a9e;
}

/* Utility transitions */
a {
  transition: color 0.2s;
}
</style>

<div class="partner-area-wrapper">

  <!-- Main Content -->
  <div class="pa-main">
    <!-- Header -->
    <div class="pa-header">
      <h2>Partner Area</h2>
      <span>Welcome, <?php echo esc_html( $current_user->display_name ); ?></span>
    </div>

    <!-- Account Info Summary -->
    <div class="pa-account-info">
      <div class="info-block">
        <h3>Wallet №</h3>
        <p><?php echo esc_html( $wallet_number ); ?></p>
      </div>
      <div class="info-block">
        <h3>Balance</h3>
        <p>$<?php echo number_format( floatval( get_user_meta( $user_id, 'partner_balance', true ) ?: 101.05 ), 2 ); ?></p>
      </div>
      <div class="info-block">
        <h3>Account Type</h3>
        <p><?php echo esc_html( $account_type ); ?></p>
      </div>
      <div class="info-block">
        <h3>Partner Code</h3>
        <p><?php echo esc_html( $partner_code ); ?></p>
      </div>
    </div>

    <!-- Referral Link -->
    <div class="pa-referral-link">
      <h3>Referral Link</h3>
      <input
        type="text"
        readonly
        value="<?php echo esc_attr( $referral_link ); ?>"
        onclick="this.select();"
      />
      <button onclick="navigator.clipboard.writeText('<?php echo esc_js( $referral_link ); ?>')">
        Copy Link
      </button>
    </div>

    <!-- Search Clients -->
    <div class="pa-search-clients">
      <h3>Search Your Clients</h3>
      <form method="get" style="margin-top: 0.75rem;">
        <select name="search_by">
          <option value="wallet">By Wallet</option>
          <option value="email">By Email</option>
          <option value="username">By Username</option>
        </select>
        <input
          type="text"
          name="search_term"
          placeholder="Enter search term…"
        />
        <button type="submit">Search</button>
      </form>
    </div>

    <!-- Last Registrations -->
    <div class="pa-last-registrations">
      <h3>Last Registrations</h3>
      <table>
        <thead>
          <tr>
            <th>Wallet</th>
            <th>Registration Date</th>
            <th>Payments</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ( $last_registrations as $reg ) : ?>
            <tr>
              <td><?php echo esc_html( $reg['wallet'] ); ?></td>
              <td><?php echo esc_html( $reg['date'] ); ?></td>
              <td><?php echo esc_html( $reg['payments'] ); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Remuneration Section -->
    <div class="pa-remuneration">
      <h3>Remuneration</h3>
      <div class="rem-summary">
        <div class="rem-block">
          <h4>Total</h4>
          <p>$<?php echo number_format( floatval( $total_remuneration ), 2 ); ?></p>
        </div>
        <div class="rem-block">
          <h4>Today</h4>
          <p>$<?php echo number_format( floatval( $today_remuneration ), 2 ); ?></p>
        </div>
        <div class="rem-block">
          <h4>Remuneration Rate</h4>
          <p><?php echo esc_html( $current_tier ); ?> (No Multilevel)</p>
        </div>
        <div class="rem-block">
          <h4>New Clients</h4>
          <p><?php echo intval( $new_clients_last_month ); ?></p>
        </div>
      </div>
      <div class="rem-info">
        <p>
          The level of remuneration depends on the number of new active clients who have registered and funded accounts during the last month:
          <br>1. SILVER – from 0 new clients
          <br>2. GOLD – from 3 new clients
          <br>3. PLATINUM – from 5 new clients
        </p>
        <p>Trade volume till the next rate: <?php echo intval( $trading_volume_to_next ); ?> lots</p>
        <p>
          Remuneration levels depending on trading turnover:
          <br>1. SILVER – from 0 to 99 lots
          <br>2. GOLD – from 100 to 299 lots
          <br>3. PLATINUM – from 300 lots and higher
        </p>
        <p>
          The remuneration level is updated at the beginning of each month. This doesn’t happen immediately once the required trading volume is reached.
          Please note that remuneration is calculated based on the trading turnover in Forex & Metals and added in the “Reserved” column. It can be adjusted downwards in accordance with the company’s terms and conditions, described in the Partnership Agreement.
        </p>
      </div>
      <div class="tiers">
        <div class="tier-card" style="background: <?php echo $current_tier === 'SILVER' ? 'var(--accent)' : 'var(--light-panel)'; ?>;">
          <h5>SILVER</h5>
          <p>0 lots</p>
        </div>
        <div class="tier-card" style="background: <?php echo $current_tier === 'GOLD' ? 'var(--accent)' : 'var(--light-panel)'; ?>;">
          <h5>GOLD</h5>
          <p>100 lots</p>
        </div>
        <div class="tier-card" style="background: <?php echo $current_tier === 'PLATINUM' ? 'var(--accent)' : 'var(--light-panel)'; ?>;">
          <h5>PLATINUM</h5>
          <p>300 lots+</p>
        </div>
      </div>
    </div>

    <!-- Sub‐Partners Section -->
    <div class="pa-subpartners">
      <h3>Sub‐Partners</h3>
      <?php
        $subpartners_raw = get_user_meta( $user_id, 'partner_subpartners', true );
        $subpartners     = $subpartners_raw ? json_decode( $subpartners_raw, true ) : [];
      ?>
      <?php if ( $subpartners ) : ?>
        <table>
          <thead>
            <tr>
              <th>Username</th>
              <th>Joined</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $subpartners as $sp ) : ?>
              <tr>
                <td><?php echo esc_html( $sp['username'] ); ?></td>
                <td><?php echo esc_html( $sp['joined'] ); ?></td>
                <td><?php echo esc_html( ucfirst( $sp['active'] ? 'Active' : 'Inactive' ) ); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else : ?>
        <p>No sub‐partners found.</p>
      <?php endif; ?>
    </div>

    <!-- Payout History Section -->
    <div class="pa-payouts">
      <h3>Payout History</h3>
      <?php
        $payout_history_raw = get_user_meta( $user_id, 'partner_payout_history', true );
        $payout_history     = $payout_history_raw ? json_decode( $payout_history_raw, true ) : [];
      ?>
      <?php if ( $payout_history ) : ?>
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Amount (USD)</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $payout_history as $p ) : ?>
              <tr>
                <td><?php echo esc_html( $p['date'] ); ?></td>
                <td>$<?php echo esc_html( number_format( floatval( $p['amount'] ), 2 ) ); ?></td>
                <td><?php echo esc_html( ucfirst( $p['status'] ) ); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else : ?>
        <p>No payout records yet.</p>
      <?php endif; ?>
    </div>

    <!-- Commission Statement Download -->
    <div class="pa-statement">
      <h3>Download Commission Statement</h3>
      <a href="<?php echo esc_url( $statement_url ); ?>" download>Download PDF</a>
    </div>

    <!-- Marketing Banners Gallery -->
    <div class="pa-banners">
      <h3>Marketing Banners</h3>
      <div class="banner-grid">
        <?php foreach ( $marketing_banners as $banner ) : ?>
          <div class="banner-item">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/partner/banners/' . $banner['filename'] ); ?>" alt="<?php echo esc_attr( $banner['label'] ); ?>">
            <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/partner/banners/' . $banner['filename'] ); ?>" download><?php echo esc_html( $banner['label'] ); ?></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Widgets Embed Code -->
    <div class="pa-widgets">
      <h3>Widgets Embed Code</h3>
      <textarea readonly onclick="this.select();"><?php echo esc_html( $widget_code ); ?></textarea>
      <button onclick="navigator.clipboard.writeText('<?php echo esc_js( $widget_code ); ?>')">Copy Code</button>
    </div>

    <!-- API Key Section -->
    <div class="pa-api-key">
      <h3>Your API Key</h3>
      <input type="text" readonly value="<?php echo esc_attr( $api_key ); ?>" onclick="this.select();">
      <button onclick="navigator.clipboard.writeText('<?php echo esc_js( $api_key ); ?>')">Copy API Key</button>
    </div>
  </div>

  <!-- Sidebar Content -->
  <aside class="pa-sidebar">
    <!-- Language Selector -->
    <div class="pa-languages">
      <a href="#">English</a>
      <a href="#">فارسی</a>
      <a href="#">Русский</a>
      <a href="#">O'zbek</a>
      <a href="#">हिन्दी</a>
      <a href="#">Bahasa Melayu</a>
      <a href="#">Українська</a>
      <a href="#">Azərbaycan</a>
      <a href="#">Türकçe</a>
      <a href="#">Bahasa Indonesia</a>
      <a href="#">Tiếng Việt</a>
      <a href="#">ไทย</a>
      <a href="#">Nigerian</a>
      <a href="#">Español</a>
    </div>

    <!-- User Menu -->
    <div class="pa-user-menu">
      <div class="pa-user-avatar"></div>
      <button class="btn-deposit">Deposit</button>
      <nav>
        <a href="<?php echo esc_url( home_url( '/user-profile/' ) ); ?>">My Profile</a>
        <a href="<?php echo wp_logout_url(); ?>">Log Off</a>
      </nav>
    </div>

    <!-- Support Card -->
    <div class="pa-support">
      <p>@fmtbroker_support</p>
      <p>+44 330 777 22 22</p>
      <p>support@fmtbroker.com</p>
    </div>

    <!-- Privacy & Legal -->
    <div class="pa-privacy">
      <p>
        <a href="#">Privacy Policy</a> |
        <a href="#">Documents</a> |
        <a href="#">FMTbroker Site</a>
      </p>
      <p>FMTbroker LLC is registered in the Cook Islands…</p>
      <p>Risk Warning: Trading foreign exchange on margin…</p>
    </div>
  </aside>

</div>

<script>
// No tabs remaining under “Statistics,” so no JS needed here.
</script>

<?php get_footer(); ?>
