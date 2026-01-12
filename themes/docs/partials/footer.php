<?php
/**
 * Footer Partial - Docs Theme
 * 
 * This partial closes the main content area and includes scripts.
 * 
 * @see https://ava.addy.zone/docs/themes#partials
 */

$showToc = $showToc ?? false;
$isHomepage = $isHomepage ?? false;
?>
            <footer class="docs-footer<?= $isHomepage ? ' home-footer' : '' ?>">
                <div class="footer-content">
                    <span>Made with 💖 & ☕ by <a href="https://addy.zone/" target="_blank" rel="noopener">Addy</a>. Powered by <a href="https://ava.addy.zone/" target="_blank" rel="noopener">Ava</a> (so meta).</span>
                    <div class="footer-links">
                        <a href="https://github.com/adamgreenough/ava" target="_blank" rel="noopener">GitHub</a>
                        <a href="https://github.com/adamgreenough/ava/blob/main/LICENSE" target="_blank" rel="noopener">License</a>
                        <a href="https://ko-fi.com/addycodes" target="_blank" rel="noopener">Ko-fi</a>
                        <a href="https://discord.gg/fZwW4jBVh5" target="_blank" rel="noopener">Discord</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Search Overlay -->
    <div id="search-overlay" class="search-overlay" aria-hidden="true">
        <div class="search-overlay-content">
            <div class="search-overlay-header">
                <svg class="search-icon" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input 
                    type="text" 
                    id="search-overlay-input" 
                    placeholder="Search documentation..."
                    autocomplete="off"
                    spellcheck="false"
                >
                <kbd class="search-shortcut">ESC</kbd>
            </div>
            <div id="search-overlay-results" class="search-overlay-results">
                <div class="search-hint">Start typing to search...</div>
            </div>
            <div class="search-overlay-footer">
                <div class="search-hint">
                    <kbd>↑</kbd> <kbd>↓</kbd> to navigate
                    <kbd>↵</kbd> to select
                    <kbd>ESC</kbd> to close
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/prismjs@1/components/prism-core.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="<?= $ava->asset('instantpage.js') ?>"></script>

    <script>
    // Theme toggle functionality
    (function() {
        const themeToggle = document.querySelector('.theme-toggle');
        if (!themeToggle) return;
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    })();
    
    // Mobile sidebar toggle
    (function() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.sidebar:not(.mobile-nav-only)') || document.querySelector('.sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');
        
        if (!sidebarToggle || !sidebar) return;
        
        function toggleSidebar(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('open');
            backdrop?.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }
        
        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarToggle.addEventListener('touchend', toggleSidebar);
        
        // Close sidebar when clicking backdrop
        backdrop?.addEventListener('click', function() {
            sidebar.classList.remove('open');
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Close sidebar when clicking a link (mobile)
        document.querySelectorAll('.sidebar-nav a, .sidebar-mobile-nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('open');
                    backdrop?.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                backdrop?.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    })();

    <?php if ($showToc): ?>
    // Build Table of Contents from headings
    (function() {
        const tocList = document.getElementById('toc-list');
        const article = document.querySelector('.markdown-section');
        
        if (!tocList || !article) return;
        
        // Only include h2 headings with IDs (auto-generated IDs start with content-)
        const headings = article.querySelectorAll('h2[id]');

        if (headings.length < 2) {
            // Hide TOC if fewer than 2 headings
            const tocSidebar = document.getElementById('toc-sidebar');
            if (tocSidebar) tocSidebar.style.display = 'none';
            return;
        }
        
        headings.forEach(heading => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = '#' + heading.id;
            a.textContent = heading.textContent;
            a.dataset.level = '2';
            li.appendChild(a);
            tocList.appendChild(li);
        });
        
        // Highlight current section on scroll
        const tocLinks = tocList.querySelectorAll('a');
        
        function updateActiveLink() {
            const scrollPos = window.scrollY + 100;
            let current = null;
            
            headings.forEach(heading => {
                if (heading.offsetTop <= scrollPos) {
                    current = heading;
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (current && link.getAttribute('href') === '#' + current.id) {
                    link.classList.add('active');
                }
            });
        }
        
        window.addEventListener('scroll', updateActiveLink, { passive: true });
        updateActiveLink();
    })();
    <?php endif; ?>
    
    // Global Search Overlay with auto-search
    (function() {
        const overlay = document.getElementById('search-overlay');
        const input = document.getElementById('search-overlay-input');
        const results = document.getElementById('search-overlay-results');
        const searchButton = document.getElementById('search-button');
        
        if (!overlay || !input || !results) return;
        
        let searchTimeout;
        let selectedIndex = -1;
        let isInitialized = false;
        
        // Open search with button click
        if (searchButton) {
            searchButton.addEventListener('click', (e) => {
                e.preventDefault();
                openSearch();
            });
        }
        
        // Open search with Cmd/Ctrl+K
        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeSearch();
            }
        });
        
        // Click overlay background to close
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeSearch();
        });
        
        function openSearch() {
            // Mark as initialized to enable transitions
            if (!isInitialized) {
                isInitialized = true;
                overlay.classList.add('initialized');
            }
            overlay.classList.add('active');
            overlay.setAttribute('aria-hidden', 'false');
            input.focus();
            document.body.style.overflow = 'hidden';
        }
        
        function closeSearch() {
            overlay.classList.remove('active');
            overlay.setAttribute('aria-hidden', 'true');
            input.value = '';
            results.innerHTML = '<div class="search-hint">Start typing to search...</div>';
            selectedIndex = -1;
            document.body.style.overflow = '';
        }
        
        // Auto-search on input with debounce (300ms cooldown)
        input.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            const query = input.value.trim();
            
            if (query.length < 3) {
                results.innerHTML = '<div class="search-hint">Type at least 3 characters to search...</div>';
                return;
            }
            
            results.innerHTML = '<div class="search-hint">Searching...</div>';
            searchTimeout = setTimeout(performSearch, 300);
        });
        
        function performSearch() {
            const query = input.value.trim();
            
            if (query.length < 3) {
                results.innerHTML = '<div class="search-hint">Type at least 3 characters to search...</div>';
                return;
            }
            
            fetch(`/search.json?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(displayResults)
                .catch(() => {
                    results.innerHTML = '<div class="search-hint">Search unavailable</div>';
                });
        }
        
        function displayResults(data) {
            selectedIndex = -1;
            
            if (!data.items || data.items.length === 0) {
                results.innerHTML = '<div class="search-hint">No results found</div>';
                return;
            }
            
            const html = data.items.map((item, i) => `
                <a href="${escapeHtml(item.url)}" class="search-result" data-index="${i}">
                    <div class="search-result-title">${escapeHtml(item.title)}</div>
                    <div class="search-result-meta">${escapeHtml(item.type)}</div>
                    ${item.excerpt ? `<div class="search-result-excerpt">${escapeHtml(item.excerpt)}</div>` : ''}
                </a>
            `).join('');
            
            results.innerHTML = html;
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Keyboard navigation
        input.addEventListener('keydown', (e) => {
            const items = results.querySelectorAll('.search-result');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                updateSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, -1);
                updateSelection(items);
            } else if (e.key === 'Enter' && selectedIndex >= 0 && items[selectedIndex]) {
                e.preventDefault();
                items[selectedIndex].click();
            }
        });
        
        function updateSelection(items) {
            items.forEach((item, i) => {
                item.classList.toggle('selected', i === selectedIndex);
            });
            if (selectedIndex >= 0 && items[selectedIndex]) {
                items[selectedIndex].scrollIntoView({ block: 'nearest' });
            }
        }
    })();
    </script>
</body>
</html>
