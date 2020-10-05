<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SearchTrait
{
    public function scopeSearch($query, Request $request)
    {
        $filtered   = $request->query('filtered');
        $JsonFilter = json_decode($filtered, true);

        $sorted   = $request->query('sorted');
        $JsonSort = json_decode($sorted, true);

        $pageSize = (int) $request->query('pageSize') ?: 10;

        // check array filter
        if (is_array($JsonFilter)) {
            foreach ($JsonFilter as $item) {
                $query->where($item['id'], 'like', '%' . $item['value'] . '%');
            }
        }

        // check array sort
        if (is_array($JsonSort)) {
            foreach ($JsonSort as $item) {
                $query->orderBy($item['id'], $item['desc'] ? 'desc' : 'asc');
            }
        } else {
            $query->latest();
        }

        return $query->paginate($pageSize);
    }
}
