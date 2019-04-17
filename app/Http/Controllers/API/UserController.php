<?php
namespace App\Http\Controllers\API;

use App\Exceptions\SuperAdminException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\GenerateAccessToken;
use App\Helpers\Response;
use App\Http\Controllers\API\Driver;
use Validator;


class UserController extends Controller
{

    public $successStatus = 200;

     
    private $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
   
 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function register(Request $request) 
    { 
       
        $validator = Validator::make($request->all(), [

            'username' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
           
            'first_name'=>'required', 
             'last_name' =>'required',
             'address'  =>'required',
             'house_number'=>'required', 
             'postal_code'=>'required',
             'city'=>'required',
             'telephone_number'=>'required',
             'is_active',
             
        ]);

        
       if ($validator->fails()) { 
               return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['username'] =  $user->name;
            return response()->json(['success'=>$success], $this-> successStatus); 
            }

    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function sort(Request $request,User $user)
    {
       
    $data = $request->get('data');
    $sortColumn = $request->get('sortColumn');
    $sort = $request->get('sort');


    $sort_users = User::orderBy($sortColumn,$sort) 
    ->get();
     return $sort_users;
     return response()->json(['data'=>$ $user]);
    }
     
    public function index(User $user)
    {
      $users=$this->userService->index();

     return response()->json(['success' => $users], $this-> successStatus);
     }
    
    public function createUser()
    {
        
        return view('admin.users.user');
    }

    
    public function store(CreateUserRequest $request)
    {
       
        $result = $this->userService->createUser($request);
        if (!$result) {
            return redirect('/users')->with('errorMessage',
                __('frontendMessages.EXCEPTION_MESSAGES.CREATE_USER_MESSAGE'));
        }
        return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_CREATED'));
        return response()->json($request);
        dd('$result');
    }



    public function edit($id)
    {
        $user = $this->userService->getUser($id);
        if ($user == null) {
            return redirect('/users')->with('errorMessage',
                __('frontendMessages.EXCEPTION_MESSAGES.FIND_USER_MESSAGE'));
        }
        return view('admin.users.user', ['user' => $user]);
    }
   


    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->userService->updateUser($request, $id);
        if ($result == null) {
            return redirect('/users/edit')->with('errorMessage',
                config('frontendMessages.EXCEPTION_MESSAGES.UPDATE_USER_MESSAGE'));
        }
        return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_UPDATED'));
    }
    


    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);
        if (!$result) {
            return redirect('/users')->with('errorMessage',
                __('frontendMessages.EXCEPTION_MESSAGES.DELETE_USER_MESSAGE'));
        }
        return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_DELETED'));
    }

    public function getSearchResults(Request $request) {

        $data = $request->get('data');

        $search_drivers = User::where('username', 'like', "%{$data}%")
                         ->orWhere('first_name', 'like', "%{$data}%")
                         ->orWhere('last_name', 'like', "%{$data}%")
                         ->get();
        return response()->json(['data'=>$search_drivers]);     
    }

    public function logout(Request $request)
    {
      $request->user()->token()->revoke();
      return response()->json([
     'message' => 'Successfully logged out'
    
    ]);
    }
    }
  





