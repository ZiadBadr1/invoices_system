<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Actions\Search\TimeSearchAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\Customer\SearchRequest;
use App\Models\Invoices;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.reports.customer',
        [
            'sections' => Section::all(),
        ]);
    }

    public function searchCustomer(SearchRequest $request)
    {
        $attributes = $request->validated();
//        dd($attributes);
        $query = Invoices::where('section_id',$attributes['section_id']);
        if($attributes['product_id'] != 0)
        {
            $query = $query->where('product_id',$attributes['product_id']);
        }
        (new TimeSearchAction())->execute($query, $attributes);
        $customers = $query->get();
        return view('admin.reports.customer',[
            'customers' => $customers,
            'sections' => Section::all(),
        ]);

    }



}
