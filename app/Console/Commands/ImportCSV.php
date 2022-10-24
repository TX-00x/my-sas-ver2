<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use SplFileObject;

class ImportCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {--location=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a CSV file to database';

    protected int $characterLength = 2000;

    protected string $filename;

    protected array $csvHeaders;

    protected bool $csvValidated = false;

    protected int $dbRecordCount;

    protected string $fileLocation;

    protected function getFileName()
    {
        return $this->filename;
    }

    protected function setFileName($filename)
    {
        $this->filename = $filename;
    }

    protected function getFileLocation()
    {
        return $this->fileLocation;
    }

    protected function setFileLocation($location)
    {
        $this->fileLocation = $location;
    }

    protected function getCsvHeaders()
    {
        return $this->csvHeaders;
    }

    protected function setCsvHeaders($csv)
    {
        $this->csvHeaders = fgetcsv($csv, $this->characterLength, ",");
    }

    protected function setDbCountBeforeImport($table)
    {
        $this->dbRecordCount = DB::table($table)->count();
    }

    protected function getDbCountBeforeImport()
    {
        return $this->dbRecordCount;
    }

    protected function setValidatedStatus($status)
    {
        $this->csvValidated = $status;
    }

    protected function getValidatedStatus()
    {
        return $this->csvValidated;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $location = $this->option('location');

        if ($location == null) {
            $this->line('This will search for the import files in default path which is set to \'database/data/\'');
            $this->line('You can change this location by adding --location option to the command');
            $this->setFileLocation('database/data/');
        } else {
            $this->setFileLocation($location);
        }

        if ($this->confirm('Do you wish to continue?')) {
            $filename = $this->ask('Please enter the file name (ex: table_name.csv)');
            $validationErrors = $this->validateCsvFile($filename, $this->getFileLocation());

            if ($this->getValidatedStatus()
            ) {
                $this->setFileName($filename);
                $csvfileContents = fopen(base_path($this->getFileLocation().$filename), "r");
                $this->setCsvHeaders($csvfileContents);
                $this->setDbCountBeforeImport(pathinfo($this->getFileLocation().$filename, PATHINFO_FILENAME));
                $this->importFromCsv($csvfileContents, $this->getFileLocation());
            } else {
                $this->error($validationErrors);
            }
        }
    }

    protected function getCsvFileRowCount()
    {
        $file = new SplFileObject($this->getFileLocation().$this->getFileName(), 'r');
        $file->seek(PHP_INT_MAX);

        return $file->key() - 1;
    }

    protected function validateCsvFile($filename, $location)
    {
        $error = null;
        $this->setValidatedStatus(false);
        try {
            $fileType = pathinfo($location.$filename, PATHINFO_EXTENSION);
            $fileTitle = pathinfo($location.$filename, PATHINFO_FILENAME);
        } catch (\Exception $exception) {
            $error = $exception->getMessage(). ' Please make sure you type the filename with the format (ex: table_name.csv)';
        }

        if ($fileType !== 'csv'){
            $error = 'File type is incorrect. Please make sure you give a csv format file';
        }
        else if (!Schema::hasTable($fileTitle)){
            $error = 'Could not find the corresponding table for this file name. Please make sure the .csv file name matches the table name.';
        } else {
            $this->setValidatedStatus(true);
        }

        return $error;
    }

    protected function importFromCsv($fileContents, $fileLocation)
    {
        $fileTitle = pathinfo($fileLocation.$this->getFileName(), PATHINFO_FILENAME);

        if (!Schema::hasColumns($fileTitle, $this->getCsvHeaders())){
            $this->line('csv headers');
            $this->table($this->getCsvHeaders(), [['']]);
            $this->warn('table headers');
            $this->table(Schema::getColumnListing($fileTitle), [['']]);
            $this->error('Table columns are not matching for the given csv file headers. Please verify the csv file and try again.');
        } else {
            $this->info('importing...');

            if (Schema::hasColumns($fileTitle, ['created_at', 'updated_at'])) {
                $this->line('Inserting/Updating new records');
                $this->processTheCSVFile($fileContents, $fileTitle);

            } else {
                $this->line('No timestamps found in table. Ignoring timestamps');
                $this->processTheCSVFile($fileContents, $fileTitle, false);
            }

        }
    }

    protected function processTheCSVFile($csv, $table, $withTimeStamps = true)
    {
        $headers = $this->getCsvHeaders();
        $bar = $this->output->createProgressBar($this->getCsvFileRowCount());
        if ($withTimeStamps) {

            $bar->start();
            while (($csvRow = fgetcsv($csv, $this->characterLength, ",")) !== false) {
                $rowWithoutTimeStamp = array_combine($headers, $csvRow);

                DB::table($table)
                    ->updateOrInsert($rowWithoutTimeStamp, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                $bar->advance();
            }
            $bar->finish();

        } else {
            $bar->start();
            while (($csvRow = fgetcsv($csv, $this->characterLength, ",")) !== false) {
                $rowWithoutTimeStamp = array_combine($headers, $csvRow);
                DB::table($table)->updateOrInsert($rowWithoutTimeStamp, $rowWithoutTimeStamp);
                $bar->advance();
            }
            $bar->finish();
        }

        if ($this->getDbCountBeforeImport() < DB::table($table)->count()) {
            $this->newLine(3);
            $this->line(DB::table($table)->count() - $this->dbRecordCount . ' new records added to the '.$table.' table');
            $this->info('Successfully imported!');
        }


        if ($this->getDbCountBeforeImport() == DB::table($table)->count()) {
            $this->newLine(3);
            $this->warn('Didn\'t import anything. Please check if the csv file records are already existing in the '.$table.' table');
        }

    }

}
