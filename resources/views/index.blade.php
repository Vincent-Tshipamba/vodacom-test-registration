<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-center text-sm text-red-800 rounded-lg bg-white border-2 border-gray-400 shadow dark:bg-gray-800 dark:text-red-400"
                role="alert">

                <span class="font-medium">{{ $error }}</span>

            </div>
        @endforeach
    @endif
    <div class="h-full flex items-center justify-center">
        <div class="mx-auto w-full max-w-[750px] bg-white dark:bg-gray-900 p-8">
            <form id="candidatForm" action="{{ route('candidats.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                        Nom complet
                    </label>
                    <input type="text" name="name" id="name" placeholder="Nom Postnom Prénom"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium dark:text-gray-200 text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        required />
                </div>

                <div class="mb-5">
                    <label for="phone" class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                        Numéro de téléphone
                    </label>
                    <input type="text" name="phone" id="phone" placeholder="Ex: 0826869063"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium dark:text-gray-200 text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                        required />
                </div>

                <div class="mb-5 full flex space-x-2 justify-between">
                    <div class="w-full">
                        <label for="code_exetat"
                            class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                            Code d'exetat (14 chiffres)
                        </label>
                        <input type="text" name="code_exetat" id="code_exetat"
                            placeholder="Entrez votre code d'exetat"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            pattern="\d{14}" required />
                    </div>
                    <div class="w-96">
                        <label for="pourcentage"
                            class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                            Pourcentage obtenu (70 ou plus)
                        </label>
                        <input type="number" name="pourcentage" id="pourcentage" placeholder="Ex: 70"
                            max="100"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            pattern="\d{14}" required />
                    </div>
                </div>

                <!-- Photo du candidat -->
                <div class="flex items-center justify-between space-x-6">
                    <div class="mb-5 w-full">
                        <label for="photo"
                            class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                            Photo du candidat
                        </label>
                        <input type="file" onchange="loadPhoto(event)" name="photo" id="photo"
                            accept="image/*,application/pdf"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            required />
                    </div>
                    <div class="shrink-0">
                        <img id='preview_photo' class="h-24 w-24 object-cover rounded-full"
                            src="https://ralfvanveen.com/wp-content/uploads/2021/06/Espace-r%C3%A9serv%C3%A9-_-Glossaire.svg"
                            alt="Aperçu de votre image" />
                    </div>

                </div>

                <!-- Pièce d'identité -->
                <div class="flex items-center justify-between space-x-6">
                    <div class="mb-5 w-full">
                        <label for="identity"
                            class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                            Pièce d'identité (une image nette)
                        </label>
                        <input type="file" onchange="loadID(event)" name="identity" id="identity"
                            accept="image/*,application/pdf"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            required />
                    </div>
                    <div class="shrink-0">
                        <img id='preview_identity_card' class="h-24 w-24 object-cover rounded-full"
                            src="https://ralfvanveen.com/wp-content/uploads/2021/06/Espace-r%C3%A9serv%C3%A9-_-Glossaire.svg"
                            alt="Aperçu de la pièce d'identité" />
                    </div>
                </div>

                <!-- Attestation de réussite -->
                <div class="flex items-center justify-between space-x-6">
                    <div class="mb-5 w-full">
                        <label for="certificate"
                            class="mb-3 block text-base font-medium dark:text-gray-200 text-[#07074D]">
                            Attestation de réussite (image nette s'il vous plait)
                        </label>
                        <input type="file" onchange="loadCertificate(event)" name="certificate" id="certificate"
                            accept="image/*,application/pdf"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                            required />
                    </div>
                    <div class="shrink-0">
                        <img id='preview_certificate' class="h-24 w-24 object-cover rounded-full"
                            src="https://ralfvanveen.com/wp-content/uploads/2021/06/Espace-r%C3%A9serv%C3%A9-_-Glossaire.svg"
                            alt="Aperçu du certificat" />
                    </div>
                </div>
                <div>
                    <button id="submitButton"
                        class="hover:shadow-form w-full rounded-md hover:bg-[#4b38dc] bg-[#2f1acd] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Soumettre la candidature
                    </button>
                </div>
            </form>
        </div>
    </div>

    @section('script')
        <script>
            $('#candidatForm').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true); // Désactiver le bouton
                $(this).find('button[type="submit"]').text('Soumission en cours...'); // Changer le texte du bouton
            });
        </script>
        <script>
            // Aperçu de la photo du candidat
            var loadPhoto = function(event) {

                var inputPhoto = event.target;
                var photoFile = inputPhoto.files[0];
                var typePhoto = photoFile.type;
                let pdfSrc = "{{ asset('img/PDF_file_icon.svg.png') }}"

                var outputPhoto = document.getElementById('preview_photo');

                if (typePhoto === 'application/pdf') {
                    outputPhoto.src = pdfSrc;
                } else {
                    outputPhoto.src = URL.createObjectURL(event.target.files[0]);
                    outputPhoto.onload = function() {
                        URL.revokeObjectURL(outputPhoto.src) // free memory
                    }
                }
            };

            // Aperçu de la pièce d'identité
            var loadID = function(event) {

                var inputIDCard = event.target;
                var IDfile = inputIDCard.files[0];
                var typeID = IDfile.type;
                let pdfSrc = "{{ asset('img/PDF_file_icon.svg.png') }}"

                var outputID = document.getElementById('preview_identity_card');

                if (typeID === 'application/pdf') {
                    outputID.src = pdfSrc;
                } else {
                    outputID.src = URL.createObjectURL(event.target.files[0]);
                    outputID.onload = function() {
                        URL.revokeObjectURL(outputID.src)
                    }
                }
            };

            // Aperçu de l'attestation de réussite
            var loadCertificate = function(event) {
                var inputCertificate = event.target;
                var certificateFile = inputCertificate.files[0];
                var typeCertificate = certificateFile.type;
                let pdfSrc = "{{ asset('img/PDF_file_icon.svg.png') }}"

                var outputCertificate = document.getElementById('preview_certificate');

                if (typeCertificate === 'application/pdf') {
                    outputCertificate.src = pdfSrc;
                } else {
                    outputCertificate.src = URL.createObjectURL(event.target.files[0]);
                    outputCertificate.onload = function() {
                        URL.revokeObjectURL(outputCertificate.src) // free memory
                    }
                }
            };
        </script>
    @endsection
</x-app-layout>
