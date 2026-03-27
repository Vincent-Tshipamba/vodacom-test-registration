@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/3.1.3/css/select.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.5/css/searchPanes.dataTables.css">
@endpush
@section('content')
    <nav class="flex justify-between items-center my-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard', app()->getLocale()) }}"
                    class="inline-flex items-center font-medium text-gray-700 hover:text-indigo-800 dark:text-gray-300 text-base">
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                            stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ml-1 md:ml-2 font-medium text-gray-700 dark:text-gray-300 text-base">Interviews</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                            stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base">{{ $currentEdition->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <livewire:admin.interview-phase :currentEdition="$currentEdition" />
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/select/3.1.3/js/dataTables.select.js" defer></script>
    <script src="https://cdn.datatables.net/select/3.1.3/js/select.dataTables.js" defer></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.5/js/dataTables.searchPanes.js" defer></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.5/js/searchPanes.dataTables.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js" defer></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.tailwindcss.js" defer></script>
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            let table = document.getElementById('interview-results-table');
            // alert(table);
            // Initialiser DataTable avec les options de pagination
            const dataTable = $('#interview-results-table').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                info: true,
                language: {
                    search: "Rechercher : ",
                    paginate: {
                        next: "Suivant",
                        previous: "Précédent"
                    },
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    lengthMenu: "Afficher _MENU_ entrées",
                    loadingRecords: "Chargement...",
                    infoEmpty: 'Aucun candidat jusque-là ! ',
                    zeroRecords: 'Aucun candidat trouvé, désolé !',
                },
                layout: {
                    topStart: {
                        buttons: ['copy', 'excel', 'pdf', 'print']
                    },
                },
            });
        })
    </script>
@endpush
