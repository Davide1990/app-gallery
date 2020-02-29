<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AdminUsersRequest;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
       
        return view('admin/users');
    }

    private function getUserButtons(User $user){

        $id = $user->id;
       
        $buttonEdit = '<a href="'.route('users.edit',['id' => $id]).'" id="edit-'.$id.'" class="btn btn-xs btn-primary"><i class="fas fa-pencil-alt"></i></a>'.' ';

        if ($user->deleted_at){
            $buttonRoute = route('users.restore', $id);
            $iconBtn = '<i class="fas fa-redo"></i>';
            $buttonId = 'restore-'.$id;
            $buttClass= 'btn btn-xs btn-default';
        }else {
            $buttonRoute = route('users.destroy',['id' => $id]);
            $iconBtn = '<i class="fas fa-user-minus"></i>';
            $buttonId = 'delete-'.$id;
            $buttClass= 'btn btn-xs btn-danger';
        }

        $buttonDelete = '<a href="'.$buttonRoute.'" id="'.$buttonId.'" class="'.$buttClass.'">'.$iconBtn.'</a>'.' ';

        $buttonForceDelete =  '<a href="'.route('users.destroy',['id' => $id]).'?hard=1'.'" id="forceDelete-'.$id.'" class="btn btn-xs btn-danger"><i class="fas fa-user-slash"></i></a>';
            
        return $buttonEdit.$buttonDelete.$buttonForceDelete;
    }


    public function getUsers(){

        $users = User::select(['id','name','email','created_at','deleted_at'])->orderBy('created_at')->withTrashed()->get();
        $result = DataTables::of($users)
        ->addColumn('action', function ($user) {
           return $this->getUserButtons($user);
        })
        ->editColumn('created_at', function ($user) {
            return $user->created_at->format('d/m/y H:i');
        })
         ->editColumn('deleted_at', function ($user) {
            return $user->deleted_at ? $user->deleted_at->format('d/m/y H:i') : '';
        })
        ->make(true);
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin/editUser',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUsersRequest $request)
    {
        $user = new User();
        $user->password = bcrypt($request->input('email'));

        $user->fill($request->only(['name','role','email']));

        $res = $user->save();
        $message = $res ? 'Utente creato correttamente': 'Problemi a creare l\'utente';
        session()->flash('message',$message);
        return redirect()->route('users.list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin/editUser',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUsersRequest $request, User $user)
    {
        $user->fill($request->only(['name','email','role']));
       
        $res = $user->save();
        $message = $res ? 'Utente modificato con successo': 'Problemi ad aggiornare l\'utente';
        session()->flash('message',$message);
        return redirect()->route('users.list');
    }


    public function restore($id){
        
        $user = User::withTrashed()->findOrFail($id);
        $res =$user->restore();
        return ''.$res;

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $req)
    {

        $user = User::withTrashed()->findOrFail($id);
        // se una colonna è gia stata cancellata soft, non puoi andare a fare $user->forceDelete() con il
        //  type hinting (User $user), perchè quella risorsa non la troverebbe.
        $hard = $req->query('hard','');
        
        $res = $hard ? $user->forceDelete() : $user->delete();
        return ''.$res;
    }
}
