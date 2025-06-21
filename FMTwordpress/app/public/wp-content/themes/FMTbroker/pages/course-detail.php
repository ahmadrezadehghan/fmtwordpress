<?php
/**
 * Template Name: Course Detail
 * Path: wp-content/themes/YourTheme/pages/course-detail.php
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
/* ===== Left & Right Panels ===== */
.left-panel,
.right-panel {
  /* marble + subtle tint overlay */
  background-image:
    linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
    url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  background-color: #2a2a2a;      /* fallback tint */
  background-blend-mode: overlay;

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

/* ===== Center: Course Detail ===== */
.course-detail {
  background-color: #2a2a2a;
  padding: 2rem;
  border-radius: 8px;
  color: #e0e0e0;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
.course-detail h1 {
  margin: 0 0 1rem;
  font-size: 2rem;
  color: #ffffff;
}
.course-meta {
  font-size: 0.9rem;
  color: #cccccc;
}
.course-thumb {
  width: 100%;
  max-height: 300px;
  background-size: cover;
  background-position: center;
  border-radius: 4px;
}
.course-content {
  line-height: 1.6;
  color: #cccccc;
}
.course-video {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  border-radius: 4px;
}
.course-video iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: none;
}
.course-images {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}
.course-images img {
  width: calc(50% - 0.5rem);
  border-radius: 4px;
}
.course-audio {
  background-color: #1a1a1a;
  padding: 1rem;
  border-radius: 4px;
}
.course-downloads {
  margin-top: 1rem;
}
.course-downloads a {
  display: inline-block;
  margin-right: 1rem;
  background-color: #1694ca;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  text-decoration: none;
  transition: background-color 0.2s;
}
.course-downloads a:hover {
  background-color: #117a9e;
}
.course-back {
  font-size: 1rem;
}
.course-back a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.course-back a:hover {
  color: #117a9e;
}
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Back to Courses List -->
  <aside class="left-panel">
    <h3>Back to Courses</h3>
    <ul>
      <li>
        <a href="<?php echo esc_url( home_url( '/training-and-courses/' ) ); ?>">
          ← All Training & Courses
        </a>
      </li>
    </ul>
  </aside>

  <!-- Center Panel: Show single course item based on ?id=… -->
  <section>
    <div class="course-detail">
      <?php
      // Example array of courses with rich media
      $courses = [
        0 => [
          'title'         => 'Forex Trading for Beginners',
          'date'          => 'Starts: July 10, 2025',
          'thumbnail'     => get_template_directory_uri() . '/assets/images/forex-beginners.jpg',
          'content'       => 'This beginner-level course covers all the fundamentals of Forex trading. You’ll learn:
- What are currency pairs, pips, and lots
- How to read candlestick charts and basic indicators
- Order types (market, limit, stop) and risk management basics
- Demo account setup and first mock trades
- Developing a simple moving-average crossover system
  \n\nBy course end, you will be able to place and manage basic Forex trades confidently, with a clear foundation for advancing to technical analysis and risk management modules.',
          'video_url'     => 'https://www.youtube.com/embed/0xAbC123XYZ', // sample YouTube embed
          'images'        => [
                              get_template_directory_uri() . '/assets/images/forex-chart1.jpg',
                              get_template_directory_uri() . '/assets/images/forex-chart2.jpg',
                            ],
          'audio_url'     => get_template_directory_uri() . '/assets/audio/forex-intro.mp3',
          'downloads'     => [
                              [
                                'label' => 'Course Slides PDF',
                                'url'   => get_template_directory_uri() . '/assets/downloads/forex-beginners-slides.pdf',
                              ],
                              [
                                'label' => 'Example Spreadsheet',
                                'url'   => get_template_directory_uri() . '/assets/downloads/forex-examples.xlsx',
                              ],
                            ],
        ],
        1 => [
          'title'         => 'Advanced Technical Analysis',
          'date'          => 'Starts: August 1, 2025',
          'thumbnail'     => get_template_directory_uri() . '/assets/images/technical-analysis.jpg',
          'content'       => 'Deep dive into advanced charting and indicators:
- Fibonacci retracements, extensions, and time zones
- Elliott Wave wave counts and practical application
- Advanced candlestick patterns (Abandoned Baby, Three Line Strike)
- Ichimoku Cloud: build strategies using Tenkan/Kijun crosses
- Volume-based indicators and OBV/Volume Profile
- Trend-confirmation with multiple time frame analysis
\n\nThis course is hands-on: students complete live chart projects and backtest strategies in MT4/TradingView. Perfect for traders who already understand basics and want to refine their edge.',
          'video_url'     => 'https://www.youtube.com/embed/1aBcD456EFG',
          'images'        => [
                              get_template_directory_uri() . '/assets/images/elliott-wave.jpg',
                              get_template_directory_uri() . '/assets/images/fibonacci.jpg',
                            ],
          'audio_url'     => get_template_directory_uri() . '/assets/audio/ta-overview.mp3',
          'downloads'     => [
                              [
                                'label' => 'TA Workbook PDF',
                                'url'   => get_template_directory_uri() . '/assets/downloads/ta-workbook.pdf',
                              ],
                              [
                                'label' => 'Indicator Scripts',
                                'url'   => get_template_directory_uri() . '/assets/downloads/ta-scripts.zip',
                              ],
                            ],
        ],
        2 => [
          'title'         => 'Cryptocurrency Trading 101',
          'date'          => 'Starts: July 20, 2025',
          'thumbnail'     => get_template_directory_uri() . '/assets/images/crypto-trading.jpg',
          'content'       => 'An introduction to trading digital assets:
- Cryptocurrency fundamentals: blockchain, decentralized ledgers, smart contracts
- Major coins: Bitcoin, Ethereum, Binance Coin, and stablecoins
- Setting up and securing an exchange account (Binance, Coinbase)
- On-chain vs. off-chain metrics: reading on-chain data and exchange flows
- Basic on-chart indicators (RSI, MACD) applied to crypto pairs
- Managing volatility: position sizing and stop-loss techniques
  \n\nBy the end, you will be comfortable placing trades on major exchanges, using proper security practices, and interpreting key on-chain metrics for entry/exit timing.',
          'video_url'     => 'https://www.youtube.com/embed/2GhIj789KLM',
          'images'        => [
                              get_template_directory_uri() . '/assets/images/crypto-chart1.jpg',
                              get_template_directory_uri() . '/assets/images/crypto-chart2.jpg',
                            ],
          'audio_url'     => get_template_directory_uri() . '/assets/audio/crypto-intro.mp3',
          'downloads'     => [
                              [
                                'label' => 'Crypto Basics PDF',
                                'url'   => get_template_directory_uri() . '/assets/downloads/crypto-basics.pdf',
                              ],
                              [
                                'label' => 'On-Chain Analysis Guide',
                                'url'   => get_template_directory_uri() . '/assets/downloads/onchain-guide.pdf',
                              ],
                            ],
        ],
        3 => [
          'title'         => 'Risk Management & Money Management',
          'date'          => 'Starts: September 5, 2025',
          'thumbnail'     => get_template_directory_uri() . '/assets/images/risk-management.jpg',
          'content'       => 'Protect your capital and preserve gains:
- Defining risk tolerance and setting realistic goals
- Position-sizing formulas: fixed fractional, Kelly Criterion
- Determining proper stop-loss levels: ATR and support/resistance
- Risk-reward ratios: how to ensure positive expectancy
- Psychology of risk: avoiding revenge trading and FOMO
- Portfolio diversification: combining Forex, crypto, and commodities
  \n\nIncludes interactive worksheets and case studies. After this module, you’ll have a complete trade-plan template focusing on capital preservation and consistency.',
          'video_url'     => 'https://www.youtube.com/embed/3IjKl012NOP',
          'images'        => [
                              get_template_directory_uri() . '/assets/images/risk-chart1.jpg',
                              get_template_directory_uri() . '/assets/images/risk-chart2.jpg',
                            ],
          'audio_url'     => get_template_directory_uri() . '/assets/audio/risk-management.mp3',
          'downloads'     => [
                              [
                                'label' => 'Risk Workbook PDF',
                                'url'   => get_template_directory_uri() . '/assets/downloads/risk-workbook.pdf',
                              ],
                              [
                                'label' => 'Money-Management Spreadsheet',
                                'url'   => get_template_directory_uri() . '/assets/downloads/money-management.xlsx',
                              ],
                            ],
        ],
        4 => [
          'title'         => 'Trading Certification Program',
          'date'          => 'Starts: October 15, 2025',
          'thumbnail'     => get_template_directory_uri() . '/assets/images/certification.jpg',
          'content'       => 'A comprehensive, multi-week program culminating in a certified trading credential:
- Week 1: Market microstructure and order book dynamics
- Week 2: Technical vs. fundamental analysis finding balance
- Week 3: Advanced algorithms: using Python for simple backtests
- Week 4: Psychology of trading: mindset, journaling, and accountability
- Final exam: theory + practical trading simulation on a live demo account
- Live Q&A with experienced traders and brokers
  \n\nGraduates receive a digital certificate recognized by partner brokers, along with a letter of recommendation for prop-trading firm applications.',
          'video_url'     => 'https://www.youtube.com/embed/4OpQr345QRS',
          'images'        => [
                              get_template_directory_uri() . '/assets/images/certify1.jpg',
                              get_template_directory_uri() . '/assets/images/certify2.jpg',
                            ],
          'audio_url'     => get_template_directory_uri() . '/assets/audio/certification-overview.mp3',
          'downloads'     => [
                              [
                                'label' => 'Certification Handbook PDF',
                                'url'   => get_template_directory_uri() . '/assets/downloads/certification-handbook.pdf',
                              ],
                              [
                                'label' => 'Practice Exam Files',
                                'url'   => get_template_directory_uri() . '/assets/downloads/practice-exams.zip',
                              ],
                            ],
        ],
      ];

      // Retrieve “id” from query parameter
      $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : -1;

      if ( array_key_exists( $id, $courses ) ) {
        $course = $courses[ $id ];
      ?>
        <h1><?php echo esc_html( $course['title'] ); ?></h1>
        <div class="course-meta"><?php echo esc_html( $course['date'] ); ?></div>
        <div class="course-thumb" style="background-image: url('<?php echo esc_url( $course['thumbnail'] ); ?>');"></div>
        <div class="course-content"><?php echo nl2br( esc_html( $course['content'] ) ); ?></div>

        <?php if ( ! empty( $course['video_url'] ) ) : ?>
          <div class="course-video">
            <iframe src="<?php echo esc_url( $course['video_url'] ); ?>" allowfullscreen></iframe>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $course['images'] ) ) : ?>
          <div class="course-images">
            <?php foreach ( $course['images'] as $img_url ) : ?>
              <img src="<?php echo esc_url( $img_url ); ?>" alt="Course image">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $course['audio_url'] ) ) : ?>
          <div class="course-audio">
            <audio controls>
              <source src="<?php echo esc_url( $course['audio_url'] ); ?>" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $course['downloads'] ) ) : ?>
          <div class="course-downloads">
            <?php foreach ( $course['downloads'] as $file ) : ?>
              <a href="<?php echo esc_url( $file['url'] ); ?>" target="_blank" download>
                <?php echo esc_html( $file['label'] ); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="course-back">
          <a href="<?php echo esc_url( home_url( '/training-and-courses/' ) ); ?>">
            ← Back to Training & Courses
          </a>
        </div>
      <?php
      } else {
        echo '<p>Course not found.</p>';
        echo '<p><a href="' . esc_url( home_url( '/training-and-courses/' ) ) . '">← Back to Training & Courses</a></p>';
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
