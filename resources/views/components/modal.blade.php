<div id="{{ $modalId }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900 bg-opacity-50 opacity-0 invisible transition-opacity duration-300">
    <div class="relative p-4 max-w-2xl w-full bg-white rounded-lg shadow-lg transform scale-95 transition-transform duration-300 dark:bg-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modalTitle">Form Input</h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                id="closeModalButton">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Tutup modal</span>
            </button>
        </div>
        <!-- Modal Body (Tempat Form Akan Dimasukkan) -->
        <div class="p-4 space-y-4 overflow-y-auto max-h-[60vh]" id="modalContent">
            <!-- Form akan dimasukkan di sini menggunakan JavaScript -->
        </div>
        <!-- Modal Footer -->
        <div class="flex items-center p-4 border-t dark:border-gray-600" id="modalFooter">
            <!-- Tombol-tombol footer akan dimasukkan di sini menggunakan JavaScript -->
        </div>
    </div>
</div>