<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrsoProduct as  Product;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('allplants');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $prods = Product::all();

        return Datatables::of($prods)
            ->addColumn('action', function ($prod) {
                return '<a href="/search?number='. $prod->number.'" class="btn btn-xs btn-primary"> Аналоги/совместимость</a>';
            })
            ->make(true);
    }
}
