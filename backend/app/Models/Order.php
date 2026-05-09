<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['external_order_id', 'patient_id'];

    public function results() {
        return $this->hasMany(TestResult::class);
    }
}