@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <!-- View Toggle -->
        <div class="inline-flex bg-gray-100 dark:bg-gray-700 shadow-sm p-1 rounded-lg">
            <button id="gridViewBtn"
                class="inline-flex items-center px-3 py-2 rounded-md font-medium text-gray-800 dark:text-white text-sm transition-all duration-200 active">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Grille
            </button>
            <button id="listViewBtn"
                class="inline-flex items-center hover:bg-white dark:hover:bg-gray-600 px-3 py-2 rounded-md font-medium text-gray-600 dark:text-gray-300 text-sm transition-all duration-200">
                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Liste
            </button>
        </div>
        <!-- Search Button -->
        <button id="searchModalButton" type="button" class="bg-blue-600 hover:bg-blue-700 text-white btn">
            <i data-lucide="search" class="inline-block mr-2 size-4"></i>
            Recherche avancée
        </button>
    </div>
    <!-- Grid View -->
    <div id="gridView" class="w-full">
        <div id="applicantsGrid" class="gap-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
            @include('admin.applicants.partials.applicants-grid', ['applicants' => $gridApplicants])
        </div>
    </div>

    <!-- List View (initially hidden) -->
    <div id="listView" class="hidden w-full">
        @include('admin.applicants.partials.applicants-list')
    </div>

    <!-- Loading Placeholders (initially hidden) -->
    <div id="loadingPlaceholders" class="hidden">
        @include('admin.applicants.partials.loading-placeholders')
    </div>
    <!-- Search Modal -->
    @include('admin.applicants.partials.search-modal')
@endsection
@section('script')
    <script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialiser DataTable avec les options de pagination
            const dataTable = $('#applicants-table').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                info: true,
                language: {
                    search: "Rechercher:",
                    paginate: {
                        next: "Suivant",
                        previous: "Précédent"
                    },
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées"
                }
            });
        })
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setupModal();
            const gridViewBtn = document.getElementById("gridViewBtn");
            const listViewBtn = document.getElementById("listViewBtn");
            const gridView = document.getElementById("gridView");
            const listView = document.getElementById("listView");
            const loadingPlaceholders = document.getElementById('loadingPlaceholders');

            // Restaurer la vue précédemment sélectionnée
            const savedView = localStorage.getItem('selectedView') || 'grid';
            switchView(savedView);

            // Gestionnaires d'événements pour les boutons
            gridViewBtn.addEventListener("click", () => switchView('grid'));
            listViewBtn.addEventListener("click", () => switchView('list'));

            // Infinite scroll for grid view
            const grid = document.getElementById('applicantsGrid');
            const loadMoreContainer = document.getElementById('load-more-container');

            // Search functionality
            const searchModalButton = document.getElementById('searchModalButton');
            const searchModal = document.getElementById('searchModal');
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const noResults = document.getElementById('noResults');
            let searchTimeout;
            // Search input event listener
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();
                    if (query.length < 2) {
                        searchResults.classList.add('hidden');
                        noResults.classList.add('hidden');
                        return;
                    }
                    searchTimeout = setTimeout(() => {
                        searchApplicants(query);
                    }, 300);
                });
            }

            // Initialize modals
            const modals = document.querySelectorAll('[data-modal-toggle]');
            modals.forEach(button => {
                button.addEventListener('click', () => {
                    const target = button.getAttribute('data-modal-toggle');
                    const modal = document.getElementById(target);
                    modal.classList.toggle('hidden');
                });
            });
            // Close modals when clicking outside
            window.addEventListener('click', (e) => {
                modals.forEach(button => {
                    const target = button.getAttribute('data-modal-toggle');
                    const modal = document.getElementById(target);
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            });
        });

        let isLoading = false;
        let isScrolling = false;
        let nextPageUrl = '{{ $gridApplicants->nextPageUrl() }}';
        window.addEventListener('scroll', () => {
            if (isScrolling) return;

            isScrolling = true;
            const {
                scrollTop,
                scrollHeight,
                clientHeight
            } = document.documentElement;

            if (!gridView.classList.contains('hidden') && scrollTop + clientHeight >= scrollHeight - 50) {
                loadMoreApplicants();
            }

            setTimeout(() => {
                isScrolling = false;
            }, 100);
        }, {
            passive: true
        });
    </script>
    <script>
        document.addEventListener('click', function(e) {
            const toggleBtn = e.target.closest('[data-bs-toggle]');
            const isInsideDropdown = e.target.closest('.dropdown-menu');

            if (toggleBtn) {
                e.preventDefault();
                e.stopPropagation();

                const dropdownId = toggleBtn.dataset.bsToggle;
                const dropdown = document.getElementById(dropdownId);
                if (dropdown) {
                    // Fermer tous les autres dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdown && !menu.contains(toggleBtn)) {
                            menu.classList.add('hidden');
                        }
                    });

                    // Basculer le dropdown actuel
                    dropdown.classList.toggle('hidden');
                    return false;
                }
            }

            if (!isInsideDropdown) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
    <script>
        function setupModal() {
            const modal = document.getElementById('searchModal');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const closeModal = document.getElementById('closeModal');
            const searchModalButton = document.getElementById('searchModalButton');

            function openModal() {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeModalHandler() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            if (searchModalButton) {
                searchModalButton.addEventListener('click', openModal);
            }
            if (closeModal) {
                closeModal.addEventListener('click', closeModalHandler);
            }
            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', closeModalHandler);
            }
        }

        function displaySearchResults(results) {
            const resultsContainer = document.querySelector('#searchResults ul');
            resultsContainer.innerHTML = '';
            if (results.length === 0) {
                noResults.classList.remove('hidden');
                searchResults.classList.add('hidden');
                return;
            }
            noResults.classList.add('hidden');

            results.forEach(applicant => {
                const li = document.createElement('li');
                li.className = 'p-3 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer';
                li.innerHTML = `
                <a href="/admin/applicants/${applicant.id}" class="block">
                    <div class="font-medium text-gray-900 dark:text-white">
                        ${applicant.first_name} ${applicant.last_name}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">
                        ${applicant.province} ${applicant.coupon_code ? '• ' + applicant.coupon_code : ''}
                    </div>
                </a>
            `;
                resultsContainer.appendChild(li);
            });
            searchResults.classList.remove('hidden');
        }

        // Search applicants function
        async function searchApplicants(query) {
            try {
                const response = await fetch(
                    '{{ route('admin.applicants.search', ['locale' => app()->getLocale()]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            query
                        })
                    });
                const results = await response.json();
                displaySearchResults(results);
            } catch (error) {
                console.error('Error searching applicants:', error);
            }
        }

        // Load more applicants function
        async function loadMoreApplicants() {
            if (isLoading || !nextPageUrl) return;

            isLoading = true;
            loadingPlaceholders.classList.remove('hidden');

            try {
                const response = await fetch(nextPageUrl + '&ajax=1');
                const data = await response.json();

                if (data.html) {
                    const temp = document.createElement('div');
                    temp.innerHTML = data.html;
                    const newItems = temp.querySelectorAll('.card');

                    newItems.forEach(item => {
                        if (gridView.classList.contains('hidden')) {
                            return;
                        } else {
                            document.getElementById('applicantsGrid').appendChild(item);
                            lucide.createIcons();
                        }
                    });

                    nextPageUrl = data.next_page_url;
                    if (!nextPageUrl) {
                        document.getElementById('load-more-container')?.remove();
                    }
                }
            } catch (error) {
                console.error('Error loading more applicants:', error);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'col-span-1 md:col-span-2 xl:col-span-4 text-center p-4 text-red-500';
                errorDiv.textContent = 'Erreur lors du chargement des candidats. Veuillez réessayer.';
                document.getElementById('applicantsGrid').appendChild(errorDiv);
            } finally {
                isLoading = false;
                loadingPlaceholders.classList.add('hidden');
            }
        }

        // Fonction pour changer la vue
        function switchView(view) {
            if (view === 'grid') {
                gridView.classList.remove("hidden");
                listView.classList.add("hidden");
                gridViewBtn.classList.add("active");
                listViewBtn.classList.remove("active");
                localStorage.setItem('selectedView', 'grid');
            } else {
                listView.classList.remove("hidden");
                gridView.classList.add("hidden");
                listViewBtn.classList.add("active");
                gridViewBtn.classList.remove("active");
                localStorage.setItem('selectedView', 'list');

                const url = new URL(window.location.href);
                url.searchParams.set('view', 'list');
                // window.location.href = url.toString();
            }
        }

        function showDocument(fileUrl, fileId, fileType, candidateId, name, isPdf) {
            let contentHtml;
            let title;
            if (fileType === 'DIPLOMA') {
                title = `Attestation de réussite de ${name}`;
            } else if (fileType === 'PHOTO') {
                title = `Image de ${name}`;
            } else if (fileType === 'ID') {
                title = `Pièce d'identité de ${name}`;
            }

            if (isPdf) {
                contentHtml = `
                <div>
                    <iframe id="certificateIframe${candidateId}" src="${fileUrl}"
                            style="width: 100%; height: 65vh;" frameborder="0"></iframe>
                </div>
            `;
            } else {
                contentHtml = `
                <div>
                    <img id="certificateImage${candidateId}" src="${fileUrl}" alt="${fileType}" class="w-full h-48 object-cover">
                </div>
            `;
            }
            Swal.fire({
                title: title,
                html: `${contentHtml}`,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: "Je valide le document",
                denyButtonText: "Je ne valide pas le document",
                cancelButtonText: "Fermer",
                focusConfirm: false,
                customClass: {
                    popup: 'custom-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // TODO: Handle confirmation
                    console.log('Document validated');
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('application-documents.change-status', app()->getLocale()) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: fileId,
                            is_valid: true
                        },
                        dataType: "json",
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: response.message,
                            });
                        },
                        error: function(xhr, status, error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: "Une erreur est survenue lors de la validation.",
                            });
                        }
                    });
                } else if (result.isDenied) {
                    // TODO: Handle denial
                    console.log('Document not validated');
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('application-documents.change-status', app()->getLocale()) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            is_valid: false,
                            id: fileId,
                        },
                        dataType: "json",
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: response.message,
                            });
                        },
                        error: function(xhr, status, error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: "Une erreur est survenue lors de l'invalidation.",
                            });
                        }
                    });
                }
            })
        }


        function extractTextFromImage(certificateUrl, candidatId) {
            const pourcentageMessage = document.getElementById('pourcentageMessage' + candidatId);
            const progressIndicator = document.getElementById('progressIndicator' + candidatId);

            // Affiche l'indicateur de progression
            progressIndicator.style.display = 'block';
            progressIndicator.innerHTML = 'Vérification en cours : 0%';
            pourcentageMessage.innerText = '';

            Tesseract.recognize(
                certificateUrl,
                'eng', // Langue d'analyse
                {
                    logger: (m) => {
                        if (m.status === 'recognizing text') {
                            const progress = Math.round(m.progress * 100);
                            progressIndicator.innerHTML = `Vérification en cours : ${progress}%`;
                        }
                    }
                }
            ).then(({
                data: {
                    text
                }
            }) => {
                // Masque l'indicateur de progression
                progressIndicator.style.display = 'none';

                // Recherche de la mention "AVEC XX % DES POINTS" dans le texte extrait
                const match = text.match(/(\d[\d\s\[\]]*)\s*%\s*DES\s*POINTS/i);

                if (match && match[1]) {
                    const pourcentage = parseInt(match[1], 10);

                    pourcentageMessage.innerText =
                        `Le candidat a obtenu un pourcentage de ${pourcentage}%.`;

                } else {
                    pourcentageMessage.innerText =
                        "Le pourcentage n'a pas pu être détecté sur l'attestation.";
                }
            }).catch((err) => {
                // Masque l'indicateur de progression et affiche un message d'erreur
                progressIndicator.style.display = 'none';
                pourcentageMessage.innerText = 'Erreur lors de la reconnaissance du texte.';
                console.error(err);
            });
        }

        function showIdentity(identityUrl, candidatId, name, isPDF) {
            let contentHtml;

            if (isPDF) {
                contentHtml = `
                <div>
                    <iframe id="IdentityIframe${candidatId}" src="${identityUrl}"
                            style="width: 1000px; height: 400px;" frameborder="0"></iframe>
                </div>
            `;
            } else {
                contentHtml = `
                <div>
                    <img id="identityImage${candidatId}" src="${identityUrl}" alt="Piece d'identite" class="w-full h-48 object-cover">
                </div>
            `;
            }
            Swal.fire({
                title: `Pièce d\'identité de ${name}`,
                html: `
                ${contentHtml}
                `,
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: 'Fermer',
                customClass: {
                    popup: 'custom-swal'
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@endsection
