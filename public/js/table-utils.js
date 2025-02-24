// function untuk sorting table
export const sortTable = (tableId, columnClass) => {
    const table = document.getElementById(tableId);
    if (!table) {
        console.log(`Table with id ${tableId} not found`);
        return;
    }

    const rows = Array.from(table.rows);
    const header = document.querySelector(`th[data-column="${columnClass}"]`);
    const order = header.dataset.order === "desc" ? "asc" : "desc"; // toggle sorting order
    header.dataset.order = order; // simpan order baru di attribut data

    rows.sort((a, b) => {
        let aText = a.querySelector(`.${columnClass}`).textContent.trim() || "";
        let bText = b.querySelector(`.${columnClass}`).textContent.trim() || "";

        // jika data berupa angka, maka sorting berdasarkan angka
        if (!isNaN(parseFloat(aText)) && !isNaN(parseFloat(bText))) {
            aText = parseFloat(aText);
            bText = parseFloat(bText);
            return order === "asc" ? aText - bText : bText - aText;
        }

        return order === "asc"
            ? aText.localeCompare(bText, undefined, { numeric: true })
            : bText.localeCompare(aText, undefined, { numeric: true });
    });

    // perbarui tabel dengan hasil sorting
    table.innerHTML = "";
    rows.forEach((row) => table.appendChild(row));

    console.log(
        `Table ${tableId} sorted by column ${columnClass} in ${order} order`
    );
};

window.sortTable = sortTable;

// function untuk pencarian data di tabel
export const searchData = async (
    searchInput,
    tableId,
    apiEndpoint,
    rowGenerator
) => {
    if (!searchInput || !(searchInput instanceof HTMLInputElement)) {
        return;
    }

    const searchValue = searchInput.value.trim();
    if (searchValue === "") return;

    const url = `${apiEndpoint}?q=${encodeURIComponent(searchValue)}`;
    console.log(`🚀 Mengambil data dari: ${url}`);

    try {
        const response = await fetch(url);
        const data = await response.json();
        const tableBody = document.getElementById(tableId);

        if (!tableBody) {
            console.error(
                `❌ Error: Tabel dengan ID 'pendudukTable' tidak ditemukan!`
            );
            return;
        }

        tableBody.innerHTML = data.length
            ? data.map((item, index) => rowGenerator(item, index)).join("")
            : `<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>
                <td colspan='7' class='text-center px-6 py-4'>Data tidak ditemukan.</td></tr>`;
    } catch (error) {
        console.error("❌ Error Fetching Data:", error);
    }

    searchInput.addEventListener("keyup", (e) => {
        if (e.target.value === "") {
            fetchDataTable(tableId);
        }
    });
};

// ✅ Buat fungsi tetap global agar bisa dipanggil langsung di HTML
window.searchData = searchData;

// function untuk reload semua data jika search kosong
let originalTableContent = {};
export const fetchDataTable = (tableId) => {
    const tableBody = document.getElementById(tableId);

    if (!tableBody) {
        console.error(`Table with id ${tableId} not found`);
        return;
    }

    if (!originalTableContent[tableId]) {
        originalTableContent[tableId] = tableBody.innerHTML;
    }

    tableBody.innerHTML = originalTableContent[tableId];
};

// ✅ Pastikan bisa dipanggil di HTML dan `data-penduduk.js`
window.fetchDataTable = fetchDataTable;
