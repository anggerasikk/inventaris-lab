// Dark Mode Toggle Script
document.addEventListener('DOMContentLoaded', function() {
    const toggles = Array.from(document.querySelectorAll('.dark-mode-toggle'));
    const html = document.documentElement;

    // Load theme preference from localStorage or server
    function loadTheme() {
        const userTheme = document.querySelector('meta[name="user-theme"]')?.getAttribute('content');
        const savedTheme = localStorage.getItem('theme-preference') || userTheme || 'light';

        const isDark = savedTheme === 'dark';
        if (isDark) html.classList.add('dark-mode'); else html.classList.remove('dark-mode');
        updateAllToggles(isDark);
    }

    // Update single toggle appearance
    function updateToggleElement(toggleEl, isDark) {
        const icon = toggleEl.querySelector('i');
        const label = toggleEl.querySelector('span');
        if (isDark) {
            toggleEl.classList.add('dark');
            if (icon) icon.className = 'fas fa-moon toggle-icon';
            if (label) label.textContent = 'Dark';
            toggleEl.setAttribute('aria-pressed', 'true');
        } else {
            toggleEl.classList.remove('dark');
            if (icon) icon.className = 'fas fa-sun toggle-icon';
            if (label) label.textContent = 'Light';
            toggleEl.setAttribute('aria-pressed', 'false');
        }
    }

    // Update all toggles
    function updateAllToggles(isDark) {
        toggles.forEach(function(btn) {
            updateToggleElement(btn, isDark);
        });
    }

    // Handler for toggle clicks
    function onToggleClick(e) {
        e.preventDefault();
        const isDark = html.classList.toggle('dark-mode');
        const theme = isDark ? 'dark' : 'light';

        localStorage.setItem('theme-preference', theme);
        updateAllToggles(isDark);

        if (document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true') {
            fetch('/api/theme/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ theme: theme })
            }).catch(err => console.log('Theme save failed:', err));
        }
    }

    // Attach listeners to all found toggles
    toggles.forEach(function(toggleEl) {
        // ensure button type
        if (toggleEl.tagName.toLowerCase() === 'button') toggleEl.type = 'button';
        toggleEl.addEventListener('click', onToggleClick);
        toggleEl.addEventListener('keydown', function(ev) {
            if (ev.key === 'Enter' || ev.key === ' ') {
                ev.preventDefault();
                onToggleClick(ev);
            }
        });
    });

    // Load theme on page load
    loadTheme();
});
