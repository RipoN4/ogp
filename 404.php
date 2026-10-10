<?php get_header(); ?>

<main id="primary" class="site-main">

    <section class="error-404 not-found">
        <div class="error-404-visual" aria-hidden="true">
            <svg class="error-404-svg" viewBox="0 0 320 160" width="320" height="160" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="ogp404Grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#88a7ff" />
                        <stop offset="100%" stop-color="#345ee1" />
                    </linearGradient>
                    <radialGradient id="ogp404Glow" cx="50%" cy="50%" r="50%">
                        <stop offset="0%" stop-color="#88a7ff" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="#88a7ff" stop-opacity="0" />
                    </radialGradient>
                </defs>

                <!-- Background ambient glow -->
                <circle cx="160" cy="80" r="70" fill="url(#ogp404Glow)" class="svg-ambient-glow" />

                <!-- 4 on the left -->
                <text x="55" y="112" class="svg-digit" text-anchor="middle">4</text>

                <!-- Center animated icon representing '0' -->
                <g class="svg-center-zero">
                    <!-- Outer radar dashed ring -->
                    <circle cx="160" cy="80" r="44" fill="none" stroke="#2a3140" stroke-width="2" />
                    <circle cx="160" cy="80" r="44" fill="none" stroke="url(#ogp404Grad)" stroke-width="3" stroke-dasharray="60 120" stroke-linecap="round" class="svg-spin-ring" />
                    
                    <!-- Inner lens ring -->
                    <circle cx="160" cy="80" r="28" fill="#171b22" stroke="#2a3140" stroke-width="2" />
                    
                    <!-- Floating / pulsing core orb -->
                    <circle cx="160" cy="80" r="12" fill="url(#ogp404Grad)" class="svg-pulse-core" />
                    
                    <!-- Sweeping search radar beam -->
                    <line x1="160" y1="80" x2="160" y2="38" stroke="#88a7ff" stroke-width="2.5" stroke-linecap="round" class="svg-radar-beam" />
                </g>

                <!-- 4 on the right -->
                <text x="265" y="112" class="svg-digit" text-anchor="middle">4</text>
            </svg>
        </div>

        <h1 class="page-title error-404-title"><?php esc_html_e( 'Page Not Found', 'ogp' ); ?></h1>
        <p class="error-404-desc"><?php esc_html_e( 'The page you are looking for doesn\'t exist or was moved.', 'ogp' ); ?></p>

        <form role="search" method="get" class="error-404-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label for="error-404-s" class="screen-reader-text"><?php esc_html_e( 'Search', 'ogp' ); ?></label>
            <input id="error-404-s" type="search" class="error-404-input" placeholder="<?php echo esc_attr_x( 'Search videos & press Enter...', 'placeholder', 'ogp' ); ?>" value="" name="s" autocomplete="off" />
        </form>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-404-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span><?php esc_html_e( 'Back to Home', 'ogp' ); ?></span>
        </a>
    </section>

</main>

<?php get_footer(); ?>
