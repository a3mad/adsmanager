<?php

namespace App\Imports;

use App\Models\Rerun;
use App\Models\Client;
use App\Models\Channel;
use App\Models\Program;
use App\Models\Sponsor;
use App\Models\Campaign;
use App\Models\Location;
use Laravel\Nova\Resource;
use App\Models\SponsorType;
use App\Models\ProgramBreak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ReportImporter implements ToModel, WithValidation, WithHeadingRow, WithMapping, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    /** @var Resource */
    protected $resource;
    protected $attribute_map;
    protected $rules;
    protected $model_class;
    private $stored_rows = 0;
    private $errors_list = [];


    public function map($row): array
    {
        if (! $this->attribute_map) {
            return $row;
        }

        $data = [];

        foreach ($this->attribute_map as $attribute => $column) {
            if (! $column) {
                continue;
            }

            $data[$attribute] = $this->preProcessValue($row[$column]);
        }

        return $data;
    }

    private function mapForeignKeys(&$row)
    {
        if(array_key_exists("channel", $row))
        {
            $row["channel_id"] = Channel::firstWhere("name", $row["channel"])?->id;
            unset($row["channel"]);
        }
        if(array_key_exists("location", $row))
        {
            $row["location_id"] = Location::firstWhere("name", $row["location"])?->id;
            unset($row["location"]);
        }
        if(array_key_exists("program", $row))
        {
            $row["program_id"] = Program::firstWhere("name", $row["program"])?->id;
            unset($row["program"]);
        }
        if(array_key_exists("campaign", $row))
        {
            $row["campaign_id"] = Campaign::firstWhere("name", $row["campaign"])?->id;
            unset($row["campaign"]);
        }
        if(array_key_exists("client", $row))
        {
            $row["client_id"] = Client::firstWhere("name", $row["client"])?->id;
            unset($row["client"]);
        }
        if(array_key_exists("sponsorType", $row))
        {
            $row["sponsor_type_id"] = SponsorType::firstWhere("name", $row["sponsorType"])?->id;
            unset($row["sponsorType"]);
        }
        if(array_key_exists("rerun", $row))
        {
            $row["rerun_id"] = Rerun::firstWhere("name", $row["rerun"])?->id;
            unset($row["rerun"]);
        }
        if(array_key_exists("programBreak", $row))
        {
            $row["program_break_id"] = ProgramBreak::firstWhere("name", $row["programBreak"])?->id;
            unset($row["programBreak"]);
        }
        if(array_key_exists("sponsor", $row))
        {
            $row["sponsor_id"] = Sponsor::firstWhere("name", $row["sponsor"])?->id;
            unset($row["sponsor"]);
        }
        if(array_key_exists("air_time", $row) && gettype($row["air_time"]) != "string")
        {
            $row["air_time"] = date("H:i:s", $row["air_time"]);
        }
    }

    public function model(array $row)
    {
        $model = $this->resource::newModel();
        $this->mapForeignKeys($row);
        $model->fill($row);
        
        ++$this->stored_rows;
        return $model;
    }

    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * @return mixed
     */
    public function getAttributeMap()
    {
        return $this->attribute_map;
    }

    /**
     * @param mixed $map
     * @return Importer
     */
    public function setAttributeMap($map)
    {
        $this->attribute_map = $map;

        return $this;
    }

    /**
     * @param mixed $rules
     * @return Importer
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModelClass()
    {
        return $this->model_class;
    }

    /**
     * @param mixed $model_class
     * @return Importer
     */
    public function setModelClass($model_class)
    {
        $this->model_class = $model_class;

        return $this;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    private function preProcessValue($value)
    {
        switch ($value) {
            case 'FALSE':
                return false;
                break;
            case 'TRUE':
                return true;
                break;
        }

        return $value;
    }

    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        array_push($this->errors_list, $e);
        --$this->stored_rows;
    }

    public function errors()
    {
        return $this->errors_list;
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        --$this->stored_rows;
    }

    public function getRowCount(): int
    {
        return $this->stored_rows;
    }
}