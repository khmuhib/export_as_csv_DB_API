<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Add CSS styles for loader -->
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 1s linear infinite;
            margin: auto;
            margin-top: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <!-- Add loader container -->
    <div id="loader" class="loader" style="display:none;"></div>

    <button onclick="generateData()">Generate</button>
    <button onclick="exportToCSV()">Export</button>
    <!-- <a href="export_api.php">Export</a> -->
    <button onclick="saveData()">Save</button>

    <table border="1" id="data-table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
        </tr>
    </table>

    <ul>

    </ul>

    <!-- Add JavaScript for loader display and API call -->
    <script>
        function showLoader() {
            var loaderElement = document.getElementById("loader");
            if (loaderElement) {
                loaderElement.style.display = "block";
            } else {
                console.error("Loader element not found");
            }
        }

        function hideLoader() {
            var loaderElement = document.getElementById("loader");
            if (loaderElement) {
                loaderElement.style.display = "none";
            } else {
                console.error("Loader element not found");
            }
        }

        async function generateData() {
            showLoader();

            try {
                const api_url = "https://jsonplaceholder.typicode.com/posts";
                const response = await fetch(api_url);
                const data = await response.json();
                populateTable(data);
            } catch (error) {
                console.error('Error fetching data:', error);
            } finally {
                hideLoader();
            }
        }

        function populateTable(data) {
            var table = document.getElementById("data-table");
            // table.innerHTML = ""; // Clear existing table data

            for (var i = 0; i < data.length; i++) {
                var row = table.insertRow(); // Without specifying an index, it adds a new row at the end
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);

                cell1.innerHTML = data[i].id;
                cell2.innerHTML = data[i].title;
                cell3.innerHTML = data[i].body;
            }
        }


        function saveData() {
            showLoader();
            // Add your save data logic here
            // After data is saved, call hideLoader() to hide the loader
            // For simplicity, I'm using a setTimeout to simulate data saving
            setTimeout(function() {
                hideLoader();
            }, 2000);
        }

        function exportToCSV() {
            var table = document.getElementById("data-table");
            var rows = table.getElementsByTagName("tr");
            var csvContent = "data:text/csv;charset=utf-8,";

            // Get the table headers
            var headerRow = rows[0];
            var headerCells = headerRow.getElementsByTagName("th");
            var headerArray = [];

            for (var h = 0; h < headerCells.length; h++) {
                headerArray.push(headerCells[h].innerText);
            }

            csvContent += headerArray.join(",") + "\n";

            // Get the table data
            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var rowArray = [];

                for (var j = 0; j < cells.length; j++) {
                    rowArray.push(cells[j].innerText);
                }

                csvContent += rowArray.join(",") + "\n";
            }

            // Create a download link
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "table_data.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>

</body>

</html>