<?php
// Component: footer.php
?>
<style>
  .site-footer {
    background: #212121;
    color: #fff;
    font-size: 0.9rem;
    padding: 3rem 50px 1rem;
  }
  .site-footer a {
    color: #e0e0e0;
    text-decoration: none;
    transition: color .2s;
  }
  .site-footer a:hover { color: #fff; }

  /* Logo + tagline */
  .footer-branding {
    flex: 1 1 200px;
    min-width: 180px;
    padding-right: 2rem;
  }
  .footer-branding .logo { margin-bottom: 1rem; }
  .footer-branding .footer-brand {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 .5rem;
  }
  .footer-branding .footer-brand .f { color: #1673ca; }
  .footer-branding .footer-brand .m { color: #1694ca; }
  .footer-branding .footer-brand .t { color: #16cac4; }
  .footer-branding p {
    line-height: 1.6;
    color: #bbbbbb;
  }

  /* Social + language */
  .footer-social-lang {
    margin-top: 2rem;
  }
  .footer-social-lang .social-icons {
    display: flex;
    gap: 4rem;
    margin-bottom: 2rem;
  }
  .footer-social-lang .social-icons a {
    display: inline-block;
    width: 25px;
    height: 25px;
    background-color: #fff; /* default icon color */
    transition: background-color .2s;
    mask-repeat: no-repeat;
    mask-position: center;
    mask-size: contain;
    -webkit-mask-repeat: no-repeat;
    -webkit-mask-position: center;
    -webkit-mask-size: contain;
  }
  .social-icons a.telegram {
    mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/telegram.png');
    -webkit-mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/telegram.png');
  }
  .social-icons a.facebook {
    mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/facebook.png');
    -webkit-mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/facebook.png');
  }
  .social-icons a.youtube {
    mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/youtube.png');
    -webkit-mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/youtube.png');
  }
  .social-icons a.instagram {
    mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/instagram.png');
    -webkit-mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/instagram.png');
  }
  .social-icons a.linkedin {
    mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/linkedin.png');
    -webkit-mask-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/linkedin.png');
  }
  .social-icons a.telegram:hover   { background-color: #0088cc; }
  .social-icons a.facebook:hover   { background-color: #3b5998; }
  .social-icons a.youtube:hover    { background-color: #ff0000; }
  .social-icons a.instagram:hover  { background-color: #c32aa3; }
  .social-icons a.linkedin:hover   { background-color: #0077b5; }

  .footer-social-lang select {
    background: #2a2a2a;
    border: none;
    color: #e0e0e0;
    padding: .5rem;
    border-radius: 4px;
    margin-bottom: 4rem;
  }

  /* Link columns */
  .footer-columns {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  .footer-col {
    flex: 1 1 100px;
    min-width: 120px;
  }
  .footer-col h4 {
    font-size: .79rem;
    font-weight: 600;
    margin-top: .8rem;
    margin-bottom: .4rem;
    color: #1694ca;
  }
  .footer-col ul {
    list-style: none;
    font-size: .75rem;
    margin: 0;
    padding: 0;
  }
  .footer-col li {
    margin-bottom: .19rem;
  }
  .footer-col p {
    font-size: .75rem;
    color: #fafafa;
    line-height: 1.5;
    margin-bottom: 1rem;
  }

  /* Footer bottom */
  .footer-bottom {
    border-top: 1px solid #333;
    padding: 2rem 0 1rem;
    color: #777;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch; /* ensure equal heights */
    justify-content: space-between;
    gap: 2rem;
    font-size: 0.75rem;
  }

  /* Left block: horizontally align image and text, center image vertically */
  .footer-bottom-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1 1 200px;
    min-width: 180px;
  }
  .footer-bottom-left .badges img {
    height: 40px;
  }
  .footer-bottom-left .text-block p {
    margin: 0 0 0.3rem;
    color: #999999;
    font-size: 0.65rem;
    line-height: 1.4;
  }

  /* Center and right blocks: equal height, text justified */
  .footer-bottom-center,
  .footer-bottom-right {
    flex: 1 1 200px;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #1f1f1f;
    padding: 1rem;
    border-radius: 4px;
  }

  .footer-bottom-center h4,
  .footer-bottom-right h4 {
    margin: 0 0 0.5rem;
    font-size: 0.75rem;
    color: #999999;
  }
  .footer-bottom-center p,
  .footer-bottom-right p {
    margin: 0;
    line-height: 1.4;
    color: #999999;
    font-size: 0.65rem;
    text-align: justify;
  }
  .footer-bottom-center p small,
  .footer-bottom-right p small {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.55rem;
    color: #777777;
    text-align: left;
  }

  @media (max-width: 768px) {
    .footer-columns,
    .footer-bottom {
      flex-direction: column;
      text-align: center;
    }
    .footer-bottom-left,
    .footer-bottom-center,
    .footer-bottom-right {
      flex: 1 1 100%;
      min-width: auto;
      align-items: center;
    }
    .footer-bottom-center,
    .footer-bottom-right {
      margin-top: 1rem;
      align-items: stretch;
    }
  }
</style>

<footer class="site-footer container">

  <!-- Branding + tagline -->
  <div class="footer-branding">
    <div class="logo">
      <?php get_template_part('components/logo'); ?>
    </div>
    <div class="footer-brand">
      <span class="f">F</span><span class="m">M</span><span class="t">T</span>broker
    </div>
    <p>Your gateway to real-time market data, analytics, and trading tools. FMTbroker delivers the insights you need to trade with confidence.</p>

    <!-- Social icons + language picker -->
    <div class="footer-social-lang">
      <div class="social-icons">
        <a href="#" class="telegram"   aria-label="Telegram"></a>
        <a href="#" class="facebook"   aria-label="Facebook"></a>
        <a href="#" class="youtube"    aria-label="YouTube"></a>
        <a href="#" class="instagram"  aria-label="Instagram"></a>
        <a href="#" class="linkedin"   aria-label="LinkedIn"></a>
      </div>
      <select aria-label="Select language">
        <option>English</option>
        <option>فارسی</option>
        <!-- …other langs… -->
      </select>
    </div>
  </div>

  <!-- Multi-column links -->
  <div class="footer-columns">
    <div class="footer-col">
      <h4>MORE THAN A PRODUCT</h4>
      <ul>
        <li><a href="#">Supercharts</a></li>
      </ul>

      <h4>SCREENERS</h4>
      <ul>
        <li><a href="#">Stocks</a></li>
        <li><a href="#">ETFs</a></li>
        <li><a href="#">Bonds</a></li>
        <li><a href="#">Crypto coins</a></li>
        <li><a href="#">Crypto pairs</a></li>
        <li><a href="#">CEX pairs</a></li>
        <li><a href="#">DEX pairs</a></li>
        <li><a href="#">Pine</a></li>
      </ul>

      <h4>HEAT MAPS</h4>
      <ul>
        <li><a href="#">Stocks</a></li>
        <li><a href="#">ETFs</a></li>
        <li><a href="#">Crypto</a></li>
      </ul>

      <h4>CALENDARS</h4>
      <ul>
        <li><a href="#">Economic</a></li>
        <li><a href="#">Earnings</a></li>
        <li><a href="#">Dividends</a></li>
      </ul>

      <h4>MORE PRODUCTS</h4>
      <ul>
        <li><a href="#">Yield curves</a></li>
        <li><a href="#">Options</a></li>
        <li><a href="#">News Flow</a></li>
        <li><a href="#">Pine Script®</a></li>
      </ul>

      <h4>APPS</h4>
      <ul>
        <li><a href="#">Mobile</a></li>
        <li><a href="#">Desktop</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>TOOLS &amp; SUBSCRIPTIONS</h4>
      <ul>
        <li><a href="#">Features</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Market data</a></li>
      </ul>

      <h4>SPECIAL OFFERS</h4>
      <ul>
        <li><a href="#">CME Group futures</a></li>
        <li><a href="#">Eurex futures</a></li>
        <li><a href="#">US stocks bundle</a></li>
      </ul>

      <h4>ABOUT COMPANY</h4>
      <ul>
        <li><a href="#">Who we are</a></li>
        <li><a href="#">Manifesto</a></li>
        <li><a href="#">Athletes</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Media kit</a></li>
      </ul>

      <h4>MERCH</h4>
      <ul>
        <li><a href="#">TradingView store</a></li>
        <li><a href="#">Tarot cards for traders</a></li>
        <li><a href="#">The C63 TradeTime</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>COMMUNITY</h4>
      <ul>
        <li><a href="#">Social network</a></li>
        <li><a href="#">Wall of Love</a></li>
        <li><a href="#">Refer a friend</a></li>
        <li><a href="#">House Rules</a></li>
        <li><a href="#">Moderators</a></li>
      </ul>

      <h4>IDEAS</h4>
      <ul>
        <li><a href="#">Trading</a></li>
        <li><a href="#">Education</a></li>
        <li><a href="#">Editors’ picks</a></li>
      </ul>

      <h4>PINE SCRIPT</h4>
      <ul>
        <li><a href="#">Indicators &amp; strategies</a></li>
        <li><a href="#">Wizards</a></li>
        <li><a href="#">Freelancers</a></li>
      </ul>

      <h4>BUSINESS SOLUTIONS</h4>
      <ul>
        <li><a href="#">Widgets</a></li>
        <li><a href="#">Charting libraries</a></li>
        <li><a href="#">Lightweight Charts™</a></li>
        <li><a href="#">Advanced Charts</a></li>
        <li><a href="#">Trading Platform</a></li>
      </ul>

      <h4>GROWTH OPPORTUNITIES</h4>
      <ul>
        <li><a href="#">Advertising</a></li>
        <li><a href="#">Brokerage integration</a></li>
        <li><a href="#">Partner program</a></li>
        <li><a href="#">Education program</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>📞 CONTACT &amp; SUPPORT</h4>
      <ul>
        <li><a href="mailto:support@fmtbroker.com">Email: support@fmtbroker.com</a></li>
        <li><a href="tel:+442012345678">Phone: +44 20 1234 5678</a></li>
        <li><a href="#">FAQ &amp; Help Center</a></li>
        <li><a href="#">Careers at FMTbroker</a></li>
        <li><a href="#">Affiliate Program</a></li>
        <li><a href="#">Sitemap</a></li>
      </ul>
    </div>
  </div>

  <!-- Footer bottom with equal-height containers and justified text -->
  <div class="footer-bottom">
    <div class="footer-bottom-left">
      <div class="badges">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/financial_c.png" alt="financial-commission">
      </div>
      <div class="text-block">
        <p>© 2025 FMTbroker, Inc. All Rights Reserved.</p>
        <p>All trademarks are the property of their respective owners.</p>
        <p>Built and maintained by FMTbroker Engineering Team.</p>
      </div>
    </div>

    <div class="footer-bottom-center">
      <h4>⚠️ Risk Warning</h4>
      <p>
        Trading CFDs involves significant risk and may not be suitable for all investors. Leverage can work both in your favor and against you. Please ensure you fully understand the risks before trading and consider your investment objectives and level of experience. You may lose all your invested capital.
      </p>
    </div>

    <div class="footer-bottom-right">
      <h4>🏛 Regulatory Status</h4>
      <p>
        FMTbroker operates in compliance with international financial regulations and adheres to strict data protection and anti-money laundering standards.
        <br>
        <small>
          Select market data provided by ICE Data Services.<br>
          Select reference data powered by FactSet Research Systems Inc.
        </small>
      </p>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>
