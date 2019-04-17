<?php
namespace App\Repositories;
use App\User;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelBootstrapTableList\TableList;
use DB;
use Illuminate\Http\Request;  
class UserRepository extends Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    /**
     * Method to get model class
     *
     * @return string
     */
    public function getModelClass() : string
    {
        return User::class;
    }

   
    public function getUsersList() : TableList
    {
        return app(TableList::class)
            ->setModel(User::class)
            ->setRoutes([
                'index'      => ['alias' => 'users.index', 'parameters' => []],
                'edit'       => ['alias' => 'users.edit', 'parameters' => []],
                'destroy'    => ['alias' => 'users.destroy', 'parameters' => []],
            ])
            ->setRowsNumber(10)
            ->addQueryInstructions(function ($query){
                $query->select('users.*');
                //$query->selectRaw('MAX(authentication_logs.created_at) as last_login_at');
                $query->leftJoin('authentication_logs', 'authentication_logs.user_id', '=', 'users.id');
                $query->where('users.id', '!=', Auth::id());
                $query->where('users.is_active', 1);
                //$query->groupBy('users.id');
            });
    }


    public function index()
   {

    $users = DB::table('users')
     ->orderBy('first_name', 'desc')
     ->paginate(10);
      return $users;
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
   }