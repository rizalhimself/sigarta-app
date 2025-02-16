document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Data Penduduk JS Loaded!"); // Debugging

    // ✅ Function untuk menampilkan modal dengan isi yang berbeda
    window.showModal = function (title, content, footer) {
        document.getElementById("modalTitle").textContent = title;
        document.getElementById("modalContent").innerHTML = content;
        document.getElementById("modalFooter").innerHTML = footer;

        // **Hapus class yang menyembunyikan modal**
        modal.classList.remove("invisible", "opacity-0");
        modal.classList.add("opacity-100");

        let modalContent = modal.querySelector(".transform");
        if (modalContent) {
            modalContent.classList.remove("scale-95");
            modalContent.classList.add("scale-100");
        }

        // Kosongkan password saat diklik
        const passwordInput = document.getElementById("passwordInput");
        if (passwordInput) {
            passwordInput.addEventListener("focus", function () {
                this.value = "";
            });
        }

        // Event listener untuk tombol close modal
        const closeModalButton = document.getElementById("closeModalButton");
        if (closeModalButton) {
            closeModalButton.addEventListener("click", closeModal);
        }

        // Attach event listener untuk input file (validasi gambar)
        document.querySelectorAll("input[type='file']").forEach((input) => {
            input.addEventListener("change", function (event) {
                const previewId = this.getAttribute("data-preview");
                if (previewId) {
                    validateImage(event, previewId);
                }
            });
        });
    };

    // ✅ Function untuk menutup modal
    window.closeModal = function () {
        const modal = document.getElementById("modal");
        modal.classList.remove("opacity-100");

        let modalContent = modal.querySelector(".transform");
        if (modalContent) {
            modalContent.classList.remove("scale-100");
            modalContent.classList.add("scale-95");
        }
        modal.classList.add("opacity-0");

        // **Tunggu animasi selesai sebelum menyembunyikan modal**
        setTimeout(() => {
            modal.classList.add("invisible");
        }, 300); // Sesuaikan dengan durasi transisi CSS (300ms)

        // Hapus isi modal agar tidak ada event listener yang tertinggal
        document.getElementById("modalContent").innerHTML = "";
        document.getElementById("modalFooter").innerHTML = "";
    };

    // ✅ Function untuk validasi gambar sebelum upload
    window.validateImage = function (event, previewId) {
        let file = event.target.files[0];

        if (file) {
            // Cek format file
            let validExtensions = ["image/jpeg", "image/png", "image/jpg"];
            if (!validExtensions.includes(file.type)) {
                alert("❌ Format gambar harus JPEG, PNG, atau JPG!");
                event.target.value = ""; // Reset input file
                return;
            }

            // Cek ukuran file (maksimal 2MB)
            if (file.size > 2048 * 1024) {
                alert("❌ Ukuran gambar maksimal 2MB!");
                event.target.value = ""; // Reset input file
                return;
            }

            // Preview gambar jika lolos validasi
            let reader = new FileReader();
            reader.onload = function () {
                let preview = document.getElementById(previewId);
                if (preview) {
                    preview.src = reader.result;
                    preview.classList.remove("hidden");
                }
            };
            reader.readAsDataURL(file);
        }
    };

    // ✅ Function untuk menampilkan Detail Penduduk di Modal
    window.showDetail = function (id) {
        fetch(`/data-penduduk/${id}`)
            .then((response) => response.json())
            .then((data) => {
                showModal(
                    "Detail Penduduk - " + data.nama_lengkap,
                    `
                    <p><strong>NIK:</strong> ${data.nik}</p>
                    <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
                    <p><strong>Tanggal Lahir:</strong> ${data.tgl_lahir}</p>
                    <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin}</p>
                    <p><strong>No Telepon:</strong> ${data.no_telfon}</p>
                    <p><strong>Alamat:</strong> ${
                        data.keluarga?.rumah?.no_rumah ?? "-"
                    }</p>
                    <p><strong>Foto:</strong><br>
                        <img src="/storage/${
                            data.link_foto
                        }" class="w-32 h-32 mt-2 rounded-lg shadow">
                    </p>
                    <p><strong>Foto KTP:</strong><br>
                        <img src="/storage/${
                            data.link_foto_ktp
                        }" class="w-32 h-32 mt-2 rounded-lg shadow">
                    </p>
                    `,
                    `<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>`
                );
            })
            .catch((error) => console.error("❌ Error Fetching Data:", error));
    };

    // ✅ Function untuk menampilkan form Edit Penduduk di modal
    window.showEditForm = function (id) {
        fetch(`/data-penduduk/${id}`)
            .then((response) => response.json())
            .then((data) => {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                showModal(
                    "Edit Penduduk - " + data.nama_lengkap,
                    `
                    <form id="pendudukForm" action="/data-penduduk/${
                        data.id
                    }" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="user_id" value="${
                            data.user_id
                        }">

                         <!-- Data User -->
                        <div>
                            <label class="block text-sm font-medium">Username</label>
                            <input type="text" name="username" value="${
                                data.user ? data.user.username : ""
                            }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email" name="email" value="${
                                data.user ? data.user.email : ""
                            }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="passwordInput" value="••••••" 
                            class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Role</label>
                            <select name="golongan_darah" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                                <option value="warga" ${
                                    data.user.role === "warga" ? "selected" : ""
                                }>Warga</option>
                                <option value="ketua" ${
                                    data.user.role === "ketua" ? "selected" : ""
                                }>Ketua</option>
                                <option value="kadus" ${
                                    data.user.role === "kadus" ? "selected" : ""
                                }>Kadus</option>
                                <option value="sekertaris" ${
                                    data.user.role === "sekertaris"
                                        ? "selected"
                                        : ""
                                }>Sekertaris</option>
                                <option value="bendahara1" ${
                                    data.user.role === "bendahara1"
                                        ? "selected"
                                        : ""
                                }>Bendahara 1</option>
                                <option value="bendahara2" ${
                                    data.user.role === "bendahara2"
                                        ? "selected"
                                        : ""
                                }>Bendahara 2</option>
                                <option value="humas" ${
                                    data.user.role === "humas" ? "selected" : ""
                                }>Humas</option>
                                <option value="kerohanian" ${
                                    data.user.role === "kerohanian"
                                        ? "selected"
                                        : ""
                                }>Kerohanian</option>
                                <option value="pembantuUmum" ${
                                    data.user.role === "pembantuUmum"
                                        ? "selected"
                                        : ""
                                }>Pembantu Umum</option>
                                <option value="admin" ${
                                    data.user.role === "admin" ? "selected" : ""
                                }>Admin</option>
                            </select>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-medium">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="${
                                data.nama_lengkap
                            }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required autofocus>
                        </div>
                        <!-- NIK -->
                        <div>
                            <label class="block text-sm font-medium">NIK</label>
                            <input type="text" name="nik" value="${
                                data.nik
                            }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\\d{16}" title="Harus 16 digit" required>
                        </div>
                        <!-- Tempat & Tanggal Lahir -->
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="${
                                    data.tempat_lahir
                                }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" value="${
                                    data.tgl_lahir
                                }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                            </div>
                        </div>
                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                                <option value="L" ${
                                    data.jenis_kelamin === "L" ? "selected" : ""
                                }>Laki-laki</option>
                                <option value="P" ${
                                    data.jenis_kelamin === "P" ? "selected" : ""
                                }>Perempuan</option>
                            </select>
                        </div>
                        <!-- Golongan Darah -->
                        <div>
                            <label class="block text-sm font-medium">Golongan Darah</label>
                            <select name="golongan_darah" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                                <option value="A" ${
                                    data.golongan_darah === "A"
                                        ? "selected"
                                        : ""
                                }>A</option>
                                <option value="B" ${
                                    data.golongan_darah === "B"
                                        ? "selected"
                                        : ""
                                }>B</option>
                                <option value="AB" ${
                                    data.golongan_darah === "AB"
                                        ? "selected"
                                        : ""
                                }>AB</option>
                                <option value="O" ${
                                    data.golongan_darah === "O"
                                        ? "selected"
                                        : ""
                                }>O</option>
                                <option value="-" ${
                                    data.golongan_darah === "-"
                                        ? "selected"
                                        : ""
                                }>Tidak Diketahui</option>
                            </select>
                        </div>
                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-medium">Agama</label>
                            <select name="agama" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                                <option value="Islam" ${
                                    data.agama === "Islam" ? "selected" : ""
                                }>Islam</option>
                                <option value="Kristen" ${
                                    data.agama === "Kristen" ? "selected" : ""
                                }>Kristen</option>
                                <option value="Katolik" ${
                                    data.agama === "Katolik" ? "selected" : ""
                                }>Katolik</option>
                                <option value="Hindu" ${
                                    data.agama === "Hindu" ? "selected" : ""
                                }>Hindu</option>
                                <option value="Budha" ${
                                    data.agama === "Budha" ? "selected" : ""
                                }>Budha</option>
                                <option value="Konghucu" ${
                                    data.agama === "Konghucu" ? "selected" : ""
                                }>Konghucu</option>
                            </select>
                        </div>
                        <!-- Status Perkawinan -->
                        <div>
                            <label class="block text-sm font-medium">Status Perkawinan</label>
                            <select name="status_perkawinan" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                                <option value="Kawin" ${
                                    data.status_perkawinan === "Kawin"
                                        ? "selected"
                                        : ""
                                }>Kawin</option>
                                <option value="Belum Kawin" ${
                                    data.status_perkawinan === "Belum Kawin"
                                        ? "selected"
                                        : ""
                                }>Belum Kawin</option>
                                <option value="Cerai Hidup" ${
                                    data.status_perkawinan === "Cerai Hidup"
                                        ? "selected"
                                        : ""
                                }>Cerai Hidup</option>
                                <option value="Cerai Mati" ${
                                    data.status_perkawinan === "Cerai Mati"
                                        ? "selected"
                                        : ""
                                }>Cerai Mati</option>
                            </select>
                        </div>
                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-sm font-medium">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="${
                                data.pekerjaan ?? ""
                            }"
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300"
                                maxlength="255" required>
                        </div>

                        <!-- Kewarganegaraan -->
                        <div>
                            <label class="block text-sm font-medium">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="${
                                data.kewarganegaraan ?? ""
                            }"
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300"
                                maxlength="255" required>
                        </div>
                        <!-- No Telepon -->
                        <div>
                            <label class="block text-sm font-medium">No Telepon</label>
                            <input type="text" name="no_telfon" value="${
                                data.no_telfon
                            }" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\\d+" required>
                        </div>
                       <!-- Upload Foto Profil -->
                        <div>
                            <label class="block text-sm font-medium">Upload Foto Profil</label>
                            <input type="file" name="link_foto" accept="image/*" 
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300" 
                                onchange="validateImage(event, 'previewFoto')">
                            <img id="previewFoto" src="/storage/${
                                data.link_foto
                            }" 
                                class="mt-2 w-32 h-32 rounded-lg shadow" />
                        </div>

                        <!-- Upload Foto KTP -->
                        <div>
                            <label class="block text-sm font-medium">Upload Foto KTP</label>
                            <input type="file" name="link_foto_ktp" accept="image/*" 
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300" 
                                onchange="validateImage(event, 'previewKTP')">
                            <img id="previewKTP" src="/storage/${
                                data.link_foto_ktp
                            }" 
                                class="mt-2 w-32 h-32 rounded-lg shadow" />
                        </div>
                    </form>
                    `,
                    `
                    <button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" form="pendudukForm" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                    `
                );
            })
            .catch((error) => console.error("❌ Error Fetching Data:", error));
    };

    // Function untuk pencarian penduduk dengan debounce dan ajax
    let searchTimeout;
    window.searchPenduduk = function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            let searchValue = document
                .getElementById("searchPenduduk")
                .value.trim();
            let url =
                "/data-penduduk/search?q=" + encodeURIComponent(searchValue);

            console.log("🔍 Fetching data from:", url); // Debugging

            fetch(url)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("✅ Fetched Data:", data); // Debugging data

                    let tableBody = document.getElementById("pendudukTable");
                    tableBody.innerHTML = ""; // Kosongkan tabel sebelum update

                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4">Data tidak ditemukan.</td></tr>`;
                        return;
                    }

                    // Update tabel dengan hasil pencarian
                    data.forEach((w, index) => {
                        tableBody.innerHTML += `
                        <tr class="text-center">
                            <td class="py-2 px-4 border">${index + 1}</td>
                            <td class="py-2 px-4 border">${
                                w.keluarga?.rumah?.no_rumah ?? "-"
                            }</td>
                            <td class="py-2 px-4 border">${
                                w.keluarga?.id ?? "-"
                            }</td>
                            <td class="py-2 px-4 border text-blue-500 cursor-pointer" onclick="showDetail(${
                                w.id
                            })">
                                ${w.nama_lengkap}
                            </td>
                            <td class="py-2 px-4 border">${w.jenis_kelamin}</td>
                            <td class="py-2 px-4 border">${w.umur ?? "-"}</td>
                            <td class="py-2 px-4 border">
                                <button onclick="editPenduduk(${
                                    w.id
                                })" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                <button data-id="${
                                    w.id
                                }" class="bg-red-500 text-white px-2 py-1 rounded deletePendudukBtn">Hapus</button>
                            </td>
                        </tr>`;
                    });
                })
                .catch((error) => {
                    console.error("❌ Error Fetching Data:", error);
                    alert("Terjadi kesalahan saat mengambil data pencarian!");
                });
        }, 500);
    };

    // Function untuk sorting tabel berdasarkan kolom yang diklik
    window.sortTable = function (colIndex) {
        let table = document.querySelector("table tbody");
        let rows = Array.from(table.rows);

        let sortedRows = rows.sort((a, b) => {
            let aText = a.cells[colIndex].textContent.trim();
            let bText = b.cells[colIndex].textContent.trim();

            return aText.localeCompare(bText, undefined, { numeric: true });
        });

        table.innerHTML = "";
        sortedRows.forEach((row) => table.appendChild(row));

        console.log(`🔀 Tabel di-sort berdasarkan kolom ke-${colIndex}`);
    };

    // Function untuk me-reload data penduduk utama saat search bar kosong
    function fetchDataPenduduk() {
        fetch(`/data-penduduk`)
            .then((response) => response.text())
            .then((html) => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");
                let newTable = doc.getElementById("pendudukTable").innerHTML;
                document.getElementById("pendudukTable").innerHTML = newTable;
            })
            .catch((error) =>
                console.error("Error fetching default data:", error)
            );
    }

    // Function untuk mengedit penduduk
    window.editPenduduk = function (id) {
        window.location.href = `/data-penduduk/${id}/edit`;
    };

    // Function untuk menghapus penduduk dengan event delegation
    document
        .getElementById("pendudukTable")
        .addEventListener("click", function (event) {
            if (event.target.classList.contains("deletePendudukBtn")) {
                let id = event.target.dataset.id;
                if (
                    confirm("Apakah Anda yakin ingin menghapus penduduk ini?")
                ) {
                    fetch(`/data-penduduk/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert("Penduduk berhasil dihapus.");
                                location.reload();
                            } else {
                                alert("Gagal menghapus penduduk.");
                            }
                        })
                        .catch((error) => console.error("Error:", error));
                }
            }
        });

    // Function untuk menampilkan modal tambah penduduk
    window.showAddPendudukModal = function () {
        console.log("Tombol Tambah Penduduk Diklik!");
        window.location.href = "/data-penduduk/create";
    };
});
