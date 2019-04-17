<?php
namespace App\Http\Controllers;

use App\Services\ExportUserService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportUserController extends Controller
{
    private $exportUserService;

    public function __construct(ExportUserService $exportUserService)
    {
        $this->exportUserService = $exportUserService;
    }

    public function exportUsers()
    {
        $this->exportUserService->processUserExport();

        return redirect('/users')->with('successMessage',
            __('frontendMessages.SUCCESS_MESSAGES.USERS_EXPORTED'));
    }

    
    public function showUsersDownload()
    {
        $pathToFile = storage_path(config('constants.USER_EXPORTED_FILE_PATH'). '/' .
            Auth::id() . '.' . config('constants.USER_EXPORTED_FILE_TYPE'));

        return view('admin.users.userFileDownloads', ['pathToFile' => $pathToFile]);
    }


    public function downloadUsers()
    {
        $pathToFile = storage_path(config('constants.USER_EXPORTED_FILE_PATH'). '/' .
            Auth::id() . '.' . config('constants.USER_EXPORTED_FILE_TYPE'));

        return response()->download($pathToFile, now() . '.' . config('constants.USER_EXPORTED_FILE_TYPE'));
    }
}
