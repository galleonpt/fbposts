<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Users')->insert([
            'id' => '1',
            'username' => 'admin',
            'password' => '$2y$10$QYHK2zCUx.ll26Zo2CrT.uCzehvo5702vghmuKpEjSePGniBWimiq',
            'FbAccessToken' => 'YXtAjrXugxVsdW7wpp7krbpB3Aurcw9aBGIW0I1n30+yAD73afqU8ITbwVYCYns4rBtE4WZUnJ3ROvQDWz4+zzl/LqaPpEQqGU9BWLm+hLiycYIu9STZGWyDPoSnk6+HuRyfA+ZFHHnd0g0mTckpWOJMuEz/8MeYsDdL41Va5tZGJdO91asl4OYZhrdhWMYatoKL9gYpBNv07DdbcdU79KjQ6arsZU59iAgnd4N96edfiN6fUA==',
            'FbUserID' => 'FQox/+Lt/V4nA2qu0uyS'
        ]);

        DB::table('Pages')->insert([
            'id' => '1',
            'FbID' => 'FQo0+efv+18uAmag1eeY',
            'name' => 'Desafio',
            'FbAccessToken' => 'YXtAjrXugxVsdW7wpp7kqeA00yTcejFyChl/yZtoyBLXHjj3YvGOhvvH0V0jX0ZSkRRt32JvnKrWZtI4aS8MvCZVMsStlnEyDhZIP8OlnPqTZYY0mgOzIk7HN7H2k+6j7T+sDNhMGWTIsilnTKtWWLx4mHqonpWXsBQrv0pM/81VNfCK0NQl5/tRmNV9deYHz/S2ympfE+7/1DcyeZI864nW2qHwQwlNrUcrTt9j0vItvoe5Bxbwrr6qQEm4js8sx1iVFB4M',
            'userID' => '1'

        ]);
    }
}
