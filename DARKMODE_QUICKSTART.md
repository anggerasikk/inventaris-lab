# Quick Start Guide - Dark Mode Feature

## 🚀 Installation Complete!

Dark mode feature sudah siap digunakan. Berikut adalah hal-hal yang sudah diimplementasikan:

## ✅ Yang Sudah Selesai

### 1. **Database Migration**
```bash
php artisan migrate
```
✅ Kolom `theme_preference` sudah ditambahkan ke tabel `users`

### 2. **Frontend Assets**
✅ CSS dark mode: `resources/css/darkmode.css`
✅ JavaScript logic: `resources/js/darkmode.js`
✅ Component toggle: `resources/views/components/theme-toggle.blade.php`

### 3. **Backend**
✅ Theme Controller: `app/Http/Controllers/ThemeController.php`
✅ API Routes untuk theme toggle dan preference
✅ User Model updated dengan `theme_preference` fillable

### 4. **Layout Integration**
✅ Main layout (app.blade.php) - dengan toggle button di navbar
✅ Admin layout (admin.blade.php) - dengan dark mode support

## 🎯 How to Use

### For End Users:
1. Login ke aplikasi
2. Lihat navbar atas, ada icon matahari ☀️ (light mode) atau bulan 🌙 (dark mode)
3. Klik untuk toggle antara light dan dark mode
4. Pilihan akan otomatis tersimpan dan dimuat saat login kembali

### Features:
- **Smooth Animation**: Toggle icon beranimasi saat switching
- **Persistent**: Preferensi tersimpan di database
- **All Pages**: Dark mode tersedia di semua halaman
- **All Roles**: Admin, Dosen, dan Mahasiswa bisa menggunakan

## 📝 Customization

### Mengubah Warna Dark Mode

Edit file `resources/css/darkmode.css`:

```css
/* Cari section :root dan html.dark-mode */
html.dark-mode {
    --bg-primary: #1a1a1a;        /* Background utama */
    --bg-secondary: #2d2d2d;      /* Background card */
    --text-primary: #e0e0e0;      /* Text utama */
    --text-secondary: #b0b0b0;    /* Text secondary */
}
```

### Mengubah Warna Light Mode

```css
:root {
    --bg-primary: #ffffff;        /* Background utama */
    --bg-secondary: #f8f9fa;      /* Background secondary */
    --text-primary: #212529;      /* Text utama */
    --text-secondary: #6c757d;    /* Text secondary */
}
```

### Mengubah Animasi Toggle

```css
#darkModeToggle {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Ubah durasi di sini */
}

@keyframes sunRotate {
    0% { transform: rotate(-180deg); }  /* Ubah sudut rotasi */
    100% { transform: rotate(0deg); }
}
```

## 🎨 Toggle Button Styling

Toggle button sudah termasuk:
- **Icon**: Matahari (☀️) untuk light, Bulan (🌙) untuk dark
- **Animation**: Smooth rotation saat toggle
- **Hover Effect**: Slight background change dan scale up
- **Position**: Di navbar kanan, sebelum user dropdown

Styling ada di `resources/css/darkmode.css` bagian:
```css
/* ===== DARK MODE TOGGLE BUTTON STYLES ===== */
```

## 🔧 API Endpoints

Jika ingin menggunakan API directly:

### Toggle Dark Mode
```bash
POST /api/theme/toggle
Headers: 
  - Content-Type: application/json
  - X-CSRF-TOKEN: {csrf_token}
Body:
  {
    "theme": "dark"  // atau "light"
  }
```

### Get User Theme Preference
```bash
GET /api/theme/preference
Response:
  {
    "theme": "dark"  // atau "light"
  }
```

## 📱 Responsive Design

Toggle button responsive:
- **Desktop**: Menampilkan icon + text ("Light" atau "Dark")
- **Tablet**: Menampilkan icon saja
- **Mobile**: Compact view dengan icon saja

```css
/* Di mobile (d-none d-lg-inline) hanya text yang disembunyikan */
#darkModeToggle span {
    display: none; /* Di mobile */
}

@media (min-width: 992px) {
    #darkModeToggle span {
        display: inline; /* Di desktop */
    }
}
```

## 🧪 Testing

Untuk testing dark mode:

1. **Manual Testing**:
   - Login sebagai user apapun (admin, dosen, mahasiswa)
   - Klik toggle button di navbar
   - Verifikasi semua elemen berubah warna dengan smooth
   - Logout dan login kembali - preferensi harus tersimpan

2. **Browser Console Testing**:
   ```javascript
   // Check current theme
   document.documentElement.classList.contains('dark-mode');
   
   // Check localStorage
   localStorage.getItem('theme-preference');
   
   // Check user theme in DB
   // Login sebagai user, buka developer tools > Network
   // Klik toggle button, lihat request POST ke /api/theme/toggle
   ```

3. **Visual Testing**:
   - Pastikan text readable di dark mode
   - Pastikan contrast ratio cukup (WCAG AA standard)
   - Test di berbagai browser (Chrome, Firefox, Safari)

## 🐛 Troubleshooting

### Toggle button tidak muncul?
- Pastikan user sudah login
- Check console untuk error
- Pastikan `darkmode.js` di-load

### Dark mode tidak bekerja?
- Clear browser cache
- Check console untuk JavaScript errors
- Pastikan `darkmode.css` di-link di HTML

### Warna terlihat aneh di dark mode?
- Element mungkin tidak pakai CSS variables
- Ubah `.your-element` untuk pakai `var(--text-primary)` dll

### Preferensi tidak tersimpan?
- Check Database jika `theme_preference` ada
- Check Network tab jika AJAX request berhasil
- Cek error log Laravel

## 📚 File Structure

```
inventaris-lab/
├── resources/
│   ├── css/
│   │   └── darkmode.css          ← Dark mode styles
│   ├── js/
│   │   └── darkmode.js           ← Dark mode logic
│   └── views/
│       ├── components/
│       │   └── theme-toggle.blade.php  ← Toggle button
│       └── layouts/
│           ├── app.blade.php     ← Updated dengan dark mode
│           └── admin.blade.php   ← Updated dengan dark mode
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ThemeController.php    ← Theme API
│   └── Models/
│       └── User.php              ← Updated fillable
│
├── database/
│   └── migrations/
│       └── 2025_12_28_000000_add_theme_preference_to_users_table.php
│
└── routes/
    └── web.php                   ← Updated dengan theme routes
```

## 🎓 Developer Notes

### Menambahkan Dark Mode ke Komponen Baru

```blade
{{-- Component --}}
<div class="my-component">
    ...
</div>

{{-- CSS --}}
<style>
    .my-component {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        border-color: var(--border-color);
        transition: background-color 0.3s ease, color 0.3s ease;
    }
</style>
```

### Menambahkan Conditional Dark Mode Styles

```css
/* Light mode */
.my-component {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Dark mode */
html.dark-mode .my-component {
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}
```

## ✨ Next Steps (Optional)

Untuk enhancement lebih lanjut:

1. **System Theme Detection**:
   ```javascript
   // Detect system preference
   if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
       // Set dark mode by default
   }
   ```

2. **Theme Selector**:
   - Tambah lebih banyak tema (sepia, high contrast, etc)
   - Buat theme picker UI

3. **Animations**:
   - Add more sophisticated transition effects
   - Particle effects saat toggle

4. **Analytics**:
   - Track theme preference of users
   - Analyze usage patterns

## ❓ FAQ

**Q: Apakah dark mode tersedia untuk guest?**
A: Saat ini hanya untuk authenticated users. Bisa diperluas dengan localStorage.

**Q: Bagaimana dengan performance?**
A: CSS variables tidak impact performance. AJAX call adalah optional.

**Q: Bisa disable dark mode?**
A: Ya, remove toggle button dari component dan CSS variables akan tetap di light mode.

**Q: Supported di IE11?**
A: Tidak. Requires modern browser (Chrome, Firefox, Safari, Edge)

---

**Enjoy your new Dark Mode Feature! 🌙☀️**

Untuk questions atau issues, lihat DARKMODE_DOCUMENTATION.md untuk detail lebih lanjut.
