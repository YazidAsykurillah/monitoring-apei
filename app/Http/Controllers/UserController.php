<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadPhotoRequest;
use App\Http\Requests\ChangePasswordRequest;

use App\User;
use Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');

    }


    public function indexUserDpp()
    {
        return view('user.index_user_dpp');
    }

    public function indexUserDpd()
    {
        return view('user.index_user_dpd');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    public function createUserDpp()
    {
        return view('user.create_user_dpp');
    }

    public function createUserDpd()
    {
        return view('user.create_user_dpd');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        if($request->role_id == 2){
            return $this->storeUserDpp($request);
        }elseif ($request->role_id == 3){
            return $this->storeUserDpd($request);
        }elseif ($request->role_id == 4){
            return $this->storeUserMember($request);
        }

    }

    //Block store user Member
    protected function storeUserMember(Request $request){

        $default_password = \Config::get('monitoring_options.default_password.member');
        

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($default_password);
        $user->id_card = $request->id_card;
        $user->telephone = $request->telephone;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->save();
        $user_id = $user->id;
        //attach role for this user
        $saved_user = User::find($user_id);
        $saved_user->roles()->attach(4);
        //attach dpd for this user
        $saved_user->dpds()->attach($request->dpd_id);
        return redirect('member/'.$user_id)
            ->with('successMessage', "$saved_user->name has been registered");
    }
    //ENDBlock store user Member

    //Block store user DPP
    protected function storeUserDpp(Request $request){
        $default_password = \Config::get('monitoring_options.default_password.admin_dpp');

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($default_password);
        $user->save();
        $user_id = $user->id;
        //attach role for this user
        $saved_user = User::find($user_id);
        $saved_user->roles()->attach(2);
        return redirect('user-dpp')
            ->with('successMessage', "$saved_user->name has been registered");
    }
    //ENDBlock store user DPP

    //Block store user DPD
    protected function storeUserDpd(Request $request){
        $default_password = \Config::get('monitoring_options.default_password.admin_dpd');

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($default_password);
        $user->save();
        $user_id = $user->id;
        //attach role for this user
        $saved_user = User::find($user_id);
        $saved_user->roles()->attach(3);
        //attach dpd for this user
        $saved_user->dpds()->attach($request->dpd_id);
        return redirect('user-dpd')
            ->with('successMessage', "$saved_user->name has been registered");
    }
    //ENDBlock store user DPD

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user_role = $user->roles->first()->code;
        if($user_role == 'AD-DPP'){
            return view('user.show_user_dpp')
            ->with('user', $user);
        }elseif ($user_role == 'AD-DPD') {
            return view('user.show_user_dpd')
            ->with('user', $user);
        }elseif ($user_role == 'MBR') {
            return view('user.show')
            ->with('user', $user);
        }else{
            return "Undefined role";
            exit();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_role = $user->roles->first()->code;
        /*echo $user_role;
        exit();*/
        if($user_role == 'AD-DPP'){
            return view('user.edit_user_dpp')
                ->with('user', $user);
        }elseif($user_role == 'AD-DPD') {
            return view('user.edit_user_dpd')
                ->with('user', $user);
        }
        elseif($user_role == 'MBR') {
            return view('user.edit')
                ->with('user', $user);
        }
        else{
            echo"Undefined role";
            exit();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->id_card = $request->id_card;
        $user->telephone = $request->telephone;
        $user->tempat_lahir = $request->tempat_lahir ? $request->tempat_lahir : NULL;
        $user->tanggal_lahir = $request->tanggal_lahir ? $request->tanggal_lahir : NULL;
        $user->save();
        if($request->role_id == 2){ //update user with role of Administrator DPP
            return redirect('user-dpp')
                ->with('successMessage', " 1 User DPP has been updated");

        }elseif($request->role_id == 3){ //update user with role of Administrator DPD
            //synchronize dpd_user
            $updated_user = User::findOrFail($id);
            $updated_user->dpds()->detach();
            $updated_user->dpds()->attach($request->dpd_id);
            return redirect('user-dpd')
                ->with('successMessage', " 1 User DPD has been updated");

        }elseif($request->role_id == 4){   //update user with role of Member
            $updated_user = User::findOrFail($id);
            $updated_user->dpds()->detach();
            $updated_user->dpds()->attach($request->dpd_id);
            return redirect('member')
                ->with('successMessage', " 1 member has been updated");
        }
        else{
            return "Undefined role";
            exit();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user_role = $user->roles->first()->code;

        $user->delete();
        //detach all user's roles
        $user->roles()->detach();
        //detach all user's dpds
        $user->dpds()->detach();
        if($user_role == 'AD-DPP'){
            return redirect('user-dpp')
            ->with('successMessage', '1 DPP Administrator has been deleted');
        }
        else if($user_role == 'AD-DPD'){
            return redirect('user-dpd')
            ->with('successMessage', '1 DPD Administrator has been deleted');
        }
        else{
            return redirect('user')
            ->with('successMessage', '1 Member has been deleted');
        }
        
    }


    protected $photo_to_insert = NULL;
    protected $photo_to_delete = NULL;

    public function uploadphoto(UploadPhotoRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        if($request->hasFile('photo')){
            //if there is an uploaded photo, fire the upload process,set the new photo
            // and collect this photo (to be deleted from the server).
            $this->upload_process($request);
            $this->photo_to_delete = $user->photo;
        }
        else{
            //no file uploaded, it means the photo stays still
            $this->photo_to_insert = $user->file;
        }
        $user->photo = $this->photo_to_insert;
        $user->save();
        //delete old user photo
        \File::delete(public_path().'/files/photo/'.$this->photo_to_delete);
        return redirect()->back()
            ->with('successMessage', "Photo has been uploaded");
    }

    //File upload handling process
    protected function upload_process(Request $request){
        
        $upload_directory = public_path().'/files/photo/';
        $extension = $request->file('photo')->getClientOriginalExtension();
        $photo_to_insert = time().'.'.$extension;
        $this->photo_to_insert = $photo_to_insert;
        $save_image = \Image::make($request->photo)->save($upload_directory.$photo_to_insert);
        //make the thumbnail
        $thumbnail = \Image::make($request->photo)->resize(171,180)->save($upload_directory.'thumb_'.$this->photo_to_insert);
        //free the memory
        $save_image->destroy();
    }

    //delete photo
    public function deletephoto(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $this->photo_to_delete = $user->photo;
        $user->photo = NULL;
        $user->save();
        //delete photo and it's thumbnail from the server
        \File::delete(public_path().'/files/photo/'.$this->photo_to_delete);
        \File::delete(public_path().'/files/photo/thumb_'.$this->photo_to_delete);
        return redirect()->back()
            ->with('successMessage', 'Photo has been deleted');
    }


    public function chagePassword(ChangePasswordRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        if($request->has('default_password')){
            //reset user password to default -> "manchesterunited"
            $user->password = bcrypt('manchesterunited');
            $user->save();
            return redirect()->back()
                ->with('successMessage', "Password has been resetted to default");
        }
        else{
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->back()
                ->with('successMessage', "Password has been changed");
       }
    }


    //import excel
    public function getImport()
    {
        return view('user.import');
    }

    public function postImport(Request $request)
    {
        $default_password = \Config::get('monitoring_options.default_password.member');
        $imported_data = 0;
        if($request->hasFile('file') && $request->dpd_id!=""){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $check_for_member_duplication = $this->check_for_member_duplication($value->id_card, $value->email);
                    if($check_for_member_duplication == FALSE){
                        $user = new User;
                        $user->name = $value->name;
                        $user->email = $value->email;
                        $user->password = bcrypt($default_password);
                        $user->id_card = $value->id_card;
                        $user->telephone = $value->telephone;
                        $user->tempat_lahir = $value->tempat_lahir;
                        $user->tanggal_lahir = $value->tanggal_lahir;
                        $user->save();
                        $user_id = $user->id;
                        //attach role for this user
                        $saved_user = User::find($user_id);
                        $saved_user->roles()->attach(4);
                        //attach dpd for this user
                        $saved_user->dpds()->attach($request->dpd_id);
                        $imported_data +=1;   
                    }
                    
                }

                
            }
            return back()->with('successMessage', "$imported_data has been imported");
            
        }
        else{
            return redirect()->back()
            ->withInput()
            ->with('errorMessage', "Please select the DPD and upload the file");
        }
    }

    protected function check_for_member_duplication($id_card = NULL, $email = NULL)
    {
        if($id_card != NULL)
        {
            $user = User::where('id_card', '=', $id_card)->orWhere('email', '=', $email)->get();

            if($user ->count()){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }else{
            return TRUE;    
        }
        
    }
}
