<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('title', 'logo_id', 'currency', 'time_zone', 'date_format', 'fiscal_year_id');

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function logo()
    {
        return $this->belongsTo(File::class, 'logo_id');
    }

    public static function companyName()
    {
        $setting = Setting::findOrFail(1);
        return $setting->title;
    }

    public static function imageUrl()
    {
        $setting = Setting::findOrFail(1);
        $image_url = null;
        if ($setting->logo_id !== null) {
            $image_url = $setting->logo->path ?? '';
        }
        return $image_url;
    }

    public static function title()
    {
        $setting = Setting::findOrFail(1);
        return $setting->title;
    }

}
