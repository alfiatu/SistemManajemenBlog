<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f1f5f9;
}

/* sidebar active */
.sidebar-item-active {
    background-color: #f0fdf4;
    color: #166534;
    border-left: 4px solid #22c55e;
    font-weight: 600;
}

/* modal system */
.modal {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
}

.modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* view system */
.view-content {
    display: none;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.25s ease;
}

.view-content.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* animasi keluar (opsional halus) */
.view-content.hide-anim {
    opacity: 0;
    transform: translateY(10px);
}

/* card style */
.main-card {
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04),
                0 8px 10px -6px rgba(0,0,0,0.04);
}

/* table alignment */
table td {
    vertical-align: middle !important;
}

/* image square (penulis + artikel) */
.img-square-fixed {
    width: 50px !important;
    height: 50px !important;
    min-width: 50px !important;
    min-height: 50px !important;
    aspect-ratio: 1 / 1 !important;
    object-fit: cover !important;
    border-radius: 0 !important;
    display: block;
}

.img-container {
    width: 50px;
    height: 50px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

/* preview upload */
.preview-box {
    width: 80px;
    height: 80px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    object-fit: cover;
    display: none;
}

.pressable {
    transition: transform 0.12s ease, box-shadow 0.12s ease;
    will-change: transform;
}

.pressable:active {
    transform: scale(0.96);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
    </style>
</head>
<body class="min-h-screen">

    <!-- Header -->
    <header class="bg-[#2d3748] text-white p-4 flex items-center shadow-md">
        <div>
            <h1 class="text-base font-bold leading-tight">Sistem Manajemen Blog (CMS)</h1>
            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Blog UTeeS</p>
        </div>
    </header>

    <div class="flex flex-col md:flex-row min-h-[calc(100vh-72px)] p-4 md:p-8 gap-8">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">MENU UTAMA</p>
                <nav class="space-y-2">
                    <button onclick="switchView('penulis')" id="btn-penulis" class="pressable w-full sidebar-item-active flex items-center px-4 py-3 text-sm rounded-lg transition-all text-left">
                        <i class="fas fa-user-edit mr-3 w-5 text-sm"></i>
                        Kelola Penulis
                    </button>
                    <button onclick="switchView('artikel')" id="btn-artikel" class="pressable w-full flex items-center px-4 py-3 text-sm text-gray-500 hover:bg-gray-50 rounded-lg transition-all text-left">
                        <i class="far fa-file-alt mr-3 w-5 text-sm"></i>
                        Kelola Artikel
                    </button>
                    <button onclick="switchView('kategori')" id="btn-kategori" class="pressable w-full flex items-center px-4 py-3 text-sm text-gray-500 hover:bg-gray-50 rounded-lg transition-all text-left">
                        <i class="far fa-folder mr-3 w-5 text-sm"></i>
                        Kelola Kategori
                    </button>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            
            <!-- View Kelola Penulis -->
            <div id="view-penulis" class="view-content active">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-slate-700">Data Penulis</h2>
                    <button onclick="openTambahModal()" class="bg-[#22c55e] hover:bg-[#16a34a] text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center transition-all shadow-sm">
                        <span class="pressable mr-2 text-lg">+</span> Tambah Penulis
                    </button>
                </div>

                <div class="bg-white main-card border border-gray-50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">
                                    <th class="px-8 py-6 text-center w-24">FOTO</th>
                                    <th class="px-6 py-6">NAMA</th>
                                    <th class="px-6 py-6">USERNAME</th>
                                    <th class="px-6 py-6">PASSWORD</th>
                                    <th class="px-8 py-6 text-center w-44">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-penulis-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- View Kelola Kategori -->
<div id="view-kategori" class="view-content">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-700">Data Kategori</h2>
        <button onclick="openTambahKategori()" 
            class="pressable bg-[#22c55e] hover:bg-[#16a34a] text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center transition-all shadow-sm">
            <span class="mr-2 text-lg">+</span> Tambah Kategori
        </button>
    </div>

    <div class="bg-white main-card border border-gray-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-6 w-20">ID</th>
                        <th class="px-6 py-6">Nama Kategori</th>
                        <th class="px-6 py-6">Keterangan</th>
                        <th class="px-6 py-6 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-kategori-body" class="text-sm text-gray-600 divide-y divide-gray-50">
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

            <!-- View Kelola Artikel -->
        <div id="view-artikel" class="view-content">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-700">Kelola Artikel</h2>

        <button onclick="toggleModal('modalTambahArtikel')"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold">
            + Tambah Artikel
        </button>
    </div>

    <div class="bg-white main-card border border-gray-50 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
    <tr class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">
        <th class="px-8 py-6">GAMBAR</th>
        <th class="px-6 py-6">JUDUL</th>
        <th class="px-6 py-6">KATEGORI</th>
        <th class="px-6 py-6">PENULIS</th>
        <th class="px-6 py-6">TANGGAL</th>
        <th class="px-8 py-6 text-center w-44">AKSI</th>
    </tr>
</thead>

            <tbody id="tabel-artikel"></tbody>
        </table>
    </div>

</div>

    <!-- MODAL TAMBAH PENULIS -->
    <div id="modalTambahPenulis" class="modal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Penulis Baru</h3>
            <form id="formTambahPenulis" enctype="multipart/form-data" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Depan</label>
                        <input type="text" name="nama_depan" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-green-500 transition-all" placeholder="Ahmad">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Belakang</label>
                        <input type="text" name="nama_belakang" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-green-500 transition-all" placeholder="Fauzi">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Username</label>
                    <input type="text" name="username" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-green-500 transition-all" placeholder="ahmad_f">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Password</label>
                    <input type="password" name="password" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-green-500 transition-all" placeholder="••••••••••••">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4 p-4 border-2 border-gray-200 border-dashed rounded-lg hover:border-green-500 transition-colors">
                        <img id="previewTambah" class="preview-box">
                        <div id="placeholderTambah" class="flex-1 text-center py-2">
                            <i class="fas fa-image text-gray-300 text-3xl mb-1"></i>
                            <div class="text-xs text-gray-500 mt-2">
                                <label class="cursor-pointer font-bold text-green-600 hover:text-green-500 bg-green-50 px-3 py-1.5 rounded-md border border-green-200">
                                    Pilih Foto
                                    <input name="foto" type="file" accept="image/*" class="sr-only" onchange="previewImage(this, 'previewTambah', 'placeholderTambah')">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-8">
                    <button type="button" onclick="toggleModal('modalTambahPenulis')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-bold transition-all">Batal</button>
                    <button type="submit" class="bg-[#22c55e] hover:bg-[#16a34a] text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENULIS -->
    <div id="modalEditPenulis" class="modal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Data Penulis</h3>
            <form id="formEditPenulis" enctype="multipart/form-data" method="POST" class="space-y-5">
                <input type="hidden" name="id" id="edit_id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Depan</label>
                        <input type="text" name="nama_depan" id="edit_nama_depan" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Belakang</label>
                        <input type="text" name="nama_belakang" id="edit_nama_belakang" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Username</label>
                    <input type="text" name="username" id="edit_username" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Password Baru</label>
                    <input type="password" name="password" id="edit_password" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-blue-500 transition-all" placeholder="Kosongkan jika tidak diubah">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4 p-4 border-2 border-gray-200 border-dashed rounded-lg hover:border-blue-500 transition-colors">
                        <img id="previewEdit" class="preview-box">
                        <div id="placeholderEdit" class="flex-1 text-center py-2">
                            <i class="fas fa-image text-gray-300 text-3xl mb-1"></i>
                            <div class="text-xs text-gray-500 mt-2">
                                <label class="cursor-pointer font-bold text-blue-600 hover:text-blue-500 bg-blue-50 px-3 py-1.5 rounded-md border border-blue-200">
                                    Ganti Foto
                                    <input name="foto" type="file" accept="image/*" class="sr-only" onchange="previewImage(this, 'previewEdit', 'placeholderEdit')">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-8">
                    <button type="button" onclick="toggleModal('modalEditPenulis')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-bold transition-all">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
    <div id="modalHapus" class="modal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 mx-4 text-center">
            <div class="w-20 h-20 bg-red-50 flex items-center justify-center mx-auto mb-6 text-red-500 rounded-full">
                <i class="far fa-trash-alt text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus data ini?</h3>
            <p class="text-gray-400 text-sm mb-8 px-4">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-center gap-3">
                <button onclick="toggleModal('modalHapus')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-bold transition-all">Batal</button>
                <button id="btn-konfirmasi-hapus" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition-all shadow-md">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH KATEGORI -->
<div id="modalTambahKategori" class="modal">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Kategori</h3>

        <form id="formTambahKategori" class="space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Keterangan</label>
                <textarea name="keterangan"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="toggleModal('modalTambahKategori')"
                    class="bg-gray-100 px-5 py-2 rounded-lg text-sm font-bold">
                    Batal
                </button>
                <button type="submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-bold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT KATEGORI -->
<div id="modalEditKategori" class="modal">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Kategori</h3>

        <form id="formEditKategori" class="space-y-5">
            <input type="hidden" name="id" id="edit_kategori_id">

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit_nama_kategori" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-2">Keterangan</label>
                <textarea name="keterangan" id="edit_keterangan"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="toggleModal('modalEditKategori')"
                    class="bg-gray-100 px-6 py-2.5 rounded-lg text-sm font-bold">
                    Batal
                </button>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS KATEGORI -->
<div id="modalHapusKategori" class="modal">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 mx-4 text-center">
        <h3 class="text-lg font-bold mb-4">Hapus kategori?</h3>
        <p class="text-gray-400 text-sm mb-6">Data tidak bisa dikembalikan</p>

        <div class="flex justify-center gap-3">
            <button onclick="toggleModal('modalHapusKategori')"
                class="bg-gray-200 px-5 py-2 rounded">
                Batal
            </button>
            <button id="btn-hapus-kategori"
                class="bg-red-600 text-white px-5 py-2 rounded">
                Hapus
            </button>
        </div>
    </div>
</div>
    
<div id="modalTambahArtikel" class="modal hidden fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg p-6 rounded-xl">

        <h2 class="text-lg font-bold mb-4">Tambah Artikel</h2>

        <form id="formTambahArtikel" enctype="multipart/form-data">

            <select name="id_penulis" class="w-full border p-2 mb-2" id="penulisSelect"></select>

            <select name="id_kategori" class="w-full border p-2 mb-2" id="kategoriSelect"></select>

            <input type="text" name="judul" placeholder="Judul"
                class="w-full border p-2 mb-2">

            <textarea name="isi" placeholder="Isi artikel"
                class="w-full border p-2 mb-2"></textarea>

            <input type="file" name="gambar" class="mb-3" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal('modalTambahArtikel')"
                    class="px-3 py-2 bg-gray-300 rounded">Batal</button>

                <button class="px-3 py-2 bg-green-600 text-white rounded">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<div id="modalEditArtikel" class="modal hidden fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg p-6 rounded-xl">

        <h2 class="text-lg font-bold mb-4">Edit Artikel</h2>

        <form id="formEditArtikel" enctype="multipart/form-data">

            <input type="hidden" name="id" id="edit_id">

            <select name="id_penulis" id="edit_penulis" class="w-full border p-2 mb-2"></select>

            <select name="id_kategori" id="edit_kategori" class="w-full border p-2 mb-2"></select>

            <input type="text" name="judul" id="edit_judul"
                class="w-full border p-2 mb-2">

            <textarea name="isi" id="edit_isi"
                class="w-full border p-2 mb-2"></textarea>

            <input type="file" name="gambar" class="mb-3">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal('modalEditArtikel')"
                    class="px-3 py-2 bg-gray-300 rounded">Batal</button>

                <button class="px-3 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

<div id="modalHapusArtikel" class="modal hidden fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-xl text-center">

        <h2 class="text-lg font-bold mb-3">Yakin hapus artikel?</h2>

        <button onclick="toggleModal('modalHapusArtikel')"
            class="px-4 py-2 bg-gray-300 rounded">Batal</button>

        <button id="btnHapusArtikel"
            class="px-4 py-2 bg-red-600 text-white rounded">
            Hapus
        </button>

    </div>

</div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            init();
        });

        let idHapusGlobal = null;

        function init() {
            loadPenulis();
            document.getElementById('formTambahPenulis')?.addEventListener('submit', handleTambah);
            document.getElementById('formEditPenulis')?.addEventListener('submit', handleEdit);
            document.getElementById('btn-konfirmasi-hapus')?.addEventListener('click', handleHapus);
            document.getElementById('tabel-penulis-body')?.addEventListener('click', handleTableClick);
        }

        async function apiFetch(url, options = {}) {
            const res = await fetch(url, options);
            const text = await res.text();
            let json;
            try {
                json = JSON.parse(text);
            } catch (e) {
                console.error("Non-JSON response:", text);
                throw e;
            }
            if (json.status !== "success") {
                throw new Error(json.msg || "Terjadi kesalahan");
            }
            return json;
        }

        async function loadPenulis() {
            const body = document.getElementById('tabel-penulis-body');
            body.innerHTML = `<tr><td colspan="5" class="px-8 py-12 text-center text-gray-400 italic font-medium">Memuat data...</td></tr>`;
            try {
                const res = await apiFetch('penulis/ambil_penulis.php');
                renderTable(res.data);
            } catch {
                body.innerHTML = `<tr><td colspan="5" class="px-8 py-12 text-center text-red-400 italic">Gagal memuat data dari server.</td></tr>`;
            }
        }

        function renderTable(data) {
            const body = document.getElementById('tabel-penulis-body');
            if (!data || data.length === 0) {
                body.innerHTML = `<tr><td colspan="5" class="px-8 py-12 text-center text-gray-400 italic">Belum ada data penulis.</td></tr>`;
                return;
            }

            body.innerHTML = data.map(p => `
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-4">
                        <div class="flex justify-center">
                            <div class="img-container">
                                <img src="uploads_penulis/${p.foto}" 
                                     class="img-square-fixed"
                                     onerror="this.src='https://ui-avatars.com/api/?name=${p.nama_depan}+${p.nama_belakang}&background=random&rounded=false&size=100'">
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-700">${p.nama_depan} ${p.nama_belakang}</td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-50 text-blue-500 px-3 py-1.5 rounded-lg text-xs font-extrabold uppercase tracking-tight">${p.user_name}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-300 font-mono text-xs truncate max-w-[150px]">
                        ${p.password.substring(0, 15)}...
                    </td>
                    <td class="px-8 py-4">
                        <div class="flex justify-center gap-2">
                            <button data-id="${p.id}" data-action="edit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold px-4 py-2 rounded transition-all shadow-sm">
                                EDIT
                            </button>
                            <button data-id="${p.id}" data-action="hapus"
                                    class="bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold px-4 py-2 rounded transition-all shadow-sm">
                                HAPUS
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Preview Fungsi
        function previewImage(input, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    // Kita tidak menyembunyikan placeholder seluruhnya agar tombol input (label) tetap ada
                    // Tapi kita sembunyikan icon dan teks instruksi lama
                    const icon = placeholder.querySelector('i');
                    if(icon) icon.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetPreview(previewId, placeholderId, src = null) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const icon = placeholder.querySelector('i');
            
            if (src) {
                preview.src = src;
                preview.style.display = 'block';
                if(icon) icon.style.display = 'none';
            } else {
                preview.src = "";
                preview.style.display = 'none';
                if(icon) icon.style.display = 'block';
            }
        }

        function openTambahModal() {
            document.getElementById('formTambahPenulis').reset();
            resetPreview('previewTambah', 'placeholderTambah');
            toggleModal('modalTambahPenulis');
        }

        function handleTableClick(e) {
            const btn = e.target.closest('button');
            if (!btn) return;
            const id = btn.dataset.id;
            const action = btn.dataset.action;
            if (action === 'edit') editPenulis(id);
            else if (action === 'hapus') konfirmasiHapus(id);
        }

        async function handleTambah(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                await apiFetch('penulis/simpan_penulis.php', { method: 'POST', body: formData });
                toggleModal('modalTambahPenulis');
                loadPenulis();
            } catch (err) { alert(err.message); }
        }

        async function editPenulis(id) {
            try {
                const res = await fetch(`penulis/ambil_satu_penulis.php?id=${id}`);
                const json = await res.json();
                const data = json.data;
                document.getElementById('edit_id').value = data.id || data.id_penulis;
                document.getElementById('edit_nama_depan').value = data.nama_depan;
                document.getElementById('edit_nama_belakang').value = data.nama_belakang;
                document.getElementById('edit_username').value = data.user_name;
                document.getElementById('edit_password').value = "";
                
                // Tampilkan foto lama di preview edit
                const oldPhotoUrl = `uploads_penulis/${data.foto}`;
                resetPreview('previewEdit', 'placeholderEdit', oldPhotoUrl);
                
                toggleModal('modalEditPenulis');
            } catch (err) { alert("Gagal mengambil data."); }
        }

        async function handleEdit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                await apiFetch('penulis/update_penulis.php', { method: 'POST', body: formData });
                toggleModal('modalEditPenulis');
                loadPenulis();
            } catch (err) { alert(err.message); }
        }

        function konfirmasiHapus(id) {
            idHapusGlobal = id;
            toggleModal('modalHapus');
        }

        async function handleHapus() {
            const formData = new FormData();
            formData.append('id', idHapusGlobal);
            try {
                await apiFetch('penulis/hapus_penulis.php', { method: 'POST', body: formData });
                toggleModal('modalHapus');
                loadPenulis();
            } catch (err) { alert(err.message); }
        }

        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal?.classList.toggle('active');
        }

        // ================== LOAD KATEGORI ==================

let idKategoriHapus = null;

// ================== LOAD DATA ==================
document.addEventListener('DOMContentLoaded', () => {
    loadKategori();
});

async function loadKategori() {
    const body = document.getElementById('tabel-kategori-body');

    try {
        const res = await fetch('kategori/ambil_kategori.php');
        const data = await res.json();

        body.innerHTML = '';

        if (!Array.isArray(data) || data.length === 0) {
            body.innerHTML = `
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-gray-400 italic">
                        Tidak ada data kategori
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach(k => {
            body.innerHTML += `
                <tr class="hover:bg-gray-50">
                    <td class="px-8 py-4 text-center">${k.id}</td>
                    <td class="px-6 py-4">
    <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-extrabold uppercase tracking-tight">
        ${k.nama_kategori}
    </span>
</td>
                    <td class="px-6 py-4">${k.keterangan ?? '-'}</td>
                    <td class="px-8 py-4">
                        <div class="flex gap-2 justify-center">

                            <button onclick="editKategori(${k.id})"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold px-4 py-2 rounded transition-all shadow-sm">
                                EDIT
                            </button>

                            <button onclick="openHapusKategori(${k.id})"
                                class="bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold px-4 py-2 rounded transition-all shadow-sm">
                                HAPUS
                            </button>

                        </div>
                    </td>
                </tr>
            `;
        });

    } catch (err) {
        body.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-6 text-red-500">
                    Error: ${err.message}
                </td>
            </tr>
        `;
    }
}

function openTambahKategori() {
    toggleModal('modalTambahKategori');
}

document.getElementById('formTambahKategori').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    const res = await fetch('kategori/simpan_kategori.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();

    if (result.status === 'success') {
        toggleModal('modalTambahKategori');
        e.target.reset();
        loadKategori();
    } else {
        alert(result.msg || 'Gagal simpan');
    }
});

async function editKategori(id) {
    try {
        const res = await fetch('kategori/ambil_satu_kategori.php?id=' + id);
        const text = await res.text();

        console.log("RAW:", text);

        const data = JSON.parse(text);

        // 🔥 penting: fallback kalau nama field beda
        document.getElementById('edit_kategori_id').value = data.id || data.id_kategori;
        document.getElementById('edit_nama_kategori').value = data.nama_kategori || '';
        document.getElementById('edit_keterangan').value = data.keterangan || '';

        toggleModal('modalEditKategori');

    } catch (err) {
        alert('Edit gagal: ' + err.message);
    }
}

document.getElementById('formEditKategori').addEventListener('submit', async (e) => {
    e.preventDefault(); // 🔥 WAJIB, biar tidak reload / pindah halaman

    const formData = new FormData(e.target);

    const res = await fetch('kategori/update_kategori.php', {
        method: 'POST',
        body: formData
    });

    const text = await res.text();
    console.log("RAW:", text);

    const result = JSON.parse(text);

    if (result.status === 'success') {
        toggleModal('modalEditKategori');
        loadKategori(); // 🔥 refresh tabel
    } else {
        alert(result.msg || 'Gagal update');
    }
});

function openHapusKategori(id) {
    idKategoriHapus = id;
    toggleModal('modalHapusKategori');
}

document.getElementById('btn-hapus-kategori').addEventListener('click', async () => {
    const formData = new FormData();
    formData.append('id', idKategoriHapus);

    const res = await fetch('kategori/hapus_kategori.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();

    if (result.status === 'success') {
        toggleModal('modalHapusKategori');
        loadKategori();
    } else {
        alert(result.msg || 'Gagal hapus');
    }
});


let idHapusArtikel = null;



// ================= LOAD =================
async function loadArtikel() {
    const res = await fetch('artikel/ambil_artikel.php');
    const data = await res.json();

    const tbody = document.getElementById('tabel-artikel');
    tbody.innerHTML = '';

    data.forEach(a => {
        tbody.innerHTML += `
       <tr class="hover:bg-gray-50/50 transition-colors">

   <td class="px-8 py-4">
        <div class="flex justify-center">
            <div class="img-container">
                <img src="uploads_artikel/${a.gambar}"
                     class="img-square-fixed">
            </div>
        </div>
    </td>

    <td class="px-6 py-4 font-bold text-gray-700">
        ${a.judul}
    </td>

    <td class="px-6 py-4">
    <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-extrabold uppercase tracking-tight">
        ${a.nama_kategori}
    </span>
</td>

    <td class="px-6 py-4 text-gray-600">
        ${a.nama_depan} ${a.nama_belakang}
    </td>

    <td class="px-6 py-4 text-gray-500 text-sm">
        ${a.hari_tanggal}
    </td>

    <td class="px-8 py-4">
        <div class="flex justify-center gap-2">

            <button onclick="editArtikel(${a.id})"
                class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold px-4 py-2 rounded shadow-sm">
                EDIT
            </button>

            <button onclick="hapusArtikel(${a.id})"
                class="bg-red-500 hover:bg-red-600 text-white text-[11px] font-bold px-4 py-2 rounded shadow-sm">
                HAPUS
            </button>

        </div>
    </td>
        </tr>`;
    });
}

// ================= LOAD DROPDOWN =================
async function loadDropdown() {
    const penulisRes = await fetch('penulis/ambil_penulis.php');
    const penulisJson = await penulisRes.json();

    const kategoriRes = await fetch('kategori/ambil_kategori.php');
    const kategoriJson = await kategoriRes.json();

    // 🔥 amankan struktur
    const penulis = penulisJson.data || [];
    const kategori = Array.isArray(kategoriJson) 
        ? kategoriJson 
        : (kategoriJson.data || []);

    let p = `<option value="">-- pilih penulis --</option>`;
    let k = `<option value="">-- pilih kategori --</option>`;

    penulis.forEach(x => {
        p += `<option value="${x.id}">
                ${x.nama_depan} ${x.nama_belakang}
              </option>`;
    });

    kategori.forEach(x => {
        k += `<option value="${x.id}">
                ${x.nama_kategori}
              </option>`;
    });

    document.getElementById('penulisSelect').innerHTML = p;
    document.getElementById('kategoriSelect').innerHTML = k;

    document.getElementById('edit_penulis').innerHTML = p;
    document.getElementById('edit_kategori').innerHTML = k;
}

// ================= TAMBAH =================
document.getElementById('formTambahArtikel').addEventListener('submit', async (e) => {
    e.preventDefault();

    const res = await fetch('artikel/simpan_artikel.php', {
        method: 'POST',
        body: new FormData(e.target)
    });

    const r = await res.json();

    if (r.status === 'success') {
        toggleModal('modalTambahArtikel');
        loadArtikel();
    }
});

// ================= EDIT =================
async function editArtikel(id) {

    console.log("EDIT CLICK ID:", id);

    const res = await fetch('artikel/ambil_satu_artikel.php?id=' + id);
    const text = await res.text();

    console.log("RAW:", text);

    const a = JSON.parse(text);

    console.log("PARSED:", a);

    // 🔥 INI YANG SELAMA INI HILANG
   document.querySelector('#formEditArtikel input[name="id"]').value = id;

    document.getElementById('edit_penulis').value = a.id_penulis;
    document.getElementById('edit_kategori').value = a.id_kategori;
    document.getElementById('edit_judul').value = a.judul;
    document.getElementById('edit_isi').value = a.isi;

    toggleModal('modalEditArtikel');
}

// submit edit
document.getElementById('formEditArtikel').addEventListener('submit', async function(e) {
    e.preventDefault();

    const fd = new FormData(this);

    // DEBUG WAJIB
    console.log("=== FORM DATA EDIT ===");
    for (let [k, v] of fd.entries()) {
        console.log(k, v);
    }

    const res = await fetch('artikel/update_artikel.php', {
        method: 'POST',
        body: fd
    });

    const text = await res.text();
    console.log("UPDATE RESPONSE:", text);

    const json = JSON.parse(text);

    if (json.status === 'success') {
        toggleModal('modalEditArtikel');
        loadArtikel();
    } else {
        alert('Gagal update');
    }
});
// ================= HAPUS =================
function hapusArtikel(id) {
    idHapusArtikel = id;
    toggleModal('modalHapusArtikel');
}

document.getElementById('btnHapusArtikel').addEventListener('click', async () => {

    const fd = new FormData();
    fd.append('id', idHapusArtikel);

    await fetch('artikel/hapus_artikel.php', {
        method: 'POST',
        body: fd
    });

    toggleModal('modalHapusArtikel');
    loadArtikel();
});

// ================= INIT =================
document.addEventListener('DOMContentLoaded', () => {
    loadArtikel();
    loadDropdown();
});

let currentView = 'penulis';

function switchView(view) {
    if (view === currentView) return;

    const views = {
        penulis: document.getElementById('view-penulis'),
        artikel: document.getElementById('view-artikel'),
        kategori: document.getElementById('view-kategori')
    };

    const prev = views[currentView];
    const next = views[view];

    if (!next || !prev) return;

    // mulai fade out view lama
    prev.classList.remove('active');

    // delay kecil untuk GPU sync (ini penting untuk 60fps feel)
    requestAnimationFrame(() => {
        // tampilkan view baru
        next.classList.add('active');
    });

    currentView = view;

    // sidebar update
    const buttons = {
        penulis: document.getElementById('btn-penulis'),
        artikel: document.getElementById('btn-artikel'),
        kategori: document.getElementById('btn-kategori')
    };

    Object.values(buttons).forEach(btn => {
        btn.classList.remove('sidebar-item-active');
    });

    buttons[view].classList.add('sidebar-item-active');

    if (view === 'kategori') {
        loadKategori();
    }
}
document.addEventListener('DOMContentLoaded', () => {

    // paksa sinkron awal
    const activeView =
        document.querySelector('.view-content.active')?.id?.replace('view-', '') 
        || 'penulis';

    switchView(activeView);
});
    </script>
</body>
</html>