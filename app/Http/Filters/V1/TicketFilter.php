<?php

namespace App\Http\Filters\V1;

class TicketFilter extends QueryFilter
{
    public function status($value)
    {
        return $this->builder->where('status', $value);
    }

    public function filter($query, array $filters)
    {
        if ($filters['name'] ?? false) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if ($filters['status'] ?? false) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
