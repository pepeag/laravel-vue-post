<?php

namespace App\Import;

use App\Models\Post;
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
            "title" => trim($row['title'], '"='),
            "description" => trim($row['description'], '"='),
        ]);
    }
}
