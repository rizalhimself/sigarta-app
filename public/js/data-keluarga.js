import { showModal, closeModal } from "./modal.js";
import { sortTable, searchData, fetchDataTable } from "./table-utils.js";

document.addEventListener("DOMContentLoaded", function () {
    console.log(" Data Keluarga JS Loaded");

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


// callback untuk membuat row pada tabel keluarga
const generateKeluargaRow = (w, index, currentPage, perPage) => `
<tr id="row-${
    w.id
}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
    <td class="px-6 py-4 col-no">${(currentPage - 1) * perPage + (index + 1)}</td>
    <td class="px-6 py-4 col-no-kk">${w.no_kk ?? "-"}</td>
    <td class="px-6 py-4 col-nama-kk">${w.kepala_keluarga?.nama_lengkap ?? "-"}</td>
    <td class="px-6 py-4 col-jumlah-anggota-kk">${
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
