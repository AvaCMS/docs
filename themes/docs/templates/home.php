<?php
/**
 * Home Template - Hero landing page
 * 
 * Uses shared header/footer partials with homepage-specific body class
 * for consistent navigation while allowing unique hero styling.
 */

// Homepage configuration
$showSidebar = false;
$showToc = false;
$bodyClass = 'home-hero-page';
?>
<?= $ava->partial('header', [
    'request' => $request,
    'item' => $content,
    'pageTitle' => $content->title() . ' - Ava CMS',
    'pageDescription' => 'A friendly, flexible, flat-file, PHP-based CMS for bespoke personal websites, blogs and more.',
    'showSidebar' => $showSidebar,
    'bodyClass' => $bodyClass,
]) ?>

            <div class="home-hero-content">
                <div class="home-container">
                    <div class="hero-badge">Flat-file CMS</div>
                    <h1>Ava</h1>
                    <p class="home-tagline">A friendly, flexible CMS for bespoke websites. No database, no build step — just Markdown files and pure simplicity.</p>
                    
                    <div class="home-cta">
                        <a href="/docs" class="cta-primary">Get Started →</a>
                        <a href="https://github.com/adamgreenough/ava" class="cta-secondary" target="_blank" rel="noopener">View on GitHub</a>
                    </div>
                    
                    <div class="home-features">
                        <a href="/docs/content" class="home-feature">
                            <div class="home-feature-icon">📁</div>
                            <div class="home-feature-title">No Database</div>
                            <div class="home-feature-desc">Just Markdown files</div>
                        </a>
                        <a href="/docs/hosting" class="home-feature">
                            <div class="home-feature-icon">⚡</div>
                            <div class="home-feature-title">No Build Step</div>
                            <div class="home-feature-desc">Edit and refresh</div>
                        </a>
                        <a href="/docs/theming" class="home-feature">
                            <div class="home-feature-icon">🎨</div>
                            <div class="home-feature-title">Easy Theming</div>
                            <div class="home-feature-desc">HTML + PHP</div>
                        </a>
                        <a href="/docs/configuration" class="home-feature">
                            <div class="home-feature-icon">🧩</div>
                            <div class="home-feature-title">Any Content</div>
                            <div class="home-feature-desc">Blogs, wikis, more</div>
                        </a>
                        <a href="/docs/routing" class="home-feature">
                            <div class="home-feature-icon">🛣️</div>
                            <div class="home-feature-title">Auto Routing</div>
                            <div class="home-feature-desc">Smart URLs</div>
                        </a>
                        <a href="/docs/bundled-plugins" class="home-feature">
                            <div class="home-feature-icon">🔍</div>
                            <div class="home-feature-title">SEO Ready</div>
                            <div class="home-feature-desc">Sitemaps built-in</div>
                        </a>
                        <a href="/docs/performance" class="home-feature">
                            <div class="home-feature-icon">🚀</div>
                            <div class="home-feature-title">Blazing Fast</div>
                            <div class="home-feature-desc">Smart caching</div>
                        </a>
                        <a href="/docs/creating-plugins" class="home-feature">
                            <div class="home-feature-icon">🔌</div>
                            <div class="home-feature-title">Extensible</div>
                            <div class="home-feature-desc">Simple plugins</div>
                        </a>
                    </div>
                </div>
            </div>

<?= $ava->partial('footer', ['showToc' => $showToc, 'isHomepage' => true]) ?>
