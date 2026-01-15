<!-- Search Modal -->
<div id="searchModal" class="fixed z-50 mt-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modalBackdrop">
        </div>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4" id="modal-title">
                            Rechercher un candidat
                        </h3>

                        <!-- Search input -->
                        <div class="relative">
                            <input type="text" id="searchInput"
                                class="w-full px-4 py-2 pl-10 pr-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Rechercher par nom, prénom, ville ou code d'inscription..."
                                autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Search results -->
                        <div id="searchResults" class="mt-4 max-h-60 overflow-y-auto hidden">
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Results will be inserted here by JavaScript -->
                            </ul>
                        </div>

                        <div id="noResults" class="mt-4 text-center text-gray-500 dark:text-gray-400 hidden">
                            Aucun résultat trouvé
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeModal" class="btn bg-blue-600 hover:bg-blue-700 text-white">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>
