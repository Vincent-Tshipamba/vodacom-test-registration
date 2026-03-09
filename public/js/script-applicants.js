function initializeDataTable() {
    let candidatsTableElement = document.getElementById('candidats-table');
    if (!candidatsTableElement) return;

    if ($.fn.DataTable.isDataTable(('#candidats-table'))) {
        $('#candidats-table').DataTable().clear().destroy();
    }

    candidatsTableInstance = $('#candidats-table').DataTable({
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
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            },
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
