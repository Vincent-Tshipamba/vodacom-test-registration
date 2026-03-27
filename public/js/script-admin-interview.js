function initializeDataTable() {
    let resultsTableElement = document.getElementById('interview-results-table');
    if (!resultsTableElement) return;

    if ($.fn.DataTable.isDataTable(('#interview-results-table'))) {
        $('#interview-results-table').DataTable().clear().destroy();
    }

    candidatsTableInstance = $('#interview-results-table').DataTable({
        paging: true,
        pageLength: 10,
        lengthChange: true,
        info: true,
        autoWidth: true,
        language: {
            search: "Rechercher : ",
            paginate: {
                next: "Suivant",
                previous: "Précédent"
            },
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            lengthMenu: "Afficher _MENU_ entrées",
            loadingRecords: "Chargement...",
            infoEmpty: 'Aucun candidat jusque-là !',
            zeroRecords: 'Aucun candidat trouvé, désolé !',
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées"
        },
        layout: {
            topStart: {
                buttons: [
                    'copy', 'excel', 'pdf', 'print',
                ]
            }
        },
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            },
        ],
    });
}

$(function () {
    $('.dataTables_filter input[type="search"]').addClass('p-2 bg-gray-300 dark:bg-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
});

initializeDataTable();
