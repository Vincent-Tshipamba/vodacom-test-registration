@extends('admin.layouts.app')
@section('content')
    <style>
        .custom-swal {
            max-width: 90%;
            /* Largeur maximale du modal */
            width: auto;
            /* Largeur automatique */
            height: auto;
            /* Hauteur automatique */
        }

        .custom-swal img {
            width: 100%;
            /* L'image prend toute la largeur du modal */
            height: auto;
            /* Hauteur automatique pour garder les proportions */
            max-height: 80vh;
            /* Limiter la hauteur maximale à 80% de la fenêtre */
            object-fit: contain;
            /* Ajuster l'image sans déformer */
        }
    </style>
    @if ($candidats->count() > 0)
        <div class="flex items-center justify-center space-x-3 mb-4">
            <div class="w-96">
                <form id="searchForm"
                    class="mx-auto max-w-xl py-2 px-6 rounded-full bg-gray-50 border flex focus-within:border-gray-300">
                    <input type="text" placeholder="Tapez un coupon pour retrouver un candidat"
                        class="bg-transparent w-full focus:outline-none pr-4 font-semibold border-0 focus:ring-0 px-0 py-0"
                        name="coupon" id="couponInput" required>
                </form>
            </div>
            <div>
                <button onclick="location.reload()" class="p-2 bg-blue-500 hover:bg-blue-700 text-white rounded-full">
                    <svg class="w-6 h-6 text-gray-200 hover:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="searchResults" class="mx-auto mb-2 flex flex-wrap items-center justify-center gap-4"></div>
        {{-- Modal pour l'affichage des messages de success --}}

        <div id="alert-success-session"
            class="flex hidden items-center p-4 mb-4 text-green-400 border-t-4 border-green-300 bg-gray-900 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ms-3 text-sm font-medium" id="body-alert-status">

            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-success-session" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div class="mx-auto flex flex-wrap items-center justify-center gap-8" id="list">
            @foreach ($candidats as $candidat)
                <div
                    class="max-w-sm w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow-lg hover:shadow-red-400">
                    @php
                        $photoUrl = Storage::url($candidat->photo);
                        $isPhotoPdf = pathinfo($candidat->photo, PATHINFO_EXTENSION) === 'pdf';
                    @endphp

                    <div class="relative">
                        @if ($isPhotoPdf)
                            <iframe src="{{ $photoUrl }}" style="width: 100%; height: 200px;" frameborder="0"></iframe>
                        @else
                            <img class="w-full h-48 object-cover" src="{{ $photoUrl }}" alt="Photo du candidat">
                        @endif
                    </div>

                    <div class="text-xl text-center mt-4 font-semibold dark:text-gray-200 text-gray-800">
                        {{ $candidat->name }}</div>
                    <div class="flex justify-between items-center">
                        <div class="px-4 py-2">
                            <p class="text-gray-600">{{ $candidat->phone }}</p>
                        </div>
                        @if ($candidat->status === 'Absent')
                            <a href="#" id="checkpresent{{ $candidat->id }}"
                                onclick="changeStatus(event, '{{ $candidat->id }}')">
                                <span>
                                    <svg class="w-6 h-6 text-green-400 dark:text-white hover:text-green-900"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
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
                            Coupon : {{ $candidat->coupon }}
                        </p>
                        <a href="#" class="text-blue-500 hover:underline"
                            onclick="showIdentity('{{ Storage::url($candidat->identity) }}', '{{ $candidat->id }}', '{{ $candidat->name }}', '{{ pathinfo($candidat->identity, PATHINFO_EXTENSION) === 'pdf' ? 'true' : 'false' }}')">
                            Voir la pièce d'identité
                        </a><br>
                        <a href="#" class="text-blue-500 hover:underline"
                            onclick="showCertificate('{{ Storage::url($candidat->certificate) }}', '{{ $candidat->id }}', '{{ $candidat->name }}', '{{ pathinfo($candidat->certificate, PATHINFO_EXTENSION) === 'pdf' ? 'true' : 'false' }}')">
                            Voir l'attestation
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mx-auto flex flex-wrap items-center justify-center gap-4">
            <span>Aucun candidat enregistré pour l'instant.</span>
        </div>
    @endif
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>

    <script>
        $(document).ready(function() {
            var typingTimer;
            var doneTypingInterval = 500;

            $('#couponInput').on('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(searchCoupon);

            });

            $('#search').on('keydown', function() {
                clearTimeout(typingTimer);
            });

            function searchCoupon() {
                var formData = $('#search').serialize();
                var searchInput = $('#couponInput').val().toUpperCase().trim();

                if (searchInput === '') {

                    $('#searchResults').html('<p>Veuillez entrer un coupon.</p>');
                    $('#list').removeClass('hidden')
                    return;
                }
                if (searchInput.length < 2) {
                    $('#list').removeClass('hidden')

                    $('#searchResults').html('<p>Veuillez entrer au moins 2 caractères.</p>');
                    return;
                }

                $.ajax({
                    url: "{{ route('candidats.search') }}",
                    method: "GET",
                    data: {
                        coupon: searchInput
                    },
                    success: function(response) {
                        $('#searchResults').empty();

                        if (response.length === 0) {
                            $('#searchResults').html(
                                '<p class="text-red-500">Aucun candidat trouvé.</p>');
                            return;
                        }

                        // Boucle pour créer le HTML des candidats
                        response.forEach(function(candidat) {
                            let imageUrl =
                                `${window.location.origin}/storage/${candidat.photo}`;
                            let certificateUrl =
                                `${window.location.origin}/storage/${candidat.certificate}`;
                            let identityUrl =
                                `${window.location.origin}/storage/${candidat.identity}`;

                            let status = candidat.status === 'Présent' ?
                                'text-teal-900 bg-teal-200' : 'text-red-900 bg-red-200'
                            const candidatHtml = `
                                    <div class="max-w-sm w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow-lg hover:shadow-red-400">
                                        <div class="relative">
                                            <img class="w-full h-48 object-cover" src="${imageUrl}" alt="Photo du candidat">
                                        </div>
                                        <div class="text-xl mt-4 text-center font-semibold dark:text-gray-200 text-gray-800">${candidat.name}</div>
                                        <div class="flex justify-between items-center">
                                            <div class="px-6 py-4">
                                                <p class="text-gray-600">${candidat.phone}</p>
                                            </div>
                                            ${candidat.status === 'Absent' ? `
                                                                                                                                        <a href="#" onclick="changeStatus(event, '${candidat.id}')">
                                                                                                                                            <span>
                                                                                                                                                <svg class="w-6 h-6 text-green-400 dark:text-white hover:text-green-900"
                                                                                                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                                                                                    fill="none" viewBox="0 0 24 24">
                                                                                                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                                                                                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                                                                                                                                </svg>
                                                                                                                                            </span>
                                                                                                                                        </a>
                                                                                                                                    ` : ''}
                                            <div class="px-6 py-4">
                                                <span
                                                    class="inline-block px-2 py-1 font-semibold ${status} rounded-full">${candidat.status}</span>
                                            </div>
                                        </div>
                                        <div class="px-6 py-4 text-center">
                                            <p class="text-blue-500 hover:underline" onclick="showIdentity('${identityUrl}')">
                                                Coupon : ${candidat.coupon}
                                            </p>
                                            <a href="#" class="text-blue-500 hover:underline" onclick="showIdentity('${identityUrl}')">
                                                Voir la pièce d'identité
                                            </a><br>
                                            <a href="#" class="text-blue-500 hover:underline" onclick="showCertificate('${certificateUrl}')">
                                                Voir l'attestation
                                            </a>
                                        </div>
                                    </div>`;

                            $('#searchResults').append(candidatHtml);
                            $('#list').addClass('hidden')
                        });
                    },
                    error: function(xhr) {
                        $('#searchResults').html(
                            '<p class="text-red-500">Candidat non trouvé.</p>');
                        $('#list').removeClass('hidden')
                    }
                });
            }
        });
    </script>

    <script>
        function changeStatus(event, id) {
            event.preventDefault();
            $.ajax({
                type: "PATCH",
                url: "{{ route('status.update') }}",
                data: {
                    'id': id,
                    'status': 'Présent'
                },
                dataType: "json",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                },
                success: function(response) {
                    $('#checkpresent' + id).addClass('hidden')
                    $('#statusSpan' + id).text('Présent').removeClass('text-red-900 bg-red-200').addClass(
                        'text-teal-900 bg-teal-200')
                    $('#alert-success-session').removeClass('hidden')
                    $('#body-alert-status').text(response.status)
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    </script>
    <script>
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
                    pourcentageMessage.innerText = "Le pourcentage n'a pas pu être détecté sur l'attestation.";
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
