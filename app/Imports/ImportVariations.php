<?php

namespace App\Imports;

use App\Models\CategoryData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
class ImportVariations implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $cate_id;

    public function __construct(int $cate_id) 
    {
        $this->cate_id = $cate_id;
    }
    public function model(array $row)
    {
        $description = str_replace("�","“",$row['description']);
        $existing_variations = CategoryData::where('category_id',$this->cate_id)->where('description', 'LIKE', "%$description%")->get();
        if(isset($existing_variations)){
            foreach ($existing_variations as $variation) {
                $variation->delete();
            }
        }
        if(isset($row['name'])){
            $name = str_replace("�","“",$row['name']);
        }else{
            $name = '';
        }
        return new CategoryData([
            'name'        => $name,
            'description' => $description,
            'category_id' => $this->cate_id,
            'status'      => 1,
        ]);
    }
}
