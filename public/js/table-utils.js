// function untuk sorting table
export const sortTable = (tableId, columnClass) => {
    const table = document.getElementById(tableId);
    if (!table) {
        console.log(`Table with id ${tableId} not found`);
        return;
    }

    const rows = Array.from(table.rows); // skip header row
    const header = document.querySelector(`th[data-column="${columnClass}"]`);
    if (!header) {
        console.log(`Column with class ${columnClass} not found`);
        return;
    }

    const order = header.dataset.order === "desc" ? "asc" : "desc"; // toggle sorting order
    header.dataset.order = order; // simpan order baru di attribut data

    rows.sort((a, b) => {
        let aCell = a.querySelector(`.${columnClass}`);
        let bCell = b.querySelector(`.${columnClass}`);

        if (!aCell || !bCell) {
            console.log(`Column with class ${columnClass} not found`);
            return 0;
        }

        let aText = aCell.textContent.trim() || "";
        let bText = bCell.textContent.trim() || "";

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
    rowGenerator,
    currentPage = 1
) => {
    if (!searchInput || !(searchInput instanceof HTMLInputElement)) {
        return;
    }

    const searchValue = searchInput ? searchInput.value.trim() : "";
    const url = searchValue ? `${apiEndpoint}?q=${encodeURIComponent(searchValue)}&page=${currentPage}` 
        : `${apiEndpoint}?page=${currentPage}`;

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

        tableBody.innerHTML = data.data.length
            ? data.data.map((item, index) => rowGenerator(item, index, data.current_page, data.per_page)).join("")
            : `<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>
                <td colspan='7' class='text-center px-6 py-4'>Data tidak ditemukan.</td></tr>`;

        // update pagination
        updatePagination(data.current_page, data.last_page, tableId, searchInput, rowGenerator, apiEndpoint);

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

// function untuk update pagination
const updatePagination = (currentPage, totalPage, tableId, searchInput, rowGenerator, apiEndpoint) => {
    console.log(`📌 Debug Pagination: Halaman ${currentPage} dari ${totalPage}`);

    const paginationContainer = document.getElementById(`${tableId}-pagination`);
    if (!paginationContainer) {
        console.error(`Pagination container not found`);
        return;
    }
    paginationContainer.innerHTML = '';

    // tombol previous
    const prevButton = document.createElement("button");
    prevButton.innerHTML =  `<i class="fas fa-angle-left"></i>`;
    prevButton.className = "px-3 py-2 border rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-50";
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => loadPage(currentPage - 1, tableId, searchInput, apiEndpoint, rowGenerator);
    paginationContainer.appendChild(prevButton);

    for (let i = 1; i <= totalPage; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i;
        pageButton.className = `px-3 py-2 border rounded-md hover:bg-gray-200 ${
            i === currentPage ? "bg-blue-500 text-white" : "text-gray-700"  
        }`
        pageButton.disabled = i === currentPage;
        pageButton.onclick = () => loadPage(i, tableId, searchInput, apiEndpoint, rowGenerator);
        paginationContainer.appendChild(pageButton);
    }

    // tombol next
    const nextButton = document.createElement("button");
    nextButton.innerHTML = `<i class="fas fa-angle-right"></i>`;
    nextButton.className = "px-3 py-2 border rounded-md text-gray-700 hover:bg-gray-200 disabled:opacity-50";
    nextButton.disabled = currentPage === totalPage;
    nextButton.onclick = () => loadPage(currentPage + 1, tableId, searchInput, apiEndpoint, rowGenerator);
    paginationContainer.appendChild(nextButton);
}

// function untuk load halaman tertentu
const loadPage = (page, tableId, searchInput, apiEndpoint, rowGenerator) => {
    searchData(searchInput, tableId, apiEndpoint, rowGenerator, page);
};
