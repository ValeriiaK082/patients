<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['order_id', 'name', 'value', 'reference'];
}