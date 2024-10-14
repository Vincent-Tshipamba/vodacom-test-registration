<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-gray-900 dark:bg-gray-800 dark:text-red-400"
                role="alert">

                <span class="font-medium">{{ $error }}</span>

            </div>
        @endforeach
    @endif
    @if (Session('success'))
        {{-- Modal pour l'affichage des messages de success --}}
        <div id="alert-success-session"
            class="flex items-center xl:max-w-full max-w-full mx-auto p-5 mb-4 text-green-400 border-t-4 border-green-300 bg-gray-900 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ms-3 2xl:text-xl lg:text-lg md:text-md text-sm font-medium lg:text-center w-full">
                Merci d'avoir rempli ce formulaire. <br><br>
                <a href="" id="showCoupon"
                    class="text-white text-center rounded-full hover:bg-blue-700 px-4 py-2 bg-blue-600 hover:text-gray-300 font-bold">Cliquez
                    ici pour voir votre coupon </a><br><br>
                Veuillez bien le garder, car il vous donnera l'accès
                à la salle de passation du test. <br><br>
                Consultez <a href="https://vodaeduc.vodacom.cd/fr-fr/learn/#/library"
                    class="text-underline text-blue-500">vodaeduc.vodacom.cd </a> pour une meilleure préparation. <br>
                A bientôt cher(e) {{ session('name') }}.
            </div>
        </div>
    @endif


    @section('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Vérifier si l'élément existe avant d'ajouter l'événement
                var showCouponLink = document.getElementById('showCoupon');
                if (showCouponLink) {
                    showCouponLink.addEventListener('click', function(event) {
                        event.preventDefault(); // Empêche le lien de se comporter normalement

                        // Récupère le coupon depuis la session ou toute autre source
                        var coupon = "{{ session('coupon') }}";

                        // Afficher SweetAlert avec le coupon et une option pour copier
                        Swal.fire({
                            title: 'Votre coupon',
                            html: `<strong style="font-size: 24px;">${coupon}</strong>`,
                            showCancelButton: false,
                            confirmButtonText: 'Copier',
                            confirmButtonColor: '#3085d6',
                            showCloseButton: true,
                            customClass: {
                                popup: 'swal-wide', // Permet d'agrandir l'alerte si nécessaire
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Copier le coupon dans le presse-papier
                                navigator.clipboard.writeText(coupon).then(function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Coupon copié !',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }, function(err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Échec de la copie',
                                        text: 'Essayez de copier manuellement.',
                                    });
                                });
                            }
                        });
                    });
                }
            });
        </script>
    @endsection
</x-app-layout>
