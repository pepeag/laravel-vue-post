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
        //\Log::info($row["created_at"]);
        //\Log::info($row["updated_at"]);
        //\Log::info(Carbon::createFromFormat("M d, Y", $row["created_at"]));
        return new Post([
            "title" => $row['title'],
            "description" => $row['description'],
            "created_at" => $row['created_at']->format-date('Y-m-d H:i:s'),
            "updated_at" => $row['updated_at']->format-date('Y-m-d H:i:s'),
        ]);
    }
}
