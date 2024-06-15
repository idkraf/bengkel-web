<?php

namespace App\Http\Controllers;

use App\User;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Auth\Request\UpdateUser;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
use Firebase\Auth\Token\Exception\InvalidToken;
require 'vendor/autoload.php';

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     *
     */
    protected $auth;
    protected $database;
    //protected $firestore;
    protected $db;

    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->database = app('firebase.database');
        //$this->db = new FirestoreClient(['projectId' => 'logreg-bengkel',]);
        //$this->db = app('firebase.firestore')->database();
        // Create the Cloud Firestore client
        $this->db = new FirestoreClient(['projectId' => 'logreg-bengkel',]);
        $this->db = app('firebase.firestore')->database();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$database = app('firebase.database');
        $users = $this->auth->listUsers();
        $you = auth()->user();
        $userListArray = [];
       // foreach ($users as $user) {
          //  $userData = $database
          //      ->getReference('users/' . $user->uid . '/name')
          //      ->getvalue();
          //  if (!empty($userData)) {
          //      $name = $userData;
          //  } else {
          //      $name = '';
           // }

       //     $userListArray[] = [
       //         'uid' => $user->uid,
        //        'phoneNumber' => $user->phoneNumber,
        //        'name' => $name,
         //       'namaBisnis' => $name,                
         //       'disabled'=>$user->disabled
        //   ];
       // }
        
        //$reference = $db->collection('users');

        $userListArray = app('firebase.firestore')->database()->collection('users')->documents();
        //return view('dashboard.admin.usersList', compact('userListArray', 'you'));
        return view('dashboard.admin.usersList',['userListArray'=>$userListArray, 'you'=>$you]);
    }

    public function create()
    {
        return view('dashboard.admin.userCreateForm');
    }
    
    public function store(Request $request)
    {
        try {
            $mobile_no = $request->mobile_no;
            if (!empty($mobile_no)) {
                return redirect()->route('users.index');
            }
        } catch (Exception $e) {
            return view('dashboard.admin.userCreateForm');
        }
    }
    public function store1(Request $request)
    {
        try {
            $this->validator($request->all())->validate();
            $userProperties = [
                'email' => $request->input('email'),
                'emailVerified' => true,
                'password' => $request->input('password'),
                'displayName' => $request->input('name'),
                'disabled' => true,
            ];
            $createdUser = $this->auth->createUser($userProperties);
        } catch (FirebaseException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }
        $request->session()->flash('message', 'Successfully created note');
        return redirect()->route('users.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->auth->getUser($id);
        $userName = $this->database
                ->getReference('users/' . $user->uid . '/name')
                ->getvalue();
        $phoneNumber = $user->phoneNumber;
        return view('dashboard.admin.userShow', compact('phoneNumber','userName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->auth->getUser($id);
        $userName = $this->database
                ->getReference('users/' . $user->uid . '/name')
                ->getvalue();
        $phoneNumber = $user->phoneNumber;
        return view('dashboard.admin.userEditForm', compact('phoneNumber','userName','id'));
    }

    public function reloadData($id)
    {
        $uid = $id;
        
        //$this->firestore = $factory->createFirestore();
        //$this->db = $firestore->database();
        
        //$this->db = app('firebase.firestore')->database();
        $ref = $db->collection('users')->doc($id);
        $ref->update([
            'tes' => 'tes'
        ]);
        //$updatedPhone = $this->auth->updateUser($uid, $properties);

        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $phoneNumber = $request->phoneNumber;
        $name = $request->name;
        $uid = $id;
        $properties = [
            'phoneNumber' =>$phoneNumber
        ];
        $updatedPhone = $this->auth->updateUser($uid, $properties);
        $updatesUser = [
            'users/'.$uid.'/name' => $request->name,
        ];
        $this->database->getReference()->update($updatesUser);

        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->auth->getUser($id);
        if ($user) {
            $this->auth->deleteUser($id);
        }
        return redirect()->route('users.index');
    }

    public function block($id)
    {
        $user = $this->auth->getUser($id);
        if (!empty($user) && $user->disabled) {
            $block = $this->auth->enableUser($id);
        } else {
            $block = $this->auth->disableUser($id);
        }
        return redirect()->route('block-users');
    }

    public function blockUser()
    {
        $users = $this->auth->listUsers();
        $userListArray = [];
        foreach ($users as $user) {
            $userData = $this->database->getReference('users/' . $user->uid . '/name')->getvalue();
            if (!empty($userData)) {
                $name = $userData;
            } else {
                $name = '';
            }
            $userListArray[] = [
                'uid' => $user->uid,
                'phoneNumber' => $user->phoneNumber,
                'name' => $name,
                'disabled'=>$user->disabled
            ];
        }
        //dd($userListArray);
        
        return view('dashboard.admin.blockUsersList', compact('userListArray'));
    }
}
