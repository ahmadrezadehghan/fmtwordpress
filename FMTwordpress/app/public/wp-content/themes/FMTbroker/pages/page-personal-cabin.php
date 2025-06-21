<?php
/**
 * Template Name: Personal Cabin
 * Description: FMTbroker “Personal Cabin” accounts overview
 */
get_header();
?>

<style>
  :root {
    --bg: #212121;
    --panel-bg: #2a2a2a;
    --panel-gradient: linear-gradient(135deg, #1694ca 0%, #16cac4 100%);
    --light-panel: #333333;
    --accent: #16cac4;
    --text-light: #f5f5f5;
    --text-muted: #bbbbbb;
    --header-height: 90px;
     /* 1. Point to your temple.svg in the theme assets */
     --lux-pattern-1: url('<?php echo get_template_directory_uri(); ?>/assets/images/temple.svg');
  }

  /* make sure children layering works */
  .pc-cards .pc-card {
    position: relative;
    overflow: hidden;
    background: var(--panel-gradient);  /* default, overridden per card below */
  }
  .pc-cards .pc-card > * {
    position: relative;
    z-index: 2;
  }
  /* === All accounts card pattern overlay === */
  .pc-cards .pc-card:nth-child(1)::after {
    content: '';
    position: absolute;
    inset: 0;                    /* shorthand for top/right/bottom/left = 0 */
    background: var(--lux-pattern-1) repeat;
    opacity: 0.2;                /* 50% transparency */
    pointer-events: none;        /* so buttons/etc still clickable */
  }

  /* === Copy Trading card pattern overlay === */
  .pc-cards .pc-card:nth-child(2)::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--lux-pattern-1) repeat;
    opacity: 0.2;
    pointer-events: none;
  }

  /* Now leave your existing backgrounds alone */
  .pc-cards .pc-card:nth-child(1) {
    background: var(--panel-gradient);
  }

  /* === Copy Trading card: use light panel colour under pattern === */
  .pc-cards .pc-card:nth-child(2) {
    background: var(--light-panel);
  }

  html, body {
    margin: 0; padding: 0;
    background: var(--bg);
    color: var(--text-light);
    font-family: 'Segoe UI', Tahoma, sans-serif;
  }

  .personal-cabin-wrapper {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.5rem;
    padding: 2rem;
    min-height: calc(100vh - var(--header-height));
  }

  /* === Header === */
  .pc-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
  }
  .pc-accounts-header {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-light);
  }
  .pc-list-toggle {
    font-size: 1.1rem;
    color: var(--accent);
    text-decoration: none;
    display: flex;
    align-items: center;
  }
  .pc-list-toggle svg {
    margin-left: 6px;
    fill: var(--accent);
  }

  /* === Cards Container === */
  .pc-cards {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 2rem;
  }

  .pc-card {
    position: relative;
    flex: 1 1 320px;
    min-width: 300px;
    background: var(--panel-gradient);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.6);
    color: #fff;
    overflow: hidden;
  }
  .pc-card h3 {
    margin: 0 0 .75rem;
    font-size: 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
  }
  .pc-balance {
    font-size: 2.8rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: .25rem;
  }
  .pc-subtext {
    font-size: 1.5rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: .25rem;
  }
  .pc-card::before {
    content: '';
    position: absolute;
    bottom: -20px; right: -20px;
    width: 120px; height: 120px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }
  .pc-card.light {
    background: var(--light-panel);
    color: var(--text-light);
  }

  /* === Actions Row === */
  .pc-actions {
    display: flex;
    justify-content: space-around;
    background: var(--panel-bg);
    padding: 1rem 0;
    border-radius: 8px;
    margin-bottom: 2rem;
  }
  .pc-actions button {
    background: none;
    border: none;
    color: var(--text-light);
    font-size: .95rem;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .5rem;
    transition: color .2s;
  }
  .pc-actions button:hover {
    color: var(--accent);
  }
  .pc-actions button img {
    width: 28px; height: 28px;
    filter: invert(100%) brightness(100%);
    transition: filter .2s;
  }
  .pc-actions button:hover img {
    filter: invert(38%) sepia(98%) saturate(407%)
            hue-rotate(183deg) brightness(96%) contrast(98%);
  }

  /* === Sidebar Panels Shared Style === */
  .pc-sidebar > div {
    background: var(--panel-bg);
    border-radius: 8px;
    padding: 1.2rem;
    margin-bottom: 1.2rem;
  }

  /* === User Profile Panel === */
  .pc-user-menu {
    text-align: center;
  }

  .pc-user-menu .avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--light-panel) center/cover no-repeat url('<?php echo get_template_directory_uri(); ?>/assets/images/avatar.png');
    margin: 0 auto 1rem;
  }
  .profile-basic {
    margin-bottom: 1rem;
  }
  .pc-user-menu .profile-basic h2 {
    margin: 0;
    font-size: 1.25rem;
    color: #fff;
  }
  .pc-user-menu .profile-basic .profile-email {
    font-size: .9rem;
    color: #ccc;
  }
  .pc-user-menu .kyc-status {
    font-size: .85rem;
    margin-top: .25rem;
  }
  .pc-user-menu .kyc-status.verified { color: #4caf50; }
  .pc-user-menu .kyc-status.pending  { color: #f5a623; }
  .pc-user-menu .kyc-status.rejected { color: #f44336; }

  /* === User Links === */
  .pc-user-links {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
  .pc-user-links a {
    color: var(--text-light);
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.2s;
    padding: 0.25rem 0;
    border-bottom: 1px solid var(--panel-bg);
  }
  .pc-user-links a:hover {
    color: var(--accent);
  }
  .pc-user-links a.logout-link {
    color: #e74c3c;
    font-weight: 600;
    border-bottom: none;
  }
  .pc-user-links a.logout-link:hover {
    color: #c0392b;
  }

  /* === Promo & CTA === */
  .pc-promo {
    background: var(--panel-bg);
    border-radius: 8px;
    padding: 1.25rem;
    text-align: center;
    font-size: 1rem;
    margin-bottom: 1.5rem;
  }

  .pc-promo h4 {
    margin: 0 0 .5rem;
    font-size: 1.25rem;
    color: var(--accent);
  }
  .pc-promo a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
  }

  .pc-cta {
    background: var(--panel-gradient);
    padding: 1.75rem;
    border-radius: 12px;
    text-align: center;
    color: #fff;
  }
  .pc-cta h3 {
    margin: 0 0 1rem;
    font-size: 1.5rem;
    font-weight: 700;
  }
  .pc-cta button {
    background: #fff;
    color: var(--accent);
    padding: .75rem 2rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, transform .2s;
  }
  .pc-cta button:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
  }

  /* === Support & Privacy === */
  .pc-support p:first-child { font-weight: 600; color: var(--accent); }
  .pc-privacy p, .pc-support p { margin: .5rem 0; font-size: .9rem; }
  .pc-privacy a { color: var(--accent); text-decoration: none; margin-right: .5rem; }
</style>

<?php
// Fetch profile data
$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$display_name = $current_user->display_name;
$email        = $current_user->user_email;
$kyc_status   = get_user_meta( $user_id, 'kyc_status', true );
$avatar_url   = get_user_meta( $user_id, 'avatar_url', true ) ?: get_avatar_url( $user_id );
?>

<div class="personal-cabin-wrapper">

  <!-- Left: Main content -->
  <div class="pc-main">
    <div class="pc-list-header">
      <span class="pc-accounts-header">FMTbroker Accounts</span>
      <a href="#" class="pc-list-toggle">
        Show as a list
        <svg width="16" height="16" viewBox="0 0 16 16">
          <path d="M4 6h8v2H4V6zM4 10h8v2H4v-2z"/>
          <circle cx="2" cy="3" r="2"/>
          <circle cx="2" cy="9" r="2"/>
          <circle cx="2" cy="15" r="2"/>
        </svg>
      </a>
    </div>

    <div class="pc-cards">
      <div class="pc-card">
        <h3>All accounts</h3>
        <div class="pc-balance">$96.63</div>
        <div class="pc-subtext">$0.00</div>
        <div class="pc-subtext">Wallet: 440954</div>
      </div>
      <div class="pc-card light">
        <h3>Copy Trading</h3>
        <div class="pc-subtext">1355637</div>
        <div class="pc-balance">$0.00</div>
      </div>
    </div>

    <div class="pc-actions">
      <?php
      $icons  = ['Deposit','Trade','Transfer','Withdraw','more'];
      $labels = ['Deposit','Trade','Transfer','Withdraw','Transactions'];
      foreach ( $icons as $i => $icon ) : ?>
        <button>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $icon; ?>.png"
               alt="<?php echo $labels[ $i ]; ?> Icon" />
          <span><?php echo $labels[ $i ]; ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="pc-promo">
      <h4>Trade Analyzer</h4>
      Level up your trading and enhance your results
      <p><a href="#">View &gt;</a></p>
    </div>

    <div class="pc-cta">
      <h3>Fund your account and start trading now!</h3>
      <button>Deposit</button>
    </div>
  </div>

  <!-- Right: Sidebar -->
  <aside class="pc-sidebar">

    <!-- User Profile Panel -->
    <div class="pc-user-menu">
      <div class="avatar" style="background-image: url('<?php echo esc_url( $avatar_url ); ?>');"></div>

      <div class="profile-basic">
        <h2><?php echo esc_html( $display_name ); ?></h2>
        <div class="profile-email"><?php echo esc_html( $email ); ?></div>
        <?php if ( $kyc_status ) : ?>
          <div class="kyc-status <?php echo esc_attr( $kyc_status ); ?>">
            KYC Status: <?php echo esc_html( ucfirst( $kyc_status ) ); ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- QUICK LINKS UNDER AVATAR -->
      <nav class="pc-user-links">
        <a href="<?php echo esc_url( home_url( '/personal-cabin/' ) ); ?>">Personal Cabin</a>
        <a href="<?php echo esc_url( home_url( '/pages/user-profile/' ) ); ?>">My profile</a>
        <a href="#">My achievements</a>
        <a href="#">Cashback</a>
        <a href="#">My coupons</a>
        <a href="#">Language: EN</a>
        <a href="#">My Partner</a>
        <a href="<?php echo esc_url( home_url( '/partner-area/' ) ); ?>">Partner Area ↗</a>
        <a href="#">New update. Version 1.36.0</a>
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" class="logout-link">Log Out</a>
      </nav>
    </div>

    <!-- Support details -->
    <div class="pc-support">
      <p>@fmtbroker_support</p>
      <p>+44 330 777 22 22</p>
      <p>support@fmtbroker.com</p>
    </div>

    <!-- Privacy & legal -->
    <div class="pc-privacy">
      <p>
        <a href="#">Privacy policy</a> |
        <a href="#">Documents</a> |
        <a href="#">FMTbroker site</a>
      </p>
      <p>FMTbroker LLC is registered in the Cook Islands…</p>
      <p>Risk Warning: Trading foreign exchange on margin…</p>
    </div>

  </aside>
</div>

<?php get_footer(); ?>
