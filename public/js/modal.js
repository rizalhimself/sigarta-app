// Function untuk menampilkan modal
export const showModal = (title, content, footer) => {
    const modal = document.getElementById("modal");
    if (!modal) {
        console.error("Modal tidak ditemukan");
        return;
    }

    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modalContent").innerHTML = content;
    document.getElementById("modalFooter").innerHTML = footer;

    modal.classList.remove("invisible", "opacity-0");
    modal.classList.add("opacity-100");

    // animasi modal
    const modalContent = modal.querySelector(".transform");
    if (modalContent) {
        modalContent.classList.remove("scale-95");
        modalContent.classList.add("scale-100");
    }
};

// Function untuk menutup modal
export const closeModal = () => {
    const modal = document.getElementById("modal");
    if (!modal) return;

    modal.classList.remove("opacity-100");
    modal.classList.add("opacity-0");


    setTimeout(() => {
        modal.classList.add("invisible");
        document.getElementById("modalTitle").textContent = "";
        document.getElementById("modalContent").innerHTML = "";
    }, 300);
};

// event delegation untuk tombol close modal darimanapun
document.addEventListener("click", (event) => {
    if (event.target.matches("#closeModalButton, #cancelModalButton")) {
        closeModal();
    }
});