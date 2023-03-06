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
        console.log(parameters);
        $.getJSON(
            'iwt-cw.php', parameters,
            function(data) {
                // Error checks
                if(data.hasOwnProperty("error")) {
                    $.each(data, function(index, item) {
                        $('<div>')
                        .text(item)
                        .appendTo('#output');
                    });
                }
                else {
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
                };
            }
        );
    });
}

function clearFields() {
    document.getElementById("year").value = "";
    document.getElementById("winner").value = "";
    document.getElementById("runner-up").value = "";
    document.getElementById("file").value = "default";
    document.getElementById("year-op").value = "=";
    document.getElementById("tournament").value = "Any";

}

function clearTable() {
    $("#output-table").html("");
}