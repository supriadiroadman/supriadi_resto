<?php

namespace App\Exports;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExportXML implements FromQuery
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Product::all();
    // }
    public function __construct($catid)
    {
        $this->catid = $catid;
        // $this->bagian = $bagian;
    }

    use Exportable;

    // public function query()
    // {
    //     return Product::query();
    // }
    // public function query()
    // {
    //     // return Product::query()->where('id', $this->catid);
    //     return Product::query()->whereHas('categories', function (Builder $query) {
    //         $query->where('id', $this->catid});
    // }

    public function query()
    {
        return Product::query()->whereHas('categories', function (Builder $query) {
            $query->where('id', $this->catid);
        });
    }
}
