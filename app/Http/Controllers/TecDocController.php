<?php

namespace App\Http\Controllers;

use App\Models\TecDoc\Types;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DB;
use App\Models\TecDoc\Manufacturers;
use App\Models\TecDoc\Models;
use App\Models\TecDoc\TypesModel;
use App\Models\TecDoc\TreeSpares;
use App\Models\TecDoc\Spares;
use App\Models\Tecdoc_nissan;
use App\Models\PrsoProduct;
use App\Models\CategoryTree;
use Cache;
//use Yajra\Datatables\Datatables;
use Yajra\Datatables\Facades\Datatables;

//use App\DataTables\ModelsDataTable;

class TecDocController extends Controller
{

    public function Index()
    {
        $tecdoc = new Manufacturers();
        $Marks = $tecdoc
            ->select('MFA_ID', 'MFA_BRAND')
            ->where('MFA_ID', 1234)
            ->orWhere('MFA_ID', 558)
            ->get();

//dd($Marks);
        return view('tecdoc.index', compact('Marks'));
    }

    public function GetModel($marks)
    {
//
        return view('tecdoc.model', compact('marks'));
    }

    public function GetModeldata($marks)
    {

        $tecdoc = new Models();
        $Models = $tecdoc
            ->select('MOD_ID', 'TEX_TEXT as MOD_CDS_TEXT', 'MOD_PCON_START', 'MOD_PCON_END')
            ->join('country_designations', 'CDS_ID', '=', 'MOD_CDS_ID')
            ->join('des_texts', 'TEX_ID', '=', 'CDS_TEX_ID')
            ->where('MOD_MFA_ID', '=', $marks)
            ->where('CDS_LNG_ID', '=', 16)
            ->orderBy('MOD_CDS_TEXT')->get();

        return Datatables::of($Models)
            ->editColumn('MOD_ID', function ($model) {
                $start = $model->MOD_ID;
                 return $start;
//                return '<img class="img-responsive" src="/images/nissan/'.$start.'.png" />';
            
            })
            ->editColumn('MOD_PCON_START', function ($model) {
                $start = $model->MOD_PCON_START;
                $start = substr($start, 0, 4) . "-" . substr($start, 4, 2);
                return $start;
            })
            ->editColumn('MOD_PCON_END', function ($model) {
                $start = $model->MOD_PCON_END;
                $start = substr($start, 0, 4) . "-" . substr($start, 4, 2);
                return $start;
            })
            ->addColumn('action', function ($model) use ($marks) {
                return '<a href="/podbortecdoc/' . $marks . '/' . $model->MOD_ID . '" class="btn btn-xs btn-primary">Дальше <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
            })
            ->make(true);
    }

    public function Nissan()
    {
        $nissan = new Tecdoc_nissan();
        $Models = $nissan
            ->select('MOD_ID', 'groupe')
            ->whereIn('groupe', ['PATROL', 'ALMERA', 'JUKE', 'MICRA', 'PATHFINDER', 'NOTE', 'QASHQAI', 'X-TRAIL', 'TERRANO', 'MURANO', 'TIIDA'])
            ->orderBy('groupe')
            ->get();

        $Modelns = $nissan
            ->select('MOD_ID', 'groupe')
            ->whereNotIn('groupe', ['PATROL', 'ALMERA', 'JUKE', 'MICRA', 'PATHFINDER', 'NOTE', 'QASHQAI', 'X-TRAIL', 'TERRANO', 'MURANO', 'TIIDA'])
            ->orderBy('groupe')
            ->get();

        return view('tecdoc.popmodel', compact('Models', 'Modelns'));


    }

    public function NissanPop($groupe)
    {
        $nissan = new Tecdoc_nissan();
        $Models = $nissan
            ->select('MOD_ID', 'MOD_CDS_TEXT', 'MOD_PCON_START', 'MOD_PCON_END', 'URL')
            ->where('groupe', $groupe)->get();

        return view('tecdoc.modelpop', compact('Models'));


    }


    public function GetType($marks, $Models)
    {
        $tecdoc = new TypesModel();
        $types = $tecdoc
            ->select('TYP_ID', 'MFA_BRAND', 'DES_TEXTS7.TEX_TEXT as MOD_CDS_TEXT', 'des_texts.TEX_TEXT as TYP_CDS_TEXT', 'TYP_PCON_START', 'TYP_PCON_END', 'TYP_CCM',
                'TYP_KW_FROM', 'TYP_KW_UPTO', 'TYP_HP_FROM', 'TYP_HP_UPTO', 'TYP_CYLINDERS', 'engines.ENG_CODE', 'DES_TEXTS2.TEX_TEXT as TYP_ENGINE_DES_TEXT', 'DES_TEXTS3.TEX_TEXT as TYP_FUEL_DES_TEXT',
                DB::raw('IFNULL(DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) as TYP_BODY_DES_TEXT'),
                'DES_TEXTS6.TEX_TEXT as TYP_AXLE_DES_TEXT', 'TYP_MAX_WEIGHT')
            ->join('models', 'MOD_ID', '=', 'TYP_MOD_ID')
            ->join('manufacturers', 'MFA_ID', '=', 'MOD_MFA_ID')
            ->join('country_designations as COUNTRY_DESIGNATIONS2', function ($join) {
                $join->on('COUNTRY_DESIGNATIONS2.CDS_ID', '=', 'MOD_CDS_ID')
                    ->where('COUNTRY_DESIGNATIONS2.CDS_LNG_ID', '=', 16);
            })
            ->join('des_texts as DES_TEXTS7', 'DES_TEXTS7.TEX_ID', '=', 'COUNTRY_DESIGNATIONS2.CDS_TEX_ID')
            ->join('country_designations', function ($join) {
                $join->on('country_designations.CDS_ID', '=', 'TYP_CDS_ID')
                    ->where('country_designations.CDS_LNG_ID', '=', 16);
            })
            ->join('des_texts', 'des_texts.TEX_ID', '=', 'country_designations.CDS_TEX_ID')
            ->leftJoin('designations', function ($join) {
                $join->on('designations.DES_ID', '=', 'TYP_KV_ENGINE_DES_ID')
                    ->where('designations.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts AS DES_TEXTS2', 'DES_TEXTS2.TEX_ID', '=', 'designations.DES_TEX_ID')
            ->leftJoin('designations AS DESIGNATIONS2', function ($join) {
                $join->on('DESIGNATIONS2.DES_ID', '=', 'TYP_KV_FUEL_DES_ID')
                    ->where('DESIGNATIONS2.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts AS DES_TEXTS3', 'DES_TEXTS3.TEX_ID', '=', 'DESIGNATIONS2.DES_TEX_ID')
            ->leftJoin('link_typ_eng', 'LTE_TYP_ID', '=', 'TYP_ID')
            ->leftJoin('engines', 'ENG_ID', '=', 'LTE_ENG_ID')
            ->leftJoin('designations AS DESIGNATIONS3', function ($join) {
                $join->on('DESIGNATIONS3.DES_ID', '=', 'TYP_KV_BODY_DES_ID')
                    ->where('DESIGNATIONS3.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts AS DES_TEXTS4', 'DES_TEXTS4.TEX_ID', '=', 'DESIGNATIONS3.DES_TEX_ID')
            ->leftJoin('designations AS DESIGNATIONS4', function ($join) {
                $join->on('DESIGNATIONS4.DES_ID', '=', 'TYP_KV_MODEL_DES_ID')
                    ->where('DESIGNATIONS4.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts AS DES_TEXTS5', 'DES_TEXTS5.TEX_ID', '=', 'DESIGNATIONS4.DES_TEX_ID')
            ->leftJoin('designations AS DESIGNATIONS5', function ($join) {
                $join->on('DESIGNATIONS5.DES_ID', '=', 'TYP_KV_AXLE_DES_ID')
                    ->where('DESIGNATIONS5.DES_LNG_ID', '=', 16);
            })
            ->leftJoin('des_texts AS DES_TEXTS6', 'DES_TEXTS6.TEX_ID', '=', 'DESIGNATIONS5.DES_TEX_ID')
            ->where('TYP_MOD_ID', '=', $Models)
            ->orderBy('MFA_BRAND')
            ->orderBy('MOD_CDS_TEXT')
            ->orderBy('TYP_CDS_TEXT')
            ->orderBy('TYP_PCON_START')
            ->orderBy('TYP_CCM')
            ->paginate(25);

//        return Datatables::of($types)->make(true);
        return view('tecdoc.typemodel', compact('Models', 'marks', 'types'));


    }


    public function GetAllTree()
    {

        $qeery = 'SELECT SEARCH_TREE.STR_LEVEL, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL, DES_TEXTS.TEX_TEXT, DES_TEXTS2.TEX_TEXT, DES_TEXTS3.TEX_TEXT, DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS STR_TEXT, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL, SEARCH_TREE.STR_ID, SEARCH_TREE2.STR_ID, SEARCH_TREE3.STR_ID, SEARCH_TREE4.STR_ID, SEARCH_TREE5.STR_ID) AS STR_ID, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-1, DES_TEXTS.TEX_TEXT, DES_TEXTS2.TEX_TEXT, DES_TEXTS3.TEX_TEXT, DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS STR_TEXT2, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-1, SEARCH_TREE.STR_ID, SEARCH_TREE2.STR_ID, SEARCH_TREE3.STR_ID, SEARCH_TREE4.STR_ID, SEARCH_TREE5.STR_ID) AS STR_ID2, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-2, DES_TEXTS.TEX_TEXT, DES_TEXTS2.TEX_TEXT, DES_TEXTS3.TEX_TEXT, DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS STR_TEXT3, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-2, SEARCH_TREE.STR_ID, SEARCH_TREE2.STR_ID, SEARCH_TREE3.STR_ID, SEARCH_TREE4.STR_ID, SEARCH_TREE5.STR_ID) AS STR_ID3, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-3, DES_TEXTS.TEX_TEXT, DES_TEXTS2.TEX_TEXT, DES_TEXTS3.TEX_TEXT, DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS STR_TEXT4, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-3, SEARCH_TREE.STR_ID, SEARCH_TREE2.STR_ID, SEARCH_TREE3.STR_ID, SEARCH_TREE4.STR_ID, SEARCH_TREE5.STR_ID) AS STR_ID4, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-4, DES_TEXTS.TEX_TEXT, DES_TEXTS2.TEX_TEXT, DES_TEXTS3.TEX_TEXT, DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS STR_TEXT5, ';
        $qeery .= 'ELT(SEARCH_TREE.STR_LEVEL-4, SEARCH_TREE.STR_ID, SEARCH_TREE2.STR_ID, SEARCH_TREE3.STR_ID, SEARCH_TREE4.STR_ID, SEARCH_TREE5.STR_ID) AS STR_ID5 ';
        $qeery .= 'FROM SEARCH_TREE ';
        $qeery .= 'LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = SEARCH_TREE.STR_DES_ID AND DESIGNATIONS.DES_LNG_ID = 16 ';
        $qeery .= 'LEFT JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID ';
        $qeery .= 'LEFT JOIN SEARCH_TREE AS SEARCH_TREE2 ON SEARCH_TREE2.STR_ID = SEARCH_TREE.STR_ID_PARENT ';
        $qeery .= 'LEFT JOIN DESIGNATIONS AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = SEARCH_TREE2.STR_DES_ID AND DESIGNATIONS2.DES_LNG_ID = 16 ';
        $qeery .= 'LEFT JOIN DES_TEXTS AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = DESIGNATIONS2.DES_TEX_ID ';
        $qeery .= 'LEFT JOIN SEARCH_TREE AS SEARCH_TREE3 ON SEARCH_TREE3.STR_ID = SEARCH_TREE2.STR_ID_PARENT ';
        $qeery .= 'LEFT JOIN DESIGNATIONS AS DESIGNATIONS3 ON DESIGNATIONS3.DES_ID = SEARCH_TREE3.STR_DES_ID AND DESIGNATIONS3.DES_LNG_ID = 16 ';
        $qeery .= 'LEFT JOIN DES_TEXTS AS DES_TEXTS3 ON DES_TEXTS3.TEX_ID = DESIGNATIONS3.DES_TEX_ID ';
        $qeery .= 'LEFT JOIN SEARCH_TREE AS SEARCH_TREE4 ON SEARCH_TREE4.STR_ID = SEARCH_TREE3.STR_ID_PARENT ';
        $qeery .= 'LEFT JOIN DESIGNATIONS AS DESIGNATIONS4 ON DESIGNATIONS4.DES_ID = SEARCH_TREE4.STR_DES_ID AND DESIGNATIONS4.DES_LNG_ID = 16 ';
        $qeery .= 'LEFT JOIN DES_TEXTS AS DES_TEXTS4 ON DES_TEXTS4.TEX_ID = DESIGNATIONS4.DES_TEX_ID ';
        $qeery .= 'LEFT JOIN SEARCH_TREE AS SEARCH_TREE5 ON SEARCH_TREE5.STR_ID = SEARCH_TREE4.STR_ID_PARENT ';
        $qeery .= 'LEFT JOIN DESIGNATIONS AS DESIGNATIONS5 ON DESIGNATIONS5.DES_ID = SEARCH_TREE5.STR_DES_ID AND DESIGNATIONS5.DES_LNG_ID = 16 ';
        $qeery .= 'LEFT JOIN DES_TEXTS AS DES_TEXTS5 ON DES_TEXTS5.TEX_ID = DESIGNATIONS5.DES_TEX_ID ';
        $qeery .= 'ORDER BY STR_TEXT, STR_TEXT2, STR_TEXT3, STR_TEXT4, STR_TEXT5 ';

        $SparesTree = DB::connection('tecdoc')->select($qeery);


        foreach ($SparesTree as $tree) {
            $CategoryTree = new CategoryTree();
            $CategoryTree->STR_LEVEL = $tree->STR_LEVEL;
            $CategoryTree->STR_TEXT = $tree->STR_TEXT;
            $CategoryTree->STR_ID = $tree->STR_ID;
            $CategoryTree->STR_TEXT2 = $tree->STR_TEXT2;
            $CategoryTree->STR_ID2 = $tree->STR_ID2;
            $CategoryTree->STR_TEXT3 = $tree->STR_TEXT3;
            $CategoryTree->STR_ID3 = $tree->STR_ID3;
            $CategoryTree->STR_TEXT4 = $tree->STR_TEXT4;
            $CategoryTree->STR_ID4 = $tree->STR_ID4;
            $CategoryTree->STR_TEXT5 = $tree->STR_TEXT5;
            $CategoryTree->STR_ID5 = $tree->STR_ID5;
            $CategoryTree->save();


        }

      //  dd($SparesTree);
    }

    public function GetTreeSpares(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $data = [];

        Cache::pull('DataTree');


        $qeery = 'SELECT STR_ID, TEX_TEXT AS STR_DES_TEXT, ';
        $qeery .= 'IF(EXISTS(SELECT * FROM search_tree AS SEARCH_TREE2 WHERE SEARCH_TREE2.STR_ID_PARENT <=> search_tree.STR_ID LIMIT 1 ), 1, 0) AS DESCENDANTS ';
        $qeery .= 'FROM search_tree ';
        $qeery .= 'INNER JOIN designations ON DES_ID = STR_DES_ID ';
        $qeery .= 'INNER JOIN des_texts ON TEX_ID = DES_TEX_ID WHERE STR_ID_PARENT <=> 10001 AND DES_LNG_ID = 16 AND STR_ID !=13771 AND ';
        $qeery .= 'EXISTS( SELECT * FROM link_ga_str INNER JOIN link_la_typ ON LAT_TYP_ID = \'' . $types . '\'  AND LAT_GA_ID = LGS_GA_ID INNER JOIN link_art ON LA_ID = LAT_LA_ID WHERE LGS_STR_ID = STR_ID LIMIT 1 )';
//        dd($qeery);
        $Trees = DB::connection('tecdoc')->select($qeery);
//
        foreach ($Trees as $tree) {
            $data = array_add($data, $tree->STR_ID, $tree->STR_DES_TEXT);
        }


        Cache::add('DataTree', $data, 30);
//
        return view('tecdoc.tree', compact('models', 'marks', 'types', 'Trees'));

    }


    public function GetSubTreeSpares(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;

        $data = Cache::get('DataTree');
        Cache::pull('DataTree');

        $qeery = 'SELECT STR_ID, TEX_TEXT AS STR_DES_TEXT, ';
        $qeery .= 'IF(EXISTS(SELECT * FROM search_tree AS SEARCH_TREE2 WHERE SEARCH_TREE2.STR_ID_PARENT <=> search_tree.STR_ID LIMIT 1 ), 1, 0) AS DESCENDANTS ';
        $qeery .= 'FROM search_tree ';
        $qeery .= 'INNER JOIN designations ON DES_ID = STR_DES_ID ';
        $qeery .= 'INNER JOIN des_texts ON TEX_ID = DES_TEX_ID WHERE STR_ID_PARENT <=> \'' . $STR_ID . '\'  AND DES_LNG_ID = 16 AND ';
        $qeery .= 'EXISTS( SELECT * FROM link_ga_str INNER JOIN link_la_typ ON LAT_TYP_ID = \'' . $types . '\'  AND LAT_GA_ID = LGS_GA_ID INNER JOIN link_art ON LA_ID = LAT_LA_ID WHERE LGS_STR_ID = STR_ID LIMIT 1 )';
//        dd($qeery);
        $Trees = DB::connection('tecdoc')->select($qeery);

        foreach ($Trees as $tree) {
            $data = array_add($data, $tree->STR_ID, $tree->STR_DES_TEXT);
        }

        Cache::add('DataTree', $data, 30);


        return view('tecdoc.subtree', compact('marks', 'models', 'types', 'Trees', 'STR_ID'));

    }

    public function GetSubTreeSpares1(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;
        $STR_ID1 = $request->STR_ID1;

        $data = Cache::get('DataTree');
        Cache::pull('DataTree');

        $qeery = 'SELECT STR_ID, TEX_TEXT AS STR_DES_TEXT, ';
        $qeery .= 'IF(EXISTS(SELECT * FROM search_tree AS SEARCH_TREE2 WHERE SEARCH_TREE2.STR_ID_PARENT <=> search_tree.STR_ID LIMIT 1 ), 1, 0) AS DESCENDANTS ';
        $qeery .= 'FROM search_tree ';
        $qeery .= 'INNER JOIN designations ON DES_ID = STR_DES_ID ';
        $qeery .= 'INNER JOIN des_texts ON TEX_ID = DES_TEX_ID WHERE STR_ID_PARENT <=> \'' . $STR_ID1 . '\'  AND DES_LNG_ID = 16 AND ';
        $qeery .= 'EXISTS( SELECT * FROM link_ga_str INNER JOIN link_la_typ ON LAT_TYP_ID = \'' . $types . '\'  AND LAT_GA_ID = LGS_GA_ID INNER JOIN link_art ON LA_ID = LAT_LA_ID WHERE LGS_STR_ID = STR_ID LIMIT 1 )';
//        dd($qeery);
        $Trees = DB::connection('tecdoc')->select($qeery);
        foreach ($Trees as $tree) {
            $data = array_add($data, $tree->STR_ID, $tree->STR_DES_TEXT);
        }

        Cache::add('DataTree', $data, 30);

        return view('tecdoc.subtree1', compact('models', 'marks', 'types', 'Trees', 'STR_ID', 'STR_ID1'));

    }

    public function GetSubTreeSpares2(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;
        $STR_ID1 = $request->STR_ID1;
        $STR_ID2 = $request->STR_ID2;

        $data = Cache::get('DataTree');
        Cache::pull('DataTree');


        $qeery = 'SELECT STR_ID, TEX_TEXT AS STR_DES_TEXT, ';
        $qeery .= 'IF(EXISTS(SELECT * FROM search_tree AS SEARCH_TREE2 WHERE SEARCH_TREE2.STR_ID_PARENT <=> search_tree.STR_ID LIMIT 1 ), 1, 0) AS DESCENDANTS ';
        $qeery .= 'FROM search_tree ';
        $qeery .= 'INNER JOIN designations ON DES_ID = STR_DES_ID ';
        $qeery .= 'INNER JOIN des_texts ON TEX_ID = DES_TEX_ID WHERE STR_ID_PARENT <=> \'' . $STR_ID2 . '\'  AND DES_LNG_ID = 16 AND ';
        $qeery .= 'EXISTS( SELECT * FROM link_ga_str INNER JOIN link_la_typ ON LAT_TYP_ID = \'' . $types . '\'  AND LAT_GA_ID = LGS_GA_ID INNER JOIN link_art ON LA_ID = LAT_LA_ID WHERE LGS_STR_ID = STR_ID LIMIT 1 )';
//        dd($qeery);
        $Trees = DB::connection('tecdoc')->select($qeery);

        foreach ($Trees as $tree) {
            $data = array_add($data, $tree->STR_ID, $tree->STR_DES_TEXT);
        }

        Cache::add('DataTree', $data, 30);


        return view('tecdoc.subtree2', compact('models', 'marks', 'types', 'Trees', 'STR_ID', 'STR_ID1', 'STR_ID2'));

    }

    public function GetSpares(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;

        $Spares = DB::connection('tecdoc')
            ->table('link_ga_str')
            ->select('LA_ART_ID')
            ->join('link_la_typ', function ($join) use ($types) {
                $join->on('LAT_GA_ID', 'LGS_GA_ID')
                    ->where('LAT_TYP_ID', $types);
            })
            ->join('link_art', 'LA_ID', 'LAT_LA_ID')
            ->where('LGS_STR_ID', $STR_ID)->get();
//dd($Spares);
        return view('tecdoc.spares', compact('models', 'marks', 'types', 'STR_ID', 'Spares'));
    }

    public function GetSpares1(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;
        $STR_ID1 = $request->STR_ID1;


//          dd($marks,$models,$types,$STR_ID1);
        $Spares = DB::connection('tecdoc')
            ->table('link_ga_str')
            ->select('LA_ART_ID')
            ->join('link_la_typ', function ($join) use ($types) {
                $join->on('LAT_GA_ID', ' = ', 'LGS_GA_ID')
                    ->where('LAT_TYP_ID', ' = ', $types);
            })
            ->join('link_art', 'LA_ID', ' = ', 'LAT_LA_ID')
            ->where('LGS_STR_ID', $STR_ID1)->get();


        return view('tecdoc . spares1', compact('models', 'marks', 'types', 'Trees', 'STR_ID', 'STR_ID1', 'Spares'));
    }

    public function GetSpares2(Request $request)
    {
        $marks = $request->marks;
        $models = $request->models;
        $types = $request->type;
        $STR_ID = $request->STR_ID;
        $STR_ID1 = $request->STR_ID1;
        $STR_ID2 = $request->STR_ID2;

        $Spares = DB::connection('tecdoc')
            ->table('link_ga_str')
            ->select('LA_ART_ID')
            ->join('link_la_typ', function ($join) use ($types) {
                $join->on('LAT_GA_ID', ' = ', 'LGS_GA_ID')
                    ->where('LAT_TYP_ID', ' = ', $types);
            })
            ->join('link_art', 'LA_ID', ' = ', 'LAT_LA_ID')
            ->where('LGS_STR_ID', $STR_ID2)->get();


        return view('tecdoc . spares2', compact('models', 'marks', 'types', 'Trees', 'STR_ID', 'STR_ID1', 'STR_ID2', 'Spares'));
    }

    public function SearchSpares(Request $request)
    {
        $number = $request->number;
        $number = str_replace('-', '_', $number);

        $number = camel_case($number);
        $number = strtoupper($number);
//dd($number);
        $Spares = DB::connection('tecdoc')
            ->table('art_lookup')
            ->select(DB::raw('IF (art_lookup.ARL_KIND IN(2, 3), brands.BRA_BRAND, suppliers.SUP_BRAND) AS BRAND'),
                'art_lookup.ARL_SEARCH_NUMBER as NUMBER', 'art_lookup.ARL_KIND', 'art_lookup.ARL_ART_ID', 'des_texts.TEX_TEXT as ART_COMPLETE')
            ->leftJoin('brands', 'brands.BRA_ID', '=', 'art_lookup.ARL_BRA_ID')
            ->join('articles', 'articles.ART_ID', '=', 'art_lookup.ARL_ART_ID')
            ->join('suppliers', 'suppliers.SUP_ID', '=', 'articles.ART_SUP_ID')
            ->join('designations', 'designations.DES_ID', '=', 'articles.ART_COMPLETE_DES_ID')
            ->join('des_texts', 'des_texts.TEX_ID', '=', 'designations.DES_TEX_ID')
            ->where('art_lookup.ARL_SEARCH_NUMBER', trim($number, "\""))
            ->whereIn('art_lookup.ARL_KIND', [2, 3])
            ->where('designations.DES_LNG_ID', 16)
            ->groupBy('BRAND', 'NUMBER')
            ->distinct()->get();
        $named ="";
        $analog = [];
        $prim = [];
        foreach ($Spares as $Spare) {

            $prim = array_merge($prim, $this->Primenimost($Spare->NUMBER));
//            $analog = $this->SearchSparesPodbor($Spare->BRAND, $Spare->NUMBER, $Spare->ART_COMPLETE);
            $analog = array_merge($analog, $this->SearchSparesPodbor($Spare->BRAND, $Spare->NUMBER, $Spare->ART_COMPLETE));
            $named = $Spare->ART_COMPLETE;
        }
        $analog = $this->unique_multidim_array($analog, 'NUMBER');
        $prim = $this->unique_multidim_array($prim, 'MOD_CDS_TEXT');

        return view('tecdoc.searchspares', compact('analog', 'Spares', 'number', 'named', 'prim'));
    }

    public function SearchSparesPodbor($brand, $number, $named)

    {

        $number = str_replace('-', '_', $number);

        $number = camel_case($number);
        $number = strtoupper($number);


        $qeery = 'SELECT DISTINCT IF (ART_LOOKUP2 . ARL_KIND = 3, BRANDS2 . BRA_BRAND, SUPPLIERS2 . SUP_BRAND) AS BRAND,';
        $qeery .= 'IF (ART_LOOKUP2 . ARL_KIND = 3, ART_LOOKUP2 . ARL_DISPLAY_NR, ARTICLES2 . ART_ARTICLE_NR) AS NUMBER,';
        $qeery .= 'ART_LOOKUP2 . ARL_KIND ';
        $qeery .= 'FROM art_lookup ';
        $qeery .= 'LEFT JOIN brands ON brands . BRA_ID = art_lookup . ARL_BRA_ID ';
        $qeery .= 'INNER JOIN articles ON articles . ART_ID = art_lookup . ARL_ART_ID ';
        $qeery .= 'INNER JOIN suppliers ON suppliers . SUP_ID = articles . ART_SUP_ID ';
        $qeery .= 'INNER JOIN art_lookup AS ART_LOOKUP2 FORCE KEY(PRIMARY) ON ART_LOOKUP2 . ARL_ART_ID = art_lookup . ARL_ART_ID ';
        $qeery .= 'LEFT JOIN brands AS BRANDS2 ON BRANDS2 . BRA_ID = ART_LOOKUP2 . ARL_BRA_ID ';
        $qeery .= 'INNER JOIN articles AS ARTICLES2 ON ARTICLES2 . ART_ID = ART_LOOKUP2 . ARL_ART_ID ';
        $qeery .= 'INNER JOIN suppliers AS SUPPLIERS2 FORCE KEY(PRIMARY) ON SUPPLIERS2 . SUP_ID = ARTICLES2 . ART_SUP_ID ';
        $qeery .= 'WHERE ';
        $qeery .= 'art_lookup . ARL_SEARCH_NUMBER = \'' . $number . '\' AND ';
        $qeery .= '(art_lookup.ARL_KIND  = 3 AND brands.BRA_BRAND = \'' . $brand . '\' ) AND';
        $qeery .= '(art_lookup.ARL_KIND, ART_LOOKUP2.ARL_KIND) IN ((3, 3))';
        $qeery .= 'ORDER BY BRAND, NUMBER; ';

        $SparesAnalog = DB::connection('tecdoc')->select($qeery);

        $SparesAnalogRezult = [];
        foreach ($SparesAnalog as $spa) {

            if ($spa->BRAND == 'NISSAN' || $spa->BRAND == 'INFINITI') {

                $spa->NUMBER = str_replace(['-', ' '], '', $spa->NUMBER);
                $spa->price = $this->CatalogItemPrice($spa->NUMBER);
                $analog = ['BRAND' => $spa->BRAND, 'NUMBER' => str_replace(['-', ' '], '', $spa->NUMBER), 'price' => $this->CatalogItemPrice($spa->NUMBER)];
                $SparesAnalogRezult[] = $analog;
            }

        }

//        dump($SparesAnalogRezult);
        $sorted = array_values(array_sort($SparesAnalogRezult, function ($value) {
            return $value['price'];
        }));

        $sorteds = $this->unique_multidim_array($sorted, 'NUMBER');

        return $sorteds;

    }

    public function Primenimost($snumber)
    {

//        $snumber = $request->snumber;
        $sklad = new PrsoProduct();
        $snumber = str_replace('-', '_', $snumber);

        $snumber = camel_case($snumber);
        $snumber = strtoupper($snumber);
//dd($number);

        $nalichie = $sklad->where('number', $snumber)
            ->get();
//        dump($nalichie);
        $Spares = DB::connection('tecdoc')
            ->table('art_lookup')
            ->select(DB::raw('IF (art_lookup.ARL_KIND IN(2, 3), brands.BRA_BRAND, suppliers.SUP_BRAND) AS BRAND'),
                'art_lookup.ARL_SEARCH_NUMBER as NUMBER', 'art_lookup.ARL_KIND', 'art_lookup.ARL_ART_ID', 'des_texts.TEX_TEXT as ART_COMPLETE')
            ->leftJoin('brands', 'brands.BRA_ID', '=', 'art_lookup.ARL_BRA_ID')
            ->join('articles', 'articles.ART_ID', '=', 'art_lookup.ARL_ART_ID')
            ->join('suppliers', 'suppliers.SUP_ID', '=', 'articles.ART_SUP_ID')
            ->join('designations', 'designations.DES_ID', '=', 'articles.ART_COMPLETE_DES_ID')
            ->join('des_texts', 'des_texts.TEX_ID', '=', 'designations.DES_TEX_ID')
            ->where('art_lookup.ARL_SEARCH_NUMBER', trim($snumber, "\""))
            ->whereIn('art_lookup.ARL_KIND', [2, 3])
            ->where('designations.DES_LNG_ID', 16)
            ->groupBy('BRAND', 'NUMBER')
            ->distinct()->get();
//        dump($Spares);

        if ($Spares->count() != null) {
            $snumber_id = $Spares->first()->ARL_ART_ID;
        //    dump($snumber_id);
            $qeery = 'SELECT TYP_ID, MFA_BRAND, DES_TEXTS7.TEX_TEXT AS MOD_CDS_TEXT,des_texts.TEX_TEXT AS TYP_CDS_TEXT, TYP_PCON_START, TYP_PCON_END, TYP_CCM, TYP_KW_FROM,TYP_KW_UPTO, TYP_HP_FROM, TYP_HP_UPTO, TYP_CYLINDERS, engines.ENG_CODE,DES_TEXTS2.TEX_TEXT AS TYP_ENGINE_DES_TEXT, DES_TEXTS3.TEX_TEXT AS TYP_FUEL_DES_TEXT, IFNULL(DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS TYP_BODY_DES_TEXT ';
            $qeery .= 'FROM link_art ';
            $qeery .= 'INNER JOIN link_la_typ ON lat_la_id = LA_ID ';
            $qeery .= 'INNER JOIN types ON TYP_ID = LAT_TYP_ID ';
            $qeery .= 'INNER JOIN country_designations ON country_designations.CDS_ID = TYP_CDS_ID ';
            $qeery .= 'INNER JOIN des_texts ON des_texts.TEX_ID = country_designations.CDS_TEX_ID ';
            $qeery .= 'INNER JOIN models ON MOD_ID = TYP_MOD_ID ';
            $qeery .= 'INNER JOIN manufacturers ON MFA_ID = MOD_MFA_ID ';
            $qeery .= 'INNER JOIN country_designations AS COUNTRY_DESIGNATIONS2 ON COUNTRY_DESIGNATIONS2.CDS_ID = MOD_CDS_ID ';
            $qeery .= 'INNER JOIN des_texts AS DES_TEXTS7 ON DES_TEXTS7.TEX_ID = COUNTRY_DESIGNATIONS2.CDS_TEX_ID ';
            $qeery .= 'LEFT JOIN designations ON designations.DES_ID = TYP_KV_ENGINE_DES_ID ';
            $qeery .= 'LEFT JOIN des_texts AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = designations.DES_TEX_ID ';
            $qeery .= 'LEFT JOIN designations AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = TYP_KV_FUEL_DES_ID ';
            $qeery .= 'LEFT JOIN des_texts AS DES_TEXTS3 ON DES_TEXTS3.TEX_ID = DESIGNATIONS2.DES_TEX_ID ';
            $qeery .= 'LEFT JOIN link_typ_eng ON LTE_TYP_ID = TYP_ID ';
            $qeery .= 'LEFT JOIN engines ON ENG_ID = LTE_ENG_ID ';
            $qeery .= 'LEFT JOIN designations AS DESIGNATIONS3 ON DESIGNATIONS3.DES_ID = TYP_KV_BODY_DES_ID ';
            $qeery .= 'LEFT JOIN des_texts AS DES_TEXTS4 ON DES_TEXTS4.TEX_ID = DESIGNATIONS3.DES_TEX_ID ';
            $qeery .= 'LEFT JOIN designations AS DESIGNATIONS4 ON DESIGNATIONS4.DES_ID = TYP_KV_MODEL_DES_ID ';
            $qeery .= 'LEFT JOIN des_texts AS DES_TEXTS5 ON DES_TEXTS5.TEX_ID = DESIGNATIONS4.DES_TEX_ID ';
            $qeery .= 'LEFT JOIN designations AS DESIGNATIONS5 ON DESIGNATIONS5.DES_ID = TYP_KV_AXLE_DES_ID ';
            $qeery .= 'LEFT JOIN des_texts AS DES_TEXTS6 ON DES_TEXTS6.TEX_ID = DESIGNATIONS5.DES_TEX_ID ';
            $qeery .= 'WHERE LA_ART_ID = \'' . $snumber_id . '\' AND ';
            $qeery .= 'country_designations.CDS_LNG_ID = 16 AND ';
            $qeery .= 'COUNTRY_DESIGNATIONS2.CDS_LNG_ID = 16 AND ';
            $qeery .= '(designations.DES_LNG_ID IS NULL OR designations.DES_LNG_ID = 16) AND ';
            $qeery .= '(DESIGNATIONS2.DES_LNG_ID IS NULL OR DESIGNATIONS2.DES_LNG_ID = 16) AND ';
            $qeery .= '(DESIGNATIONS3.DES_LNG_ID IS NULL OR DESIGNATIONS3.DES_LNG_ID = 16) AND ';
            $qeery .= '(DESIGNATIONS4.DES_LNG_ID IS NULL OR DESIGNATIONS4.DES_LNG_ID = 16) AND ';
            $qeery .= '(DESIGNATIONS5.DES_LNG_ID IS NULL OR DESIGNATIONS5.DES_LNG_ID = 16) ';
            $qeery .= 'ORDER BY MFA_BRAND, MOD_CDS_TEXT, TYP_CDS_TEXT, TYP_PCON_START, TYP_CCM ';
            $qeery .= 'LIMIT 100 ';

            $SparesSovmest = DB::connection('tecdoc')->select($qeery);
//            dump($SparesSovmest);
            $Sovmest = [];
            foreach ($SparesSovmest as $spa) {

                if ($spa->MFA_BRAND == 'NISSAN' || $spa->MFA_BRAND == 'INFINITI') {

                    $Sovmest[] = (array)$spa;
                }

            }
            $sorteds = $this->unique_multidim_array($Sovmest, 'MOD_CDS_TEXT');
//           dump($sorteds);
        } else {
            $SparesSovmest = null;
        }
        return $sorteds;
        return view('tecdoc.searchsparessclad', compact('SparesSovmest', 'nalichie', 'Spares'));

    }

    public function CatalogItemPrice($cart_p)
    {

        $cart_p = camel_case($cart_p);

        $catalog = new PrsoProduct();
        $cart_prices = $catalog
            ->where('number', $cart_p)
            ->orwhere('artikul', $cart_p)
            ->get();
        $price = 'Под заказ';

        foreach ($cart_prices as $cart_price) {
            // dd($cart_price);
            if ($cart_price->exists) {
                $price = $cart_price->price;
            }
        };

        return $price;
    }

    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}

