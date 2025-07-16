<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Warung;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarungSelectionTest extends TestCase
{
    use RefreshDatabase;

 public function test_admin_bypass_warung_selection()
{
    // Buat role Admin jika belum ada
    // Buat role Admin jika belum ada
    if (!\Spatie\Permission\Models\Role::where('name', 'Admin')->exists()) {
        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
    }

    $admin = \App\Models\User::factory()->create();
    $admin->assignRole('Admin');

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Dashboard'); // Sesuaikan dengan isi dashboard kamu
}

    public function test_user_with_one_warung_auto_set_session()
    {
        $user = User::factory()->create();
        Warung::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
        $this->assertNotNull(session('warung_id'));
        $this->assertNotNull(session('nama_warung'));
    }

    public function test_user_with_multiple_warung_redirected_to_select()
    {
        $user = User::factory()->create();
        Warung::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertRedirect('/pilih-warung');
    }

    public function test_invalid_warung_id_should_fail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->post('/pilih-warung', [
            'warung_id' => 999 // id tidak ada
        ]);

        $response->assertSessionHasErrors('warung_id');
    }
}
