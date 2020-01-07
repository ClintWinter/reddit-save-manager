<?php

namespace App\Filters;

use Illuminate\Http\Request;

class SaveFilters extends QueryFilters {

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        parent::__construct($request);
    }

    public function subreddit($term = null)
    {
        if (! $term) {
            return $this->builder;
        }

        return $this->builder->when($term, function($query, $subreddit) {
            $query->whereHas('subreddit', function($q) use ($subreddit) {
                $q->where('name', $subreddit);
            });
        });
    }

    public function tags($term = null)
    {
        if (! $term) {
            return $this->builder;
        }

        return $this->builder->when($term, function($query, $tag) {
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('name', $tag);
            });
        });
    }

    public function type($term = null)
    {
        if (! $term) {
            return $this->builder;
        }

        return $this->builder->when($term, function($query, $type) {
            $query->whereHas('type', function($q) use ($type) {
                $q->where('type', $type);
            });
        });
    }

    public function query($term = null)
    {
        if (! $term) {
            return $this->builder;
        }

        $search = "%{$term}%";

        return $this->builder->where(function($query) use ($search) {
            $query->where('title', 'like', $search)
                ->orWhere('body', 'like', $search);
        });
    }

}