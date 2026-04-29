<!DOCTYPE html>
<html>
    <head>
        <title>CMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <!-- CO:1 -->
        <div class="main-container">

            <!-- C0:2 header -->
            <div class="header">
                <!-- <div class="gambar"> -->
                    <img class="logo" src="img/itunes.png" alt="logo">
                <!-- </div> -->
                <h1>Sistem Manajemen Blog (CMS)</h1>
                <P>Blog Keren</P>
            </div>

            <!-- CO:2 (kiri & kanan) -->
            <div class="wrapper-container">

                <!-- CO:3 menu -->
                <div class="nav">
                    <h3 id="menu-utama">MENU UTAMA</h3>
                    <ul>
                        <li>
                            <img class="menu" src="img/user.png" alt="user">
                            <a href="javascript:void(0)" onclick="loadContent('penulis')">Kelola Penulis</a>
                        </li>
                        <li>
                            <img class="menu" src="img/document.png" alt="doc">
                            <a href="javascript:void(0)" onclick="loadContent('artikel')">Kelola Artikel</a>
                        </li>
                        <li>
                            <img class="menu" src="img/folder.png" alt="folder">
                            <a href="javascript:void(0)" onclick="loadContent('kategori')">Kelola Kategori</a>
                        </li>
                    </ul>
                </div>

                <!-- CO:3 konten -->
                <div class="main">
                    <div class="top-main">
                        <div class="judul">
                            <h3 id="text-judul">Daftar Penulis</h3>
                        </div>
    
                        <div class="tambah">
                            <h3 id="text-tambah">+ Tambah Penulis</h3>
                        </div>
                    </div>

                    <div class="list" id="content-area">
                        <p>Silakan pilih menu di samping.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TEMPLATE: Tabel Penulis -->
        <template id="temp-penulis">
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="isi-tabel-penulis">
                    </tbody>
            </table>
        </template>

        <template id="temp-kosong">
            <tr>
                <td colspan="5" class="pesan-kosong">Data belum ada...</td>
            </tr>
        </template>

        <!-- TEMPLATE: Modal Tambah Penulis -->
        <div id="modalPenulis" class="modal">
            <div class="modal-content">
                <h3 class="modal-title">Tambah Penulis</h3>
                <hr class="divider">
                
                <form id="formPenulis">
                    <input type="hidden" name="id_penulis" id="id_penulis">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Depan</label>
                            <input type="text" name="nama_depan" placeholder="Ahmad" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Belakang</label>
                            <input type="text" name="nama_belakang" placeholder="Fauzi" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user_name" placeholder="ahmad_f" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label>Foto Profil</label>
                        <input type="file" name="foto" class="file-input">
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                        <button type="submit" class="btn-simpan">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =========================
                TEMPLATE: Tabel Artikel 
            ========================= -->
        <template id="temp-artikel">
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="isi-tabel-artikel">
                    </tbody>
            </table>
        </template>


        <!-- =========================
                TEMPLATE: Tabel Kategori
            ========================= -->
        <template id="temp-kategori">
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th style="text-align: center;" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody id="isi-tabel-kategori">
                    </tbody>
            </table>
        </template>

        <!-- =========================
            TEMPLATE: Modal Tambah Kategori
            ========================= -->
        <div id="modalKategori" class="modal">
            <div class="modal-content">
                <h3 class="modal-title" id="titleKategori">Tambah Kategori</h3>
                <hr class="divider">
                
                <form id="formKategori">
                    <input type="hidden" name="id_kategori" id="id_kategori">
                    
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" placeholder="Contoh: Teknologi" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" placeholder="Deskripsi singkat kategori..." rows="4"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" onclick="tutupModalKategori()">Batal</button>
                        <button type="submit" class="btn-simpan">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- =========================
            TEMPLATE: Modal Edit Kategori
            ========================= -->
        <div id="modalKategori" class="modal">
            <div class="modal-content">
                <h3 class="modal-title" id="titleKategori">Tambah Kategori</h3>
                <hr class="divider">
                
                <form id="formKategori">
                    <input type="hidden" name="id_kategori" id="id_kategori">
                    
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" placeholder="Contoh: Teknologi" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" placeholder="Deskripsi singkat kategori..." rows="4"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" onclick="tutupModalKategori()">Batal</button>
                        <button type="submit" class="btn-simpan" id="btnSimpanKategori">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =========================
            TEMPLATE: Modal Hapus Global
            ========================= -->
        <div id="modalHapus" class="modal">
            <div class="modal-content" style="text-align:center; max-width:400px;">
                
                <div class="container-sampah">
                    <img id="sampah-edit" src="img/trash (1).png" alt="Sampah">
                </div>
                
                <h3>Hapus data ini?</h3>
                <p style="color:gray;">Data yang dihapus tidak dapat dikembalikan.</p>

                <input type="hidden" id="id_hapus">

                <div style="margin-top:20px;">
                    <button type="button" class="btn-batal-hapus" onclick="tutupModalHapus()">Batal</button>
                    <button type="button" class="btn-iya-hapus" id="btn-konfirmasi-hapus-global">Ya, Hapus</button>
                </div>
            </div>
        </div>

        <!-- =========================
            TEMPLATE: Tabel Artikel
            ========================= -->
        <template id="temp-artikel">
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th width="100">Gambar</th>
                        <th>Judul Artikel</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th width="120">Tanggal</th>
                        <th style="text-align: center;" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody id="isi-tabel-artikel">
                    </tbody>
            </table>
        </template>

        <!-- =========================
            TEMPLATE: Modal Tambah Artikel
            ========================= -->
        <div id="modalArtikel" class="modal">
            <div class="modal-content">
                <h3 class="modal-title" id="titleArtikel">Tambah Artikel</h3>
                <hr class="divider">
                
                <form id="formArtikel" enctype="multipart/form-data">
                    <input type="hidden" name="id_artikel" id="id_artikel">
                    
                    <div class="form-group">
                        <label>Judul Artikel</label>
                        <input type="text" name="judul" id="judul_artikel" placeholder="Masukkan judul artikel..." required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" id="opt_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Penulis</label>
                            <select name="id_penulis" id="opt_penulis" required>
                                <option value="">-- Pilih Penulis --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Isi Artikel</label>
                        <textarea name="isi" id="isi_artikel" rows="6" placeholder="Tuliskan konten artikel di sini..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label id="labelGambar">Gambar</label>
                        
                        <input type="file" name="gambar" id="gambar_artikel" class="file-input">
                        
                        <small id="keteranganGambar" style="color: gray;">
                            Format: JPG, PNG, WEBP (Maks. 2MB)
                        </small>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-batal" onclick="tutupModalArtikel()">Batal</button>
                        <button type="submit" class="btn-simpan" id="btnSimpanArtikel">Simpan Artikel</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            /*  =============================
                FUNGSI: Ganti Konten
                ============================= */  
            function loadContent(menu) {
                const judul = document.getElementById('text-judul');
                const tambah = document.getElementById('text-tambah');
                const area = document.getElementById('content-area');

                switch(menu) {
                    case 'penulis':
                        judul.innerText = "Daftar Penulis";
                        tambah.innerText = "+ Tambah Penulis";
                        
                        const temp = document.getElementById('temp-penulis').content.cloneNode(true);
                        const tbody = temp.getElementById('isi-tabel-penulis');

                        fetch('ambil_penulis.php')
                            .then(response => response.json())
                            .then(data => {
                                area.innerHTML = "";

                                if (data.error) {
                                    area.innerHTML = `<p style="color:red;">Error: ${data.error}</p>`;
                                } else if (data.length > 0) {
                                    data.forEach(item => {
                                        const row = `<tr>
                                            <td><img src="uploads_penulis/${item.foto}" class="img-table" onerror="this.src='uploads_penulis/default.png'"></td>

                                            <td>${item.nama_lengkap}</td>
                                            
                                            <td><span class="user-edit">${item.username}</span></td>
                                            
                                            <td>******</td> 
                                            
                                            <td>
                                                <button class="btn-edit" onclick="editPenulis(${item.id})">Edit</button>
                                                
                                                <button class="btn-hapus" onclick="hapusPenulis(${item.id})">Hapus</button>
                                            </td>
                                        </tr>`;
                                        tbody.innerHTML += row;
                                    });
                                    area.appendChild(temp); 
                                } else {
                                    const kosong = document.getElementById('temp-kosong').content.cloneNode(true);
                                    tbody.appendChild(kosong);
                                    area.appendChild(temp);
                                }
                            })
                            .catch(error => {
                                area.innerHTML = "<p style='color:red;'>Gagal menyambungkan ke server.</p>";
                            });
                        break;
                        
                    case 'artikel':
                        judul.innerText = "Daftar Artikel";
                        tambah.innerText = "+ Tambah Artikel";
                        
                        const tempArt = document.getElementById('temp-artikel').content.cloneNode(true);
                        const tbodyArt = tempArt.getElementById('isi-tabel-artikel');

                        fetch('ambil_artikel.php')
                        .then(response => response.json())
                        .then(data => {
                            area.innerHTML = "";
                    
                            const temp = document.getElementById('temp-artikel').content.cloneNode(true);
                            const tbody = temp.getElementById('isi-tabel-artikel');

                            if (data.length > 0) {
                                data.forEach(item => {
                                    const row = `<tr>
                                        <td><img src="uploads_artikel/${item.gambar}" width="60" class="img-table" onerror="this.src='img/no-image.png'"></td>
                                        <td><strong>${item.judul}</strong></td>
                                        <td><span class="badge-kategori">${item.nama_kategori}</span></td>
                                        <td>${item.nama_lengkap}</td>
                                        <td class="tgl-edit">${item.hari_tanggal}</td>
                                        <td align="center">
                                            <button class="btn-edit" onclick="editArtikel(${item.id})">Edit</button>
                                            <button class="btn-hapus" onclick="hapusArtikel(${item.id})">Hapus</button>
                                        </td>
                                    </tr>`;
                                    tbody.innerHTML += row;
                                });
                                area.appendChild(temp);
                            } else {
                                const kosong = document.getElementById('temp-kosong').content.cloneNode(true);
                                kosong.querySelector('td').setAttribute('colspan', 6);
                                tbody.appendChild(kosong);
                                area.appendChild(temp);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            area.innerHTML = "<p style='color:red;'>Gagal memuat data artikel.</p>";
                        });
                        break;
                    case 'kategori':
                        judul.innerText = "Daftar Kategori";
                        tambah.innerText = "+ Tambah Kategori";
                        
                        const tempKat = document.getElementById('temp-kategori').content.cloneNode(true);
                        const tbodyKat = tempKat.getElementById('isi-tabel-kategori');

                        fetch('ambil_kategori.php')
                            .then(response => response.json())
                            .then(data => {
                                area.innerHTML = "";

                                if (data.error) {
                                    area.innerHTML = `<p style="color:red;">Error: ${data.error}</p>`;
                                } else if (data.length > 0) {
                                    data.forEach(item => {
                                        const row = `<tr>
                                            <td><strong class="kategori-edit">${item.nama_kategori}</strong></td>
                                            <td>${item.keterangan}</td>
                                            <td align="center">
                                                <button class="btn-edit" onclick="editKategori(${item.id})">Edit</button>
                                                <button class="btn-hapus" onclick="hapusKategori(${item.id})">Hapus</button>
                                            </td>
                                        </tr>`;
                                        tbodyKat.innerHTML += row;
                                    });
                                    area.appendChild(tempKat);
                                } else {
                                    const kosong = document.getElementById('temp-kosong').content.cloneNode(true);
                                    kosong.querySelector('td').setAttribute('colspan', 3);
                                    tbodyKat.appendChild(kosong);
                                    area.appendChild(tempKat);
                                }
                            })
                            .catch(error => {
                                area.innerHTML = "<p style='color:red;'>Gagal menyambungkan ke server.</p>";
                            });
                        break;
                }
            }
            
            /*  =============================
                FUNGSI: Edit Penulis
                ============================= */ 
            function editPenulis(id) {
                fetch(`ambil_satu_penulis.php?id=${id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("HTTP error " + response.status);
                        }
                        return response.text(); 
                    })
                    .then(text => {
                        console.log("Response:", text); 

                        let result;
                        try {
                            result = JSON.parse(text);
                        } catch (e) {
                            throw new Error("Response bukan JSON");
                        }

                        if (result.status === 'sukses') {
                           const penulis = result.data;

                            document.querySelector('.modal-title').innerText = "Edit Penulis";
                            document.querySelector('.btn-simpan').innerText = "Simpan Perubahan";

                            document.getElementById('id_penulis').value = penulis.id;
                            document.getElementsByName('nama_depan')[0].value = penulis.nama_depan;
                            document.getElementsByName('nama_belakang')[0].value = penulis.nama_belakang;
                            document.getElementsByName('user_name')[0].value = penulis.username;

                            const passwordField = document.getElementsByName('password')[0];
                            passwordField.required = false;
                            passwordField.value = "";
                            passwordField.placeholder = "Kosongkan jika tidak diganti";

                            document.getElementById('modalPenulis').style.display = 'block';
                        } else {
                            alert("Gagal: " + result.pesan);
                        }
                    })
                    .catch(error => {
                        console.error("DETAIL ERROR:", error);
                        alert("Gagal koneksi / response tidak valid");
                    });
            }


            /*  =============================
                FUNGSI: Membuka Modal Tambah Penulis
                ============================= */ 
                function bukaModalPenulis() {
                    const form = document.getElementById('formPenulis');
                    form.reset();
                    document.getElementById('id_penulis').value = "";
                    document.querySelector('.modal-title').innerText = "Tambah Penulis";
                    document.querySelector('.btn-simpan').innerText = "Simpan Data";
                    
                    // Reset field password untuk tambah baru
                    const pw = document.getElementsByName('password')[0];
                    if(pw) {
                        pw.required = true;
                        pw.placeholder = "••••••••";
                    }
                    
                    document.getElementById('modalPenulis').style.display = 'block';
                }

                function tutupModal() {
                    document.getElementById('modalPenulis').style.display = 'none';
                    document.getElementById('formPenulis').reset();
                }
                            
            // --- Menangani pengiriman formulir menggunakan FETCH (AJAX)
            document.getElementById('formPenulis').addEventListener('submit', function(e) {
                e.preventDefault(); 

                const formData = new FormData(this);
                const id = document.getElementById('id_penulis').value;
                const urlTujuan = id ? 'update_penulis.php' : 'simpan_penulis.php';


                fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'sukses') {
                        alert(result.pesan);
                        tutupModal();         
                        loadContent('penulis'); 
                    } else {
                        alert("Terjadi Kesalahan: " + result.pesan);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Gagal mengirim data ke server.");
                });
            });

            /*  =============================
                FUNGSI: Membuka modal hapus
                ============================= */ 
            function hapusPenulis(id) {
                document.getElementById('id_hapus').value = id;
                
                const btnIya = document.getElementById('btn-konfirmasi-hapus-global');
                btnIya.onclick = function() {
                    eksekusiHapusData('hapus_penulis.php', 'penulis');
                };
                
                document.getElementById('modalHapus').style.display = 'block';
            }

            /*  =============================
                FUNGSI: Menutup modal hapus
                ============================= */ 
            function tutupModalHapus() {
                document.getElementById('modalHapus').style.display = 'none';
                document.getElementById('id_hapus').value = "";
            }

            /*  =============================
                FUNGSI: Edit Kategori
                ============================= */ 
            function editKategori(id) {
                // 1. Ambil data dari server berdasarkan ID
                fetch(`ambil_satu_kategori.php?id=${id}`)
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === "sukses") {
                            document.getElementById('id_kategori').value = result.data.id;
                            document.getElementById('nama_kategori').value = result.data.nama_kategori;
                            document.getElementById('keterangan').value = result.data.keterangan;

                            document.getElementById('titleKategori').innerText = "Edit Kategori";
                            document.getElementById('btnSimpanKategori').innerText = "Update Kategori";
                            
                            document.getElementById('modalKategori').style.display = "block";
                        } else {
                            alert("Gagal mengambil data: " + result.pesan);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Terjadi kesalahan koneksi saat mengambil data.");
                    });
            }

            /*  =============================
                FUNGSI: Modal Tambah Kategori
                ============================= */ 
            const modalKategori = document.getElementById('modalKategori');
            const formKategori = document.getElementById('formKategori');
            const btnTambah = document.querySelector('.tambah'); 

            btnTambah.onclick = function() {
                const judulMenu = document.getElementById('text-judul').innerText;
                if (judulMenu === "Daftar Kategori") {
                    bukaModalKategori();
                } else if (judulMenu === "Daftar Penulis") {
                    document.getElementById('modalPenulis').style.display = "block";
                }
            };


            formKategori.onsubmit = function(e) {
                e.preventDefault();
        
                const formData = new FormData(formKategori);
                const id = document.getElementById('id_kategori').value;

                const urlTujuan = id ? 'update_kategori.php' : 'simpan_kategori.php';
                
                fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "sukses") { 
                        alert(data.pesan);
                        tutupModalKategori();
                        loadContent('kategori'); 
                    } else {
                        alert("Terjadi Kesalahan: " + data.pesan);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Gagal memproses data.");
                });
            };

            /*  =============================
                FUNGSI: Kontrol Modal Kategori
                ============================= */
            function bukaModalKategori() {
                const form = document.getElementById('formKategori');
                form.reset();
                document.getElementById('id_kategori').value = "";
                document.getElementById('titleKategori').innerText = "Tambah Kategori";
                
                document.getElementById('modalKategori').style.display = "block";
            }

            function tutupModalKategori() {
                document.getElementById('modalKategori').style.display = "none";
            }

            /*  =============================
                FUNGSI: Trigger Modal Hapus Kategori
                ============================= */
            function hapusKategori(id) {
                document.getElementById('id_hapus').value = id;
    
                const btnIya = document.getElementById('btn-konfirmasi-hapus-global');
                btnIya.onclick = function() {
                    eksekusiHapusData('hapus_kategori.php', 'kategori');
                };
                
                document.getElementById('modalHapus').style.display = 'block';
            }

            /*  =============================
                FUNGSI: Trigger Modal Hapus Penulis
                ============================= */
            function hapusPenulis(id) {
                document.getElementById('id_hapus').value = id;
                
                // Pasang perintah ke tombol konfirmasi di modal
                const btnIya = document.getElementById('btn-konfirmasi-hapus-global');
                btnIya.onclick = function() {
                    eksekusiHapusData('hapus_penulis.php', 'penulis');
                };
                
                document.getElementById('modalHapus').style.display = 'block';
            }

            function tutupModalHapus() {
                document.getElementById('modalHapus').style.display = 'none';
                document.getElementById('id_hapus').value = "";
            }


            /*  =============================
                FUNGSI: Eksekusi Hapus (General)
                ============================= */
            function eksekusiHapusData(urlTujuan, menuAsal) {
                const id = document.getElementById('id_hapus').value;
                const formData = new FormData();
                formData.append('id', id);

                fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) 
                .then(result => {
                    if (result.status === 'sukses') {
                        alert(result.pesan);
                        tutupModalHapus();
                        loadContent(menuAsal); 
                    } else {
                        alert("Gagal: " + result.pesan);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Gagal menghapus data. Pastikan server merespon dengan JSON.");
                });
            }

            /*  =============================
                FUNGSI: Muat Pilihan Kategori (Dropdown)
                ============================= */
            function muatPilihanKategori() {
                fetch('ambil_kategori.php')
                    .then(response => response.json())
                    .then(data => {
                        const selectKat = document.getElementById('opt_kategori');
                        if (!selectKat) return;
                        
                        selectKat.innerHTML = '<option value="">-- Pilih Kategori --</option>';

                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                const option = `<option value="${item.id}">${item.nama_kategori}</option>`;
                                selectKat.innerHTML += option;
                            });
                        }
                    })
                    .catch(error => console.error('Gagal muat kategori:', error));
            }

            /*  =============================
                FUNGSI: Muat Pilihan Penulis (Dropdown)
                ============================= */
            function muatPilihanPenulis() {
                fetch('ambil_penulis.php')
                    .then(response => response.json())
                    .then(data => {
                        const selectPen = document.getElementById('opt_penulis');
                        if (!selectPen) return;

                        selectPen.innerHTML = '<option value="">-- Pilih Penulis --</option>';

                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                let namaTampil = "";
                                // Prioritas tampilan
                                if (item.nama_lengkap && item.nama_lengkap.trim() !== "") {
                                    namaTampil = item.nama_lengkap;
                                } else if (item.user_name) {
                                    namaTampil = item.user_name;
                                } else {
                                    namaTampil = "Penulis " + item.id;
                                }


                                const option = `<option value="${item.id}">${namaTampil}</option>`;
                                selectPen.innerHTML += option;
                            });
                        }
                    })
                    .catch(error => console.error('Gagal muat penulis:', error));
            }

            /*  =============================
                FUNGSI: Kontrol Modal Artikel
                ============================= */
            function bukaModalArtikel() {
                const modal = document.getElementById('modalArtikel');
                const form = document.getElementById('formArtikel');
                
                if (form) form.reset();
                
                // Reset ID dan Judul Modal
                if (document.getElementById('id_artikel')) {
                    document.getElementById('id_artikel').value = "";
                }
                if (document.getElementById('titleArtikel')) {
                    document.getElementById('titleArtikel').innerText = "Tambah Artikel";
                }
            
                document.getElementById('btnSimpanArtikel').innerText = "Simpan Data";

                const inputFile = document.getElementById('gambar_artikel');
                const label = document.getElementById('labelGambar');
                const ket = document.getElementById('keteranganGambar');

                inputFile.required = true;
                label.innerHTML = 'Gambar <small>(Wajib diisi)</small>';
                ket.innerHTML = 'Format: JPG, PNG, WEBP (Maks. 2MB)';

                muatPilihanKategori();
                muatPilihanPenulis();

                if (modal) modal.style.display = "block";
            }

            function tutupModalArtikel() {
                const modalTambah = document.getElementById('modalArtikel');
                const modalEdit = document.getElementById('modalArtikelEdit');

                if (modalTambah) modalTambah.style.display = "none";
                if (modalEdit) modalEdit.style.display = "none";
            }

            /*  =============================
                FUNGSI: Submit Form Artikel
                ============================= */
            document.getElementById('formArtikel').onsubmit = function(e) {
                e.preventDefault(); 
                const formData = new FormData(this);
                
                const idArtikel = document.getElementById('id_artikel').value;
                const urlTujuan = idArtikel === "" ? 'simpan_artikel.php' : 'update_artikel.php';

                const btnSimpan = document.getElementById('btnSimpanArtikel');
                const originalText = btnSimpan.innerText;
                btnSimpan.innerText = "Menyimpan...";
                btnSimpan.disabled = true;

                fetch(urlTujuan, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'sukses') {
                        alert(data.pesan);
                        tutupModalArtikel();
                        loadContent('artikel'); 
                    } else {
                        alert("Gagal: " + data.pesan);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan koneksi ke server.");
                })
                .finally(() => {
                    btnSimpan.innerText = originalText;
                    btnSimpan.disabled = false;
                });
            };

            /*  =============================
                FUNGSI: Edit Artikel (Ambil Data & Buka Modal)
                ============================= */
            function editArtikel(id) {
                fetch(`ambil_satu_artikel.php?id=${id}`)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'sukses') {
                            const d = res.data;

                            // Konsistensi UI: Ubah judul modal dan tombol
                            document.getElementById('titleArtikel').innerText = "Edit Artikel";
                            document.getElementById('btnSimpanArtikel').innerText = "Simpan Perubahan";

                            // Isi field form
                            document.getElementById('id_artikel').value = d.id;
                            document.getElementById('judul_artikel').value = d.judul;
                            document.getElementById('isi_artikel').value = d.isi;

                            muatPilihanKategoriEdit(d.id_kategori);
                            muatPilihanPenulisEdit(d.id_penulis);

                            const inputFile = document.getElementById('gambar_artikel');
                            const label = document.getElementById('labelGambar');
                            const ket = document.getElementById('keteranganGambar');

                            inputFile.required = false;
                            label.innerHTML = 'Gambar';
                            ket.innerHTML = `
                                Format: JPG, PNG, WEBP (Maks. 2MB)<br>
                                Kosongkan jika tidak ingin mengubah gambar
                            `;

                            document.getElementById('modalArtikel').style.display = "block";
                        } else {
                            alert("Gagal: " + res.pesan);
                        }
                    })
                    .catch(err => {
                        console.error("Error Fetch Edit:", err);
                        alert("Terjadi kesalahan saat mengambil data artikel.");
                    });
            }

            function muatPilihanKategoriEdit(selectedId) {
                fetch('ambil_kategori.php')
                    .then(r => r.json())
                    .then(data => {
                        const s = document.getElementById('opt_kategori');
                        s.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                        data.forEach(item => {
                            const selected = item.id == selectedId ? 'selected' : '';
                            s.innerHTML += `<option value="${item.id}" ${selected}>${item.nama_kategori}</option>`;
                        });
                    });
            }

            function muatPilihanPenulisEdit(selectedId) {
                fetch('ambil_penulis.php')
                    .then(r => r.json())
                    .then(data => {
                        const s = document.getElementById('opt_penulis');
                        if (!s) return;

                        s.innerHTML = '<option value="">-- Pilih Penulis --</option>';

                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                const selected = item.id == selectedId ? 'selected' : '';
                                
                                let namaTampil = "";
                                if (item.nama_lengkap) {
                                    namaTampil = item.nama_lengkap;
                                } else if (item.username) {
                                    namaTampil = item.username;
                                } else {
                                    namaTampil = "Penulis #" + item.id;
                                }

                                s.innerHTML += `<option value="${item.id}" ${selected}>${namaTampil}</option>`;
                            });
                        }
                    })
                    .catch(err => console.error("Gagal muat dropdown penulis:", err));
            }

            /* =============================
                FUNGSI: Kontrol Modal Hapus Artikel
            ============================= */
            function hapusArtikel(id) {
                document.getElementById('id_hapus').value = id;
                const btnIya = document.getElementById('btn-konfirmasi-hapus-global');
                btnIya.onclick = function() {
                    eksekusiHapusData('hapus_artikel.php', 'artikel');
                };
                document.getElementById('modalHapus').style.display = "block";
            }

            // 2. Fungsi tutup modal hapus
            function tutupModalHapus() {
                document.getElementById('modalHapus').style.display = "none";
            }

            
            /*  =============================
                FUNGSI TERPUSAT: Tombol Tambah
                ============================= */
            const btnTambahHeader = document.querySelector('.tambah');
            if (btnTambahHeader) {
                btnTambahHeader.onclick = function() {
                    const judulMenu = document.getElementById('text-judul').innerText;

                    if (judulMenu === "Daftar Penulis") {
                        if (typeof bukaModalPenulis === "function") bukaModalPenulis();
                    } else if (judulMenu === "Daftar Kategori") {
                        if (typeof bukaModalKategori === "function") bukaModalKategori();
                    } else if (judulMenu === "Daftar Artikel") {
                        bukaModalArtikel();
                    }
                };
            }

            /*  =============================
                FUNGSI: Tutup Modal (Global)
                ============================= */
            window.onclick = function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.style.display = "none";
                }
            };
        </script>
    </body>
</html>
