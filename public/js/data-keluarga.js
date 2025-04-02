import { showModal, closeModal } from "./modal.js";
import { sortTable, searchData, fetchDataTable } from "./table-utils.js";

document.addEventListener("DOMContentLoaded", function () {
    console.log(" Data Keluarga JS Loaded");
    
    // event delegation untuk modal, delete, dan edit
    document.addEventListener("click", async (e) => {
        if (e.target.matches(".detailKeluargaBtn")) {
            const id = e.target.dataset.id;
            await showDetail(id);
        }
    });

    // tampilkan data keluarga dengan fetch 
    const searchInput = document.getElementById("searchKeluarga"); // input pencarian
    if (!searchInput) return; // jika tidak ada input pencarian, keluar dari fungsi
    searchData(
        searchInput,
        "keluargaTable",
        "/data-keluarga/search",
        generateKeluargaRow
    );
    fetchDataTable("keluargaTable");

    // event delegation untuk sorting tabel
    document.querySelectorAll("th[data-column]").forEach((header) => {
        header.addEventListener("click", () => {
            const columnClass = header.dataset.column;
            sortTable("keluargaTable", columnClass);
        });
    });

    // event listener untuk pencarian data keluarga
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchData(
                searchInput,
                "keluargaTable",
                "/data-keluarga/search",
                generateKeluargaRow
            );
        }, 500); // delay 500ms
    });
});

// fetch data detail keluarga
window.showDetail = async (id) => {
    try {
        const response = await fetch(`/data-keluarga/${id}`);
        const data = await response.json();
        showModal(
            "Detail Keluarga - " +
                (data.kepala_keluarga.jenis_kelamin == "L" ? "Bp. " : "Ibu. ") +
                data.kepala_keluarga.nama_lengkap,
            `
            <div class="grid grid-cols-3 gap-4 p-2">
                ${data.anggota_keluarga
                    .map(
                        (anggota) => `
                        <div class="text-center">
                            <img src="${
                                anggota.warga.link_foto
                                    ? `/storage/${anggota.warga.link_foto}`
                                    : "/storage/default-avatar.png"
                            }" class="w-16 h-16 rounded-full mx-auto border shadow">
                            <p class="mt-2 font-semibold">${anggota.warga.nama_lengkap}</p>
                            <p class="text-sm text-gray-600">${anggota.status_hubungan}</p>
                        </div>
                    `
                    )
                    .join("")}
            </div>
            `,
            `<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>`
        );
    } catch (error) {
        showModal(
            "Error",
            "Terjadi kesalahan saat mengambil data!" + error.message,
            '<button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>'
        );
    }
};


// callback untuk membuat row pada tabel keluarga
const generateKeluargaRow = (w, index, currentPage, perPage) => `
<tr id="row-${
    w.id
}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
    <td class="px-6 py-4 col-no">${(currentPage - 1) * perPage + (index + 1)}</td>
    <td class="px-6 py-4 col-no-kk">${w.no_kk ?? "-"}</td>
    <td class="px-6 py-4 col-nama-kk">${w.kepala_keluarga?.nama_lengkap ?? "-"}</td>
    <td data-id="${w.id}"
     class="detailKeluargaBtn px-6 py-4 cursor-pointer col-jumlah-anggota-kk">${
        w.anggota_keluarga ? w.anggota_keluarga.length : "-"
    }</td>
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
