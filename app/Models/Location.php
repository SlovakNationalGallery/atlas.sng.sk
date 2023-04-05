<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['name', 'title'];

    protected $fillable = ['id', 'name', 'title', 'floor'];

    public function __toString(): string
    {
        return collect([$this->title, $this->name, $this->floor_formatted, $this->building])
            ->filter()
            ->join(', ');
    }

    protected function floorFormatted(): Attribute
    {
        return Attribute::get(function () {
            if ($this->floor === null) {
                return null;
            }

            $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::ORDINAL);
            $floor = $formatter->format($this->floor);

            return $floor . ' ' . __('floor');
        });
    }
}
