<?php

namespace App\Observers;

use Illuminate\support\Str;

class BaseObserver
{
    public function generateKey($model, $data): void
    {
        $key = Str::slug($data->name ?? $data->title);

        if ($model::where('key', $key)->exists()) {
            $key = $this->incrementKey($key, $model);
            $data->key = $key;
        }
        else {
            $data->key = Str::slug($data->name ?? $data->title);
        }
    }

    public function incrementKey($key, $model) 
    {
        $original = $key;
        $count = 1;
        while ($model::where('key', $key)->exists()) {
            $key = "{$original}-" . $count++;
        }
        return $key;
    }
}
