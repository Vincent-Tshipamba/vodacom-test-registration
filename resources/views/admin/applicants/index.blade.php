@extends('admin.layouts.app')
@section('modal')
    <!-- Main modal -->
    <div id="search-activities" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-300 ease-in-out">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="max-height: 80vh; overflow: hidden;">
                <!-- Modal header -->
                <div class="sticky top-0 bg-white dark:bg-gray-700 z-10 border-b dark:border-gray-600">
                    <div class="flex items-center justify-between p-4 md:p-5">
                        <input type="search" id="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 dark:placeholder-gray-400"
                            placeholder="Rechercher des Activites ..." required aria-label="Rechercher des Activités" />
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="search-activities" aria-label="Fermer le modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 relative overflow-y-auto" id="resultsContainer"
                    style="max-height: calc(80vh - 100px);">
                    <p class="text-gray-500">Chargement des résultats...</p>
                    <!-- Indication de chargement -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4">
        <div>
            <!-- View Toggle -->
            <div class="inline-flex rounded-lg shadow-sm bg-gray-100 dark:bg-gray-700 p-1">
                <button id="gridViewBtn"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200   text-gray-800 dark:text-white active">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Grille
                </button>
                <button id="listViewBtn"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Liste
                </button>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search Bar -->
            <div class="relative">
                <input type="search" onclick="openModal()"
                    class="w-64 pl-10 pr-4 py-2 text-sm text-gray-700 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 dark:text-white transition-colors duration-200"
                    placeholder="Rechercher des Boutique..." data-modal-target="search-activities"
                    data-modal-toggle="search-activities" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>



        <!-- Export Dropdown -->
        <div class="relative inline-block">
            <button id="dropdownBgHoverButton" data-dropdown-toggle="dropdownBgHover"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600 transition-all duration-200">
                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6 12C7.10457 12 8 11.1046 8 10C8 8.89543 7.10457 8 6 8C4.89543 8 4 8.89543 4 10C4 11.1046 4.89543 12 6 12Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 4V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6 12V20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M12 18C13.1046 18 14 17.1046 14 16C14 14.8954 13.1046 14 12 14C10.8954 14 10 14.8954 10 16C10 17.1046 10.8954 18 12 18Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 4V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M12 18V20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M18 9C19.1046 9 20 8.10457 20 7C20 5.89543 19.1046 5 18 5C16.8954 5 16 5.89543 16 7C16 8.10457 16.8954 9 18 9Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 4V5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M18 9V20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Filtrer
            </button>

            <div id="dropdownBgHover" class="z-10 hidden w-48 bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownBgHoverButton">
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="recent-applicants" type="checkbox" value="recent"
                                class="filter-checkbox w-4 h-4">
                            <label for="recent-applicants" class="ms-2 text-sm font-medium">Produits
                                récents</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="active-applicants" type="checkbox" value="is_active"
                                class="filter-checkbox w-4 h-4" checked>
                            <label for="active-applicants" class="ms-2 text-sm font-medium">Produits
                                actifs</label>
                        </div>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Create Activity Button -->
        <a href=""
            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-[#e38407] text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Ajouter un candidat
        </a>
    </div>

    <div id="listView" class="hidden w-full rounded-lg shadow-md overflow-hidden mt-7">
        <div class="overflow-x-auto">
            <table id="" class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                        <th class="group px-6 py-3 text-left">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">N°</span>
                                <svg class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 12l5-5 5 5H5z" />
                                </svg>
                            </div>
                        </th>
                        <th class="group px-6 py-3 text-left">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Prénom</span>
                                <svg class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 12l5-5 5 5H5z" />
                                </svg>
                            </div>
                        </th>
                        <th class="group px-6 py-3 text-left">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nom</span>
                            </div>
                        </th>
                        <th class="group px-6 py-3 text-left">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Phone</span>
                            </div>
                        </th>
                        <th class="group px-6 py-3 text-left">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left">
                            <span
                                class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @foreach ($applicants as $key => $applicant)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $applicant->first_name }}</td>
                            <td>{{ $applicant->last_name }}</td>
                            <td>{{ $applicant->phone_number }}</td>
                            <td>{{ $applicant->application_status }}</td>
                            <td>Actions</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($applicants->hasPages())
            <div class="mt-6 p-4">
                {{ $applicants->links() }}
            </div>
        @endif
    </div>

    <div id="gridView" class="w-full rounded-lg shadow-md overflow-hidden p-4">
        <div id="grid" class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6 mt-8 ">

            @foreach ($applicants as $candidat)
                <div
                    class="max-w-md w-full overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow-lg hover:shadow-red-400">
                    @php
                        $applicant_photo = $candidat->application_documents()->where('document_type', 'PHOTO')->first();
                        $photo_path = $applicant_photo->file_url;
                        $photoUrl = Storage::url($photo_path);
                        $isPhotoPdf = pathinfo($photo_path, PATHINFO_EXTENSION) === 'pdf';

                        $applicant_id = $candidat->application_documents()->where('document_type', 'ID')->first();
                        $id_path = $applicant_id->file_url;
                        $id_url = Storage::url($id_path);

                        $applicant_diploma = $candidat
                            ->application_documents()
                            ->where('document_type', 'DIPLOMA')
                            ->first();
                        $diploma_path = $applicant_diploma->file_url;
                        $diploma_url = Storage::url($diploma_path);
                    @endphp

                    <div class="relative">
                        @if ($isPhotoPdf)
                            <iframe src="{{ $photoUrl }}" style="width: 100%; height: 200px;"
                                frameborder="0"></iframe>
                        @else
                            <img class="w-full h-48 object-cover" src="{{ $photoUrl }}" alt="Photo du candidat">
                        @endif
                    </div>

                    <div class="text-xl text-center mt-4 font-semibold dark:text-gray-200 text-gray-800">
                        {{ $candidat->first_name . ' ' . $candidat->last_name }}</div>
                    <div class="flex justify-between items-center">
                        <div class="px-4 py-2">
                            <p class="text-gray-600">{{ $candidat->phone_number }}</p>
                        </div>
                        @if ($candidat->application_status === 'PENDING')
                            <a href="#" id="checkpresent{{ $candidat->id }}"
                                onclick="changeStatus(event, '{{ $candidat->id }}')">
                                <span>
                                    <svg class="w-6 h-6 text-green-400 dark:text-white hover:text-green-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                    </svg>
                                </span>
                            </a>
                        @endif
                        <div class="px-6 py-4">
                            <span id="statusSpan{{ $candidat->id }}"
                                class="inline-block px-2 py-1 font-semibold {{ $candidat->status === 'Présent' ? 'text-teal-900 bg-teal-200' : 'text-red-900 bg-red-200' }}  rounded-full">{{ $candidat->status }}</span>
                        </div>
                    </div>
                    <div class="px-6 py-4 text-center">
                        <p class="text-blue-500 hover:underline">
                            Coupon : {{ $candidat->registration_code }}
                        </p>
                        <a href="#" class="text-blue-500 hover:underline"
                            onclick="showIdentity('{{ $id_url }}', '{{ $candidat->id }}', '{{ $candidat->first_name }}', '{{ pathinfo($id_path, PATHINFO_EXTENSION) === 'pdf' ? 'true' : 'false' }}')">
                            Voir la pièce d'identité
                        </a><br>
                        <a href="#" class="text-blue-500 hover:underline"
                            onclick="showCertificate('{{ $diploma_url }}', '{{ $candidat->id }}', '{{ $candidat->first_name }}', '{{ pathinfo($diploma_path, PATHINFO_EXTENSION) === 'pdf' ? 'true' : 'false' }}')">
                            Voir l'attestation
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const gridViewBtn = document.getElementById("gridViewBtn");
            const listViewBtn = document.getElementById("listViewBtn");
            const gridView = document.getElementById("gridView");
            const listView = document.getElementById("listView");

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
                }
            }

            // Restaurer la vue précédemment sélectionnée
            const savedView = localStorage.getItem('selectedView') || 'grid';
            switchView(savedView);

            // Gestionnaires d'événements pour les boutons
            gridViewBtn.addEventListener("click", () => switchView('grid'));
            listViewBtn.addEventListener("click", () => switchView('list'));
        });


        function openModal() {
            const modal = document.getElementById('search-activities').classList.remove('hidden')
            const inputField = document.getElementById('search').focus()
        }

        function showCertificate(certificateUrl, candidateId, name, isPdf) {
            let contentHtml;

            if (isPdf === 'true') {
                contentHtml = `
                <div>
                    <iframe id="certificateIframe${candidateId}" src="${certificateUrl}"
                            style="width: 1000px; height: 400px;" frameborder="0"></iframe>
                </div>
            `;
            } else {
                contentHtml = `
                <div>
                    <img id="certificateImage${candidateId}" src="${certificateUrl}" alt="Certificat" class="w-full h-48 object-cover">
                </div>
            `;
            }
            Swal.fire({
                title: `Attestation de réussite de ${name}`,
                html: `
                    ${contentHtml}
                    <div id="pourcentageMessage${candidateId}" class="mt-2 text-blue-600"></div>

                    <div class="mt-2" id="progressIndicator${candidateId}" style="display: none;">Vérification en cours...</div>
                    <button id="checkpourcentage${candidateId}" class="mt-4 p-2 bg-blue-500 text-white rounded">Vérifier le pourcentage</button>
                    `,
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: 'Fermer',
                customClass: {
                    popup: 'custom-swal'
                }
            });

            // Ajoutez un écouteur d'événements sur le bouton
            const checkpourcentageButton = Swal.getHtmlContainer().querySelector('#checkpourcentage' + candidateId);
            checkpourcentageButton.addEventListener('click', () => extractTextFromImage(certificateUrl, candidateId));
        }

        function showIdentity(identityUrl, candidatId, name, isPDF) {
            let contentHtml;

            if (isPDF === 'true') {
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
@endsection
