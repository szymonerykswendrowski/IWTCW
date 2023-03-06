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
                // Column headings
                $('#output-table').append(
                    `<tr>
                        <th>Year</th>
                        <th>Tournament</th>
                        <th>Winner</th>
                        <th>Runner-up</th>
                    </tr>`);
                // Table rows
                $.each(data, function(index, row) {
                    const rowContent 
                    = `<tr>
                            <td>${row.year}</td>
                            <td>${row.tournament}</td>
                            <td>${row.winner}</td>
                            <td>${row.runnerUp}</td>
                       </tr>`;
                    $('#output-table').append(rowContent);
                });
            }
        );
    });
}