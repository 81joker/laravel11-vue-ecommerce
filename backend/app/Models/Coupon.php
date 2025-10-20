<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Coupon extends Model
{
    use HasFactory , HasApiTokens;
    protected $fillable = ["name","discount","valid_until"];

    /**
     * Convert the coupon name to uppercase
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::upper($value);
    }

    
    /**
     * Check if the coupon is not expired
     */
    public function checkIfValid()
    {
        if($this->valid_until > Carbon::now()) {
            return true;
        }else {
            return false;
        }
    }
}
