<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Auth\Request\UpdateUser;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;
use Firebase\Auth\Token\Exception\InvalidToken;

require 'vendor/autoload.php';

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     *
     */
    protected $auth;
    protected $database;
    protected $db;

    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->database = app('firebase.database');
        // Create the Cloud Firestore client
        $this->db = new FirestoreClient(['projectId' => 'logreg-bengkel',]);
        $this->db = app('firebase.firestore')->database();
    }

    public function index()
    {
        //$group = $this->database->getReference('groups');
        //$groupLists = $group->getSnapshot()->getvalue();
        $group = [];
        $group = app('firebase.firestore')->database()->collection('groups')->documents();
        return view('dashboard.group.groupUsersList', ['groupLists'=>$group]);
    }

    public function create()
    {
        //return view('dashboard.admin.userCreateForm');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$group = $this->database->getReference('groups/' . $id)->getValue();
        $group =  $this->db->collection('groups')->document($id)->snapshot();
      
      $user = [];
      foreach ($group->data()['membersUid'] as $list){ 
        
        //$user[] = $this->database->getReference('user/' . $list)->getValue();
        $user[] = $this->db->collection('users')->document($list)->snapshot();
      }
        return view(
            'dashboard.group.groupShow',
            ['group' => $group, 'user'=>$user, 'id'=>$id]
        );
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
        return view('dashboard.admin.userEditForm', compact('user'));
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
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:256',
            'email' => 'required|email|max:256',
        ]);
        $user = $this->auth->getUser($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $properties = [
            'displayName' => $request->input('name'),
            'email' => $request->input('email'),
        ];
        $updatedUser = $this->auth->updateUser($id, $properties);
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
        $user = $this->database->getReference('groups/' . $id)->remove();
        return redirect()->route('group.index');
    }

    public function memberDestroy($id)
    {
        $gname = $_POST['gname'];
        $user = $this->database->getReference('groups/' . $gname . '/name/'.$id)
            ->remove();
        return redirect()->route('group.index');
    }
}
