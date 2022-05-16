<?php

namespace App\Import;

use App\Models\Post;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Categories Import class
 */
class PostsImport implements ToModel, WithHeadingRow
{
    /**
     * To insert category data to storage
     * @param array $row
     * @return array list of categories
     */
    public function model(array $row)
    {
        return new Post([
            "title" => $row['title'],
            "description" => $row['description'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}