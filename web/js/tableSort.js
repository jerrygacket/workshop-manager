$(document).ready(function () {
    $('#techCardTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
            // "lengthMenu": "Показывать _MENU_ элементов на странице",
            // "zeroRecords": "Нечего фильтровать",
            // "info": "Страница _PAGE_ из _PAGES_",
            // "infoEmpty": "Нет записей",
            // "infoFiltered": "(filtered from _MAX_ total records)"
        }
    });
    $('.reportTable').DataTable({
        "searching": false,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "language": {
            //"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json",
            "sProcessing":   "Подождите...",
            "sLengthMenu":   "Показать _MENU_ записей",
            "sZeroRecords":  "Записи отсутствуют.",
            "sInfo":         "Записи с _START_ до _END_ из _TOTAL_ записей",
            "sInfoEmpty":    "Записи с 0 до 0 из 0 записей",
            "sInfoFiltered": "(отфильтровано из _MAX_ записей)",
            "sInfoPostFix":  "",
            "sSearch":       "Быстрый поиск:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst": "Первая",
                "sPrevious": "Предыдущая",
                "sNext": "Следующая",
                "sLast": "Последняя"
            },
            "oAria": {
                "sSortAscending":  ": активировать для сортировки столбца по возрастанию",
                "sSortDescending": ": активировать для сортировки столбцов по убыванию"
            }
        }
    });
    $('.dataTables_length').addClass('bs-select');
});