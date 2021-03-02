<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ModelsCarCrudRequest as StoreRequest;
use App\Http\Requests\ModelsCarCrudRequest as UpdateRequest;

class ModelsNCrudController extends CrudController
{
    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */


        $this->crud->setModel("App\Models\NissanModelsCars");
        $this->crud->setRoute("admin/models_niss");
        $this->crud->setEntityNameStrings('models', 'Список моделей Nissan');
        $this->crud->enableExportButtons();
        $this->crud->enableAjaxTable();
//
        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'modelname',
            'label' => 'Модель'
        ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'modelname', 'LIKE', "%$value%");
            });


//        $this->crud->allowAccess('reorder');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
//        $this->crud->allowAccess('reorder');
//        $this->crud->allowAccess('filter');
//        $this->crud->setFromDb();
//        $this->crud->addColumn([
//            'name' => 'manuId',
//            'label' => 'id',
//
//        ]);

        $this->crud->addColumn([
            'name' => 'modelname',
            'label' => 'Название'
        ]);
        $this->crud->addColumn([
            'name' => 'yearOfConstrFrom',
            'label' => 'Status',

        ]);
        $this->crud->addColumn([

            'name' => 'status', // The db column name
            'label' => 'Статус', // Table column heading
            'type' => 'check'

        ]);
//        $this->crud->addColumn([
//            'name' => 'brandLogoID', // The db column name
//            'label' => "Profile image", // Table column heading
//            'type' => 'image',
//             'prefix' => 'http://webservicepilot.tecdoc.net/pegasus-3-0/documents/1111/',
//            // optional width/height if 25px is not ok with you
//             'height' => '30px',
//            // 'width' => '30px',
//        ]);
        $this->crud->addField([
            'name' => 'status', // the name of the db column
            'label' => 'Status', // the input label
            'type' => 'radio',
            'options' => [ // the key will be stored in the db, the value will be shown as label;
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
