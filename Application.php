<?php

class Application
{
    public function run()
    {
        $programIsRunning = true;

        while ($programIsRunning) {

            $this->printMenu();

            $choice = trim(fgets(STDIN));

            switch ($choice) {
                case '0':
                    $programIsRunning = false;
                    break;
            }
        }
    }

    function printMenu()
    {

        echo "************ Garden Tracker ******************\n";
        echo "1 - Show all data\n";
        echo "2 - Get coldest hour\n";
        echo "3 - \n";
        echo "4 - \n";
        echo "0 - Quit\n";
        echo "Enter your choice: ";
    }
}
