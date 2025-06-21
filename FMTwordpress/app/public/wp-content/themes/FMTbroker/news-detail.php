<?php
/**
 * Template Name: News Detail
 * Path: wp-content/themes/YourTheme/pages/news-detail.php
 */
?>

<style>
/* (all your CSS for .container-three-col, .news-detail, etc.) */
html, body {
  margin: 0;
  padding: 0;
  background-color: #212121;
  color: #e0e0e0;
  font-family: sans-serif;
}
.container-three-col {
  display: grid;
  grid-template-columns: 1fr 3fr 1fr;
  gap: 2rem;
  width: 100%;
  min-height: calc(100vh - var(--header-height, 90px));
  margin: 0 auto;
  padding: 2rem 1rem;
  box-sizing: border-box;
  background-color: #212121;
}
.left-panel,
.right-panel {
  background-color: #2a2a2a;
  padding: 1rem;
  border-radius: 8px;
  height: 100%;
  overflow-y: auto;
}
.left-panel h3,
.right-panel h3 {
  margin-top: 0;
  color: #1694ca;
  font-size: 1.25rem;
}
.left-panel ul,
.right-panel ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.left-panel li a,
.right-panel li a {
  color: #e0e0e0;
  text-decoration: none;
  line-height: 1.5;
}
.left-panel li a:hover,
.right-panel li a:hover {
  color: #1694ca;
}
.news-detail {
  background-color: #2a2a2a;
  padding: 2rem;
  border-radius: 8px;
  color: #e0e0e0;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
.news-detail h1 {
  margin: 0 0 1rem;
  font-size: 2rem;
  color: #ffffff;
}
.news-meta {
  font-size: 0.9rem;
  color: #cccccc;
}
.news-content {
  line-height: 1.6;
  color: #cccccc;
}
.news-back {
  font-size: 1rem;
}
.news-back a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.news-back a:hover {
  color: #117a9e;
}
</style>

<main class="container-three-col" role="main">
  <!-- Left Panel: Back to News List -->
  <aside class="left-panel">
    <h3>Back to News</h3>
    <ul>
      <li>
        <a href="<?php echo esc_url( home_url( '/financial-news/' ) ); ?>">
          ← All Financial News
        </a>
      </li>
    </ul>
  </aside>

  <!-- Center Panel: Show single news item based on ?id=… -->
  <section>
    <div class="news-detail">
      <?php
      // Same example array of news items with full content
      $example_news = [
        0 => [
          'title'        => 'Dollar Hits New High Against Euro',
          'date'         => 'June 1, 2025 14:30',
          'full_content' => 'The US Dollar surged to a fresh two-year high against the Euro after the ADP employment change report showed unexpected strength in private hiring. Markets interpreted these figures as a signal that the Federal Reserve may maintain higher interest rates for longer. Analysts note that stronger employment data tend to push bond yields higher, making USD-denominated assets more attractive. In Europe, lingering concerns over sluggish growth and elevated inflation weighed on the Euro. The EUR/USD pair dropped below 1.05, marking its lowest level since mid-2023. Several banks have revised their year-end forecasts for EUR/USD to the 1.02–1.03 range, contingent on further robust US labor statistics and persistent Eurozone stagnation. Investors await Friday’s Nonfarm Payrolls report for confirmation of the trend.',
        ],
        1 => [
          'title'        => 'Oil Prices Rally on OPEC+ Supply Cuts',
          'date'         => 'June 1, 2025 13:00',
          'full_content' => 'Brent crude oil climbed above $80 per barrel after OPEC+ agreed to extend voluntary production cuts of 2.2 million barrels per day into the third quarter. Saudi Arabia announced an additional cut of 1 million barrels per day for June and July, while Russia pledged to reduce output by 500,000 barrels per day. The measures aim to prop up global oil prices amid concerns about weakening demand from China. Traders said market sentiment was bullish because supply discipline by key producers has tightened physical markets. Energy strategists warn that any signs of demand deterioration especially from Asia could moderate gains. Meanwhile, US crude inventories showed a drawdown of 3 million barrels, reinforcing the tightness. Oil futures are now trading near their 2025 highs, with analysts forecasting $85/barrel if OPEC+ maintains its current stance.',
        ],
        2 => [
          'title'        => 'Gold Retreats as Real Yields Rise',
          'date'         => 'May 31, 2025 18:45',
          'full_content' => 'Gold prices retreated from multi-week highs as US Treasury yields climbed and the US dollar strengthened. The 10-year yield jumped 12 basis points to 3.65%, making interest-bearing assets more attractive relative to gold, which pays no interest. Market participants pointed to stronger-than-expected durable goods orders and an uptick in consumer confidence as drivers of higher yields. Additionally, traders anticipate the Federal Reserve will remain cautious about cutting rates soon despite easing inflation trends. Technical analysts noted that gold’s drop below $1,950 per ounce opened the door for a retest of $1,920. On the demand side, physical buying from India and China remained healthy, but central bank purchases have slowed compared to earlier in the year. In the near term, gold could find support around $1,900 if risk-off flows return to global markets.',
        ],
        3 => [
          'title'        => 'Bank of England Holds Rates Steady',
          'date'         => 'May 31, 2025 10:15',
          'full_content' => 'The Bank of England’s Monetary Policy Committee voted 7-2 to hold the benchmark interest rate at 5%. Governor Huw Pill noted that inflation has eased more quickly than anticipated, falling to 3.8% in April from 4.2% in March, but remains above the 2% target. Two committee members dissented, advocating for an additional 25-basis-point hike to tackle persistent wage growth pressures. Several MPC members signaled that further tightening could be needed if wage-driven inflation picks up. GDP growth forecasts were downgraded for 2025, reflecting slower real incomes and global headwinds. The pound initially strengthened against the dollar after the announcement but pared gains later in the session as markets assessed the mixed signals on future policy. Analysts expect a rate cut later in Q4 2025 if inflation continues its downward trajectory.',
        ],
        4 => [
          'title'        => 'Tech Stocks Lead Wall Street Higher',
          'date'         => 'May 30, 2025 16:00',
          'full_content' => 'The Nasdaq Composite rose 1.2%, outperforming the S&P 500 (+0.5%) and Dow Jones Industrial Average (+0.3%) as technology stocks rallied. Apple beat revenue estimates, reporting $95.2 billion in quarterly sales up 6% year-over-year driven by strong iPhone and Services growth. Microsoft posted better-than-expected cloud revenue, sending its shares up 4%. Alphabet and Amazon also gained after forecasting robust advertising and AWS demand, respectively. Market sentiment was lifted by expectations that the Federal Reserve will maintain interest rates near current levels through Q3. Traders are positioning for potential rate hikes from the European Central Bank and the Bank of Japan, which could further fuel capital flows into US tech. Small-cap indexes also outperformed, reflecting a broad-based risk-on mood. Strategists caution that valuation multiples in tech remain elevated and advise selective stock picking ahead of Q2 guidance season.',
        ],
      ];

      // Retrieve “id” from query parameter
      $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : -1;

      if ( array_key_exists( $id, $example_news ) ) {
        $news = $example_news[ $id ];
      ?>
        <h1><?php echo esc_html( $news['title'] ); ?></h1>
        <div class="news-meta"><?php echo esc_html( $news['date'] ); ?></div>
        <div class="news-content"><?php echo esc_html( $news['full_content'] ); ?></div>
        <div class="news-back">
          <a href="<?php echo esc_url( home_url( '/financial-news/' ) ); ?>">
            ← Back to News List
          </a>
        </div>
      <?php
      } else {
        echo '<p>News item not found.</p>';
        echo '<p><a href="' . esc_url( home_url( '/financial-news/' ) ) . '">← Back to News List</a></p>';
      }
      ?>
    </div>
  </section>

  <!-- Right Panel: Recent Posts (optional) -->
  <aside class="right-panel">
    <h3>Recent Posts</h3>
    <ul>
      <?php
      $recent_posts = wp_get_recent_posts( [
        'numberposts' => 5,
        'post_status' => 'publish',
      ] );
      foreach ( $recent_posts as $p ) {
        $title = esc_html( $p['post_title'] );
        $link  = get_permalink( $p['ID'] );
        echo "<li><a href='" . esc_url( $link ) . "'>{$title}</a></li>";
      }
      ?>
    </ul>
  </aside>

</main>

<?php get_footer(); ?>
