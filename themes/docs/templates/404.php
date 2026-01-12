<?php
/**
 * 404 Error Template - Docs Theme
 * 
 * This template is displayed when a URL doesn't match any content or route.
 * 
 * Available variables:
 *   $request - The HTTP request object
 *   $ava     - Template helper
 *   $site    - Site configuration array
 * 
 * @see https://ava.addy.zone/docs/themes#error-templates
 */
?>
<?= $ava->partial('header', ['request' => $request, 'pageTitle' => 'Page Not Found | Ava CMS']) ?>

                <article class="markdown-section">
                    <h1>404 - Page Not Found</h1>
                    <p>Sorry, the page you're looking for doesn't exist.</p>
                    <p><a href="/docs">← Back to Documentation</a></p>
                </article>

<?= $ava->partial('footer') ?>
