<?php

use Illuminate\Database\Seeder;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Block table roles
	    DB::table('roles')->delete();
        $roles = [
        	['id'=>1, 'code'=>'SUP', 'name'=>'Super Admin', 'label'=>'User with this role will have full access to apllication'],
            ['id'=>2, 'code'=>'AD-DPP', 'name'=>'Administrator DPP', 'label'=>'User with this role has full access to DPP privileges'],
            ['id'=>3, 'code'=>'AD-DPD', 'name'=>'Administrator DPD', 'label'=>'User with this role has full access to DPD privileges'],
            ['id'=>4, 'code'=>'MBR', 'name'=>'Member', 'label'=>'User with this role has full access to Member privileges'],
        ];
        DB::table('roles')->insert($roles);
	    //ENDBlock table roles

        //Block table role_user
	    DB::table('role_user')->delete();
        $role_user = [
            //Super Admin
        	['role_id'=>1, 'user_id'=>1],

            //Administrator DPP
            ['role_id'=>2, 'user_id'=>2],
            ['role_id'=>2, 'user_id'=>3],

            //Administrator DPD
            ['role_id'=>3, 'user_id'=>4],
            ['role_id'=>3, 'user_id'=>5],

            //Member
            ['role_id'=>4, 'user_id'=>6],
            ['role_id'=>4, 'user_id'=>7],
            ['role_id'=>4, 'user_id'=>8],
        ];
        DB::table('role_user')->insert($role_user);
        //ENDBlock table role_user

        //Block table permissions
        DB::table('permissions')->delete();

        $permissions = [
            //Modul DPD
            ['id'=>1, 'slug'=>'index-dpd', 'description'=>'Access index-dpd method'],
            ['id'=>2, 'slug'=>'show-dpd', 'description'=>'Access show-dpd method'],
            ['id'=>3, 'slug'=>'create-dpd', 'description'=>'Access create-dpd method'],
            ['id'=>4, 'slug'=>'edit-dpd', 'description'=>'Access edit-dpd method'],
            ['id'=>5, 'slug'=>'delete-dpd', 'description'=>'Access delete-dpd method'],

            //Modul Proposal
            ['id'=>6, 'slug'=>'index-proposal', 'description'=>'Access index-proposal method'],
            ['id'=>7, 'slug'=>'show-proposal', 'description'=>'Access show-proposal method'],
            ['id'=>8, 'slug'=>'create-proposal', 'description'=>'Access create-proposal method'],
            ['id'=>9, 'slug'=>'edit-proposal', 'description'=>'Access edit-proposal method'],
            ['id'=>10, 'slug'=>'delete-proposal', 'description'=>'Access delete-proposal method'],

            //Modul Member
            ['id'=>11, 'slug'=>'index-member', 'description'=>'Access index-member method'],
            ['id'=>12, 'slug'=>'show-member', 'description'=>'Access show-member method'],
            ['id'=>13, 'slug'=>'create-member', 'description'=>'Access create-member method'],
            ['id'=>14, 'slug'=>'edit-member', 'description'=>'Access edit-member method'],
            ['id'=>15, 'slug'=>'delete-member', 'description'=>'Access delete-member method'],

            //Modul Administrator DPP
            ['id'=>16, 'slug'=>'index-administrator-dpp', 'description'=>'Access index-administrator-dpp method'],
            ['id'=>17, 'slug'=>'show-administrator-dpp', 'description'=>'Access show-administrator-dpp method'],
            ['id'=>18, 'slug'=>'create-administrator-dpp', 'description'=>'Access create-administrator-dpp method'],
            ['id'=>19, 'slug'=>'edit-administrator-dpp', 'description'=>'Access edit-administrator-dpp method'],
            ['id'=>20, 'slug'=>'delete-administrator-dpp', 'description'=>'Access delete-administrator-dpp method'],

            //Modul Administrator DPD
            ['id'=>21, 'slug'=>'index-administrator-dpd', 'description'=>'Access index-administrator-dpd method'],
            ['id'=>22, 'slug'=>'show-administrator-dpd', 'description'=>'Access show-administrator-dpd method'],
            ['id'=>23, 'slug'=>'create-administrator-dpd', 'description'=>'Access create-administrator-dpd method'],
            ['id'=>24, 'slug'=>'edit-administrator-dpd', 'description'=>'Access edit-administrator-dpd method'],
            ['id'=>25, 'slug'=>'delete-administrator-dpd', 'description'=>'Access delete-administrator-dpd method'],
        ];

        DB::table('permissions')->insert($permissions);

        //ENDBlock table permissions

        //Block table permission_role
        DB::table('permission_role')->delete();

        $permission_role = [
            //Permission for ADMINISTRATOR DPP
            ['permission_id'=>1, 'role_id'=>2],
            ['permission_id'=>2, 'role_id'=>2],
            ['permission_id'=>3, 'role_id'=>2],
            ['permission_id'=>4, 'role_id'=>2],
            ['permission_id'=>5, 'role_id'=>2],
            ['permission_id'=>6, 'role_id'=>2],
            ['permission_id'=>7, 'role_id'=>2],
            ['permission_id'=>8, 'role_id'=>2],
            ['permission_id'=>9, 'role_id'=>2],
            ['permission_id'=>10, 'role_id'=>2],
            ['permission_id'=>11, 'role_id'=>2],
            ['permission_id'=>12, 'role_id'=>2],
            ['permission_id'=>13, 'role_id'=>2],
            ['permission_id'=>14, 'role_id'=>2],
            ['permission_id'=>15, 'role_id'=>2],
            ['permission_id'=>21, 'role_id'=>2],
            ['permission_id'=>22, 'role_id'=>2],
            ['permission_id'=>23, 'role_id'=>2],
            ['permission_id'=>24, 'role_id'=>2],
            ['permission_id'=>25, 'role_id'=>2],

            //Permission for ADMINISTRATOR DPD
            ['permission_id'=>6, 'role_id'=>3],
            ['permission_id'=>7, 'role_id'=>3],
            ['permission_id'=>8, 'role_id'=>3],
            ['permission_id'=>9, 'role_id'=>3],
            ['permission_id'=>10, 'role_id'=>3],
            ['permission_id'=>11, 'role_id'=>3],
            ['permission_id'=>12, 'role_id'=>3],
            ['permission_id'=>13, 'role_id'=>3],
            ['permission_id'=>14, 'role_id'=>3],
            ['permission_id'=>15, 'role_id'=>3],
        ];
        DB::table('permission_role')->insert($permission_role);

        //ENDBlock table permission_role
    }
}
