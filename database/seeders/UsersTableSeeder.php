<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Qs;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createNewUsers();
        if (DB::table('users')->count() < 8) {
            $this->createManyUsers(3);
        }
    }

    protected function createNewUsers()
    {
        $defaultPassword = Hash::make('cj'); // Default initial password for newly created demo accounts

        $defaultUsers = [
            [
                'name' => 'CJ Inspired',
                'email' => 'cj@cj.com',
                'username' => 'cj',
                'password' => $defaultPassword,
                'user_type' => 'super_admin',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Admin KORA',
                'email' => 'admin@admin.com',
                'password' => $defaultPassword,
                'user_type' => 'admin',
                'username' => 'admin',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Teacher Chike',
                'email' => 'teacher@teacher.com',
                'user_type' => 'teacher',
                'username' => 'teacher',
                'password' => $defaultPassword,
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Parent Kaba',
                'email' => 'parent@parent.com',
                'user_type' => 'parent',
                'username' => 'parent',
                'password' => $defaultPassword,
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Accountant Jeff',
                'email' => 'accountant@accountant.com',
                'user_type' => 'accountant',
                'username' => 'accountant',
                'password' => $defaultPassword,
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Librarian Sita',
                'email' => 'librarian@librarian.com',
                'user_type' => 'librarian',
                'username' => 'librarian',
                'password' => $defaultPassword,
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($defaultUsers as $user) {
            $exists = DB::table('users')
                ->where('username', $user['username'])
                ->orWhere('email', $user['email'])
                ->exists();

            if (!$exists) {
                DB::table('users')->insert($user);
            }
        }
    }

    protected function createManyUsers(int $count)
    {
        $userTypes = Qs::getAllUserTypes(['super_admin', 'librarian', 'student']);

        for ($i = 1; $i <= $count; $i++) {
            foreach ($userTypes as $ut) {
                $username = $ut . $i;
                $email = $ut . $i . '@' . $ut . '.com';

                $exists = DB::table('users')
                    ->where('username', $username)
                    ->orWhere('email', $email)
                    ->exists();

                if (!$exists) {
                    DB::table('users')->insert([
                        'name' => ucfirst($ut) . ' ' . $i,
                        'email' => $email,
                        'user_type' => $ut,
                        'username' => $username,
                        'password' => Hash::make($ut),
                        'code' => strtoupper(Str::random(10)),
                        'remember_token' => Str::random(10),
                    ]);
                }
            }
        }
    }
}
