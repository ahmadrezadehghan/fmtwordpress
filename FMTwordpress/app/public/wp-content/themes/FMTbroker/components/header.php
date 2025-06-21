<?php
/**
 * Component: Header
 *
 * Outputs a modern glassmorphic header with logo/site title, nav, search, and mobile toggle.
 * Formats 'FMT' uppercase and 'broker' lowercase when using site title fallback.
 */
?>
<!-- Force the header never to translate or transition -->
<style>
  #masthead {
    position: sticky !important;
    top: 0 !important;
    z-index: 50 !important;
    transform: none !important;
    transition: none !important;
    margin-left: 10px;
  }

  /* Icon and Language Switcher Styles */
  .header-icons {
    display: flex;
    align-items: right;
    margin-left: 5px; /* Reduced space to bring icons closer */
  }
  .header-icons img {
    width: 17px;
    height: 17px;
    padding: 0 4px; /* Less padding for tighter placement */
    filter: brightness(0) invert(1); /* Ensure icon appears white */
    cursor: pointer;
    margin-left: 5px; /* Reduced space to bring icons closer */
    margin-right: 5px; /* Reduced space to bring icons closer */
  }
  .lang-switcher {
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #ffffff;
    font-size: 0.875rem;
    margin-left: 4px;
    margin-right: 5px;
  }
  .lang-switcher .flag-circle {
    display: inline-block;
    width: 16px;
    height: 16px;
    background-color: #ffffff;
    border-radius: 50%;
    margin-right: 4px;
  }

  /* Search form adjustments */
  .header-search {
    display: flex;
    align-items: center;
    margin-left: 2px; /* Minimize left margin to remove empty space */
  }
  .header-search input[type="search"] {
    padding: 4px 10px; /* Keep consistent styling */
    font-size: 0.875rem;
    color: #333;
  }
  .header-search button {
    margin-left: 4px;
    padding: 4px 10px;
    font-size: 0.875rem;
  }

  /* ─────────────────────────────────────────────────────────
     UPDATED: Lay out nav + (icons+search) in one flex container
     ───────────────────────────────────────────────────────── */
  .nav-search-wrap {
    display: flex;
    justify-content: space-between; /* was `justify-center` */
    align-items: center;
    flex: 1;
  }
  /* Tiny wrapper around the two right parts to give exactly 5px gap from header edge */
  .right-group {
    display: flex;
    align-items: center;
    margin-right: 5px; /* ← 5px gap from the right side of the header */
  }

  /* Hide the center nav links on screens ≤1499px */
  @media (max-width: 1499px) {
    #masthead .main-navigation {
      display: none;
    }
    /* Hide the desktop right-group on mobile */
    .right-group {
      display: none;
    }
    /* Mobile: ensure header-actions items align horizontally */
    .header-actions {
      display: flex;
      align-items: center;
    }
    .mobile-icons-search {
      display: flex;
      align-items: center;
      margin-right: 8px; /* Space between icons/search and hamburger */
    }
  }

  /* Desktop: hide mobile-icons-search */
  @media (min-width: 1500px) {
    .mobile-icons-search {
      display: none;
    }
  }
  /* Show hamburger toggle only on ≤1499px */
  @media (max-width: 1499px) {
    .mobile-menu-toggle {
      display: block !important;
    }
  }
  @media (min-width: 1500px) {
    .mobile-menu-toggle {
      display: none !important;
    }
  }

  /* Remove “always‐on” mobile panel at ≤1499px: let JS control its display */
  @media (max-width: 1499px) {
    .mobile-nav-panel {
      /* display: block !important; */  /* ← REMOVED this line */
    }
  }
  @media (min-width: 1500px) {
    .mobile-nav-panel {
      display: none !important;
    }
  }

  /* -----------------------------
     Mobile Nav Panel (Dropdown)
     ----------------------------- */

  /* Ensure the header container is positioned relative, so absolute children can align */
  .header-inner {
    position: relative;
  }

  /* Style for the dropdown panel */
  .mobile-nav-panel {
    position: absolute;
    top: 100%;              /* Just below the header */
    right: 5px;             /* Align under the right‐hand hamburger */
    width: 150px;           /* Fixed width */
    background-color: #212121;
    box-shadow: 0 2px 8px #0096c7;
    border-radius: 4px;
    overflow: hidden;
    display: none;          /* Hidden by default—JS will toggle this */
    z-index: 100;           /* Above other content */
  }

  /* Adjust the inner nav list so it fits a narrow dropdown */
  .mobile-nav-list {
    display: flex;
    flex-direction: column;
    gap: 8px;               /* Slightly smaller gap inside */
    list-style: none;
    margin: 0;
    padding: 8px;           /* Reduced padding for 150px width */
  }

  /* Each link fills the width */
  .mobile-nav-list li a {
    display: block;
    padding: 6px 8px;
    font-size: 0.875rem;
    color: #ffffff;
    text-decoration: none;
    border-radius: 3px;
  }

  /* Hover/focus states */
  .mobile-nav-list li a:hover,
  .mobile-nav-list li a:focus {
    background-color: #0096c7;
  }

  /* Ensure the toggle button itself is above the panel when opened */
  .mobile-menu-toggle {
    position: relative;
    z-index: 110;
  }
</style>

<header
  id="masthead"
  class="site-header text-sm bg-white/30 backdrop-blur-md"
>
  <div class="header-inner flex justify-between items-center">
    <!-- Logo or Site Title with 5px left padding -->
    <div class="site-branding" style="padding-left: 5px;">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <?php
          // Split “FMTbroker” into colored spans
          $home_url = esc_url( home_url('/') );
        ?>
        <a href="<?php echo $home_url; ?>" class="site-title text-sm">
          <span class="f">F</span><span class="m">M</span><span class="t">T</span>broker
        </a>
      <?php endif; ?>
    </div>

    <!-- Centered Navigation and (icons+search) for Desktop -->
    <div class="nav-search-wrap">
      <!-- (1) Hide on mobile (≤1499px) via CSS; show on desktop (≥1500px) -->
      <nav id="site-navigation" class="main-navigation">
        <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-menu flex gap-8 list-none text-sm',
          ));
        ?>
      </nav>

      <!-- (2) Wrap the existing icons + search inside a new “.right-group” for desktop -->
      <div class="right-group">
        <!-- Theme Toggle Icon and Language Switcher (desktop only) -->
        <div class="header-icons">
          <img
            id="theme-toggle-icon"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/Lightmode.png"
            alt="Toggle Theme"
            title="Toggle Theme"
          />
          <div class="lang-switcher">
            <span class="flag-circle"></span><span>EN</span>
          </div>
        </div>

        <!-- Search form (desktop only) -->
        <form
          role="search"
          method="get"
          class="header-search text-sm"
          action="<?php echo esc_url(home_url('/')); ?>"
        >
          <input
            type="search"
            name="s"
            placeholder="Search symbols, news..."
            value="<?php echo get_search_query(); ?>"
            class="text-sm"
          />
          <button type="submit" class="text-sm">Go</button>
        </form>
      </div>
    </div>

    <!-- Mobile Actions: icons + search near hamburger -->
    <div class="header-actions" style="padding-right: 5px;">
      <div class="mobile-icons-search">
        <!-- Theme Toggle Icon (mobile only) -->
        <div class="header-icons">
          <img
            id="theme-toggle-icon-mobile"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/Lightmode.png"
            alt="Toggle Theme"
            title="Toggle Theme"
          />
          <div class="lang-switcher">
            <span class="flag-circle"></span><span>EN</span>
          </div>
        </div>
        <!-- Search form (mobile only) -->
        <form
          role="search"
          method="get"
          class="header-search text-sm"
          action="<?php echo esc_url(home_url('/')); ?>"
        >
          <input
            type="search"
            name="s"
            placeholder="Search..."
            value="<?php echo get_search_query(); ?>"
            class="text-sm"
            style="width: 100px;" /* Shrink input width for mobile */
          />
          <button type="submit" class="text-sm">Go</button>
        </form>
      </div>

      <!-- Mobile Toggle aligned right (visible on ≤1499px only) -->
      <button
        class="mobile-menu-toggle lg:hidden"
        aria-controls="site-navigation"
        aria-expanded="false"
      >
        <svg
          class="hamburger"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M4 6H20M4 12H20M4 18H20"
            stroke-width="2.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Navigation Panel (dropdown) -->
  <div class="mobile-nav-panel">
    <nav class="mobile-menu">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'mobile-nav-list',
        ));
      ?>
    </nav>
  </div>

  <!-- Toggle Icon Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Theme toggle for both desktop and mobile icons
      const icons = [
        document.getElementById('theme-toggle-icon'),
        document.getElementById('theme-toggle-icon-mobile')
      ];
      icons.forEach(icon => {
        if (!icon) return;
        icon.addEventListener('click', function() {
          const lightSrc = '<?php echo get_template_directory_uri(); ?>/assets/images/Lightmode.png';
          const darkSrc = '<?php echo get_template_directory_uri(); ?>/assets/images/Darkmode.png';
          icon.src = (icon.src.includes('Lightmode.png')) ? darkSrc : lightSrc;
        });
      });

      // Mobile menu toggle logic
      const mobileToggle = document.querySelector('.mobile-menu-toggle');
      const mobilePanel = document.querySelector('.mobile-nav-panel');
      mobileToggle.addEventListener('click', function() {
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        mobilePanel.style.display = expanded ? 'none' : 'block';
      });
    });
  </script>
</header>
