<?php
/**
 * Template Name: Support Team (Single Column + Fast Access + Map)
 * Description: “Support Team” page with single-column layout, embedded Map, a hero with gradient, and a sticky Fast Access TOC panel.
 */

get_header(); ?>

<style>
  /* ===== Color Palette ===== */
  :root {
    --primary-dark: #1673ca;
    --primary: #1694ca;
    --primary-light: #16cac4;
    --accent: #f5a623;
    --bg-dark: #212121;
    --bg-medium: #2a2a2a;
    --bg-light: #333333;
    --text-light: #e0e0e0;
    --text-medium: #cccccc;
    --shadow-color: rgba(0, 0, 0, 0.6);
  }

  /* ===== Global ===== */
  html, body {
    margin: 0; padding: 0;
    background: var(--bg-dark);
    color: var(--text-light);
    font-family: 'Segoe UI', Tahoma, sans-serif;
    scroll-behavior: smooth;
  }
  a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    transition: color .2s;
  }
  a:hover { color: var(--primary-light); }

  /* ===== Layout ===== */
  .page-support-team {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
  }
  .layout-two-col {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 2rem;
  }
  @media(max-width:900px){
    .layout-two-col{ grid-template-columns:1fr; }
    .right-panel{ position:relative; margin-top:2rem; }
  }

  /* ===== Hero Container ===== */
  .support-hero {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    background: linear-gradient(135deg, #1673ca 0%, #6716ca 50%, #16cac4 100%);
  }
  .support-hero .hero-inner {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 3rem;
    max-width: 700px;
    text-align: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
  }
  .support-hero h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: #ffffff;
    font-weight: 700;
    letter-spacing: 0.5px;
    line-height: 1.2;
  }
  .support-hero p {
    font-size: 1.125rem;
    color: #f0f0f0;
    line-height: 1.6;
    margin: 0 auto;
  }

  /* ===== Sections ===== */
  .support-section {
    background: var(--bg-medium);
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 3px 12px var(--shadow-color);
  }
  .support-section h2 {
    font-size: 1.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
    position: relative;
  }
  .support-section h2::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: var(--accent);
    margin-top: .5rem;
    border-radius: 2px;
  }

  /* ===== Ticket Form ===== */
  .ticket-form-wrapper label {
    display: block;
    margin: 1rem 0 .25rem;
    font-weight: 600;
    color: var(--text-light);
  }
  .ticket-form-wrapper input,
  .ticket-form-wrapper select,
  .ticket-form-wrapper textarea {
    width: 100%;
    padding: .75rem;
    background: var(--bg-light);
    border: 1px solid #555;
    border-radius: 4px;
    color: #fff;
    font-size: .9rem;
  }
  .ticket-form-wrapper input:focus,
  .ticket-form-wrapper select:focus,
  .ticket-form-wrapper textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 4px rgba(22,115,202,0.6);
    outline: none;
  }
  .ticket-form-wrapper input[type="submit"] {
    background: var(--primary);
    color: #fff;
    padding: .6rem 1.25rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(22,148,202,0.6);
    transition: background .2s;
  }
  .ticket-form-wrapper input[type="submit"]:hover {
    background: var(--primary-light);
  }

  /* ===== Contact Info: Selectable Cards with Hover Animation ===== */
  .contact-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 1.5rem;
    margin-top: 1rem;
  }
  .contact-card {
    background: var(--bg-light);
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 3px 8px var(--shadow-color);
    text-align: center;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    border: 2px solid transparent;
  }
  .contact-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 6px 16px var(--shadow-color);
  }
  .contact-card.selected {
    border-color: var(--primary);
  }
  .contact-card i {
    font-size: 1.75rem;
    color: var(--accent);
    margin-bottom: .75rem;
  }
  .contact-card h3 {
    font-size: 1.125rem;
    margin-bottom: .5rem;
    color: var(--primary-light);
  }
  .contact-card p, .contact-card a {
    font-size: .9rem;
    color: var(--text-medium);
    line-height: 1.4;
  }
  .contact-card a {
    display: block;
    margin-top: .5rem;
    word-break: break-all;
  }
  .live-chat-btn {
    display: inline-block;
    margin-top: .75rem;
    padding: .6rem 1.25rem;
    background: var(--accent);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background .2s;
  }
  .live-chat-btn:hover { background: var(--primary-light); }

  /* ===== Map Section ===== */
  .map-section iframe {
    width: 100%;
    height: 250px;
    border: none;
    border-radius: 4px;
    margin-top: 1rem;
  }

  /* ===== Right Panel: Fast Access (TOC) ===== */
  .right-panel {
    background-image:
      linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
      url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
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
    margin: 0; padding: 0; width: 100%;
  }
  #toc li {
    list-style: none; margin: .25rem 0; position: relative;
  }
  #toc li a {
    color: var(--text-light);
    text-decoration: none;
    display: block;
    padding: .25rem .5rem .25rem 1.5rem;
    border-radius: 4px;
    transition: color .2s, background-color .2s;
  }
  #toc li.active > a {
    color: #fff !important;
    background-color: rgba(103,22,202,0.3);
  }
  #toc li .toc-h2 {
    font-size: 1rem; margin-left: 1rem;
  }
  #toc-indicator {
    position: absolute; left: 8px; width: 8px; height: 8px;
    background-color: var(--primary-light);
    border-radius: 50%;
    transition: top .25s ease;
    pointer-events: none; opacity: 0.9;
    transform: translateY(-50%); display: none;
  }
  @media(max-width:1024px){
    .right-panel {
      position: relative; top: auto; height: auto; margin-top: 2rem;
    }
  }
</style>

<main class="page-support-team">
  <div class="layout-two-col">

    <!-- Main Content -->
    <div class="main-content">

      <!-- Hero -->
      <section class="support-hero">
        <div class="hero-inner">
          <h2>How Can We Assist You Today?</h2>
          <p>At FMTbroker, our dedicated support team is on standby around the clock to provide prompt, professional guidance—whether you have questions about trading, technical issues, or your account. Reach out, and we’ll ensure you get the help you need.</p>
        </div>
      </section>

      <!-- Submit Ticket -->
      <section class="support-section ticket-form-wrapper">
        <h2>Submit a Support Ticket</h2>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
          <input type="hidden" name="action" value="handle_ticket_form">

          <label for="ft_full_name">Full Name <span style="color:#ef4444;">*</span></label>
          <input type="text" id="ft_full_name" name="ft_full_name" required placeholder="Your full name">

          <label for="ft_email">Email Address <span style="color:#ef4444;">*</span></label>
          <input type="email" id="ft_email" name="ft_email" required placeholder="you@example.com">

          <label for="ft_department">Department <span style="color:#ef4444;">*</span></label>
          <select id="ft_department" name="ft_department" required>
            <option value="" disabled selected>Select Department</option>
            <option>General Support</option>
            <option>Compliance & KYC</option>
            <option>Partnerships</option>
            <option>Technical</option>
          </select>

          <label for="ft_subject">Subject</label>
          <input type="text" id="ft_subject" name="ft_subject" placeholder="Brief summary">

          <label for="ft_message">Your Message <span style="color:#ef4444;">*</span></label>
          <textarea id="ft_message" name="ft_message" required placeholder="Describe your issue…"></textarea>

          <label for="ft_attachment">Attachment (optional)</label>
          <input type="file" id="ft_attachment" name="ft_attachment" accept=".jpg,.png,.pdf,.doc,.docx">

          <input type="submit" value="Submit Request">
        </form>
      </section>

      <!-- Other Ways to Reach Us -->
      <section class="support-section">
        <h2>Other Ways to Reach Us</h2>
        <div class="contact-info-grid">
          <div class="contact-card" data-type="email">
            <i class="fas fa-envelope"></i>
            <h3>General Inquiries</h3>
            <p>Trading, platform or account questions.</p>
            <a href="mailto:support@fmtbroker.com">support@fmtbroker.com</a>
          </div>
          <div class="contact-card" data-type="email">
            <i class="fas fa-handshake"></i>
            <h3>Partnerships & Affiliates</h3>
            <p>Looking to partner with us?</p>
            <a href="mailto:partners@fmtbroker.com">partners@fmtbroker.com</a>
          </div>
          <div class="contact-card" data-type="email">
            <i class="fas fa-user-check"></i>
            <h3>Compliance & KYC</h3>
            <p>Document verification and regulatory queries.</p>
            <a href="mailto:kyc@fmtbroker.com">kyc@fmtbroker.com</a>
          </div>
          <div class="contact-card" data-type="email">
            <i class="fas fa-tools"></i>
            <h3>Technical Support</h3>
            <p>Platform issues or feature requests.</p>
            <a href="mailto:tech@fmtbroker.com">tech@fmtbroker.com</a>
          </div>
          <div class="contact-card" data-type="phone">
            <i class="fas fa-phone"></i>
            <h3>Phone Support</h3>
            <p>Mon–Fri, 08:00–17:00 (GMT+3)</p>
            <a href="tel:+442038937690">+44 20 3893 7690</a>
          </div>
          <div class="contact-card" data-type="chat">
            <i class="fas fa-comments"></i>
            <h3>Live Chat</h3>
            <p>Instant assistance in multiple languages</p>
            <button class="live-chat-btn">Start Live Chat</button>
          </div>
        </div>
      </section>

      <!-- Map Section -->
      <section class="support-section map-section">
        <h2>Our Office Location</h2>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19835.123456789!2d-0.1277585!3d51.5073509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b3333333333%3A0xabcdefabcdefabcd!2s123%20Finance%20Street%2C%20London%2C%20UK!5e0!3m2!1sen!2s!4v0000000000000"
          allowfullscreen loading="lazy"></iframe>
      </section>

    </div>
    <!-- /.main-content -->

    <!-- Right Panel: Fast Access (TOC) -->
    <aside class="right-panel">
      <h3>Fast Access</h3>
      <nav aria-label="Page Sections" class="toc-container">
        <ul id="toc"></ul>
        <div id="toc-indicator"></div>
      </nav>
    </aside>

  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // TOC generation & scroll indicator
  const content = document.querySelector('.main-content');
  const headings = content.querySelectorAll('h2');
  const toc = document.getElementById('toc');
  const indicator = document.getElementById('toc-indicator');
  if (!headings.length) {
    toc.innerHTML = '<li><em>No sections found.</em></li>';
  } else {
    headings.forEach((h, i) => {
      if (!h.id) h.id = h.textContent.trim().toLowerCase().replace(/\s+/g,'-').replace(/[^\w-]/g,'');
      const li = document.createElement('li');
      const a  = document.createElement('a');
      a.href = '#'+h.id; a.textContent = h.textContent; a.classList.add('toc-h2');
      li.appendChild(a); toc.appendChild(li);
    });
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        const link = toc.querySelector(`a[href="#${entry.target.id}"]`);
        if (!link) return;
        const item = link.parentElement;
        if (entry.isIntersecting) {
          item.classList.add('active');
          const rectLink = link.getBoundingClientRect();
          const rectUL   = toc.getBoundingClientRect();
          const topPos = rectLink.top - rectUL.top + rectLink.height/2;
          indicator.style.display = 'block'; indicator.style.top = topPos + 'px';
        } else {
          item.classList.remove('active');
        }
      });
    }, { threshold: 0.25 });
    headings.forEach(h => observer.observe(h));
  }

  // Contact cards: click to select
  document.querySelectorAll('.contact-card').forEach(card => {
    card.addEventListener('click', () => {
      document.querySelectorAll('.contact-card').forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
    });
  });
});
</script>

<?php get_footer(); ?>
