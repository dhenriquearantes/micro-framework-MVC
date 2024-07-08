<?php

namespace App\Controllers;

use App\Https\Request;
use App\Model\User;

class UserController
{

  public function index()
  {
    $users = User::all();
    if(!$users) {
      echo json_encode(['error' => 'Users not found']);
      return;
    }   
    echo json_encode($users);
  }

  public function show($id)
  {
    $user = User::find($id);
    if(!$user) {
      echo json_encode(['error' => 'User not found']);
      return;
    }
    echo json_encode($user);
  }

  public function store(Request $request) 
  {
    $requestData = $request->getBody();

    $data = User::create($requestData);
  }

  public function update($id, Request $request)
  {
    $user = User::find($id);
    $requestData = $request->getBody();
    
    if(!$user) {
      echo json_encode(['error' => 'User not found']);
      return;
    }
    $userMod = User::update($id, $requestData);

  }
  public function delete($id)
  {
    $user = User::find($id);
    if(!$user) {
      echo json_encode(['error' => 'User not found']);
      return;
    } 
    $userDelete = User::delete($id);

    
  }

}
