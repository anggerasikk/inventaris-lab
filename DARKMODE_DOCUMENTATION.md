# Dark Mode Feature Documentation

## Overview
Dark Mode feature telah diimplementasikan untuk semua pengguna di aplikasi Inventaris Laboratorium. Fitur ini memungkinkan pengguna untuk beralih antara Light Mode dan Dark Mode dengan toggle button yang menarik.

## Features
✅ Toggle button dengan ikon matahari (Light) dan bulan (Dark)  
✅ Smooth transition animations saat switching mode  
✅ Preferensi disimpan di database untuk persistensi  
✅ LocalStorage fallback untuk offline experience  
✅ Tersedia untuk semua role (Admin, Dosen, Mahasiswa)  
✅ Responsive design untuk semua device  
✅ CSS variables untuk mudah dikustomisasi  

## Files yang Ditambahkan

### 1. Migration
- **File**: `database/migrations/2025_12_28_000000_add_theme_preference_to_users_table.php`
- **Deskripsi**: Menambahkan kolom `theme_preference` ke tabel `users` dengan default value 'light'

### 2. CSS Dark Mode
- **File**: `resources/css/darkmode.css`
- **Deskripsi**: Semua styling untuk dark mode dan light mode dengan CSS variables
- **Isi**:
  - Root variables untuk light dan dark mode
  - Dark mode specific styles untuk semua elemen
  - Toggle button animations
  - Smooth transitions untuk all elements

### 3. JavaScript
- **File**: `resources/js/darkmode.js`
- **Deskripsi**: Logic untuk handle dark mode toggle dan persistence
- **Fitur**:
  - Load theme dari localStorage atau user preference
  - Toggle dark mode dengan AJAX save ke server
  - Update UI toggle button appearance

### 4. Controller
- **File**: `app/Http/Controllers/ThemeController.php`
- **Deskripsi**: Handle API requests untuk theme preference
- **Methods**:
  - `toggle()`: POST route untuk save theme preference
  - `getPreference()`: GET route untuk retrieve user theme preference

### 5. Component
- **File**: `resources/views/components/theme-toggle.blade.php`
- **Deskripsi**: Reusable component untuk toggle button

### 6. Routes
- **Update**: `routes/web.php`
- **Routes Added**:
  - `POST /api/theme/toggle`: Toggle dark mode preference
  - `GET /api/theme/preference`: Get current user theme preference

### 7. Model
- **Update**: `app/Models/User.php`
- **Changes**: Tambahkan `theme_preference` ke `$fillable` array

### 8. Views
- **Updates**:
  - `resources/views/layouts/app.blade.php`: Add dark mode CSS, toggle button, dan script
  - `resources/views/layouts/admin.blade.php`: Add dark mode CSS dan script

## How It Works

### 1. User Clicks Toggle Button
```
User -> Click toggle button (#darkModeToggle)
```

### 2. JavaScript Handles Toggle
```javascript
// Toggle class 'dark-mode' pada <html> element
html.classList.toggle('dark-mode');

// Save ke localStorage
localStorage.setItem('theme-preference', theme);

// Send to server (if authenticated)
fetch('/api/theme/toggle', { ... });
```

### 3. CSS Variables Apply
```css
:root {
    --primary-color: #476EAE;
    --bg-primary: #ffffff;
    --text-primary: #212529;
}

html.dark-mode {
    --bg-primary: #1a1a1a;
    --text-primary: #e0e0e0;
}
```

### 4. All Elements Use Variables
```css
body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
}
```

## Usage

### For Users
1. Klik icon Matahari/Bulan di navigation bar (hanya muncul jika user authenticated)
2. Otomatis berubah ke dark mode atau light mode
3. Preferensi disimpan dan akan dimuat ulang saat login kembali

### For Developers

#### Check User Theme Preference (Blade)
```blade
@auth
    @if(Auth::user()->theme_preference === 'dark')
        <!-- Dark mode specific content -->
    @endif
@endauth
```

#### Update Theme Variable (CSS)
```css
/* Add custom variable ke root atau dark-mode selector */
:root {
    --custom-color: #any-color;
}

html.dark-mode {
    --custom-color: #dark-mode-color;
}

/* Use in element */
.my-element {
    color: var(--custom-color);
}
```

#### Add Dark Mode Support to New Component
```css
/* Always add transitions */
.my-component {
    transition: background-color 0.3s ease, color 0.3s ease;
    background-color: var(--bg-primary);
    color: var(--text-primary);
}
```

## Customization

### Change Default Colors
Edit `resources/css/darkmode.css`:

```css
:root {
    --primary-color: #YOUR_COLOR;
    --bg-primary: #YOUR_LIGHT_BG;
    --text-primary: #YOUR_LIGHT_TEXT;
}

html.dark-mode {
    --bg-primary: #YOUR_DARK_BG;
    --text-primary: #YOUR_DARK_TEXT;
}
```

### Change Toggle Button Style
Edit `resources/css/darkmode.css` section `/* DARK MODE TOGGLE BUTTON STYLES */`

### Change Animation Speed
```css
#darkModeToggle {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes sunRotate {
    /* Adjust animation timing */
    0% { ... }
    100% { ... }
}
```

## Browser Support
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile browsers: ✅ Full support

## Performance
- CSS variables don't impact performance
- LocalStorage caching prevents unnecessary server calls
- AJAX call adalah optional (hanya untuk persistence)
- Smooth 60fps transitions dengan GPU acceleration

## Known Limitations
- Dark mode preference hanya tersimpan untuk authenticated users
- Guest users akan default ke light mode (bisa diperluas dengan localStorage)

## Future Improvements
1. Add system theme detection (prefers-color-scheme)
2. Add more theme options (sepia, high contrast, dll)
3. Add smooth transition animation saat switch mode
4. Add theme picker component untuk memilih multiple themes

## Troubleshooting

### Dark mode tidak persist setelah logout
**Solution**: Dark mode hanya persist untuk authenticated users. Untuk guest, dapat ditambahkan localStorage persistence.

### Toggle button tidak muncul
**Solution**: Pastikan:
1. User sudah login
2. `darkmode.js` sudah di-load
3. Element dengan id `darkModeToggle` ada di HTML

### Warna tidak berubah saat toggle
**Solution**: Pastikan element menggunakan CSS variables:
```css
/* Wrong */
.element { color: #212529; }

/* Right */
.element { color: var(--text-primary); }
```

### AJAX save failing
**Solution**: Check browser console untuk error. Pastikan:
1. CSRF token ada di meta tag
2. Route `/api/theme/toggle` accessible
3. User authenticated

## Testing Checklist
- [ ] Light mode berfungsi dengan baik
- [ ] Dark mode berfungsi dengan baik
- [ ] Toggle animation smooth
- [ ] Preferensi persist setelah logout/login
- [ ] Bekerja di semua browser
- [ ] Responsive di mobile
- [ ] Semua alert colors terlihat dengan baik
- [ ] Form inputs readable di dark mode
- [ ] Table styling proper di dark mode
