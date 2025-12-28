# Dark Mode Testing Guide

## Pre-Testing Checklist

- [ ] Application is running (`php artisan serve`)
- [ ] Database is migrated (`php artisan migrate`)
- [ ] User has at least one test account created
- [ ] Browser developer tools can be opened (F12)
- [ ] Multiple browsers available for testing

---

## Test Case 1: Basic Toggle Functionality

### Test Description
Verify that the toggle button works and switches between light and dark mode.

### Test Steps
1. Login to the application with a user account
2. Look at the navigation bar at the top
3. Find the toggle button (☀️ for light mode)
4. Click the toggle button

### Expected Results
- ✅ Page background changes from white to dark
- ✅ Text color changes from dark to light
- ✅ Card backgrounds change color
- ✅ All elements transition smoothly (not instantly)
- ✅ Icon changes from ☀️ to 🌙
- ✅ Button label changes from "Light" to "Dark"

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 2: Toggle Animation

### Test Description
Verify that the toggle animation is smooth and visually appealing.

### Test Steps
1. In light mode, observe the toggle button
2. Click the toggle button
3. Watch the icon rotation animation
4. Observe the page transition effect

### Expected Results
- ✅ Sun icon (☀️) rotates smoothly -180° → 0°
- ✅ Moon icon (🌙) rotates smoothly 180° → 0°
- ✅ Page colors transition smoothly (not instant jump)
- ✅ Animation duration appears smooth (~0.6s)
- ✅ No flickering or jumping during transition
- ✅ Animation runs at ~60fps (smooth, not choppy)

### Browser Tools Check
Open DevTools (F12) → Performance tab:
- Record animation
- Check frame rate
- Should see constant 60fps

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 3: Persistence (Database)

### Test Description
Verify that the theme preference is saved to the database and persists across sessions.

### Test Steps
1. In light mode, click toggle → switch to dark mode
2. Open Developer Tools (F12)
3. Go to Network tab
4. Click toggle again
5. Observe the POST request to `/api/theme/toggle`
6. Close the browser completely
7. Log in again with the same account

### Expected Results
- ✅ Request sent to `/api/theme/toggle`
- ✅ Response shows `{"success": true, "theme": "dark"}`
- ✅ After logout and login, dark mode is still active
- ✅ Preference is maintained across browser sessions

### Debugging Network Request
```javascript
// In browser console after clicking toggle:
fetch('/api/theme/toggle', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ theme: 'dark' })
})
.then(r => r.json())
.then(d => console.log(d))
```

### Database Check
```bash
# In Laravel Tinker:
php artisan tinker

>>> $user = Auth::user();
>>> $user->theme_preference;
// Should return 'dark' or 'light'
```

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 4: LocalStorage Persistence (Offline)

### Test Description
Verify that theme preference is cached in localStorage for offline experience.

### Test Steps
1. Open Developer Tools (F12)
2. Go to Application tab → LocalStorage
3. Click toggle to switch mode
4. Check localStorage value

### Expected Results
- ✅ `localStorage.getItem('theme-preference')` returns 'light' or 'dark'
- ✅ Value updates when toggle is clicked
- ✅ Value is immediately set (doesn't wait for server response)

### Console Commands
```javascript
// Check localStorage
localStorage.getItem('theme-preference');

// Clear localStorage
localStorage.removeItem('theme-preference');

// Watch for changes
Object.defineProperty(localStorage, 'setItem', {
    value: function(key, val) {
        console.log(`${key} = ${val}`);
    }
});
```

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 5: All Pages Support

### Test Description
Verify that dark mode works on all pages in the application.

### Test Steps
Switch to dark mode, then visit:
1. Home page (/home)
2. Items list (/items)
3. Item detail page (/items/{id})
4. Borrowing page (/borrowings/create)
5. Borrowing history (/borrowings/history)
6. Admin dashboard (/admin/dashboard) - if admin
7. Admin items (/admin/items) - if admin
8. Admin reports (/admin/reports) - if admin

### Expected Results
- ✅ All pages display in dark mode
- ✅ All elements properly styled
- ✅ No white-background elements that should be dark
- ✅ Text is readable on all pages
- ✅ No broken styling or colors

### Actual Results
```
[ ] Home           [ ] Pass  [ ] Fail
[ ] Items List     [ ] Pass  [ ] Fail
[ ] Item Detail    [ ] Pass  [ ] Fail
[ ] Borrowing      [ ] Pass  [ ] Fail
[ ] History        [ ] Pass  [ ] Fail
[ ] Admin Dash     [ ] Pass  [ ] Fail
[ ] Admin Items    [ ] Pass  [ ] Fail
[ ] Admin Reports  [ ] Pass  [ ] Fail

Notes: _________________________________
```

---

## Test Case 6: All User Roles

### Test Description
Verify that dark mode works for all user roles (Admin, Dosen, Mahasiswa).

### Test Steps
1. Create/use test accounts for each role:
   - Admin user
   - Dosen (Lecturer) user
   - Mahasiswa (Student) user
2. Login with each user
3. Verify toggle button appears
4. Verify toggle works in dark and light mode

### Test Accounts (if available)
```
Admin:      admin@inventaris.lab / password
Dosen:      dosen@inventaris.lab / password
Mahasiswa:  mahasiswa@inventaris.lab / password
```

### Expected Results
- ✅ Toggle button visible for all roles
- ✅ Toggle works for all roles
- ✅ Each role's dashboard looks good in both modes
- ✅ Role-specific elements (admin only, etc) styled correctly

### Actual Results
```
[ ] Admin     [ ] Pass  [ ] Fail
[ ] Dosen     [ ] Pass  [ ] Fail
[ ] Mahasiswa [ ] Pass  [ ] Fail

Notes: _________________________________
```

---

## Test Case 7: Responsive Design

### Test Description
Verify that dark mode works properly on different screen sizes.

### Test Steps

#### Desktop (1024px+)
1. Open at full screen width
2. Verify toggle button shows: `☀️ Light`
3. Toggle works properly

#### Tablet (768px - 1023px)
1. Resize browser to ~800px width
2. Verify toggle button shows icon only: `☀️`
3. Toggle works properly

#### Mobile (< 768px)
1. Resize browser to ~375px width (or test on phone)
2. Verify toggle button is accessible
3. Toggle works without overlapping elements

### Expected Results
- ✅ Desktop: Icon + text visible ("☀️ Light")
- ✅ Tablet: Icon only ("☀️")
- ✅ Mobile: Icon only, properly spaced
- ✅ No overlapping elements
- ✅ All buttons/links still clickable
- ✅ Text remains readable

### DevTools Responsive Testing
```
F12 → Device Toolbar (Ctrl+Shift+M)
Test at:
- iPhone 12 (390×844)
- iPad (768×1024)
- Desktop (1920×1080)
```

### Actual Results
```
[ ] Desktop (1024px+)     [ ] Pass  [ ] Fail
[ ] Tablet (768-1023px)   [ ] Pass  [ ] Fail
[ ] Mobile (< 768px)      [ ] Pass  [ ] Fail

Notes: _________________________________
```

---

## Test Case 8: Color & Contrast

### Test Description
Verify that colors are appropriate and meet accessibility standards.

### Test Steps

#### Light Mode Check
1. Switch to light mode
2. Verify text is dark and readable
3. Check contrast ratios using DevTools

#### Dark Mode Check
1. Switch to dark mode
2. Verify text is light and readable
3. No pure white text on light backgrounds
4. No pure black text on dark backgrounds

### Contrast Testing Tools
```
Windows: Use built-in accessibility color contrast analyzer
Chrome DevTools: Elements tab → Computed → Show color contrast
Manual check: Text should be easily readable at arm's length
```

### WCAG Standards
- AA Level: 4.5:1 contrast ratio for normal text
- AAA Level: 7:1 contrast ratio for normal text

### Elements to Check
- [ ] Regular paragraph text
- [ ] Headings
- [ ] Links
- [ ] Button text
- [ ] Form labels
- [ ] Alert messages
- [ ] Table headers
- [ ] Badges

### Actual Results
```
Light Mode Readability:  [ ] Good  [ ] Fair  [ ] Poor
Dark Mode Readability:   [ ] Good  [ ] Fair  [ ] Poor

Contrast Ratios:
- Heading text: ________ [ ] Meets AA  [ ] Meets AAA
- Body text:    ________ [ ] Meets AA  [ ] Meets AAA
- Links:        ________ [ ] Meets AA  [ ] Meets AAA

Notes: _________________________________
```

---

## Test Case 9: Guest User Behavior

### Test Description
Verify behavior when guest (not logged in) user visits.

### Test Steps
1. Logout from account
2. Navigate to login page
3. Verify toggle button NOT visible
4. Verify light mode is displayed

### Expected Results
- ✅ Toggle button is NOT visible for guests
- ✅ Default light mode for guest users
- ✅ No JavaScript errors in console

### Console Check
```javascript
// Should return false for guests
document.getElementById('darkModeToggle') !== null
```

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 10: Performance

### Test Description
Verify that dark mode doesn't negatively impact performance.

### Test Steps

#### Load Time
1. Open DevTools → Network tab
2. Hard refresh (Ctrl+Shift+R)
3. Check total load time
4. Check if darkmode.css and darkmode.js load quickly

#### Toggle Performance
1. Open DevTools → Performance tab
2. Click toggle button
3. Record animation
4. Verify 60fps throughout

#### CPU Usage
1. Open DevTools → Performance
2. Record while toggling
3. Check CPU usage (should be minimal)

### Expected Results
- ✅ darkmode.css: < 20KB
- ✅ darkmode.js: < 10KB
- ✅ Load time impact: < 100ms
- ✅ Toggle animation: 60fps (smooth)
- ✅ No janky frames or stuttering
- ✅ CPU usage minimal during toggle

### Performance Tools Commands
```bash
# Check file sizes
wc -c resources/css/darkmode.css
wc -c resources/js/darkmode.js

# Measure with gzip
gzip -c resources/css/darkmode.css | wc -c
gzip -c resources/js/darkmode.js | wc -c
```

### Actual Results
```
File Sizes:
- darkmode.css:  ________ KB [ ] < 20KB
- darkmode.js:   ________ KB [ ] < 10KB

Load Time Impact:  ________ ms [ ] < 100ms
Toggle FPS:        ________ fps [ ] 60fps
CPU Usage:         ________ % [ ] < 10%

Notes: _________________________________
```

---

## Test Case 11: Browser Compatibility

### Test Description
Verify dark mode works across different browsers.

### Browsers to Test
- [ ] Chrome/Chromium (latest)
- [ ] Firefox (latest)
- [ ] Safari (if on Mac/iOS)
- [ ] Edge (latest)
- [ ] Mobile Chrome
- [ ] Mobile Safari

### Test Steps (for each browser)
1. Login to application
2. Verify toggle button visible
3. Click toggle
4. Verify dark mode displays correctly
5. Check for JavaScript errors (F12 → Console)

### Expected Results
- ✅ Toggle visible and functional
- ✅ Dark mode displays correctly
- ✅ No console errors
- ✅ Colors render properly
- ✅ Animations smooth

### Browser Compatibility Chart
```
Browser             Version    Support    Notes
─────────────────────────────────────────────────
Chrome              Latest     ✅ Full
Firefox             Latest     ✅ Full
Safari              Latest     ✅ Full
Edge                Latest     ✅ Full
Mobile Chrome       Latest     ✅ Full
Mobile Safari       Latest     ✅ Full
IE 11               -          ❌ N/A    (CSS variables)
```

### Actual Results
```
[ ] Chrome        [ ] Pass  [ ] Fail  [ ] N/A
[ ] Firefox       [ ] Pass  [ ] Fail  [ ] N/A
[ ] Safari        [ ] Pass  [ ] Fail  [ ] N/A
[ ] Edge          [ ] Pass  [ ] Fail  [ ] N/A
[ ] Mobile Chrome [ ] Pass  [ ] Fail  [ ] N/A
[ ] Mobile Safari [ ] Pass  [ ] Fail  [ ] N/A

Notes: _________________________________
```

---

## Test Case 12: Error Scenarios

### Test Description
Verify proper handling of error conditions.

### Test Scenarios

#### Network Error (API fails)
1. Open DevTools → Network tab
2. Toggle mode to dark
3. Quickly disable network (right-click in Network tab → Offline)
4. Toggle back to light mode
5. Re-enable network

Expected:
- ✅ Toggle still works (uses localStorage)
- ✅ Theme changes visually
- ✅ No error messages displayed
- ✅ AJAX failure logged to console but not breaking

#### Missing CSRF Token
1. Open Console and delete CSRF token:
   ```javascript
   document.querySelector('meta[name="csrf-token"]').remove();
   ```
2. Try to toggle mode

Expected:
- ✅ Theme still changes visually (localStorage)
- ✅ AJAX call might fail (but doesn't break UI)
- ✅ See error in console (expected)

#### Disabled JavaScript
1. Open DevTools → Settings → Disable JavaScript
2. Try to toggle

Expected:
- ✅ Toggle button still clickable
- ✅ Nothing happens (no JavaScript)
- ✅ No fatal errors

### Actual Results
```
Network Error:         [ ] Pass  [ ] Fail
Missing CSRF Token:    [ ] Pass  [ ] Fail
Disabled JavaScript:   [ ] Pass  [ ] Fail

Notes: _________________________________
```

---

## Test Case 13: LocalStorage Clearing

### Test Description
Verify behavior when localStorage is cleared.

### Test Steps
1. Switch to dark mode
2. Open DevTools → Application → LocalStorage
3. Delete `theme-preference` entry
4. Refresh page

### Expected Results
- ✅ Falls back to user preference from database
- ✅ If database has no preference, defaults to 'light'
- ✅ No errors or broken state

### Console Commands
```javascript
// Clear localStorage
localStorage.clear();

// Or specific key
localStorage.removeItem('theme-preference');

// Then refresh
location.reload();
```

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Test Case 14: Multiple Tabs

### Test Description
Verify that toggling in one tab affects other tabs.

### Test Steps
1. Open application in Tab 1 (light mode)
2. Open application in Tab 2
3. In Tab 1, toggle to dark mode
4. Observe Tab 2

### Expected Results
- ✅ Database is updated (persisted)
- ✅ Tab 2 shows light mode (hasn't refreshed)
- ✅ When Tab 2 is refreshed, shows dark mode
- OR: Both tabs sync immediately (depends on implementation)

### Actual Results
```
[ ] Pass  [ ] Fail  [ ] Partial

Notes: _________________________________
```

---

## Summary Report

### Overall Results
```
Total Test Cases:  14
Passed:            __
Failed:            __
Partial:           __
Success Rate:      __%
```

### Critical Issues Found
```
1. _________________________________
2. _________________________________
3. _________________________________
```

### Minor Issues Found
```
1. _________________________________
2. _________________________________
3. _________________________________
```

### Notes & Recommendations
```
_______________________________________
_______________________________________
_______________________________________
```

### Approval
```
Tested by:        ________________
Date:             ________________
Status:           [ ] Approved [ ] Needs Fix [ ] Blocked

Sign-off:         ________________
```

---

## Quick Test Checklist (TL;DR)

Run through these quickly:

- [ ] Toggle button visible when logged in
- [ ] Toggle button works (light ↔ dark)
- [ ] Animation is smooth
- [ ] Preference persists after logout/login
- [ ] Works on mobile, tablet, desktop
- [ ] Works for admin, dosen, mahasiswa
- [ ] Text readable in both modes
- [ ] All pages styled correctly
- [ ] No console errors
- [ ] Works in Chrome, Firefox, Safari

---

**Testing Complete! Mark the results above and attach this form to your QA report.** ✅

For detailed test failures, provide:
1. Browser name and version
2. Screenshot of issue
3. Steps to reproduce
4. Expected vs actual result
5. Browser console output (if JavaScript error)
