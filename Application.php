<?php

class Application
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "2dv513_a3");
    }

    public function run()
    {
        $programIsRunning = true;

        while ($programIsRunning) {

            $this->printMenu();

            $choice = trim(fgets(STDIN));

            switch ($choice) {

                case '1':
                    $this->printAllData();
                    break;

                case '2':
                    $this->printColdestHour();
                    break;

                case '3':
                    $this->printWarmestHour();
                    break;

                case '4':
                    $this->printRainfallData();
                    break;

                case '5':
                    $this->printAverageHumidity();
                    break;

                case '0':
                    $programIsRunning = false;
                    break;
            }
        }
    }

    function printMenu()
    {
        echo "\n************ Garden Tracker ******************\n";
        echo "1 - Show latest data\n";
        echo "2 - Show coldest hour\n";
        echo "3 - Show warmest hour\n";
        echo "4 - Show total rainfall and average rainfall per hour\n";
        echo "5 - Show average humidity (%)\n";
        echo "0 - Quit\n";
        echo "Enter your choice: ";
    }

    function printAllData()
    {
        $query = "SELECT * FROM DATAVIEW";

        if ($result = $this->conn->query($query)) {
            echo "\nThermometer\tTime\t\tLocation\tTemp\tHumidity\tRainfall\n";
            while ($row = $result->fetch_row()) {

                printf("%s\t%s\t%s\t\t%s\t%s\t\t%s\n", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
            }
            $result->free_result();
        }
    }

    function printColdestHour()
    {
        $query = "SELECT temperature, timestamp 
        FROM temperaturedata 
        WHERE temperature = (SELECT Min(temperature) AS coldestHour 
        FROM temperaturedata)";

        if ($result = $this->conn->query($query)) {
            echo "\nTemp\tTime\n";
            while ($row = $result->fetch_row()) {

                printf("%s\t%s\n", $row[0], $row[1]);
            }
            $result->free_result();
        }
    }

    function printWarmestHour()
    {
        $query = "SELECT temperature, timestamp 
        FROM temperaturedata 
        WHERE temperature = (SELECT Max(temperature) AS warmestHour 
        FROM temperaturedata)";

        if ($result = $this->conn->query($query)) {
            echo "\nTemp\tTime\n";
            while ($row = $result->fetch_row()) {

                printf("%s\t%s\n", $row[0], $row[1]);
            }
            $result->free_result();
        }
    }

    function printRainfallData()
    {
        $query = "SELECT (SELECT Sum(rainfall)FROM rainfalldata) AS totalRain, 
        Avg(rainfall) AS averageRain, 
        Avg(humidity) AS averageHumidity 
        FROM rainfalldata 
        JOIN humiditydata";

        if ($result = $this->conn->query($query)) {
            echo "\nTotal\tAverage hourly rainfall\tAverage hourly humidity\n";
            while ($row = $result->fetch_row()) {

                printf("%smm\t%smm\t\t\t%s%%\n", round($row[0], 2), round($row[1], 2), round($row[2], 2));
            }
            $result->free_result();
        }
    }

    function printAverageHumidity()
    {
        $query = "SELECT Avg(humidity) 
        AS averageHumidity 
        FROM humiditydata";

        if ($result = $this->conn->query($query)) {
            echo "\nAverage humidity per hour:\n";
            $row = $result->fetch_row();
            echo $row[0] . "%\n";
            $result->free_result();
        }
    }
}
