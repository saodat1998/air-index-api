<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\SmsApp;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => env('ADMIN_EMAIL_1', 'test2@test.com'),
                'phone' => env('ADMIN_PHONE_1', '+000000000000'),
                'name' => 'Admin',
                'password' => Hash::make('Password123')
            ],
        ];

        $this->store($users);
    }


    /**
     * Save users in the storage.
     *
     * @param array $users
     * @throws Exception
     */
    protected function store(array $users): void
    {
        foreach ($users as $user) {
            DB::beginTransaction();

            try {
                /** @var User $user */
                $user = User::firstOrCreate([
                    'email' => $user['email']
                ], [
                    'name'     => $user['name'],
                    'phone'    => $user['phone'],
                    'password' =>  $user['password'],
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }

        }
    }
}
