<?php

use Illuminate\Database\Seeder;
use App\Models\User;
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
                'email' => 'test1@test.com',
                'phone' => '+000000000000',
                'first_name' => 'User1',
                'last_name' => '',
                'password' => Hash::make('Password123')
            ],
            [
                'email' => 'test2@test.com',
                'phone' => '+000000000000',
                'first_name' => 'User2',
                'last_name' => '',
                'password' => Hash::make('Password123')
            ],
            [
                'email' => 'test3@test.com',
                'phone' => '+000000000000',
                'first_name' => 'User3',
                'last_name' => '',
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
                    'first_name'     => $user['first_name'],
                    'last_name'     => $user['last_name'],
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
