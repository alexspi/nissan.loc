<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BrandsCrudRequest as StoreRequest;
use App\Http\Requests\BrandsCrudRequest as UpdateRequest;

class BrandsCrudController extends CrudController
{
    public function setUp() {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */



        $this->crud->setModel("App\Models\Brands");
        $this->crud->setRoute("admin/brands");
        $this->crud->setEntityNameStrings('brands', 'Список Брендов производителей');
        $this->crud->enableExportButtons();
        $this->crud->enableAjaxTable();




//        $this->crud->allowAccess('reorder');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        $this->crud->allowAccess('reorder');
//        $this->crud->setFromDb();
        $this->crud->addColumn([
            'name' => 'brandName',
            'label' => 'Название'
        ]);
//        $this->crud->addColumn([
//            'name' => 'status',
//            'label' => 'Status',
//            'type' => 'boolean',
//            // optionally override the Yes/No texts
//            'options' => [0 => 'не активен', 1 => 'активен']
//        ]);
        $this->crud->addColumn([

                'name' => 'status', // The db column name
                'label' => 'Статус', // Table column heading
                'type' => 'check'

        ]);
        $this->crud->addColumn([
            'name' => 'brandLogoID', // The db column name
            'label' => "Profile image", // Table column heading
            'type' => 'image',
             'prefix' => 'http://webservicepilot.tecdoc.net/pegasus-3-0/documents/1111/',
            // optional width/height if 25px is not ok with you
             'height' => '30px',
            // 'width' => '30px',
        ]);
        $this->crud->addField([
            'name'        => 'status', // the name of the db column
            'label'       => 'Status', // the input label
            'type'        => 'radio',
            'options'     => [ // the key will be stored in the db, the value will be shown as label;
                0 => "Не активен",
                1 => "Активев"
            ],
            // optional
            //'inline'      => false, // show the radios all on the same line?
        ]);

    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
