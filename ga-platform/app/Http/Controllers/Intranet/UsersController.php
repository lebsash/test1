<?php

/*
 * Intranet - Users
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Http\Controllers\Intranet;

use GAPlatform\Http\Controllers\Controller;
use GAPlatform\Libraries\LegacyHelpers;

use Session;
use Request;
use GAPlatform\Models\GASalesPerson;
use GAPlatform\Models\GAUser;

class UsersController extends Controller
{
    /**
     * List per page
     */
    protected $perPage = 20;
    
    /**
     * Controller - lists of users
     */
    public function index($type = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['type'] = $type;

        if (!isset($data['search'])) {
            $data['search'] = '';
        }

        $oUser = new GAUser();

        if (!is_null($type)) {
            $data['items'] = $oUser->getAllUsers($this->perPage, $type, $data['search']);
        } else {
            $data['items'] = $oUser->getAllUsers($this->perPage, 'all', $data['search']);
        }

        return view('intranet.users.users', $data);
    }

    /**
     * Delete user
     */
    public function deleteUser($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $oUser = new GAUser();

        $data['usersList'] = $oUser->getUsersList();

        if ($user = $oUser->where('UserID', $id)->active()->first()) {

            $data['id'] = $user->UserID;
            $data['link'] = "/users/delete/{$user->UserID}/";
            $data['type'] = "User";
            $data['button'] = 'Delete User';
            $data['confirmInfo'] = 'User Name: ' . $user->Name;
            $data['confirmDesc'] = ' User ID: ' . $user->UserID;

            if (Request::isMethod('post')) {
                if ($data['confirm_id'] == $user->UserID) {

                    // mark as deleted users
                    GAUser::where('UserID', $user->UserID)->update(['Status'=>'deleted']);

                    $data['confirmed'] = trans('messages.deleted', []);
                }
                
            }
            return view('intranet.confirm', $data);
        }

        // unknown user
        return redirect(config('app.url-gai').'/users');
    }

    /**
     * Add/Update new user
     */
    public function formUser($id = null)
    {
        $data = $this->requests();
        $errors = [];
        $data['id'] = $id;

        $oUser = new GAUser();

        // Validations
        if (Request::isMethod('post')) {
            if (empty($data['Name'])) {
                $errors[] = trans('messages.required',['field'=>'Name']);
            }
            if (empty($data['Title'])) {
                $errors[] = trans('messages.required',['field'=>'Title']);
            }
            if (empty($data['Email'])) {
                $errors[] = trans('messages.required',['field'=>'Email']);
            }


            if (count($errors)) {
                $data['validationErrors'] = $errors;
            } else {
                // saving
                if($savedData = $oUser->saveUser($data)){

                    // created
                    if ($savedData->wasRecentlyCreated) {
                        $data['created'] = trans('messages.saved', []);

                    // updated
                    } else {
                        $data['updated'] = trans('messages.updated', []);
                    }
                    $savedData->toArray();
                }
            }
        }
        // get user information
        if ($user = $oUser->where('UserID', $id)->active()->first()) {
            $data['user'] = $user->toArray();

        // no user record
        } else {
            $data['user'] = [];
        }

        return view('intranet.users.form', $data);
    }
}
