<?php
$invoice_data = array();
$loaderVisible = false;
$errorMsg = '';

if (isset($_POST['submit'])) {
    // Validate if week_year is selected
    if (isset($_POST['week_year']) && !empty($_POST['week_year'])) {
        $week_year = $_POST['week_year'];

        // Display loader while waiting for the API response
        $loaderVisible = true;

        $api_url = "http://smartrestaurantsolutions.com/mobileapi-v2/v3/Tigger.php?funId=600&week_year=$week_year&rest_id=57";
        $token = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjB9.5lY2yythTRWK0Hnbgl4aOjbBsFAfoBQbuhqEQCz1EmWxlMLWA3VG1vIs6mZ5lFw6cH55SefHsuQ7M9gAeIRCjA';

        // Make a cURL request to the API endpoint
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Pass the Bearer token in the Authorization header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        // Hide loader after API response
        $loaderVisible = false;

        if (!empty($response)) {
            $invoice_data = json_decode($response);
            // echo '<pre>';
            // print_r($invoice_data);
            // echo '</pre>';
        }
    } else {
        $errorMsg = 'Please select a week and year.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Add CSS styles for table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

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

        .myComboBox {
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
            border: 1px solid #1fb5ad;
            /* Match the button border color */
            border-radius: 4px;
            background-color: #1fb5ad;
            /* Set a background color for the combo box */
            color: #fff;
            /* Match the button text color */
            margin: 4px 2px;
        }

        .myComboBox:hover {
            background-color: #1CA59E;
        }

        /* Style for the arrow in the combo box */
        .myComboBox::after {
            content: '▼';
            /* Unicode for a down arrow */
            font-size: 14px;
            margin-left: 5px;
            /* Adjust the spacing between text and arrow */
        }
    </style>
</head>

<body>

    <!-- Add loader container -->
    <div class="myMain">
        <div class="myMid">

            <div class="myButtonDiv">
                <form id="myForm" method="POST" class="myButtonDiv">
                    <?php
                    // Display error message if validation fails
                    if (!empty($errorMsg)) {
                        echo '<p style="color: red; float: right";>' . $errorMsg . '</p>';
                    }
                    ?>
                    <select class="myComboBox" name="week_year">
                        <option value="">Select week year</option>
                        <option value="47-2023" <?php if (isset($_POST['week_year']) && $_POST['week_year'] == '47-2023') echo 'selected'; ?>>47-2023</option>
                        <option value="48-2023" <?php if (isset($_POST['week_year']) && $_POST['week_year'] == '48-2023') echo 'selected'; ?>>48-2023</option>
                        <option value="49-2023" <?php if (isset($_POST['week_year']) && $_POST['week_year'] == '49-2023') echo 'selected'; ?>>49-2023</option>
                        <option value="50-2023" <?php if (isset($_POST['week_year']) && $_POST['week_year'] == '50-2023') echo 'selected'; ?>>50-2023</option>
                    </select>
                    <button type="submit" name="submit" class="myButton">Generate</button>
                    <button onclick="saveData()" class="myButton">Save Records</button>
                </form>
                <button onclick="exportToCSV()" class="myButton">Export</button>
            </div>

            <div class="table-container" style="clear: right;">
                <table id="data-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-search="Tiger Nixon">T. Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td data-order="1303689600">Mon 25th Apr 11</td>
                            <td data-order="320800">$320,800/y</td>
                        </tr>
                        <tr>
                            <td data-search="Garrett Winters">G. Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td data-order="1311552000">Mon 25th Jul 11</td>
                            <td data-order="170750">$170,750/y</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Add JavaScript for loader display and API call -->
    <script>
        // $(document).ready(function() {
        //     $('#myTable').DataTable();
        // });

        new DataTable('#data-table');
    </script>

</body>

</html>