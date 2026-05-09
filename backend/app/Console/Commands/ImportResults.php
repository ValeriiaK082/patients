<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patient;
use App\Models\Order;
use App\Models\TestResult;
use Illuminate\Support\Facades\Log;

class ImportResults extends Command
{
    protected $signature = 'import:results {file}';
    protected $description = 'Import patient results from CSV';

    public function handle()
    {
        $path = $this->argument('file');

        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return 1;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle, 0, ';');
        $imported = 0;
        $errors = 0;
        $line = 1;

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $line++;
            if (count($row) < 9) {
                Log::channel('import')->error("Line $line: incomplete row");
                $errors++;
                continue;
            }

            [$patientId, $name, $surname, $sex, $birthDate,
             $orderId, $testName, $testValue, $testReference] = $row;

            try {
                $patient = Patient::updateOrCreate(
                    ['external_id' => $patientId],
                    ['name' => $name, 'surname' => $surname,
                     'sex' => $sex, 'birth_date' => $birthDate]
                );

                $order = Order::firstOrCreate([
                    'external_order_id' => $orderId,
                    'patient_id'        => $patient->id,
                ]);

                TestResult::create([
                    'order_id'  => $order->id,
                    'name'      => $testName,
                    'value'     => $testValue,
                    'reference' => $testReference,
                ]);

                Log::channel('import')->info("Line $line: imported OK");
                $imported++;
            } catch (\Exception $e) {
                Log::channel('import')->error("Line $line: " . $e->getMessage());
                $errors++;
            }
        }

        fclose($handle);
        $this->info("Done. Imported: $imported, Errors: $errors");
        return 0;
    }
}