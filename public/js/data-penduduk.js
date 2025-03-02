import { showModal, closeModal } from "./modal.js";
import { sortTable, searchData, fetchDataTable } from "./table-utils.js";

document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Data Penduduk JS Loaded!"); // Debugging

    // tampilkan data penduduk dengan AJAX dan fetch semua data penduduk di tabel
    const searchInput = document.getElementById("searchPenduduk"); // Ambil input search
    if (!searchInput) return;
    searchData(
        searchInput,
        "pendudukTable",
        "/data-penduduk/search",
        generatePendudukRow
    );
    fetchDataTable("pendudukTable");

    // event delegattion untuk modal, delete, dan edit penduduk
    document.addEventListener("click", async (e) => {
        if (e.target.matches(".editPendudukBtn")) {
            await showEditForm(e.target.dataset.id);
        } else if (e.target.matches(".detailPendudukBtn")) {
            await showDetail(e.target.dataset.id);
        } else if (e.target.matches(".deletePendudukBtn")) {
            deletePenduduk(e.target.dataset.id);
        } else if (e.target.matches(".addPendudukBtn")) {
            showAddForm();
        }
    });

    // event delegation untuk input file validation
    document.addEventListener("change", (e) => {
        if (e.target.matches("input[type='file']")) {
            validateImage(e);
        }
    });

    // event delegation untuk sorting table
    document.querySelectorAll("th[data-column]").forEach((header) => {
        header.addEventListener("click", () => {
            const columnClass = header.dataset.column;
            sortTable("pendudukTable", columnClass);
        });
    });

    // event listener untuk pencarian penduduk dengan debounce
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchData(
                searchInput,
                "pendudukTable",
                "/data-penduduk/search",
                generatePendudukRow
            );
        }, 500);
    });
});

// fungsi generate modal untuk menampilkan add/edit penduduk
window.generatePendudukForm = (data = null) => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const isEdit = data !== null;

    // tentukan action url dan method form berdasarkan keggunaan edir/tambah
    const actionUrl = isEdit
        ? `/data-penduduk/${data.id}`
        : `/data-penduduk/store`;
    const method = isEdit ? "PUT" : "POST";

    // generate input tersembunyi
    const hiddenInputs = isEdit
        ? `<input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="${csrfToken}">
        <input type="hidden" name="id" value="${data.id}">
        <input type="hidden" name="user_id" value="${data.user_id}">
        `
        : `<input type="hidden" name="_token" value="${csrfToken}">`;

    // tentukan nilai field untuh edit atau tambah
    const username = isEdit && data.user ? data.user.username : ""; // Menghindari error jika data.user tidak ada
    const email = isEdit && data.user ? data.user.email : "";
    const role = isEdit && data.user ? data.user.role : "";
    const namaLengkap = isEdit ? data.nama_lengkap : "";
    const nik = isEdit ? data.nik : "";
    const tempatLahir = isEdit ? data.tempat_lahir : "";
    const tglLahir = isEdit ? data.tgl_lahir : "";
    const jenisKelamin = isEdit ? data.jenis_kelamin : "";
    const golonganDarah = isEdit ? data.golongan_darah : "";
    const agama = isEdit ? data.agama : "";
    const statusPerkawinan = isEdit ? data.status_perkawinan : "";
    const pekerjaan = isEdit ? data.pekerjaan : "";
    const kewarganegaraan = isEdit ? data.kewarganegaraan : "";
    const noTelfon = isEdit ? data.no_telfon : "";
    const linkFoto = isEdit ? data.link_foto : "";
    const linkFotoKTP = isEdit ? data.link_foto_ktp : "";

    return `
    <form id="pendudukForm" action="${actionUrl}" method="${method}" enctype="multipart/form-data">
            ${hiddenInputs}
                <!-- Data User -->
                <div>
                    <label class="block text-sm font-medium">Username</label>
                    <input type="text" name="username" value="${username}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="${email}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="passwordInput" value="••••••" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    <span id="passwordError" class="text-red-500 text-sm hidden">Password tidak boleh kosong!</span>
                    <span id="passwordMatchError" class="text-red-500 text-sm hidden">Password tidak cocok!</span>
                </div>
                <div>
                    <label class="block text-sm font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" value="••••••" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    <span id="passwordConfirmationError" class="text-red-500 text-sm hidden">Konfirmasi Password tidak boleh kosong!</span>
                    <span id="passwordConfirmationMatchError" class="text-red-500 text-sm hidden">Password tidak cocok!</span>
                </div>
                <div>
                    <label class="block text-sm font-medium">Role</label>
                    <select name="role" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                        <option value="" ${
                            role === "" ? "selected" : ""
                        }>Pilih Role</option>
                        <option value="warga" ${
                            role === "warga" ? "selected" : ""
                        }>Warga</option>
                        <option value="ketua" ${
                            role === "ketua" ? "selected" : ""
                        }>Ketua</option>
                        <option value="kadus" ${
                            role === "kadus" ? "selected" : ""
                        }>Kadus</option>
                        <option value="sekertaris" ${
                            role === "sekertaris" ? "selected" : ""
                        }>Sekertaris</option>
                        <option value="bendahara1" ${
                            role === "bendahara" ? "selected" : ""
                        }>Bendahara 1</option>
                        <option value="bendahara2" ${
                            role === "bendahara2" ? "selected" : ""
                        }>Bendahara 2</option>
                        <option value="humas" ${
                            role === "humas" ? "selected" : ""
                        }>Humas</option>
                        <option value="kerohanian" ${
                            role === "kerohanian" ? "selected" : ""
                        }>Kerohanian</option>
                        <option value="pembantuUmum" ${
                            role === "pembantuUmum" ? "selected" : ""
                        }>Pembantu Umum</option>
                        <option value="admin" ${
                            role === "admin" ? "selected" : ""
                        }>Admin</option>
                    </select>
                </div>
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium">Nama Lengkap</label>
                    <input id="namaLengkapInput" type="text" name="nama_lengkap" value="${namaLengkap}" class="w-full p-2
                    border rounded focus:ring focus:ring-blue-300" required autofocus>
                </div>
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium">NIK</label>
                    <input type="text" name="nik" value="${nik}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" pattern="\\d{16}" title="Harus 16 digit" required>
                </div>
                <!-- Tempat & Tanggal Lahir -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="${tempatLahir}" class="w-full p-2
                        border rounded focus:ring focus:ring-blue-300" required>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" value="${tglLahir}" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                        <option value="" ${
                            jenisKelamin === "" ? "selected" : ""
                        }>Pilih Jenis Kelamin</option>
                        <option value="L" ${
                            jenisKelamin === "L" ? "selected" : ""
                        }>Laki-laki</option>
                        <option value="P" ${
                            jenisKelamin === "P" ? "selected" : ""
                        }>Perempuan</option>
                    </select>
                </div>
                <!-- Golongan Darah -->
                <div>
                    <label class="block text-sm font-medium">Golongan Darah</label>
                    <select name="golongan_darah" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                        <option value="" ${
                            golonganDarah === "" ? "selected" : ""
                        }>Pilih Golongan Darah</option>
                        <option value="A" ${
                            golonganDarah === "A" ? "selected" : ""
                        }>A</option>
                        <option value="B" ${
                            golonganDarah === "B" ? "selected" : ""
                        }>B</option>
                        <option value="AB" ${
                            golonganDarah === "AB" ? "selected" : ""
                        }>AB</option>
                        <option value="O" ${
                            golonganDarah === "O" ? "selected" : ""
                        }>O</option>
                        <option value="-" ${
                            golonganDarah === "-" ? "selected" : ""
                        }>Tidak Diketahui</option>
                    </select>
                </div>
                <!-- Agama -->
                <div>
                    <label class="block text-sm font-medium">Agama</label>
                    <select name="agama" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                        <option value="" ${
                            agama === "" ? "selected" : ""
                        }>Pilih Agama</option>
                        <option value="Islam" ${
                            agama === "Islam" ? "selected" : ""
                        }>Islam</option>
                        <option value="Kristen" ${
                            agama === "Kristen" ? "selected" : ""
                        }>Kristen</option>
                        <option value="Katolik" ${
                            agama === "Katolik" ? "selected" : ""
                        }>Katolik</option>
                        <option value="Hindu" ${
                            agama === "Hindu" ? "selected" : ""
                        }>Hindu</option>
                        <option value="Budha" ${
                            agama === "Budha" ? "selected" : ""
                        }>Budha</option>
                        <option value="Konghucu" ${
                            agama === "Konghucu" ? "selected" : ""
                        }>Konghucu</option>
                    </select>
                </div>
                <!-- Status Perkawinan -->
                <div>
                    <label class="block text-sm font-medium">Status Perkawinan</label>
                    <select name="status_perkawinan" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" required>
                        <option value="" ${
                            statusPerkawinan === "" ? "selected" : ""
                        }>Pilih Status Perkawinan</option>
                        <option value="Kawin" ${
                            statusPerkawinan === "Kawin" ? "selected" : ""
                        }>Kawin</option>
                        <option value="Belum Kawin" ${
                            statusPerkawinan === "Belum Kawin" ? "selected" : ""
                        }>Belum Kawin</option>
                        <option value="Cerai Hidup" ${
                            statusPerkawinan === "Cerai Hidup" ? "selected" : ""
                        }>Cerai Hidup</option>
                        <option value="Cerai Mati" ${
                            statusPerkawinan === "Cerai Mati" ? "selected" : ""
                        }>Cerai Mati</option>
                    </select>
                </div>
                <!-- Pekerjaan -->
                <div>
                    <label class="block text-sm font-medium">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="${
                        pekerjaan ?? ""
                    }" class="w-full p-2
                    <border rounded focus:ring focus:ring-blue-300" maxlength="255" required>
                </div>
                <!-- Kewarganegaraan -->
                <div>
                    <label class="block text-sm font-medium">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" value="${
                        kewarganegaraan ?? ""
                    }" class="w-full p-2
                    border rounded focus:ring focus:ring-blue-300" maxlength="255" required>
                </div>
                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium">No Telepon</label>
                    <input type="text" name="no_telfon" value="${noTelfon}" class="w-full p-2
                    border rounded focus:ring focus:ring-blue-300" pattern="\\d+" required>
                </div>
                <!-- Upload Foto Profil -->
                <div>
                    <label class="block text-sm font-medium">Upload Foto Profil</label>
                    <input type="file" name="link_foto" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="validateImage(event, 'previewFoto')">
                    <img id="previewFoto" src="${
                        linkFoto
                            ? `/storage/${linkFoto}`
                            : "/storage/default-avatar.png"
                    }" class="mt-2 w-32 h-32 rounded-lg shadow" />    
                </div>
                <!-- Upload Foto KTP -->
                <div>
                    <label class="block text-sm font-medium">Upload Foto KTP</label>
                    <input type="file" name="link_foto_ktp" accept="image/*" class="w-full p-2 border rounded focus:ring focus:ring-blue-300" onchange="validateImage(event, 'previewKTP')">    
                    <img id="previewKTP" src="${
                        linkFotoKTP
                            ? `/storage/${linkFotoKTP}`
                            : "/storage/default-avatar.png"
                    }" class="mt-2 w-32 h-32 rounded-lg shadow" />
                </div>
            </form>
    `;
};

// fetch data detail penduduk
window.showDetail = async (id) => {
    try {
        const response = await fetch(`/data-penduduk/${id}`);
        const data = await response.json();
        showModal(
            "Detail Penduduk - " + data.nama_lengkap,
            `<p><strong>NIK:</strong> ${data.nik}</p>
            <p><strong>Tempat Lahir:</strong> ${data.tempat_lahir}</p>
            <p><strong>Tanggal Lahir:</strong> ${data.tgl_lahir}</p>
            <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin}</p>
            <p><strong>No Telepon:</strong> ${data.no_telfon}</p>
            <p><strong>Alamat:</strong> ${
                data.keluarga?.rumah?.no_rumah ?? "-"
            }<p>
            <p><strong>Foto:</strong><br>
                <img src="${
                    data.link_foto
                        ? `/storage/${data.link_foto}`
                        : "/storage/default-avatar.png"
                }" class="w-32 h-32 mt-2 rounded-lg shadow">
            </p>
            <p><strong>Foto KTP:</strong><br>
                <img src="${
                    data.link_foto_ktp
                        ? `/storage/${data.link_foto_ktp}`
                        : "/storage/default-avatar.png"
                }" class="w-32 h-32 mt-2 rounded-lg shadow">
            </p>`,
            `<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>`
        );
    } catch (error) {
        console.error("❌ Error Fetching Data:", error);
        showModal(
            "Error",
            "Terjadi kesalahan saat mengambil data!",
            '<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>'
        );
    }
};

// tampilkan form tambah penduduk
window.showAddForm = () => {
    try {
        showModal(
            "Tambah Penduduk",
            generatePendudukForm(),
            `<button id="cancelModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            <button id="submitPendudukForm" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>`
        );

        document
            .getElementById("namaLengkapInput")
            .addEventListener("input", (e) => {
                const namaPenduduk = e.target.value;
                const modalTitle = document.getElementById("modalTitle");
                modalTitle.textContent = namaPenduduk
                    ? "Tambah Penduduk - " + namaPenduduk
                    : "Tambah Penduduk";
            });

        const passwordInput = document.querySelector('input[name="password"]');
        const passwordConfirmationInput = document.querySelector(
            'input[name="password_confirmation"]'
        );
        const passwordError = document.getElementById("passwordError");
        const passwordMatchError =
            document.getElementById("passwordMatchError");
        const passwordConfirmationError = document.getElementById(
            "passwordConfirmationError"
        );
        const passwordConfirmationMatchError = document.getElementById(
            "passwordConfirmationMatchError"
        );
        passwordInput.addEventListener("input", validatePasswordConfirmation);
        passwordConfirmationInput.addEventListener(
            "input",
            validatePasswordConfirmation
        );
        function validatePasswordConfirmation() {
            const password = passwordInput.value;
            const passwordConfirmation = passwordConfirmationInput.value;

            if (password === "" || passwordConfirmation === "") {
                passwordError.style.display = "block";
                passwordMatchError.style.display = "none";
                passwordConfirmationError.style.display = "block";
                passwordConfirmationMatchError.style.display = "none";
            } else if (password !== passwordConfirmation) {
                passwordError.style.display = "none";
                passwordMatchError.style.display = "block";
                passwordConfirmationError.style.display = "none";
                passwordConfirmationMatchError.style.display = "block";
            } else {
                passwordError.style.display = "none";
                passwordMatchError.style.display = "none";
                passwordConfirmationError.style.display = "none";
                passwordConfirmationMatchError.style.display = "none";
            }
        }
    } catch (error) {
        console.error("❌ Error menampilkan form tambah penduduk", error);
    }
};

// fungsi untuk submit form tambah/edit penduduk
document.addEventListener("click", async (e) => {
    if (e.target.matches("#submitPendudukForm")) {
        const form = document.getElementById("pendudukForm");
        const formData = new FormData(form);

        // double check password untuk meghindari terisi oleh default value dari frontend
        const passwordValue = document.getElementById("passwordInput").value;
        if (passwordValue != "••••••") {
            formData.append("password", passwordValue);
        } else {
            formData.delete("password");
        }

        // Tentukan method sesuai dengan apakah ini form tambah atau edit
        const method = form.method; // Ambil method dari form (POST atau PUT)
        if (method === "POST") {
            // Untuk tambah data (POST)
            console.log("Form data yang dikirim untuk tambah:", formData);
        } else if (method === "PUT") {
            // Untuk edit data (PUT)
            formData.append("_method", "PUT"); // Pastikan ini menggunakan PUT saat edit
            console.log("Form data yang dikirim untuk edit:", formData);
        }

        //proses data sesuai dengan method form
        try {
            const response = await fetch(form.action, {
                method: method, //method yang diatur di form
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                body: formData,
            });

            const result = await response.json();
            if (result.success) {
                alert(result.message);
                if (method === "POST") {
                    updateTable();
                } else if (method === "PUT") {
                    fetchDataTable("pendudukTable");
                    updateTableRow(formData.get("id"));
                }
                console.log("✅ Method yang dipakai:", method);
                closeModal();
            } else {
                alert(
                    "Data Penduduk gagal diubah!" +
                        (result.message || "cek log server.")
                );
            }
        } catch (error) {
            console.error("❌ Error Submitting Form:", error);
        }
    }
});

// fetch data penduduk untuk form edit
window.showEditForm = async (id) => {
    try {
        const response = await fetch(`/data-penduduk/${id}`);
        const data = await response.json();
        showModal(
            "Edit Penduduk - " + data.nama_lengkap,
            generatePendudukForm(data),
            `<button id="cancelModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            <button id="submitPendudukForm" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>`
        );
    } catch (error) {
        console.error("❌ Error Fetching Data:", error);
        showModal(
            "Error",
            "Terjadi kesalahan saat mengambil data!",
            '<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>'
        );
    }
};

// fungsi untuk mengupdate tampilan tabel setelah edit
const updateTableRow = async (id) => {
    try {
        const response = await fetch(`/data-penduduk/${id}`);
        const data = await response.json();
        const row = document.querySelector(`#row-${id}`);

        if (row) {
            row.querySelector(".col-nama").textContent = data.nama_lengkap;
            row.querySelector(".col-jenis-kelamin").textContent =
                data.jenis_kelamin;
            row.querySelector(".col-umur").innerText = data.umur;
            row.querySelector(".col-no-rumah").innerText =
                data.keluarga?.rumah?.no_rumah || "-";
            row.querySelector(".col-keluarga-id").innerText =
                data.keluarga?.id || "-";

            row.classList.add("bg-green-100");
            setTimeout(() => {
                row.classList.remove("bg-green-100");
            }, 3000);
        }
    } catch (error) {
        console.error("❌ Error Updating Table Row:", error);
    }
};

// fungsi untuk megupdate tampilan seluruh data di tabel
const updateTable = async () => {
    try {
        searchData(
            document.getElementById("searchPenduduk"),
            "pendudukTable",
            "/data-penduduk/search",
            generatePendudukRow
        );
    } catch (error) {
        console.error("❌ Error Updating Table:", error);
    }
};

// fungsi untuk menghapus data penduduk
const deletePenduduk = async (id) => {
    if (!confirm("Apakah Anda yakin ingin menghapus data penduduk ini?"))
        return;

    try {
        const response = await fetch(`/data-penduduk/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });

        const result = await response.json();
        if (result.success) {
            alert("Data Penduduk berhasil dihapus!");
            document.getElementById(`row-${id}`).remove();
        } else {
            alert(
                "Data Penduduk gagal dihapus!" +
                    (result.message || "cek log server.")
            );
        }
    } catch (error) {
        console.error("❌ Error Deleting Data:", error);
    }
};

// callback table fungsu search
const generatePendudukRow = (w, index, currentPage, perPage) => `
<tr id="row-${
    w.id
}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
    <td class="px-6 py-4 col-no">${(currentPage - 1) * perPage + (index +1)}</td>
    <td class="px-6 py-4 col-no-rumah">${
        w.keluarga?.rumah?.no_rumah ?? "-"
    }</td>
    <td class="px-6 py-4 col-keluarga-id">${w.keluarga?.id ?? "-"}</td>
    <td data-id="${w.id}" 
        class="detailPendudukBtn px-6 py-4 text-blue-500 cursor-pointer col-nama">${
            w.nama_lengkap
        }</td>
    <td class="px-6 py-4 col-jenis-kelamin">${w.jenis_kelamin}</td>
    <td class="px-6 py-4 col-umur">${w.umur ?? "-"}</td>
    <td class="px-6 py-4">
        <button data-id="${
            w.id
        }" class="editPendudukBtn bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
        <button data-id="${
            w.id
        }" class="deletePendudukBtn bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
    </td>
</tr>
`;

// validasi dan preview gambar
const validateImage = (e) => {
    const file = e.target.files[0];
    const validExtensions = ["image/jpeg", "image/png", "image/jpg"];

    if (file) {
        if (
            (!validExtensions,
            includes(file.type) || file.size > 2 * 1024 * 1024)
        ) {
            alert(
                "❌ File harus berupa gambar dengan format JPEG, PNG, atau JPG dan ukuran maksimal 2MB!"
            );
            e.target.value = "";
            return;
        }

        // preview gambar
        const previewId = e.target.getAttribute("data-preview");
        if (previewId) {
            const reader = new FileReader();
            reader.onload = () => {
                document.getElementById(previewId).src = reader.result;
                document.getElementById(previewId).classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    }
};
