<?php
/**
 * Template Name: CashbackForex Economic Calendar (Dark Theme)
 */

get_header(); ?>

<style>
html,
body {
  margin: 0;
  padding: 0;
  background: #212121;
  color: #e0e0e0;
  font-family: sans-serif;
}
.container-cbf-calendar {
  width: 100%;
  max-width: 1400px;
  margin: 1rem auto;
  background: #2a2a2a;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
}
.calendar-header {
  background: #2a2a2a;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #444;
}
.calendar-header h1 {
  margin: 0;
  font-size: 1.75rem;
  color: #1694ca;
}
.calendar-iframe-wrapper {
  position: relative;
  width: 100%;
  height: calc(100vh - 140px);
  background: #212121;
}
.calendar-iframe {
  width: 100%;
  height: 100%;
  border: none;
  /* Invert colors to approximate a dark theme */
  filter: invert(1) hue-rotate(180deg);
}
</style>

<main class="container-cbf-calendar">
  <div class="calendar-header">
    <h1>Economic Calendar</h1>
  </div>
  <div class="calendar-iframe-wrapper">
    <iframe
      class="calendar-iframe"
      src="https://www.cashbackforex.com/en/tools/economic-calendar#popout"
      allowtransparency="true">
    </iframe>
  </div>
</main>

<?php get_footer(); ?>
