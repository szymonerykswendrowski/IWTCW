function sendQuery() {
    $(document).ready(function() {
        // Query string parameters:
        var parameters = {
            file: $('#file').val(),
            year: $('#year').val(),
            yearOp: $('#year-op').val(),
            tournament: $('#tournament').val(),
            winner: $('#winner').val(),
            runnerUp: $('#runner-up').val()
        };
        $.getJSON(
            'iwt-cw.php', parameters,
            function(data) {
                // Rows of the table t
                // $.each(data, function(i, j) {
                //     var row = '<tr>';
                //     $.each(data, function(m, n) {
                //         // $('<tr/>')
                //         // .text(item)
                //         // .appendTo('#output-table')
                //         row += '<td>' + n + '</td>';
                //     });
                //     row += '</tr>'
                //     $('#output-table').append(row);
                // });z
                let output = "<tr>";
                $.each(data, function(index, entry) {
                   output = output + "<th>" + entry  + "</th>";
                });
                document.getElementById("output-table").innerHTML = output + "</tr>";
            }
        );
    });
}