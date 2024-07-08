<?php

namespace App\Controllers;

use App\Https\Request;
use App\Model\User;

class UserController extends User
{

  public function index()
  {
    $users = User::all();
    if (!$users) {
      echo json_encode(['error' => 'Users not found']);
      return;
    }
    echo json_encode($users);
  }

  public function show($id)
  {
    $user = $this->find($id);

    if (empty($user)) {
      echo json_encode(['error' => 'User not found']);
      return;
    }

    echo json_encode($user);
  }

  public function store(Request $request)
  {
    $requestData = $request->getBody();
    
    $createUser = $this->create($requestData);

    echo json_encode($createUser);
  }


  public function edit(int $id, Request $request)
  {
    $user = $this->find($id);
    $requestData = $request->getBody();
     if (!$user) {
       echo json_encode(['error' => 'User not found']);
       return;
     }
     $this->upgrade($id, $requestData);
  // }
  }

  public function remove($id)
  {
    $user = User::find($id);
    if (!$user) {
      echo json_encode(['error' => 'User not found']);
      return;
    }
    $this->delete($id);
  }
}
