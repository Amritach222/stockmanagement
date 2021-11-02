<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    protected $table = 'transfers';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'from', 'to', 'item_id', 'item_variant_id', 'total_quantity', 'total_cost', 'total_tax', 'shipping_cost', 'grand_total', 'file_id', 'note', 'status');

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class, 'item_variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromDepartment()
    {
        return $this->belongsTo(Department::class, 'from');
    }

    public function toDepartment()
    {
        return $this->belongsTo(Department::class, 'to');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function totalTax($id)
    {
        $tax = Tax::findOrFail($id);
        $this->total_tax = $this->total_cost * ($tax->value / 100);
        $this->grand_total = $this->total_cost + $this->total_tax + $this->shipping_cost;
        $this->save();
    }
}
