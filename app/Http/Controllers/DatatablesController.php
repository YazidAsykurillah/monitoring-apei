<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

use App\User;
use App\Role;
use App\Permission;
use App\Dpd;
use App\Proposal;

class DatatablesController extends Controller
{

    //User DPP
    public function getUserDpps(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        $users = User::with(['roles'])
            ->whereHas('roles', function($query) use($request){
                $query->where('id','=',2);
            })
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);
        $logged_in_user = \Auth::user()->roles->first()->id;
        
        $data_users = Datatables::of($users)
            ->addColumn('actions', function($users){
                    $actions_html ='<a href="'.url('user/'.$users->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('user/'.$users->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this user">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-user" data-id="'.$users->id.'" data-text="'.$users->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_users->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_users->make(true);
    }
    //END User DPP

    //User DPD
    public function getUserDpds(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        $users = User::with(['roles', 'dpds'])
            ->whereHas('roles', function($query) use($request){
                $query->where('id','=',3);
            })
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);

        $data_users = Datatables::of($users)
            ->addColumn('dpd_name', function($users){
                if($users->dpds->count()){
                    return $users->dpds->first()->name;    
                }else{
                    return NULL;
                }
                
            })
            ->addColumn('actions', function($users){
                    $actions_html ='<a href="'.url('user/'.$users->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('user/'.$users->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this user">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-user" data-id="'.$users->id.'" data-text="'.$users->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_users->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_users->make(true);
    }
    //END User DPD

    //DPD datatables
    public function getDpds(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $dpds = Dpd::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'dpds.*',
        ]);

        $data_dpds = Datatables::of($dpds)
            //->orderColumn('code', '-code $1')
            ->addColumn('actions', function($dpds){
                    $actions_html ='<a href="'.url('dpd/'.$dpds->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('dpd/'.$dpds->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this dpd">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-dpd" data-id="'.$dpds->id.'" data-text="'.$dpds->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_dpds->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_dpds->make(true);
    }
    //END DPD datatables



    //Member Datatable
    public function getMembers(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        
        $logged_in_user = \Auth::user()->roles->first()->id;
        
        if( $logged_in_user == 1){   //logged_in_user is SUPER ADMIN
            $users = User::with(['roles', 'dpds'])
            ->whereHas('roles', function($query) use($request){
                $query->where('id','=',4);
            })
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);
        }
        elseif($logged_in_user == 2){    //logged_in_user is ADMIN DPP
            $users = User::with(['roles', 'dpds'])
            ->whereHas('roles', function($query) use($request){
                $query->where('id','=',4);
            })
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);
        }
        elseif($logged_in_user == 3){    //logged_in_user is ADMIN DPD
            //get the dpd_id of the logged in user
            $dpd_id = \Auth::user()->dpds->first()->id;

            $users = User::with(['roles', 'dpds'])
            ->whereHas('roles', function($query) use($request){
                $query->where('id','=',4);
            })
            ->whereHas('dpds', function($query) use($dpd_id){
                $query->where('id','=',$dpd_id);
            })
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*'
            ]);
        }
        else{

        }
        

        $data_users = Datatables::of($users)
            ->addColumn('dpd_name', function($users){
               return $users->dpds->first()->name;
            })
            ->addColumn('actions', function($users){
                    $actions_html ='<a href="'.url('member/'.$users->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('member/'.$users->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this user">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-user" data-id="'.$users->id.'" data-text="'.$users->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_users->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_users->make(true);
    }
    //END Member Datatable


    //Proposal
    public function getProposals(Request $request)
    {

        \DB::statement(\DB::raw('set @rownum=0'));
        $logged_in_user = \Auth::user()->roles->first()->code;

        //Super Admin or Administrator DPP
        if($logged_in_user == 'SUP' || $logged_in_user == 'AD-DPP'){
            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ]);
        }
        //Administrator DPD
        elseif($logged_in_user == 'AD-DPD'){
            //the dpd_id where the logged in user is
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            });
        }
        //Member
        elseif($logged_in_user == 'MBR'){
            //the dpd_id where the logged in user is
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->where('user_id', '=', $dpd_id);
        }
        
        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;    
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;    
                }else{
                    return NULL;
                }
                
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
            ->editColumn('status', function($proposals){
                return proposal_status_display($proposals->status);
            })
            ->addColumn('actions', function($proposals){
                    $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if(\Auth::user()->can('edit-proposal')){
                        $actions_html .='<a href="'.url('proposal/'.$proposals->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this proposal">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    if(\Auth::user()->can('delete-proposal')){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-proposal" data-id="'.$proposals->id.'" data-text="'.$proposals->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //END Proposal

    

    //Datatables Proposal_1
    //# proposal dengan status BERKAS LENGKAP
    public function getProposals_1(Request $request)
    {

        $user = \Auth::user();

        \DB::statement(\DB::raw('set @rownum=0'));

        $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])
            ->where('status', '=','1');
        //if logged in user is Administrator DPD, displsay only related proposal based on dpd_id
        if($user->roles->first()->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            })
            ->where('status', '=', '1');
        }
        
        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
            ->addColumn('actions', function($proposals){
                    $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if(\Auth::user()->can('edit-proposal')){
                        $actions_html .='<a href="'.url('proposal/'.$proposals->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this proposal">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    if(\Auth::user()->can('delete-proposal')){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-proposal" data-id="'.$proposals->id.'" data-text="'.$proposals->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //ENDDatatables Proposal_1


    //Datatables Proposal_2
    //# proposal dengan status Berkas TIDAK Lengkap
    public function getProposals_2(Request $request)
    {
        $logged_in_user = \Auth::user();

        \DB::statement(\DB::raw('set @rownum=0'));

        $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])
            ->where('status', '=','2');
        
        //if logged in user is Administrator DPD, displsay only related proposal based on dpd_id
        if($logged_in_user->roles->first()->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            })
            ->where('status', '=', '9');
        }

        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
            ->addColumn('actions', function($proposals){
                    $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if(\Auth::user()->can('edit-proposal')){
                        $actions_html .='<a href="'.url('proposal/'.$proposals->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this proposal">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    if(\Auth::user()->can('delete-proposal')){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-proposal" data-id="'.$proposals->id.'" data-text="'.$proposals->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //ENDDatatables Proposal_2
    
    //Datatables Proposal_3
    //# proposal dengan status Proses Online DJK
    public function getProposals_3(Request $request)
    {

        $logged_in_user = \Auth::user();

        \DB::statement(\DB::raw('set @rownum=0'));

        $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])
            ->where('status', '=','3');
        
        //if logged in user is Administrator DPD, displsay only related proposal based on dpd_id
        if($logged_in_user->roles->first()->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            })
            ->where('status', '=', '3');
        }
        
        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
            ->addColumn('actions', function($proposals){
                    $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('proposal/'.$proposals->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this proposal">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-proposal" data-id="'.$proposals->id.'" data-text="'.$proposals->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //ENDDatatables Proposal_3

    //Datatables Proposal_9
    //# proposal dengan status Sertifikat Sudah Terkirim
    public function getProposals_9(Request $request)
    {
        $logged_in_user = \Auth::user();

        \DB::statement(\DB::raw('set @rownum=0'));

        $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])
            ->where('status', '=','9');
        
        //if logged in user is Administrator DPD, displsay only related proposal based on dpd_id
        if($logged_in_user->roles->first()->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            })
            ->where('status', '=', '9');
        }
        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
            ->addColumn('actions', function($proposals){
                $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link"></i>';
                $actions_html .='</a>&nbsp;';
                return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //ENDDatatables Proposal_9

    //Datatables Proposal_on_process
    //# proposal dengan status SELAIN Berkas Lengkap, Berkas tidak lengkap, dan Sertifikat Sudah Dikirim
    public function getProposals_on_process(Request $request)
    {

        $logged_in_user = \Auth::user();

        \DB::statement(\DB::raw('set @rownum=0'));

        $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])
            ->whereNotIn('status',['0','1', '2', '9']);
        
        //if logged in user is Administrator DPD, displsay only related proposal based on dpd_id
        if($logged_in_user->roles->first()->code == 'AD-DPD'){
            $dpd_id = \Auth::user()->dpds->first()->id;

            $proposals = Proposal::with(['user', 'user.dpds'])
            ->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'proposals.*'
            ])->whereHas('user.dpds', function($query) use($dpd_id){
                return $query->where('id', '=', $dpd_id);
            })
            ->whereNotIn('status',['0','1', '2', '9']);
        }
        
        $data_proposals = Datatables::of($proposals)
            ->addColumn('dpd', function($proposals){
                if($proposals->user){
                    return $proposals->user->dpds->first()->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('user', function($proposals){
                if($proposals->user){
                    return $proposals->user->name;
                }
                else{
                    return NULL;
                }
            })
            ->editColumn('type', function($proposals){
                return proposal_type_display($proposals->type);
            })
             ->editColumn('status', function($proposals){
                return proposal_status_display($proposals->status);
            })
            ->addColumn('actions', function($proposals){
                    $actions_html ='<a href="'.url('proposal/'.$proposals->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if(\Auth::user()->can('edit-proposal')){
                        $actions_html .='<a href="'.url('proposal/'.$proposals->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this proposal">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    if(\Auth::user()->can('delete-proposal')){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-proposal" data-id="'.$proposals->id.'" data-text="'.$proposals->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_proposals->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_proposals->make(true);
    }
    //ENDDatatables Proposal_on_process

    //Datatables roles data
    public function getRoles(Request $request){

        \DB::statement(\DB::raw('set @rownum=0'));
        $roles = Role::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
        ])->where('name','!=', 'Super Admin');
        $datatables = Datatables::of($roles)

            ->addColumn('actions', function($roles){
                    $actions_html ='<a href="'.url('configuration/role/'.$roles->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }
    //ENDDatatables roles data

    //Permission datatables
    public function getPermissions(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $permissions = Permission::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'permissions.*'
        ]);
        $data_permissions = Datatables::of($permissions)
            ->addColumn('actions', function($permissions){
                    $actions_html ='<a href="'.url('configuration/permission/'.$permissions->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('configuration/permission/'.$permissions->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this permission">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_permissions->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_permissions->make(true);
    }
    //END Permission datatables
    
}
