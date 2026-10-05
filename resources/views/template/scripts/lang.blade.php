<script>
    $(document).ready(function() {
        var language = "{{ app()->getLocale() }}"; // Obtenez la langue actuelle de Laravel
        var languageFile = "{{ asset('Backend/lang') }}/" + language + ".json"; // Construisez l'URL du fichier de langue

        // Initialiser les DataTables
        const tables = [
            '#basic-datatable',
            '#datatable-buttons',
            '#selection-datatable',
            '#alternative-page-datatable',
            '#scroll-vertical-datatable',
            '#scroll-horizontal-datatable',
            '#complex-header-datatable',
            '#row-callback-datatable',
            '#state-saving-datatable',
            '#fixed-header-datatable',
            '#fixed-columns-datatable',
            '#datatable-buttons_wrapper'
        ];

        tables.forEach(function(table) {
            $(table).DataTable({
                "language": {
                    "url": languageFile // Chargez le fichier de langue approprié
                },
                "search": {
                    "smart": true // Activez la recherche intelligente
                },
                "ordering": true, // Permettre le tri
                ...(table === '#datatable-buttons' && {
                    dom: 'Bfrtip',
                    buttons: ['copy', 'print']
                })
            });
        });
    });
</script>
