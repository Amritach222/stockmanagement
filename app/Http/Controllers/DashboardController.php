<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function allSettingInfo()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $settings = Setting::findOrFail(1);
            $settings->product_count = Product::count();
            $settings->item_count = Item::count();
            $settings->category_count = Category::count();
            $settings->brand_count = Brand::count();
            $settings->unit_count = Unit::count();
            $data['data']=$settings;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }
}
