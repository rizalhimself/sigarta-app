document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Data Penduduk JS Loaded!"); // Debugging

    // Ambil elemen modal detail penduduk
    let modal = document.getElementById("pendudukModal");
    let modalContent = modal.querySelector(".transform");

    // Function untuk preview gambar
    window.previewImage = function (event, id) {
        let reader = new FileReader();
        reader.onload = function () {
            let output = document.getElementById(id);
            output.src = reader.result;
            output.classList.remove("hidden");
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    // Function untuk menambahkan event listener ke input file
    function setupImagePreview() {
        const fileInputs = document.querySelectorAll(
            "input[type='file'][onchange*='previewImage']"
        );
        fileInputs.forEach((input) => {
            const id = input.getAttribute("onchange").split("'")[1]; // Ambil ID dari onchange
            input.addEventListener("change", (event) => {
                previewImage(event, id);
            });
        });
    }

    // Function untuk menampilkan detail penduduk
    window.showDetail = function (id) {
        fetch(`/data-penduduk/${id}`)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("modalTitle").innerText =
                    "Detail Penduduk - " + data.nama_lengkap;
                document.getElementById("modalContent").innerHTML = `
                     <p><strong>NIK:</strong> ${data.nik}</p>
                     <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
                     <p><strong>Tanggal Lahir:</strong> ${data.tgl_lahir}</p>
                     <p><strong>Jenis Kelamin:</strong> ${
                         data.jenis_kelamin
                     }</p>
                     <p><strong>No Telepon:</strong> ${data.no_telfon}</p>
                     <p><strong>Alamat:</strong> ${
                         data.keluarga?.rumah?.no_rumah ?? "-"
                     }</p>
                     <p><strong>Foto:</strong> <br>
                         <img src="/storage/${
                             data.link_foto
                         }" alt="Foto Warga" class="w-32 h-32 mt-2 rounded-lg shadow">
                     </p>
                     <p><strong>Foto KTP:</strong> <br>
                         <img src="/storage/${
                             data.link_foto_ktp
                         }" alt="Foto KTP" class="w-32 h-32 mt-2 rounded-lg shadow">
                     </p>
                 `;

                // Tampilkan modal
                openModal();
            })
            .catch((error) => console.error("Error:", error));
    };

    // Function untuk menampilkan form tambah data
    window.showAddForm = function () {
        const modalTitle = document.getElementById("modalTitle");
        const modalContent = document.getElementById("modalContent");
        const modalFooter = document.getElementById("modalFooter");

        // Set judul modal
        modalTitle.textContent = "Tambah Penduduk";

        // Isi konten modal dengan form tambah data
        modalContent.innerHTML = `
            <form id="pendudukForm" action="{{ route('data-penduduk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required autofocus>
                </div>
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium">NIK</label>
                    <input type="text" name="nik" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\\d{16}" title="Harus 16 digit" required>
                </div>
                <!-- Tempat & Tanggal Lahir -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium">No Telepon</label>
                    <input type="text" name="no_telfon" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\\d+" required>
                </div>
                <!-- Upload Foto Profil -->
                <div>
                    <label class="block text-sm font-medium">Upload Foto Profil</label>
                    <input type="file" name="link_foto" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="previewImage(event, 'previewFoto')">
                    <img id="previewFoto" class="mt-2 hidden w-32 h-32 rounded-lg shadow" />
                </div>
                <!-- Upload Foto KTP -->
                <div>
                    <label class="block text-sm font-medium">Upload Foto KTP</label>
                    <input type="file" name="link_foto_ktp" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="previewImage(event, 'previewKTP')">
                    <img id="previewKTP" class="mt-2 hidden w-32 h-32 rounded-lg shadow" />
                </div>
            </form>
        `;

        // Setup event listener untuk input file
        setupImagePreview();

        // Isi footer modal dengan tombol "Batal" dan "Simpan"
        modalFooter.innerHTML = `
            <button type="button" id="closeModalButton"
                class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                Batal
            </button>
            <button type="submit" form="pendudukForm"
                class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
            </button>
        `;

        // Tampilkan modal
        openModal();
    };

    // Function untuk menampilkan form edit data
    window.showEditForm = function (id) {
        fetch(`/data-penduduk/${id}`)
            .then((response) => response.json())
            .then((data) => {
                const modalTitle = document.getElementById("modalTitle");
                const modalContent = document.getElementById("modalContent");
                const modalFooter = document.getElementById("modalFooter");

                // Set judul modal
                modalTitle.textContent = "Edit Penduduk - " + data.nama_lengkap;

                // Isi konten modal dengan form edit data
                modalContent.innerHTML = `
                    <form id="pendudukForm" action="/data-penduduk/${
                        data.id
                    }" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                                <option value="A" ${data.golongan_darah === "A" ? "selected" : ""}>A</option>
                                <option value="B" ${data.golongan_darah === "B" ? "selected" : ""}>B</option>
                                <option value="AB" ${data.golongan_darah === "AB" ? "selected" : ""}>AB</option>
                                <option value="O" ${data.golongan_darah === "O" ? "selected" : ""}>O</option>
                                <option value="-" ${data.golongan_darah === "-" ? "selected" : ""}>Tidak Diketahui</option>
                            </select>
                        </div>
                        <!-- Agama -->
                        <div>
                            <label class="block text-sm font-medium">Agama</label>
                            <select name="agama" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                                <option value="Islam" ${data.agama === "Islam" ? "selected" : ""}>Islam</option>
                                <option value="Kristen" ${data.agama === "Kristen" ? "selected" : ""}>Kristen</option>
                                <option value="Katolik" ${data.agama === "Katolik" ? "selected" : ""}>Katolik</option>
                                <option value="Hindu" ${data.agama === "Hindu" ? "selected" : ""}>Hindu</option>
                                <option value="Budha" ${data.agama === "Budha" ? "selected" : ""}>Budha</option>
                                <option value="Konghucu" ${data.agama === "Konghucu" ? "selected" : ""}>Konghucu</option>
                            </select>
                        </div>
                        <!-- Status Perkawinan -->
                        <div>
                            <label class="block text-sm font-medium">Status Perkawinan</label>
                            <select name="status_perkawinan" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                                <option value="Kawin" ${data.status_perkawinan === "Kawin" ? "selected" : ""}>Kawin</option>
                                <option value="Belum Kawin" ${data.status_perkawinan === "Belum Kawin" ? "selected" : ""}>Belum Kawin</option>
                                <option value="Cerai Hidup" ${data.status_perkawinan === "Cerai Hidup" ? "selected" : ""}>Cerai Hidup</option>
                                <option value="Cerai Mati" ${data.status_perkawinan === "Cerai Mati" ? "selected" : ""}>Cerai Mati</option>
                            </select>
                        </div>
                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-sm font-medium">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="${data.pekerjaan ?? ''}"
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300"
                                maxlength="255" required>
                        </div>

                        <!-- Kewarganegaraan -->
                        <div>
                            <label class="block text-sm font-medium">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="${data.kewarganegaraan ?? ''}"
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
                            <img id="previewFoto" src="/storage/${data.link_foto}" 
                                class="mt-2 w-32 h-32 rounded-lg shadow" />
                        </div>

                        <!-- Upload Foto KTP -->
                        <div>
                            <label class="block text-sm font-medium">Upload Foto KTP</label>
                            <input type="file" name="link_foto_ktp" accept="image/*" 
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300" 
                                onchange="validateImage(event, 'previewKTP')">
                            <img id="previewKTP" src="/storage/${data.link_foto_ktp}" 
                                class="mt-2 w-32 h-32 rounded-lg shadow" />
                        </div>
                    </form>
                `;

                // Setup event listener untuk input file
                setupImagePreview();

                // Isi footer modal dengan tombol "Batal" dan "Simpan"
                modalFooter.innerHTML = `
                    <button type="button" id="closeModalButton"
                        class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                        Batal
                    </button>
                    <button type="submit" form="pendudukForm"
                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">
                        Simpan
                    </button>
                `;

                // Tampilkan modal
                openModal();
            })
            .catch((error) => console.error("Error:", error));
    };

    // Function untuk validasi gambar
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
                preview.src = reader.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    };
    

    // Function untuk membuka modal
    function openModal() {
        const modal = document.getElementById("pendudukModal");
        modal.classList.remove("invisible", "opacity-0");
        modal.classList.add("opacity-100");
        modal.querySelector(".transform").classList.remove("scale-95");
        modal.querySelector(".transform").classList.add("scale-100");
    }

    // Function untuk menutup modal
    function closeModal() {
        const modal = document.getElementById("pendudukModal");
        modal.classList.add("opacity-0");
        modal.querySelector(".transform").classList.remove("scale-100");
        modal.querySelector(".transform").classList.add("scale-95");
        setTimeout(() => {
            modal.classList.add("invisible");
        }, 300);
    }

    // Event listener untuk tombol close modal
    document.addEventListener("click", function (event) {
        if (event.target.id === "closeModalButton") {
            closeModal();
        }
    });

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
