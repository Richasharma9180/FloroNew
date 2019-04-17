<?php
namespace App\Services;
use App\Repositories\AuthenticationLogRepository;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AuthenticationLog;



class AuthenticationService
{
   /**
    * @var AuthenticationLogRepository $authenticationLog
      */     private $authenticationLogRepository;
      /**
       * AuthenticationService constructor.
      * Initialize object/instances of the classes.
       *
       * @param AuthenticationLogRepository $authenticationLogRepository
       */
    public function __construct(AuthenticationLogRepository $authenticationLogRepository)
     {
        $this->authenticationLogRepository = $authenticationLogRepository;
     }
     /**
* Method to store to logged-in logs in the database.
   *
      * @param Request $request
      * @param User $user
      * @return void
      */
   public function storeLoginActivityOfUser(Request $request, User $user)
   {
   
   //   'last_login_at' => Carbon::now()->toDateTimeString(),
   //   'last_logout_at' => date('Y-m-d H:i:s'),
   //   'last_login_ip' => $request->getClientIp(),
   //   'htt   $a=auth()->id();
   //   $user->find($a)->update([p_user_agent' => $request->server('HTTP_USER_AGENT'),
   //    ]);

         $logDetails =[ 
             'user_id' => $user->id,
             'ip_address' => $request->ip(),
             'agent'=>$request->server('HTTP_USER_AGENT'),
             'login_time'=>Carbon::now()->toDateTimeString(),

             'logout_time'=>date('Y-m-d H:i:s')


             ];
        $this->authenticationLogRepository->create($logDetails);
    }

}