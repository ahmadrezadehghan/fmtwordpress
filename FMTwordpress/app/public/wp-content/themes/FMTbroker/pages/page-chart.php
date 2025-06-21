<?php
/**
 * Template Name: Chart
 * Description: Full-screen TradingView chart with custom side panels: Watchlist (left) and Symbols (right), dark theme, interval selector under titles.
 */
get_header(); ?>

<style>
  :root { --header-height: 90px; }
  .page-chart-wrapper {
    position: fixed;
    top: var(--header-height);
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #212121;
  }
  /* Side panels share styling */
  .watchlist-panel,
  .symbols-panel {
    width: 200px;
    background-color: #212121;
    color: #ffffff;
    overflow-y: auto;
    padding: 12px;
    box-sizing: border-box;
    border-right: 1px solid #333;
  }
  .symbols-panel {
    border-right: none;
    border-left: 1px solid #333;
  }
  .panel-section {
    margin-bottom: 16px;
  }
  .panel-section h3 {
    margin: 0;
    font-size: 1rem;
    color: #ffffff;
    padding-bottom: 10px;
  }
  /* Interval buttons under section titles */
  .intervals {
    display: flex;
    gap: 6px;
    margin-bottom: 10px;
  }
  .intervals button {
    background: rgba(255,255,255,0.2);
    color: #ffffff;
    border: none;
    padding: 4px 6px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8rem;
  }
  .panel-item {
    padding: 6px 0;
    font-size: 0.9rem;
    border-bottom: 1px solid #333;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .panel-item span:first-child {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-right: 8px;
  }
  .panel-item span:last-child {
    flex-shrink: 0;
  }
  /* Chart container styling */
  #tv_chart_container {
    flex: 1;
    position: relative;
    background-color: #212121;
  }
  /* Chart tools hide, intervals moved into panels */
</style>

<main class="page-chart-wrapper" role="main">

  <!-- Left Watchlist Panel -->
  <aside class="watchlist-panel">
    <div class="panel-section">
      <h3>Watchlist</h3>
      <div class="intervals">
        <button data-interval="D">1D</button>
        <button data-interval="W">1W</button>
        <button data-interval="M">1M</button>
      </div>
      <?php
      $watchlist = ['AAPL','GOOGL','MSFT','TSLA','AMZN'];
      foreach($watchlist as $sym): ?>
        <div class="panel-item" data-symbol="<?php echo esc_attr($sym); ?>">
          <span><?php echo esc_html($sym); ?></span>
          <span id="watch-price-<?php echo esc_attr($sym); ?>">–</span>
        </div>
      <?php endforeach; ?>
    </div>
  </aside>

  <!-- Main Chart Container -->
  <div id="tv_chart_container"></div>

  <!-- Right Symbols Panel -->
  <aside class="symbols-panel">
    <div class="panel-section">
      <h3>Symbols</h3>
      <div class="intervals">
        <button data-interval="D">1D</button>
        <button data-interval="W">1W</button>
        <button data-interval="M">1M</button>
      </div>
      <?php
      $symbols = ['SPX','NDQ','DJI','VIX','DXY'];
      foreach($symbols as $sym): ?>
        <div class="panel-item" data-symbol="<?php echo esc_attr($sym); ?>">
          <span><?php echo esc_html($sym); ?></span>
          <span id="sym-price-<?php echo esc_attr($sym); ?>">–</span>
        </div>
      <?php endforeach; ?>
    </div>
  </aside>

</main>

<script src="https://s3.tradingview.com/tv.js"></script>
<script>
  const widget = new TradingView.widget({
    container_id: 'tv_chart_container',
    autosize: true,
    symbol: 'NASDAQ:AAPL',
    interval: 'D',
    timezone: 'Etc/UTC',
    theme: 'Dark',
    style: 1,
    hide_side_toolbar: true,
    details: false,
    hotlist: false,
    calendar: false,
  });

  // Interval buttons behavior
  document.querySelectorAll('.intervals button').forEach(btn => {
    btn.addEventListener('click', () => {
      const interval = btn.dataset.interval;
      widget.chart().setResolution(interval);
    });
  });

  // Update panel prices after chart ready
  function updatePrices(prefix, items) {
    widget.onChartReady(() => {
      items.forEach(sym => {
        widget.setSymbol(sym, widget.interval());
        setTimeout(() => {
          const bar = widget.chart().session.getLastBar();
          document.getElementById(prefix + sym).textContent = bar ? bar.close : '–';
        }, 500);
      });
    });
  }
  const watchlist = <?php echo json_encode($watchlist); ?>;
  const symbols = <?php echo json_encode($symbols); ?>;
  updatePrices('watch-price-', watchlist);
  updatePrices('sym-price-', symbols);

  // Click panel item to change symbol
  document.querySelectorAll('.panel-item').forEach(el => {
    el.addEventListener('click', () => {
      widget.setSymbol(el.dataset.symbol, widget.interval());
    });
  });
</script>

<?php get_footer(); ?>
