<?php
/**
 * Template Name: About
 * Description: Extensive “About Us” page template for FMTbroker with dark styling, images, alternating content, and a sticky Fast Access panel on the right.
 *              The “Hear from Our Traders,” “Careers,” and “Get Started Today” sections have updated luxury styles; all other parts remain as the base version.
 */

get_header(); ?>

<style>
  /* ===== Color Palette ===== */
  :root {
    --primary-dark: #1673ca;
    --primary: #1694ca;
    --primary-light: #16cac4;
    --secondary: #6716ca;
    --bg-dark: #212121;
    --bg-medium: #2a2a2a;
    --bg-light: #333333;
    --text-light: #e0e0e0;
    --text-medium: #cccccc;
    --shadow-color: rgba(0, 0, 0, 0.6);

    /* Luxury accents only for specific sections */
    --luxury-gold: #D4AF37;
    --emerald-green: #2E8B57;
    --rose-quartz: #F7CAC9;
    --rich-cream: #FFF8E7;
    --gradient-secondary: linear-gradient(135deg, #6716ca 0%, #4B0F5C 100%);
  }

  /* ===== Global Page Styles ===== */
  html,
  body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: var(--bg-dark);
    color: var(--text-light);
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    scroll-behavior: smooth;
  }

  a {
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s, box-shadow 0.2s;
  }



  /* Wrapper for About Page */
  .page-about {
    padding: 2rem 1rem;
    box-sizing: border-box;
    max-width: 1280px;
    margin: 0 auto;
  }

  /* ===== Two‐Column Layout: Main Content + Right Panel ===== */
  .layout-two-col {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 2rem;
  }

  @media (max-width: 900px) {
    .layout-two-col {
      grid-template-columns: 1fr;
    }
  }

  /* ===== Main Content ===== */
  .main-content {
    display: flex;
    flex-direction: column;
    gap: 4rem;
  }

  /* ===== Hero Section ===== */
  .about-hero {
    position: relative;
    width: 100%;
    /* Maintain 16:9 aspect ratio */
    padding-top: 56.25%;

    background-image: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/01 - About FMTBroker.png'); ?>');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: scroll;

    /* Remove any inherited blur/transparency */
    opacity: 1;
    /* Increase brightness and contrast */
    /* Native-resolution rendering hints */
    image-rendering: auto;
    image-rendering: crisp-edges;
    filter: none !important;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 16px var(--shadow-color);
  }




  .about-hero .hero-text {
    position: absolute;
    z-index: 2;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    padding: 0 1rem;
  }

  .about-hero .hero-text h1 {
    font-size: clamp(2rem, 5vw, 3rem);
    margin: 0;
    color: #ffffff;
    text-shadow: 0 2px 8px var(--shadow-color);
    line-height: 1.2;
  }

  .about-hero .hero-text h2 {
    font-size: clamp(1rem, 3vw, 1.5rem);
    margin-top: 0.5rem;
    color: #ffffff;
    font-weight: 400;
    text-shadow: 0 1px 4px var(--shadow-color);
    line-height: 1.3;
  }

  /* ===== Alternating Section ===== */
  .alt-section {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: center;
  }

  .alt-section.reverse {
    flex-direction: row-reverse;
  }

  @media (max-width: 768px) {
    .alt-section {
      flex-direction: column;
    }
  }

  /* ===== Text Block ===== */
  .alt-text {
    flex: 1 1 400px;
  }

  .alt-text h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--primary);
    position: relative;
  }

  .alt-text h2::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: var(--primary);
    margin: 0.5rem 0 0;
    border-radius: 2px;
  }

  .alt-text p,
  .alt-text li {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-medium);
  }

  .alt-text ul {
    list-style: disc;
    padding-left: 1.5rem;
  }

  .alt-text ul li {
    margin-bottom: 0.5rem;
  }

  /* ===== Image Block (1:1 Square) ===== */
  .alt-image {
    flex: 1 1 400px;
    background-color: var(--bg-light);
    border-radius: 8px;

    background-size: cover;
    background-position: center;
    aspect-ratio: 1 / 1;
    box-shadow: 0 2px 8px var(--shadow-color);
  }

  /* ===== Section Wrappers ===== */
  .about-section {
    background-color: var(--bg-medium);
    padding: 3rem;
    border-radius: 8px;
    box-shadow: 0 2px 8px var(--shadow-color);
  }

  .about-section h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    color: var(--primary);
    text-align: center;
    position: relative;
    line-height: 1.2;
  }

  .about-section h2::after {
    content: "";
    display: block;
    width: 80px;
    height: 4px;
    background-color: var(--primary);
    margin: 0.5rem auto 0;
    border-radius: 2px;
  }

  .about-section p,
  .about-section li {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-medium);
    margin-bottom: 1rem;
  }

  .about-section ul {
    list-style: disc;
    padding-left: 1.5rem;
  }

  .about-section ul li {
    margin-bottom: 0.5rem;
  }

  /* ===== Features & Awards Items ===== */
  .about-features,
  .about-awards,
  .about-partners {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
  }

  .feature-item,
  .award-item,
  .partner-item {
    background-color: var(--bg-light);
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    flex: 1 1 280px;
    transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px var(--shadow-color);
  }

  .feature-item:hover,
  .award-item:hover,
  .partner-item:hover {
    background-color: var(--bg-medium);
    transform: translateY(-4px);
    box-shadow: 0 4px 16px var(--shadow-color);
  }

  .partner-item img {
    max-width: 120px;
    max-height: 60px;
    object-fit: contain;
    filter: brightness(0) invert(1);
    transition: opacity 0.2s;
  }

  .partner-item img:hover {
    opacity: 0.8;
  }

  .feature-item h4,
  .award-item h3 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--text-light);
  }

  .feature-item p,
  .award-item p {
    font-size: 0.9rem;
    color: var(--text-medium);
  }

  /* ===== Regulation & Security ===== */
  .about-regulation ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .about-regulation li {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
  }

  .about-regulation li img {
    width: 24px;
    height: 24px;
    margin-right: 0.75rem;
    filter: brightness(0) invert(1);
  }

  .about-regulation li span {
    font-size: 1rem;
    color: var(--text-medium);
  }

  /* ===== Careers ===== */
  .about-careers .career-intro {
    margin-bottom: 2rem;
  }

  .career-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
  }

  /* ----- Updated luxury styles for career items ----- */
  .career-item {
    background-color: var(--bg-light);
    padding: 1.5rem;
    border-radius: 8px;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px var(--shadow-color);
    position: relative;
  }

  .career-item::before {
    content: "";
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: var(--gradient-secondary);
    border-radius: 9px;
    z-index: -1;
  }

  .career-item:hover,
  .career-item:focus-within {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px var(--shadow-color);
    outline: none;
  }

  .career-item h4 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--text-light);
  }

  .career-item p {
    font-size: 0.9rem;
    color: var(--text-medium);
  }

  /* ===== Testimonials ===== */
  .about-testimonials {
    position: relative;
  }

  /* ----- Updated luxury styles for testimonial slides ----- */
  .testimonial-slide {
    display: none;
    padding: 2rem;
    background-color: var(--bg-light);
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 8px var(--shadow-color);
    position: relative;
  }

  .testimonial-slide.active {
    display: block;
  }

  .testimonial-slide::before {
    content: "“";
    position: absolute;
    top: 8px;
    left: 8px;
    font-size: 4rem;
    color: var(--luxury-gold);
    opacity: 0.2;
  }

  .testimonial-slide p {
    font-size: 1rem;
    color: var(--text-medium);
    margin-bottom: 1.5rem;
    line-height: 1.6;
  }

  .testimonial-slide h4 {
    font-size: 1.1rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
  }

  /* ----- Updated luxury styles for testimonial controls ----- */
  .testimonial-slider-controls {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
  }

  .testimonial-slider-controls button {
    background: var(--luxury-gold);
    border: none;
    color: var(--bg-dark);
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px var(--shadow-color);
  }

  .testimonial-slider-controls button:hover,
  .testimonial-slider-controls button:focus {
    background-color: var(--emerald-green);
    color: var(--rich-cream);
    transform: translateY(-2px);
    outline: none;
    box-shadow: 0 4px 16px var(--shadow-color);
  }

  /* ===== Agreements ===== */
  .about-agreements ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .about-agreements li {
    margin-bottom: 1rem;
  }

  .about-agreements li a {
    display: flex;
    align-items: center;
    font-size: 1rem;
    color: var(--text-medium);
    transition: color 0.2s, box-shadow 0.2s;
  }

  .about-agreements li a img {
    width: 20px;
    height: 20px;
    margin-right: 0.75rem;
    filter: brightness(0) invert(1);
  }

  .about-agreements li a:hover,
  .about-agreements li a:focus {
    color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px var(--primary-light);
  }

  /* ===== Contact CTA ===== */
  .about-cta {
    background-color: var(--bg-light);
    padding: 3rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 8px var(--shadow-color);
    position: relative;
    overflow: hidden;
  }

  /* ----- Updated luxury accent background layer ----- */
  .about-cta::before {
    content: "";
    position: absolute;
    top: -30%;
    left: -30%;
    width: 160%;
    height: 160%;
    background: var(--gradient-secondary);
    transform: rotate(45deg);
    opacity: 0.1;
    z-index: 0;
  }

  .about-cta h3 {
    font-size: 1.75rem;
    margin-bottom: 1rem;
    color: var(--rich-cream);
    position: relative;
    z-index: 1;
    font-weight: 700;
  }

  .about-cta ul {
    list-style: disc;
    padding-left: 1.5rem;
    text-align: left;
    max-width: 600px;
    margin: 0 auto 1.5rem;
    position: relative;
    z-index: 1;
  }

  .about-cta ul li {
    margin-bottom: 0.5rem;
    color: var(--text-medium);
    font-size: 1rem;
    line-height: 1.6;
  }

  .about-cta a.button {
    display: inline-block;
    background-color: var(--emerald-green);
    color: var(--rich-cream);
    padding: 0.75rem 2rem;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 600;
    transition: background-color 0.2s, box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px var(--shadow-color);
    position: relative;
    z-index: 1;
  }

  .about-cta a.button:hover,
  .about-cta a.button:focus {
    background-color: var(--luxury-gold);
    color: var(--bg-dark);
    outline: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px var(--shadow-color);
  }

  /* ===== Right Panel: Fast Access (TOC) ===== */
  .right-panel {
    /* use marble1.jpg as the full-panel background */
    background-image:
    linear-gradient(rgba(250, 250, 250, 0.1), rgba(33, 33, 33, 0.9)),
    url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/marble.png'); ?>');    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;

    /* fallback/background overlay if you still want a tint */
    background-color: var(--bg-medium);
    background-blend-mode: overlay;

    padding: 1rem;
    border-radius: 8px;
    position: sticky;
    top: var(--header-height, 90px);
    height: calc(100vh - var(--header-height, 90px) - 2rem);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
    box-shadow: 0 2px 8px var(--shadow-color);
  }


  .right-panel h3 {
    margin-top: 0;
    color: var(--primary);
    font-size: 1.25rem;
    margin-bottom: 1rem;
  }

  .right-panel .toc-container {
    width: 100%;
    position: relative;
  }

  #toc {
    margin: 0;
    padding: 0;
    width: 100%;
  }

  #toc li {
    list-style: none;
    margin: 0.25rem 0;
    position: relative;
  }

  #toc li a {
    color: var(--text-light);
    text-decoration: none;
    display: block;
    padding: 0.25rem 0.5rem 0.25rem 1.5rem;
    border-radius: 4px;
    transition: color 0.2s, background-color 0.2s;
  }


  #toc li.active > a {
    color: #ffffff !important;
    background-color: rgba(103, 22, 202, 0.3);
  }

  #toc li .toc-h2 {
    font-size: 1rem;
    margin-left: 1rem;
  }

  /* Indicator Dot */
  #toc-indicator {
    position: absolute;
    left: 8px;
    width: 8px;
    height: 8px;
    background-color: var(--primary-light);
    border-radius: 50%;
    transition: top 0.25s ease;
    pointer-events: none;
    opacity: 0.9;
    transform: translateY(-50%);
    display: none;
  }

  /* ===== Responsive Adjustments ===== */
  @media (max-width: 1024px) {
    .right-panel {
      position: relative;
      top: auto;
      height: auto;
      margin-top: 2rem;
    }
  }

  @media (max-width: 768px) {
    .about-hero {
      padding-top: 40%;
    }

    .about-hero .hero-text h1 {
      font-size: 2rem;
    }

    .about-hero .hero-text h2 {
      font-size: 1rem;
    }

    .alt-section {
      flex-direction: column;
    }
  }
    /* Only “Our Process” gets the full-bleed cover */
  .about-section.about-intro.process-section {
    position: relative;
    background-image: url('<?php echo esc_url( get_template_directory_uri() . "/assets/images/images/12 - Our Process_1.png" ); ?>');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 4rem 2rem;
    color: #fff;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
  }
  .about-section.about-intro.process-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    pointer-events: none;
  }
  .about-section.about-intro.process-section > * {
    position: relative;
    z-index: 1;
  }
/* ----------------------------------------
   Agreements — full‐bleed background cover
   ---------------------------------------- */
  /* ---- Agreements: full-bleed cover (force it!) ---- */
  section.about-agreements {
    /* nuke any previous background */
    background: none !important;

    /* your image—adjust the filename to match exactly! */
    background-image: url(
      '<?php echo esc_url( get_template_directory_uri() . "/assets/images/images/13 - Agreements.png" ); ?>'
    ) !important;

    background-position: center center !important;
    background-size: cover !important;
    background-repeat: no-repeat !important;

    padding: 4rem 2rem !important;
    color: #fff   !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6) !important;
  }



  section.about-agreements > * {
    position: relative;
    z-index: 1;
  }



</style>

<main class="page-about">
  <div class="layout-two-col">
    <!-- ===== Main Content Column ===== -->
    <div class="main-content">
      <?php while (have_posts()) : the_post(); ?>

        <!-- Hero Section -->
        <section class="about-hero">
          <div class="hero-overlay"></div>
          <div class="hero-text">
            <h1>About FMTbroker</h1>
            <h2>Empowering Traders Worldwide&nbsp;&nbsp;Intuitively. Securely. Transparently.</h2>
          </div>
        </section>

        <!-- Section 1: Text (left) / Image (right) -->
        <section class="alt-section">
          <div class="alt-text">
            <h2>Introduction: A Broker Built for the Modern Era</h2>
            <p>In today’s dynamic financial world, traders need more than just access to markets. They seek platforms that combine transparency, speed, education, and security&nbsp;&nbsp;platforms built to grow with them.</p>
            <p>FMTbroker was founded in 2024 with a mission to redefine the trading experience. From retail investors to institutional players, we provide a unified space where global traders can connect to the world’s markets using the latest technology, real-time data, and a transparent approach built on integrity.</p>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/02 - A Broker Built for the Modern Era 1-1 R.png'); ?>') center/cover no-repeat;background-size: 65% auto;"></div>
        </section>

        <!-- Section 2: Image (left) / Text (right) -->
        <section class="alt-section reverse">
          <div class="alt-text">
            <h2>Who We Are</h2>
            <p>FMTbroker is an international forex and CFD broker designed to bridge the gap between institutional technology and retail accessibility. Built by industry veterans in trading, fintech, and regulation, we offer a complete ecosystem that includes:</p>
            <ul>
              <li>Forex pairs (majors, minors, exotics)</li>
              <li>Precious metals &amp; commodities</li>
              <li>Global indices and stocks</li>
              <li>Blue-chip shares &amp; futures CFDs</li>
              <li>Cryptocurrencies with deep liquidity</li>
            </ul>
            <p>Whether you're a day trader, long-term investor, or algo developer&nbsp;&nbsp;FMTbroker is tailored to support your style.</p>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/03 - Who We Are 1-1 L.png'); ?>') center/cover no-repeat;background-size: 70% auto;"></div>
        </section>

        <!-- Section 3: Text (left) / Image (right) -->
        <section class="alt-section">
          <div class="alt-text">
            <h2>Our Mission &amp; Philosophy</h2>
            <p>To build a global trading community where every trader&nbsp;&nbsp;regardless of experience&nbsp;&nbsp;can access professional tools, reliable support, and market opportunity on their own terms.</p>
            <ul>
              <li>Education-first mindset: Every trader deserves to understand what they’re doing.</li>
              <li>Access without restriction: With MT4, MT5, WebTrader &amp; our FMT mobile app.</li>
              <li>Trader-first development: Innovations designed to give you clarity, insight, and control.</li>
            </ul>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/04 - Our Mission & Philosophy 16-9.png'); ?>') center/cover no-repeat;background-size: 95% auto;"></div>
        </section>

        <!-- Section 4: Image (left) / Text (right) -->
        <section class="alt-section reverse">
          <div class="alt-text">
            <h2>What We Offer</h2>
            <ul>
              <li>Multi-asset Access: Trade Forex, Commodities, Indices, Shares, Energies, Cryptocurrencies.</li>
              <li>Trusted Platforms: MetaTrader 4, MetaTrader 5 &amp; WebTrader.</li>
              <li>Mobile-first Experience: Intuitive iOS &amp; Android apps.</li>
              <li>Educational Hub: Tutorials, webinars, and expert blogs.</li>
              <li>Smart Analytics: Real-time news, economic calendar &amp; technical tools.</li>
              <li>Personal Cabin: Secure dashboard for tracking, funding, and reports.</li>
              <li>Speed &amp; Transparency: Raw spreads, instant execution, zero commission options.</li>
              <li>24/7 Multilingual Support: Global reach, local touch.</li>
            </ul>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/05 - What We Offer 1-1 R.png'); ?>') center/cover no-repeat;background-size: 75% auto;"></div>
        </section>

        <!-- Section 5: Text (left) / Image (right) -->
        <section class="alt-section">
          <div class="alt-text">
            <h2>Why Traders Choose FMTbroker</h2>
            <ul>
              <li>No Dealing Desk Interference: True STP/ECN execution.</li>
              <li>Segregated Accounts &amp; 2FA Security: Client funds held separately.</li>
              <li>Fully Integrated Analytics &amp; Education: All tools in one place.</li>
              <li>VPS Hosting, Copy Trading &amp; EAs: Run algorithms 24/7.</li>
              <li>Regulation in Progress: Expanding licenses under top authorities.</li>
              <li>Personal Support &amp; Global Liquidity: 24/7 assistance with deep liquidity.</li>
            </ul>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/06 - Why Traders Choose FMT 1-1 L.png'); ?>') center/cover no-repeat;background-size: 85% auto;"></div>
        </section>

        <!-- Section 6: Image (left) / Text (right) -->
        <section class="alt-section reverse">
          <div class="alt-text">
            <h2>Regulation &amp; Security</h2>
            <ul>
              <li>Regulated by the Financial Services Authority (FSA)&nbsp;&nbsp;License #123456.</li>
              <li>Client funds held in segregated accounts at top-tier global banks.</li>
              <li>Industry-leading SSL encryption &amp; daily backups.</li>
              <li>Two-factor authentication (2FA) &amp; AML/KYC enforced.</li>
              <li>Regular external audits to exceed compliance expectations.</li>
            </ul>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/07 - Regulation & Security 1-1 R.png'); ?>') center/cover no-repeat;background-size: 70% auto;"></div>
        </section>

        <!-- Section 7: Text (left) / Image (right) -->
        <section class="alt-section">
          <div class="alt-text">
            <h2>Education at the Core</h2>
            <p>Trading is a skill&nbsp;&nbsp;not a guess. That’s why FMTbroker makes education integrated:</p>
            <ul>
              <li>🎓 Beginner-to-Pro video courses</li>
              <li>📚 Downloadable strategy templates &amp; eBooks</li>
              <li>🧠 Trader psychology &amp; capital management content</li>
              <li>🎤 Live webinars with Q&amp;A</li>
              <li>🗓 Weekly market outlooks from analysts</li>
            </ul>
            <p>We’re not just a broker&nbsp;&nbsp;we’re your trading partner.</p>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/08 - Education at the Core 1-1 L.png'); ?>') center/cover no-repeat;background-size: 70% auto;"></div>
        </section>

        <!-- Section 8: Image (left) / Text (right) -->
        <section class="alt-section reverse">
          <div class="alt-text">
            <h2>Our Vision for the Future</h2>
            <p>FMTbroker is on a mission to become a top-10 global broker in trader satisfaction. Our roadmap includes:</p>
            <ul>
              <li>🌍 Expanding licenses in new regions</li>
              <li>🧠 Launching AI-based decision-support tools</li>
              <li>📱 Releasing social-based mobile copy trading</li>
              <li>💱 Integrating blockchain-based trade settlements</li>
              <li>🤝 Partnering with global fintech &amp; DeFi leaders</li>
            </ul>
            <p>Our future is built around you.</p>
          </div>
          <div class="alt-image" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/images/09 - Global Reach , Local Support 1-1 R.png'); ?>') center/cover no-repeat;background-size: 90% auto;"></div>
        </section>

        <!-- Section 9: Text‐Only (centered content) -->
        <section class="about-section about-intro">
          <h2>Hear from Our Traders</h2>
          <div class="about-testimonials">
            <div class="testimonial-slide active" id="testimonial-1">
              <p>“FMTbroker is the only platform that didn’t just onboard me&nbsp;&nbsp;they educated me. I started from scratch and now I’m building real consistency.”</p>
              <h4>  Sina A., Turkey</h4>
            </div>
            <div class="testimonial-slide" id="testimonial-2">
              <p>“Execution speed is excellent. The dashboard is intuitive. And I can trade crypto, gold, and forex from one app.”</p>
              <h4>  Laura M., South Africa</h4>
            </div>
            <div class="testimonial-slide" id="testimonial-3">
              <p>“As a developer, I appreciate the clean API integration and reliable execution. FMTbroker’s MetaTrader integration is seamless.”</p>
              <h4>  Priya Singh, Fintech Developer</h4>
            </div>
            <div class="testimonial-slider-controls">
              <button data-target="testimonial-1" aria-label="Show testimonial 1">1</button>
              <button data-target="testimonial-2" aria-label="Show testimonial 2">2</button>
              <button data-target="testimonial-3" aria-label="Show testimonial 3">3</button>
            </div>
          </div>
        </section>

        <!-- Section 10: Careers -->
        <section class="about-section about-careers">
          <h2>Careers at FMTbroker</h2>
          <div class="career-intro">
            <p>At FMTbroker, we don't just connect traders to markets&nbsp;&nbsp;we connect talent to opportunity. We're building a borderless, high-performance trading ecosystem. Behind every line of code, chart, or client success is a team that values innovation, clarity, and people-first thinking.</p>
            <p>If you're passionate about shaping the future of finance, there's a place for you here.</p>
          </div>
          <ul class="career-list">
            <li class="career-item" tabindex="0">
              <h4>Senior Front-End Developer</h4>
              <p>📍 Remote | Development</p>
              <p>Design intuitive, scalable UI components for our trading platform using React.js and Tailwind CSS. Prior experience with REST APIs and performance optimization required.</p>
            </li>
            <li class="career-item" tabindex="0">
              <h4>Forex Content Specialist</h4>
              <p>📍 London, UK | Marketing</p>
              <p>Create tutorials, analysis, and educational content. Must have deep forex knowledge and excellent writing/visual storytelling skills.</p>
            </li>
            <li class="career-item" tabindex="0">
              <h4>Customer Support Representative</h4>
              <p>📍 New York, USA | Support</p>
              <p>Provide 24/7 global support for our clients. Strong communication skills, empathy, and forex platform experience are essential.</p>
            </li>
            <li class="career-item" tabindex="0">
              <h4>Compliance Officer</h4>
              <p>📍 Frankfurt, Germany | Compliance</p>
              <p>Lead internal audits, maintain regulatory adherence, and interface with regulators. Must have experience in financial compliance and AML procedures.</p>
            </li>
            <li class="career-item" tabindex="0">
              <h4>UX/UI Designer</h4>
              <p>📍 Toronto, Canada | Design</p>
              <p>Shape seamless web/mobile experiences with tools like Figma, Adobe XD, or Sketch. Experience in fintech UI design preferred.</p>
            </li>
            <li class="career-item" tabindex="0">
              <h4>Data Analyst</h4>
              <p>📍 Singapore | Analytics</p>
              <p>Turn raw market data into strategic insights. Requires proficiency in SQL, Python, and tools like Power BI or Tableau.</p>
            </li>
          </ul>
        </section>

        <!-- Section 11: Partnerships -->
        <section class="about-section about-partners">
          <h2>Our Partners</h2>
          <div class="partner-item">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partner-1.png'); ?>" alt="Partner 1">
          </div>
          <div class="partner-item">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partner-2.png'); ?>" alt="Partner 2">
          </div>
          <div class="partner-item">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partner-3.png'); ?>" alt="Partner 3">
          </div>
          <div class="partner-item">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partner-4.png'); ?>" alt="Partner 4">
          </div>
          <div class="partner-item">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/partner-5.png'); ?>" alt="Partner 5">
          </div>
        </section>

        <!-- Section 12: Our Process -->

        <section class="about-section about-intro process-section">
          <h2>Our Process</h2>
          <ul class="process-list">
            <li>Submit your application</li>
            <li>Screening call with our HR team</li>
            <li>Technical or portfolio-based task (if applicable)</li>
            <li>Interview with hiring manager</li>
            <li>Final offer</li>
            <li>💬 We keep you updated every step of the way.</li>
          </ul>
        </section>


        <!-- Section 13: Agreements -->
        <section class="about-section about-agreements">
          <h2>Agreements &amp; Transparency</h2>
          <p>Before joining, we invite you to review our core policies:</p>
          <ul>
            <li>
              <a href="<?php echo esc_url(get_site_url() . '/agreement-privacy-policy'); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-document.png'); ?>" alt="Privacy Policy Icon">
                Privacy Policy
              </a>
            </li>
            <li>
              <a href="<?php echo esc_url(get_site_url() . '/agreement-terms-of-service'); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-document.png'); ?>" alt="TOS Icon">
                Terms of Service
              </a>
            </li>
            <li>
              <a href="<?php echo esc_url(get_site_url() . '/agreement-risk-disclosure'); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-document.png'); ?>" alt="Risk Disclosure Icon">
                Risk Disclosure
              </a>
            </li>
            <li>
              <a href="<?php echo esc_url(get_site_url() . '/agreement-cookie-policy'); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-document.png'); ?>" alt="Cookie Policy Icon">
                Cookie Policy
              </a>
            </li>
          </ul>
        </section>

        <!-- Section 14: Contact Call-To-Action -->
        <section class="about-section about-cta">
          <h3>Get Started Today</h3>
          <ul>
            <li>Create your account in minutes</li>
            <li>Fund securely through your preferred method</li>
            <li>Access 300+ global instruments</li>
            <li>Trade smarter&nbsp;&nbsp;from anywhere</li>
          </ul>
          <a href="<?php echo esc_url(get_site_url() . '/sign-up'); ?>" class="button">Create Your Free Account</a>
        </section>

      <?php endwhile; ?>
    </div>
    <!-- /.main-content -->

    <!-- ===== Right Panel: Fast Access (TOC) ===== -->
    <aside class="right-panel">
      <h3>Fast Access</h3>
      <nav aria-label="Page Sections" class="toc-container">
        <ul id="toc">
          <!-- Table of Contents will be injected here via JavaScript -->
        </ul>
        <div id="toc-indicator"></div>
      </nav>
    </aside>
  </div>
  <!-- /.layout-two-col -->
</main>

<script>
  /* === Testimonial Slider Functionality === */
  document.addEventListener('DOMContentLoaded', function () {
    const controls = document.querySelectorAll('.testimonial-slider-controls button');
    if (controls.length) {
      controls.forEach(btn => {
        btn.addEventListener('click', function () {
          const targetId = btn.getAttribute('data-target');
          const targetSlide = document.getElementById(targetId);
          if (!targetSlide) return;

          document.querySelectorAll('.testimonial-slide').forEach(slide => {
            slide.classList.remove('active');
          });
          targetSlide.classList.add('active');
        });
      });
    }
  });

  /* === TOC generation for all h2 in .main-content === */
  document.addEventListener('DOMContentLoaded', function () {
    const mainContent = document.querySelector('.main-content');
    if (!mainContent) return;

    const headings = mainContent.querySelectorAll('h2');
    const toc = document.getElementById('toc');

    if (!headings.length) {
      toc.innerHTML = '<li><em>No sections found.</em></li>';
      return;
    }

    headings.forEach((heading, index) => {
      if (!heading.id) {
        const slug = heading.textContent.trim()
          .toLowerCase()
          .replace(/\s+/g, '-')
          .replace(/[^\w\-]/g, '');
        heading.id = slug || ('heading-' + index);
      }
      const li = document.createElement('li');
      const a = document.createElement('a');
      a.textContent = heading.textContent;
      a.href = '#' + heading.id;
      a.classList.add('toc-h2');
      a.addEventListener('focus', () => {
        a.parentElement.classList.add('active');
      });
      a.addEventListener('blur', () => {
        a.parentElement.classList.remove('active');
      });
      li.appendChild(a);
      toc.appendChild(li);
    });

    const indicator = document.getElementById('toc-indicator');
    indicator.style.display = 'none';

    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.25
    };

    const callback = (entries) => {
      entries.forEach(entry => {
        const id = entry.target.id;
        const tocLink = toc.querySelector(`a[href="#${id}"]`);
        if (!tocLink) return;
        const listItem = tocLink.parentElement;

        if (entry.isIntersecting) {
          listItem.classList.add('active');
          const linkRect = tocLink.getBoundingClientRect();
          const containerRect = toc.getBoundingClientRect();
          const offsetWithinUL = linkRect.top - containerRect.top + (linkRect.height / 2);
          indicator.style.display = 'block';
          indicator.style.top = offsetWithinUL + 'px';
        } else {
          listItem.classList.remove('active');
        }
      });
    };

    const observer = new IntersectionObserver(callback, observerOptions);
    headings.forEach((heading) => observer.observe(heading));
  });
</script>

<?php get_footer(); ?>
