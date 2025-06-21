<?php
/**
 * Template Name: Financial News Page
 *
 * This template uses the three‐column layout from your index.php example,
 * but the center column shows a static list of example financial news items.
 * Each item links to its detail page via query parameter “?id=…”.
 */

get_header(); ?>

<style>
/* ===== Global ===== */
html,
body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #212121;
  color: #e0e0e0;
  font-family: sans-serif;
}

/* ===== Three‐Column Container ===== */
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

/* ===== Left & Right Panels ===== */
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

/* ===== Center: Financial News List ===== */
.news-list-center {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  overflow-y: auto;
}
.news-item {
  background-color: #2a2a2a;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}
.news-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9);
}
.news-item a {
  display: flex;
  width: 100%;
  text-decoration: none;
}
.news-item .excerpt {
  flex: 1;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.news-item h2 {
  margin: 0 0 0.5rem;
  font-size: 1.25rem;
  color: #ffffff;
}
.news-item h2 a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.news-item h2 a:hover {
  color: #117a9e;
}
.news-item p {
  margin: 0 0 1rem;
  color: #cccccc;
  flex: 1;
}
.news-item .meta {
  font-size: 0.85rem;
  color: #888888;
}
.news-item .read-more {
  margin-top: 0.5rem;
  font-size: 0.85rem;
}
.news-item .read-more a {
  color: #1694ca;
  text-decoration: none;
}
.news-item .read-more a:hover {
  color: #117a9e;
}

/* ===== Center: Pagination (if needed) ===== */
.news-pagination {
  text-align: center;
  margin-top: 2rem;
}
.news-pagination .page-numbers {
  display: inline-block;
  margin: 0 .25rem;
  padding: .5rem .75rem;
  background-color: #2a2a2a;
  color: #e0e0e0;
  border: 1px solid #444;
  border-radius: 4px;
  text-decoration: none;
}
.news-pagination .page-numbers.current {
  background-color: #1694ca;
  color: #ffffff;
  border-color: #1694ca;
}
.news-pagination .page-numbers:hover {
  background-color: #117a9e;
}

/* Utility transitions */
a {
  transition: color 0.2s;
}
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Sort By -->
  <aside class="left-panel">
    <h3>Sort By</h3>
    <ul>
      <?php
      $tabs = [
        'latest'       => 'Latest',
        'most_popular' => 'Most Popular',
        'forex'        => 'Forex',
        'crypto'       => 'Crypto',
        'recommended'  => 'Recommended',
      ];
      $current_sort = isset( $_GET['sort'] ) ? sanitize_key( $_GET['sort'] ) : 'latest';

      $blog_page_id = get_option( 'page_for_posts' );
      if ( $blog_page_id ) {
        $base_url = get_permalink( $blog_page_id );
      } else {
        $base_url = home_url( '/' );
      }

      foreach ( $tabs as $key => $label ) {
        $active = ( $current_sort === $key ) ? 'style="color:#1694ca;font-weight:bold;"' : '';
        $url    = add_query_arg( 'sort', $key, $base_url );
        echo "<li><a href='" . esc_url( $url ) . "' {$active}>{$label}</a></li>";
      }
      ?>
    </ul>
  </aside>

  <!-- Center Panel: Financial News (example data) -->
  <section>
    <div class="news-list-center">
      <?php
      // Example array of news items with full content
      $example_news = [
        0 => [
          'title'        => 'Dollar Hits New High Against Euro',
          'date'         => 'June 1, 2025 14:30',
          'excerpt'      => 'The US Dollar surged to a fresh 2-year high against the Euro today after stronger-than-expected jobs data...',
          'full_content' => 'The US Dollar surged to a fresh two-year high against the Euro after the ADP employment change report showed unexpected strength in private hiring. Markets interpreted these figures as a signal that the Federal Reserve may maintain higher interest rates for longer. Analysts note that stronger employment data tend to push bond yields higher, making USD-denominated assets more attractive. In Europe, lingering concerns over sluggish growth and elevated inflation weighed on the Euro. The EUR/USD pair dropped below 1.05, marking its lowest level since mid-2023. Several banks have revised their year-end forecasts for EUR/USD to the 1.02–1.03 range, contingent on further robust US labor statistics and persistent Eurozone stagnation. Investors await Friday’s Nonfarm Payrolls report for confirmation of the trend.',
        ],
        1 => [
          'title'        => 'Oil Prices Rally on OPEC+ Supply Cuts',
          'date'         => 'June 1, 2025 13:00',
          'excerpt'      => 'Brent crude climbed above $80/barrel as OPEC and its allies extend production cuts into Q3...',
          'full_content' => 'Brent crude oil climbed above $80 per barrel after OPEC+ agreed to extend voluntary production cuts of 2.2 million barrels per day into the third quarter. Saudi Arabia announced an additional cut of 1 million barrels per day for June and July, while Russia pledged to reduce output by 500,000 barrels per day. The measures aim to prop up global oil prices amid concerns about weakening demand from China. Traders said market sentiment was bullish because supply discipline by key producers has tightened physical markets. Energy strategists warn that any signs of demand deterioration especially from Asia could moderate gains. Meanwhile, US crude inventories showed a drawdown of 3 million barrels, reinforcing the tightness. Oil futures are now trading near their 2025 highs, with analysts forecasting $85/barrel if OPEC+ maintains its current stance.',
        ],
        2 => [
          'title'        => 'Gold Retreats as Real Yields Rise',
          'date'         => 'May 31, 2025 18:45',
          'excerpt'      => 'Gold prices pulled back after US Treasury yields climbed, boosting the opportunity cost of holding non-yielding bullion...',
          'full_content' => 'Gold prices retreated from multi-week highs as US Treasury yields climbed and the US dollar strengthened. The 10-year yield jumped 12 basis points to 3.65%, making interest-bearing assets more attractive relative to gold, which pays no interest. Market participants pointed to stronger-than-expected durable goods orders and an uptick in consumer confidence as drivers of higher yields. Additionally, traders anticipate the Federal Reserve will remain cautious about cutting rates soon despite easing inflation trends. Technical analysts noted that gold’s drop below $1,950 per ounce opened the door for a retest of $1,920. On the demand side, physical buying from India and China remained healthy, but central bank purchases have slowed compared to earlier in the year. In the near term, gold could find support around $1,900 if risk-off flows return to global markets.',
        ],
        3 => [
          'title'        => 'Bank of England Holds Rates Steady',
          'date'         => 'May 31, 2025 10:15',
          'excerpt'      => 'The BoE maintained its benchmark interest rate at 5% as inflation showed signs of cooling, though members flagged upside risks...',
          'full_content' => 'The Bank of England’s Monetary Policy Committee voted 7-2 to hold the benchmark interest rate at 5%. Governor Huw Pill noted that inflation has eased more quickly than anticipated, falling to 3.8% in April from 4.2% in March, but remains above the 2% target. Two committee members dissented, advocating for an additional 25-basis-point hike to tackle persistent wage growth pressures. Several MPC members signaled that further tightening could be needed if wage-driven inflation picks up. GDP growth forecasts were downgraded for 2025, reflecting slower real incomes and global headwinds. The pound initially strengthened against the dollar after the announcement but pared gains later in the session as markets assessed the mixed signals on future policy. Analysts expect a rate cut later in Q4 2025 if inflation continues its downward trajectory.',
        ],
        4 => [
          'title'        => 'Tech Stocks Lead Wall Street Higher',
          'date'         => 'May 30, 2025 16:00',
          'excerpt'      => 'Nasdaq climbed 1.2% driven by gains in mega-cap technology names after an upbeat earnings season...',
          'full_content' => 'The Nasdaq Composite rose 1.2%, outperforming the S&P 500 (+0.5%) and Dow Jones Industrial Average (+0.3%) as technology stocks rallied. Apple beat revenue estimates, reporting $95.2 billion in quarterly sales up 6% year-over-year driven by strong iPhone and Services growth. Microsoft posted better-than-expected cloud revenue, sending its shares up 4%. Alphabet and Amazon also gained after forecasting robust advertising and AWS demand, respectively. Market sentiment was lifted by expectations that the Federal Reserve will maintain interest rates near current levels through Q3. Traders are positioning for potential rate hikes from the European Central Bank and the Bank of Japan, which could further fuel capital flows into US tech. Small-cap indexes also outperformed, reflecting a broad-based risk-on mood. Strategists caution that valuation multiples in tech remain elevated and advise selective stock picking ahead of Q2 guidance season.',
        ],
      ];

      // Loop through the example news items
      foreach ( $example_news as $id => $news ) :
        // Build the detail page URL: /news-detail/?id=X
        $detail_url = home_url( '/news-detail/?id=' . $id );
      ?>
        <article class="news-item">
          <a href="<?php echo esc_url( $detail_url ); ?>">
            <div class="excerpt">
              <h2><?php echo esc_html( $news['title'] ); ?></h2>
              <div class="meta"><?php echo esc_html( $news['date'] ); ?></div>
              <p><?php echo esc_html( $news['excerpt'] ); ?></p>
              <div class="read-more">Read More →</div>
            </div>
          </a>
        </article>
      <?php endforeach; ?>

      <!-- Pagination (example) -->
      <div class="news-pagination">
        <a class="page-numbers" href="#">&laquo; Prev</a>
        <span class="page-numbers current">1</span>
        <a class="page-numbers" href="#">2</a>
        <a class="page-numbers" href="#">3</a>
        <a class="page-numbers" href="#">Next &raquo;</a>
      </div>
    </div>
  </section>

  <!-- Right Panel: Recent Posts and Tags -->
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

    <h3>Tags</h3>
    <div>
      <?php
      $tag = get_term_by( 'name', 'فارکس', 'post_tag' );
      if ( $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
        echo '<a href="' . esc_url( $tag_link ) . '" style="color:#e0e0e0; text-decoration:none;">فارکس</a>';
      } else {
        wp_tag_cloud( [
          'smallest'  => 12,
          'largest'   => 12,
          'unit'      => 'px',
          'format'    => 'flat',
          'separator' => ' ',
        ] );
      }
      ?>
    </div>
  </aside>

</main>

<?php get_footer(); ?>
