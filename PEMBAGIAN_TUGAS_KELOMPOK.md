# 🎨 PEMBAGIAN TUGAS KELOMPOK - UI/UX DESIGNER
**Project:** Sistem Informasi Klinik  
**Fokus:** User Interface & User Experience Design  
**Tanggal:** 3 Desember 2025  
**Ketua Kelompok:** [Nama Ketua]

---

## 🎯 OBJEKTIF UTAMA

> [!IMPORTANT]
> **FOKUS PADA UI/UX DESIGN**
> - Memperbaiki tampilan visual (colors, typography, spacing, layout)
> - Meningkatkan user experience (ease of use, navigation, feedback)
> - Membuat design system yang konsisten
> - Responsive design untuk semua device
> - **HANYA mengubah file `.blade.php`** - TIDAK mengubah logic/backend

---

## 🎨 DESIGN SYSTEM YANG HARUS DITERAPKAN

### Color Palette
```css
Primary:   #3B82F6 (Blue)
Secondary: #8B5CF6 (Purple)
Success:   #10B981 (Green)
Warning:   #F59E0B (Orange)
Danger:    #EF4444 (Red)
Info:      #06B6D4 (Cyan)

Background: #F9FAFB (Light Gray)
Surface:    #FFFFFF (White)
Text:       #111827 (Dark Gray)
Muted:      #6B7280 (Gray)
```

### Typography
```css
Heading 1: 2.5rem (40px) - Bold
Heading 2: 2rem (32px) - Bold
Heading 3: 1.5rem (24px) - Semibold
Body:      1rem (16px) - Regular
Small:     0.875rem (14px) - Regular
```

### Spacing Scale
```css
xs:  4px
sm:  8px
md:  16px
lg:  24px
xl:  32px
2xl: 48px
```

### Border Radius
```css
Small:  4px (buttons, inputs)
Medium: 8px (cards)
Large:  12px (modals)
Round:  9999px (badges, avatars)
```

---

## 👥 ANGGOTA 1: UI/UX DASHBOARD & MASTER DATA
**Nama:** _________________  
**Fokus:** Dashboard Analytics & Data Management Interface

### 📂 Modul yang Dikerjakan:

#### 1️⃣ Dashboard (2 files)
**Files:**
- `resources/views/dashboard.blade.php`
- `resources/views/dashboard/_card_details.blade.php`

**UI/UX Tasks:**
- [ ] **Hero Section**: Redesign welcome banner dengan gradient background
- [ ] **Statistics Cards**: 
  - Card dengan icon, angka besar, dan trend indicator (↑↓)
  - Shadow dan hover effect yang smooth
  - Color coding sesuai kategori (pasien=blue, kunjungan=green, dll)
- [ ] **Charts & Graphs**: 
  - Placeholder untuk chart yang menarik
  - Legend yang jelas
  - Responsive chart container
- [ ] **Quick Actions**: 
  - Button grid dengan icon dan label
  - Hover effect yang interaktif
  - Spacing yang proporsional
- [ ] **Recent Activities**: 
  - Timeline design yang modern
  - Avatar/icon untuk setiap activity
  - Timestamp yang readable

**Design Reference:**
- Modern admin dashboard (Tailwind UI, Material Dashboard)
- Card-based layout dengan white space yang cukup
- Data visualization yang clear

---

#### 2️⃣ Master Data (17 files)
**Files:**
- `Master/aktivasi-poli.blade.php`
- `Master/diagnosa.blade.php`
- `Master/hak-akses.blade.php`
- `Master/jadwal-poli.blade.php`
- `Master/jenis-pembayaran.blade.php`
- `Master/kamar-rawat-inap.blade.php`
- `Master/kategori-diagnosa.blade.php`
- `Master/keadaan-akhir.blade.php`
- `Master/menu.blade.php`
- `Master/mitra.blade.php`
- `Master/pegawai.blade.php`
- `Master/profesi.blade.php`
- `Master/resep-info.blade.php`
- `Master/rs-rujukan.blade.php`
- `Master/tindakan-laborat.blade.php`
- `Master/unit.blade.php`
- `Master/vendor.blade.php`
- `master-data/icd10/index.blade.php`

**UI/UX Tasks:**
- [ ] **Data Tables**: 
  - Header dengan background color
  - Striped rows untuk readability
  - Hover effect pada rows
  - Sticky header saat scroll
  - Pagination yang jelas
  - Search box dengan icon
  - Filter dropdown yang user-friendly
- [ ] **Action Buttons**: 
  - Icon buttons (Edit=pencil, Delete=trash, View=eye)
  - Tooltip on hover
  - Color coding (edit=blue, delete=red, view=green)
  - Consistent sizing
- [ ] **Forms (Add/Edit)**: 
  - Label yang jelas di atas input
  - Input dengan border dan focus state
  - Required field indicator (*)
  - Placeholder text yang helpful
  - Submit button yang prominent
  - Cancel button yang subtle
- [ ] **Empty State**: 
  - Illustration atau icon besar
  - Pesan yang friendly
  - CTA button untuk add data
- [ ] **Loading State**: 
  - Skeleton loader atau spinner
  - Disable buttons saat loading

**Design Consistency:**
- Semua 17 halaman harus punya struktur yang SAMA
- Template yang bisa di-reuse
- Spacing dan sizing yang konsisten

**Total: 19 files**

---

## 👥 ANGGOTA 2: UI/UX PASIEN & PENDAFTARAN
**Nama:** _________________  
**Fokus:** Patient Registration & Management Interface

### 📂 Modul yang Dikerjakan:

#### 1️⃣ Pasien (9 files)
**Files:**
- `pasien/cetak.blade.php`
- `pasien/create.blade.php`
- `pasien/data.blade.php`
- `pasien/edit.blade.php`
- `pasien/kontrol.blade.php`
- `pasien/master.blade.php`
- `pasien/pencarian.blade.php`
- `pasien/show.blade.php`
- `pasien/verifikasi.blade.php`

**UI/UX Tasks:**
- [ ] **Form Pendaftaran Pasien (create.blade.php)**:
  - Multi-step wizard dengan progress indicator
  - Step 1: Data Pribadi
  - Step 2: Alamat & Kontak
  - Step 3: Data Kesehatan
  - Navigation buttons (Previous, Next, Submit)
  - Visual feedback untuk step yang sudah selesai
- [ ] **Data Pasien (data.blade.php)**:
  - Card-based patient list
  - Avatar/photo placeholder
  - Key info visible (nama, no. RM, umur)
  - Quick action buttons
  - Filter by status (aktif, non-aktif)
- [ ] **Pencarian Pasien (pencarian.blade.php)**:
  - Search bar yang prominent
  - Filter options (by nama, no. RM, NIK, tanggal lahir)
  - Search results dengan highlighting
  - "No results" state yang helpful
- [ ] **Detail Pasien (show.blade.php)**:
  - Header dengan foto dan info utama
  - Tabs untuk sections (Info Pribadi, Riwayat, Dokumen)
  - Timeline riwayat kunjungan
  - Print-friendly layout
- [ ] **Cetak Kartu (cetak.blade.php)**:
  - Print layout (A4 atau kartu)
  - QR code placeholder
  - Logo klinik
  - Info pasien yang terstruktur
  - CSS print media query

**Design Focus:**
- User-friendly untuk staff admin
- Clear visual hierarchy
- Easy navigation between patient records

---

#### 2️⃣ Pendaftaran (8 files)
**Files:**
- `pendaftaran/bpjs.blade.php`
- `pendaftaran/create.blade.php`
- `pendaftaran/index.blade.php`
- `pendaftaran/kontrol.blade.php`
- `pendaftaran/lama.blade.php`
- `pendaftaran/pasien-baru.blade.php`
- `pendaftaran/show.blade.php`
- `pendaftaran/umum.blade.php`

**UI/UX Tasks:**
- [ ] **Landing Pendaftaran (index.blade.php)**:
  - 2 big cards: "Pasien Baru" vs "Pasien Lama"
  - Icon yang jelas
  - Hover effect yang inviting
- [ ] **Form Pendaftaran**:
  - Perbedaan visual BPJS vs Umum (color coding)
  - Auto-complete untuk pasien lama
  - Date picker yang user-friendly
  - Dropdown poli dengan icon
  - Nomor antrian yang prominent setelah submit
- [ ] **Daftar Pendaftaran Hari Ini**:
  - Table dengan status color (menunggu=yellow, dipanggil=blue, selesai=green)
  - Filter by poli, status, jenis pembayaran
  - Real-time update indicator
- [ ] **Konfirmasi Pendaftaran (show.blade.php)**:
  - Success message yang celebratory
  - Nomor antrian BESAR dan jelas
  - Info poli dan estimasi waktu
  - Print button untuk bukti pendaftaran

**Design Focus:**
- Fast and efficient registration flow
- Clear differentiation between patient types
- Visual feedback at every step

**Total: 17 files**

---

## 👥 ANGGOTA 3: UI/UX PEMERIKSAAN & PELAYANAN
**Nama:** _________________  
**Fokus:** Clinical Services & Patient Care Interface

### 📂 Modul yang Dikerjakan:

#### 1️⃣ Pemeriksaan (3 files)
**Files:**
- `pemeriksaan/create.blade.php`
- `pemeriksaan/index.blade.php`
- `pemeriksaan/show.blade.php`

**UI/UX Tasks:**
- [ ] **Form Pemeriksaan**:
  - Sections dengan accordion/collapse
  - Vital signs input dengan unit labels
  - Anamnesa textarea yang spacious
  - Diagnosa dengan autocomplete
  - Tindakan checklist
  - Resep table yang editable
  - Save draft button
- [ ] **Daftar Pemeriksaan**:
  - Patient queue dengan nomor antrian
  - Status indicator (menunggu, sedang diperiksa, selesai)
  - "Panggil Pasien" button yang prominent
  - Timer untuk durasi pemeriksaan

---

#### 2️⃣ Poliklinik (1 file)
**Files:**
- `poli/antrian.blade.php`

**UI/UX Tasks:**
- [ ] **Display Antrian**:
  - Nomor antrian SANGAT BESAR (untuk TV display)
  - Nama pasien
  - Nama dokter dan poli
  - Auto-refresh indicator
  - Sound notification (UI button)

---

#### 3️⃣ IGD (3 files)
**Files:**
- `igd/create.blade.php`
- `igd/index.blade.php`
- `igd/triase.blade.php`

**UI/UX Tasks:**
- [ ] **Triase Form**:
  - Color-coded priority levels:
    - 🔴 Merah (Resusitasi) - Red background
    - 🟡 Kuning (Urgent) - Yellow background
    - 🟢 Hijau (Non-urgent) - Green background
    - ⚫ Hitam (DOA) - Black background
  - Quick assessment checkboxes
  - Large submit button
- [ ] **Daftar Pasien IGD**:
  - Card layout dengan priority color border
  - Countdown timer sejak kedatangan
  - Status badges
  - Quick action buttons

---

#### 4️⃣ Rawat Inap (4 files)
**Files:**
- `rawat-inap/create.blade.php`
- `rawat-inap/index.blade.php`
- `rawat-inap/kamar.blade.php`
- `rawat-inap/show.blade.php`

**UI/UX Tasks:**
- [ ] **Ketersediaan Kamar (kamar.blade.php)**:
  - Grid layout untuk bed/kamar
  - Visual status:
    - ✅ Tersedia (green)
    - 🛏️ Terisi (red)
    - 🔧 Maintenance (orange)
  - Hover untuk detail kamar
  - Filter by kelas (VIP, Kelas 1, 2, 3)
- [ ] **Form Rawat Inap**:
  - Patient info summary card
  - Kamar selection dengan visual picker
  - Tanggal masuk dengan date picker
  - Diagnosa awal
- [ ] **Daftar Pasien Rawat Inap**:
  - Table dengan info kamar
  - Lama rawat (hari)
  - Status (stabil, kritis, dll) dengan color
  - Action buttons (visit, discharge)

---

#### 5️⃣ Rekam Medis (3 files)
**Files:**
- `rekam_medis/create.blade.php`
- `rekam_medis/index.blade.php`
- `rekam_medis/show.blade.php`

**UI/UX Tasks:**
- [ ] **Form Rekam Medis**:
  - Rich text editor untuk catatan
  - File upload untuk dokumen/foto
  - Signature pad untuk dokter
- [ ] **Riwayat Rekam Medis**:
  - Timeline vertical
  - Expandable entries
  - Filter by tanggal, dokter, diagnosa

---

#### 6️⃣ Kunjungan (1 file)
**Files:**
- `kunjungan/hari-ini.blade.php`

**UI/UX Tasks:**
- [ ] **Dashboard Kunjungan**:
  - Summary cards (total, per poli)
  - Real-time table
  - Status color coding
  - Export button (UI only)

**Total: 15 files**

---

## 👥 ANGGOTA 4: UI/UX LAPORAN, BPJS & SISTEM
**Nama:** _________________  
**Fokus:** Reporting, Integration & System Interface

### 📂 Modul yang Dikerjakan:

#### 1️⃣ Laporan (3 files)
**Files:**
- `laporan/diagnosa.blade.php`
- `laporan/index.blade.php`
- `laporan/kunjungan.blade.php`

**UI/UX Tasks:**
- [ ] **Filter Section**:
  - Date range picker yang prominent
  - Dropdown filters (poli, dokter, jenis pembayaran)
  - "Generate Report" button yang besar
  - Reset filter button
- [ ] **Report Display**:
  - Summary cards di atas
  - Chart/graph placeholder (bar, line, pie)
  - Data table di bawah
  - Print-friendly layout
  - Export buttons (PDF, Excel) - UI only
- [ ] **Visual Design**:
  - Professional dan formal
  - Grid layout yang rapi
  - Color-coded categories
  - Legend yang jelas

---

#### 2️⃣ BPJS (3 files)
**Files:**
- `bpjs/cetak-rujukan.blade.php`
- `bpjs/poli.blade.php`
- `bpjs/riwayat.blade.php`

**UI/UX Tasks:**
- [ ] **Cetak Rujukan**:
  - Print layout sesuai format BPJS
  - Logo BPJS dan Klinik
  - QR code placeholder
  - Barcode placeholder
  - Info yang terstruktur
  - CSS print media query
- [ ] **Data BPJS**:
  - Badge untuk status (aktif, non-aktif)
  - Info card untuk data peserta
  - Riwayat dalam timeline
  - Color untuk jenis pelayanan

---

#### 3️⃣ Pages Khusus (7 files)
**Files:**
- `pages/bpjs.blade.php`
- `pages/generic.blade.php`
- `pages/gudang.blade.php`
- `pages/kasir.blade.php`
- `pages/laboratorium.blade.php`
- `pages/laporan.blade.php`
- `pages/poned.blade.php`

**UI/UX Tasks:**
- [ ] **Kasir (kasir.blade.php)**:
  - Invoice layout yang jelas
  - Item list dengan harga
  - Total yang prominent
  - Payment method selector
  - Print receipt button
  - Calculator-like interface
- [ ] **Laboratorium (laboratorium.blade.php)**:
  - Request form untuk tes lab
  - Checklist jenis pemeriksaan
  - Sample collection info
  - Result entry form dengan units
  - Normal range indicator
- [ ] **Gudang (gudang.blade.php)**:
  - Inventory table
  - Stock level indicator (low=red, medium=yellow, high=green)
  - Search dan filter
  - Stock in/out form

---

#### 4️⃣ Authentication (3 files)
**Files:**
- `auth/login.blade.php`
- `auth/profile.blade.php`
- `auth/register.blade.php`

**UI/UX Tasks:**
- [ ] **Login Page**:
  - Centered card layout
  - Logo klinik di atas
  - Clean dan minimal
  - Username/email input dengan icon
  - Password dengan show/hide toggle
  - "Remember me" checkbox
  - "Forgot password" link
  - Login button yang prominent
  - Background gradient atau image
- [ ] **Profile Page**:
  - Avatar upload dengan preview
  - Info user dalam cards
  - Edit profile form
  - Change password section
  - Activity log

---

#### 5️⃣ Layout & Welcome (3 files)
**Files:**
- `layouts/app.blade.php`
- `welcome.blade.php`
- `register.blade.php`

**UI/UX Tasks:**
- [ ] **Main Layout (app.blade.php)**:
  - **Sidebar**:
    - Logo di atas
    - Menu dengan icon
    - Active state yang jelas
    - Hover effect
    - Collapsible untuk mobile
    - User info di bawah
  - **Navbar/Header**:
    - Breadcrumb
    - Search global (optional)
    - Notification bell dengan badge
    - User dropdown (profile, logout)
    - Responsive hamburger menu
  - **Footer**:
    - Copyright
    - Version info
    - Links
- [ ] **Welcome Page**:
  - Hero section dengan CTA
  - Feature highlights
  - Modern dan professional
  - Responsive design
  - Call-to-action buttons

**Design Focus:**
- Consistent navigation experience
- Professional branding
- Smooth transitions

**Total: 19 files**

---

## 📊 RINGKASAN PEMBAGIAN

| Anggota | Fokus UI/UX | Files | Kompleksitas |
|---------|-------------|-------|--------------|
| **Anggota 1** | Dashboard & Data Management | 19 | ⭐⭐⭐ Sedang |
| **Anggota 2** | Patient Registration Flow | 17 | ⭐⭐⭐⭐ Tinggi |
| **Anggota 3** | Clinical Services Interface | 15 | ⭐⭐⭐⭐⭐ Sangat Tinggi |
| **Anggota 4** | Reporting & System Pages | 19 | ⭐⭐⭐ Sedang |
| **TOTAL** | **Complete System** | **70** | |

---

## 🎨 UI/UX CHECKLIST - SETIAP HALAMAN

### Visual Design
- [ ] Color scheme konsisten dengan design system
- [ ] Typography hierarchy yang jelas
- [ ] Spacing yang proporsional (tidak terlalu rapat/renggang)
- [ ] Alignment yang rapi (left, center, right sesuai konteks)
- [ ] Contrast yang cukup untuk readability
- [ ] Icon yang konsisten (dari 1 icon library)

### Layout & Structure
- [ ] Grid system yang konsisten
- [ ] White space yang cukup
- [ ] Visual hierarchy yang jelas (apa yang paling penting?)
- [ ] Grouping elemen yang related
- [ ] Responsive breakpoints (mobile, tablet, desktop)

### Interactive Elements
- [ ] Button states (default, hover, active, disabled)
- [ ] Input states (default, focus, error, success)
- [ ] Link hover effect
- [ ] Loading indicators
- [ ] Transition yang smooth (tidak terlalu cepat/lambat)

### User Feedback
- [ ] Success messages (toast/alert)
- [ ] Error messages yang helpful
- [ ] Validation feedback real-time
- [ ] Confirmation dialogs untuk destructive actions
- [ ] Progress indicators untuk multi-step process

### Accessibility
- [ ] Label yang jelas untuk semua input
- [ ] Placeholder text yang helpful (bukan pengganti label)
- [ ] Error messages yang specific
- [ ] Focus states yang visible
- [ ] Keyboard navigation support

### Responsive Design
- [ ] Mobile-first approach
- [ ] Breakpoints: 640px (mobile), 768px (tablet), 1024px (desktop)
- [ ] Touch-friendly button size (min 44x44px)
- [ ] Readable font size di mobile (min 16px)
- [ ] Hamburger menu untuk mobile

### Performance
- [ ] Lazy loading untuk images
- [ ] Optimized images (compressed)
- [ ] Minimal use of heavy animations
- [ ] Fast perceived performance

---

## 🛠️ TOOLS & RESOURCES

### Design Inspiration
- **Dribbble**: Healthcare/Medical UI designs
- **Behance**: Hospital Management Systems
- **Tailwind UI**: Component examples
- **Material Design**: Guidelines & components

### Color Tools
- **Coolors.co**: Color palette generator
- **Adobe Color**: Color wheel
- **Contrast Checker**: WCAG compliance

### Icon Libraries (pilih 1 saja untuk konsistensi)
- **Heroicons**: Modern, clean
- **Font Awesome**: Comprehensive
- **Feather Icons**: Minimal, elegant
- **Material Icons**: Google's design

### Typography
- **Google Fonts**: 
  - Inter (modern, readable)
  - Roboto (clean, professional)
  - Poppins (friendly, rounded)
  - Open Sans (versatile)

### UI Components Reference
- **Bootstrap 5**: Component library
- **Tailwind CSS**: Utility classes
- **DaisyUI**: Tailwind components
- **Flowbite**: Tailwind components

---

## 📐 COMPONENT STANDARDS

### Buttons
```html
<!-- Primary Button -->
<button class="btn btn-primary">
  <i class="icon"></i> Label
</button>

<!-- Sizes: btn-sm, btn-md, btn-lg -->
<!-- Variants: btn-primary, btn-secondary, btn-success, btn-danger -->
<!-- States: disabled, loading -->
```

### Cards
```html
<div class="card">
  <div class="card-header">
    <h3>Title</h3>
    <div class="actions">...</div>
  </div>
  <div class="card-body">
    Content
  </div>
  <div class="card-footer">
    Footer actions
  </div>
</div>
```

### Forms
```html
<div class="form-group">
  <label for="input-id">Label <span class="required">*</span></label>
  <input type="text" id="input-id" class="form-control" placeholder="Placeholder">
  <small class="form-text">Helper text</small>
  <div class="error-message">Error message</div>
</div>
```

### Tables
```html
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Column 1</th>
      <th>Column 2</th>
      <th class="text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Data 1</td>
      <td>Data 2</td>
      <td class="text-right">
        <button class="btn btn-sm btn-info">View</button>
        <button class="btn btn-sm btn-primary">Edit</button>
        <button class="btn btn-sm btn-danger">Delete</button>
      </td>
    </tr>
  </tbody>
</table>
```

### Alerts
```html
<div class="alert alert-success">
  <i class="icon-check"></i>
  <strong>Success!</strong> Your action was successful.
  <button class="close">&times;</button>
</div>

<!-- Variants: alert-success, alert-info, alert-warning, alert-danger -->
```

### Badges
```html
<span class="badge badge-success">Active</span>
<span class="badge badge-danger">Inactive</span>
<span class="badge badge-warning">Pending</span>
```

### Modals
```html
<div class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Modal Title</h5>
        <button class="close">&times;</button>
      </div>
      <div class="modal-body">
        Content
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary">Cancel</button>
        <button class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
```

---

## 🔄 WORKFLOW

### 1. Analisis & Research (Week 1)
- [ ] Review semua file yang ditugaskan
- [ ] Screenshot tampilan existing
- [ ] Identifikasi masalah UI/UX
- [ ] Buat mockup/wireframe (optional)
- [ ] Diskusi dengan ketua kelompok

### 2. Design System Setup (Week 1)
- [ ] Sepakati color palette
- [ ] Pilih typography
- [ ] Pilih icon library
- [ ] Buat component library (reusable)
- [ ] Setup CSS variables/utilities

### 3. Implementation (Week 2-3)
- [ ] Mulai dari component yang paling sering dipakai
- [ ] Implementasi per halaman
- [ ] Test di berbagai screen size
- [ ] Cross-browser testing
- [ ] Commit progress secara berkala

### 4. Review & Refinement (Week 4)
- [ ] Self-review semua halaman
- [ ] Peer review dengan anggota lain
- [ ] Fix inconsistencies
- [ ] Polish details (spacing, colors, animations)
- [ ] Final testing

### 5. Documentation (Week 4)
- [ ] Screenshot before/after
- [ ] Dokumentasi perubahan
- [ ] Style guide (optional)
- [ ] Handover ke ketua

---

## 🎯 KRITERIA PENILAIAN UI/UX

### Visual Design (30%)
- Estetika dan keindahan
- Konsistensi visual
- Professional appearance
- Branding yang kuat

### Usability (30%)
- Ease of use
- Intuitive navigation
- Clear information architecture
- Minimal cognitive load

### Responsiveness (20%)
- Mobile-friendly
- Tablet-friendly
- Desktop optimization
- Consistent experience across devices

### Consistency (10%)
- Design system adherence
- Component reusability
- Pattern consistency
- Naming conventions

### Innovation (10%)
- Creative solutions
- Modern design trends
- Delightful interactions
- Attention to details

---

## 💡 UI/UX BEST PRACTICES

### Do's ✅
- **Keep it simple**: Less is more
- **Be consistent**: Same patterns throughout
- **Provide feedback**: User should know what's happening
- **Use whitespace**: Don't cram everything
- **Think mobile-first**: Most users on mobile
- **Test with real users**: Get feedback early
- **Follow conventions**: Don't reinvent the wheel
- **Prioritize content**: Content is king
- **Make it accessible**: Everyone should be able to use it
- **Iterate**: Design is never done

### Don'ts ❌
- **Don't use too many colors**: Stick to palette
- **Don't use too many fonts**: Max 2-3 font families
- **Don't ignore errors**: Show helpful error messages
- **Don't hide important actions**: Make them visible
- **Don't use tiny fonts**: Min 14px for body text
- **Don't use low contrast**: Text should be readable
- **Don't forget loading states**: Show progress
- **Don't use vague labels**: Be specific
- **Don't ignore mobile**: Mobile is not optional
- **Don't skip user testing**: Assumptions can be wrong

---

## 📱 RESPONSIVE BREAKPOINTS

```css
/* Mobile First Approach */

/* Extra Small (Mobile) - Default */
/* 0px - 639px */

/* Small (Large Mobile) */
@media (min-width: 640px) {
  /* Styles for ≥640px */
}

/* Medium (Tablet) */
@media (min-width: 768px) {
  /* Styles for ≥768px */
}

/* Large (Desktop) */
@media (min-width: 1024px) {
  /* Styles for ≥1024px */
}

/* Extra Large (Large Desktop) */
@media (min-width: 1280px) {
  /* Styles for ≥1280px */
}
```

---

## 🚨 ATURAN PENTING

> [!WARNING]
> **YANG BOLEH DIUBAH:**
> - HTML structure di `.blade.php`
> - CSS classes dan styling
> - Layout dan positioning
> - Colors, fonts, spacing
> - Icons dan images
> - Animations dan transitions

> [!CAUTION]
> **YANG TIDAK BOLEH DIUBAH:**
> - File Controller (`.php` di `app/Http/Controllers/`)
> - File Model (`.php` di `app/Models/`)
> - Database migrations
> - Routes (`routes/web.php`)
> - Backend logic
> - Blade directives yang ada (jangan hapus `@foreach`, `@if`, dll)
> - Variable names dari controller (`$pasien`, `$data`, dll)

> [!IMPORTANT]
> **YANG HARUS DIPERTAHANKAN:**
> - Form `action` dan `method`
> - Input `name` attributes (untuk submit form)
> - Button `type="submit"`
> - Links `href` (boleh tambah class, jangan ubah URL)
> - Data attributes (`data-*`)
> - ID untuk JavaScript functionality

---

## 📞 KOMUNIKASI & KOLABORASI

### Daily Sync (Optional)
**Format:** 5 menit stand-up
- Apa yang sudah dikerjakan?
- Apa yang akan dikerjakan hari ini?
- Ada blocker/masalah?

### Weekly Review
**Format:** 30-60 menit meeting
- Demo progress masing-masing
- Feedback dari ketua dan anggota lain
- Diskusi masalah dan solusi
- Planning untuk minggu depan

### Communication Channels
- **WhatsApp/Telegram**: Quick questions
- **Google Meet/Zoom**: Weekly review
- **GitHub**: Code review & comments
- **Figma/Google Slides**: Design sharing (optional)

---

## 🎓 LEARNING RESOURCES

### HTML & CSS
- [MDN Web Docs](https://developer.mozilla.org/)
- [CSS Tricks](https://css-tricks.com/)
- [W3Schools](https://www.w3schools.com/)

### UI/UX Design
- [Laws of UX](https://lawsofux.com/)
- [Nielsen Norman Group](https://www.nngroup.com/)
- [Refactoring UI](https://www.refactoringui.com/)

### Laravel Blade
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Laracasts](https://laracasts.com/)

### Bootstrap/Tailwind
- [Bootstrap Documentation](https://getbootstrap.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)

---

## ✅ PROGRESS TRACKING

### Week 1: Setup & Planning
- [ ] Anggota 1: Analisis selesai, design system setup
- [ ] Anggota 2: Analisis selesai, wireframe ready
- [ ] Anggota 3: Analisis selesai, component library started
- [ ] Anggota 4: Analisis selesai, style guide drafted

### Week 2: Core Development
- [ ] Anggota 1: 50% files completed
- [ ] Anggota 2: 50% files completed
- [ ] Anggota 3: 50% files completed
- [ ] Anggota 4: 50% files completed

### Week 3: Completion
- [ ] Anggota 1: 100% files completed, self-tested
- [ ] Anggota 2: 100% files completed, self-tested
- [ ] Anggota 3: 100% files completed, self-tested
- [ ] Anggota 4: 100% files completed, self-tested

### Week 4: Polish & Integration
- [ ] Cross-review antar anggota
- [ ] Consistency check
- [ ] Responsive testing
- [ ] Bug fixes
- [ ] Final polish
- [ ] Documentation
- [ ] Presentation ready

---

## 🎉 DELIVERABLES

### Setiap Anggota Harus Submit:
1. **Modified Files**: Semua `.blade.php` yang sudah diubah
2. **Screenshots**: Before & After comparison
3. **Documentation**: 
   - Apa yang diubah?
   - Kenapa diubah?
   - Challenges yang dihadapi?
4. **Demo Video** (optional): Screen recording fitur yang dikerjakan

### Ketua Kelompok Compile:
1. **Final Codebase**: Semua perubahan merged
2. **Style Guide**: Dokumentasi design system
3. **Presentation**: Slide untuk presentasi
4. **Demo**: Live demo atau video walkthrough

---

## 🏆 SUCCESS METRICS

### Quantitative
- [ ] 100% files completed
- [ ] 0 broken layouts
- [ ] Responsive di 3 device sizes
- [ ] Page load time < 3 seconds
- [ ] Accessibility score > 80%

### Qualitative
- [ ] Looks professional and modern
- [ ] Easy to use (user feedback)
- [ ] Consistent throughout
- [ ] Delightful interactions
- [ ] Team is proud of the result

---

**Dibuat oleh:** Ketua Kelompok  
**Terakhir Update:** 3 Desember 2025  
**Version:** 1.0

---

> [!NOTE]
> Dokumen ini adalah panduan lengkap untuk UI/UX design. Jika ada pertanyaan atau butuh klarifikasi, jangan ragu untuk bertanya ke ketua kelompok atau diskusi di grup.

**Let's create something beautiful! 🎨✨**
