<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;

class UserCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\User");
        $this->crud->setRoute("admin/user");
        $this->crud->setEntityNameStrings('user', 'users');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setColumns([
            [
                'name' => 'first_name',
                'label' => 'Имя',
                'type' => 'text',
            ],
            [
                'name' => 'last_name',
                'label' => 'Фамилия',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'E-mail',
                'type' => 'email',
            ],
        ]);

        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label' => 'Роль', // Table column heading
            'type' => 'select_multiple',
            'name' => 'roles', // the method that defines the relationship in your Model
            'entity' => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Roles", // foreign key model
        ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label' => 'Soc', // Table column heading
            'type' => 'select_multiple',
            'name' => 'provider', // the method that defines the relationship in your Model
            'entity' => 'social', // the method that defines the relationship in your Model
            'attribute' => 'id', // foreign key attribute that is shown to user
            'model' => "App\Models\UserSocialAccount", // foreign key model
        ]);
//

        $this->crud->addFields([
            [
                'name' => 'first_name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'last_name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
            ],
            [
                'label' => 'Roles',
                'type' => 'checklist',
                'name' => 'roles',
                'entity' => 'roles',
                'attribute' => 'name',
                'model' => "App\Models\Role",
                'pivot' => true,
            ],

        ]);


    }

    public function store(StoreRequest $request)
    {
        $this->handlePasswordInput($request);

        return parent::storeCrud($request);
    }

    /**
     * Update the specified resource in the database.
     *
     * @param UpdateRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $this->handlePasswordInput($request);

        return parent::updateCrud($request);
    }

    /**
     * Handle password input fields.
     *
     * @param CrudRequest $request
     */
    protected function handlePasswordInput(CrudRequest $request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }
    }
}
