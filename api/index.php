<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Add CSS styles for loader -->
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F1F2F7;
            font-family: tahoma;
        }

        /* Loader CSS Start */
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #1fb5ad;
            border-radius: 50%;
            width: 60px;
            height: 60px;
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

        /* Loader CSS End */

        .myMain {
            background-color: #F1F2F7;
            width: 100%;
            overflow: hidden;
        }

        .myMid {
            background-color: #fff;
            width: 90%;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .myButtonDiv {
            display: flex;
            justify-content: end;
        }

        .myButton {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #1fb5ad;
            color: #fff;
            margin: 4px 2px;
        }

        .myButton:hover {
            background-color: #1CA59E;
        }

        .table-container {
            overflow-x: auto;
        }

        .mytable {
            border-collapse: collapse;
            border: 1px solid #ddd;
            width: 100%;
            background-color: #fff;
            margin: 10px auto;
        }

        .mytable th,
        .mytable td {
            padding: 4px;
            line-height: 1.42857143;
            vertical-align: top;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <!-- Add loader container -->
    <div class="myMain">
        <div class="myMid">

            <!-- <div id="loader" class="loader" style="display:none;"></div> -->

            <div class="myButtonDiv">
                <button onclick="generateData()" class="myButton">Generate</button>
                <button onclick="exportToCSV()" class="myButton">Export</button>
                <!-- <a href="export_api.php">Export</a> -->
                <button onclick="saveData()" class="myButton">Save Records</button>
            </div>

            <div class="table-container">
                <table id="data-table" class="mytable">
                    <tr>
                        <th>Res ID</th>
                        <th>Res Name</th>
                        <th>Invoice Email</th>
                        <th>Total Sales</th>
                        <th>Netpay Orders</th>
                        <th>Netpay Sales</th>
                        <th>Netpay Charges</th>
                        <th>Service Charge</th>
                        <th>Invoice total</th>
                        <th>Card Status</th>
                    </tr>
                    <tr>
                        <td colspan="10" align="center" id="no-data">
                            <div id="loader" class="loader" style="display:none;"></div>
                            <h5>No Data Found</h5>
                        </td>
                    </tr>
                </table>
            </div>



        </div>

    </div>

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

        function noData() {
            var noDataElement = document.getElementById("no-data");
            if (noDataElement) {
                noDataElement.style.display = "none";
            } else {
                console.error("No data element not found");
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
                noData();
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
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                var cell9 = row.insertCell(8);
                var cell10 = row.insertCell(9);

                cell1.innerHTML = data[i].id;
                cell2.innerHTML = data[i].title;
                cell3.innerHTML = data[i].body;
                cell4.innerHTML = data[i].body;
                cell5.innerHTML = data[i].body;
                cell5.innerHTML = data[i].body;
                cell6.innerHTML = data[i].body;
                cell7.innerHTML = data[i].body;
                cell8.innerHTML = data[i].body;
                cell9.innerHTML = data[i].body;
                cell10.innerHTML = data[i].body;
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
            for (var i = 2; i < rows.length; i++) {
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