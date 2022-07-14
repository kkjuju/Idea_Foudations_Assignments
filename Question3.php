<!DOCTYPE html>
<html>
<head>
    <title>Question 3</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<?php

class SalaryTable
{

    /**
     * @return mysqli|void
     */
    function OpenCon()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "employees";
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

        return $conn;
    }

    /**
     * @param $conn
     */
    function CloseCon($conn)
    {
        $conn->close();
    }

    /**
     * @param $empId
     * @param $salary
     * @param $salaryDate
     */
    function recordSalary($empId, $salary, $salaryDate)
    {
        $sql = "INSERT INTO `salaries` (`emp_no`, `salary`, `salary_date`) " .
            "VALUES ('" . $empId . "','" . $salary . "','" . $salaryDate . "')";
        $connection = $this->OpenCon();
        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
        $this->CloseCon($connection);
    }

    /**
     * @param $rank
     * @return array|mixed|string
     */
    function employeeRank($rank)
    {
        $response = [];
        $connection = $this->OpenCon();
        $sql = "SELECT  CONCAT(e.first_name,' ',e.last_name) AS 'EmployeeName',
                    e.hire_date as 'JoiningDate',
                    s.emp_no AS 'EmployeeNumber',
                    SUM(s.salary) AS 'TotalSalary',
                    AVG(s.salary) AS 'AverageSalary',
                    rank() OVER ( ORDER BY SUM(s.salary) DESC,AVG(s.salary) DESC, e.hire_date ASC ) as EmployeeRank
                    FROM employees e
                    JOIN salaries s ON s.emp_no = e.emp_no
                    GROUP BY s.emp_no
                    Order by EmployeeRank ASC";
        $result = $connection->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (array_search($rank, array_column($rows, 'EmployeeRank'))) {
            foreach ($rows as $row) {
                if ($row['EmployeeRank'] == $rank) {
                    $response = $row;
                }
            }
        } else {
            $count = $this->getCount($rows);
            $response = "Please enter Rank between 1 to " . $count;
        }
        $this->CloseCon($connection);
        return $response;
    }

    /**
     * @param $array
     * @return int
     */
    private function getCount($array)
    {
        $count = 0;
        foreach ($array as $type) {
            $count += count($type);
        }
        return $count;
    }

}

$conn = new SalaryTable ();
//Inert Employee Salary
$conn->recordSalary('770', '10000', '2022-07-01');
//Get Employee Details by Rank
$response = $conn->employeeRank('5');

//Display Result In Table
echo("<table>");
if (is_array($response) != '') {
    echo "<tr>
          <th>Employee Rank</th>
          <th>Employee Number</th>
          <th>Employee Name</th>
          <th>Total Salary</th>
          <th>Average Salary</th>
          <th>Joined Date</th>
          </tr>
          <tr>";
    // Employee details along with rank
    echo "<td>" . $response['EmployeeRank'] . "</td>
          <td>" . $response['EmployeeNumber'] . "</td>
          <td>" . $response['EmployeeName'] . "</td> 
          <td>" . $response['TotalSalary'] . "</td>
          <td>" . $response['AverageSalary'] . "</td>
          <td>" . $response['JoiningDate'] . "</td>
          </tr>";
} else {
    echo("<tr>");
    echo "<td>" . $response . "</td>";
    echo '</br>';
    echo('</tr>');
}
echo("</table>");
?>
</body>
</html>