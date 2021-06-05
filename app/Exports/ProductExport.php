<?php

namespace App\Exports;

use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductExport implements FromQuery
{
    public function __construct($catid)
    {
        $this->catid = $catid;
    }

    use Exportable;


    public function query()
    {
        return Product::query()->whereHas('categories', function (Builder $query) {
            $query->where('id', $this->catid);
        });
    }
}
