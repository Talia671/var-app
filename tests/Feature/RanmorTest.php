<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ranmor\RanmorDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RanmorTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_access_ranmor_index()
    {
        $user = User::factory()->create(['role' => 'petugas']);
        $response = $this->actingAs($user)->get(route('petugas.ranmor.index'));
        $response->assertStatus(200);
    }

    public function test_petugas_can_create_ranmor_draft()
    {
        $user = User::factory()->create(['role' => 'petugas']);
        
        $data = [
            'zona' => 'zona1',
            'no_pol' => 'KT-1234-AB',
            'no_lambung' => 'LB-01',
            'tanggal_periksa' => now()->format('Y-m-d'),
            'pengemudi' => 'Test Driver',
            'npk' => '12345',
            'uraian' => ['Temuan 1', 'Temuan 2']
        ];

        $response = $this->actingAs($user)->post(route('petugas.ranmor.store'), $data);
        
        $response->assertRedirect(route('petugas.ranmor.index'));
        $this->assertDatabaseHas('ranmor_documents', [
            'no_pol' => 'KT-1234-AB',
            'workflow_status' => 'draft'
        ]);
        $this->assertDatabaseHas('ranmor_findings', ['uraian' => 'Temuan 1']);
    }

    public function test_petugas_can_submit_ranmor()
    {
        $user = User::factory()->create(['role' => 'petugas']);
        $document = RanmorDocument::create([
            'zona' => 'zona1',
            'no_pol' => 'KT-1234-AB',
            'no_lambung' => 'LB-01',
            'tanggal_periksa' => now(),
            'pengemudi' => 'Test Driver',
            'npk' => '12345',
            'workflow_status' => 'draft',
            'created_by' => $user->id
        ]);

        $response = $this->actingAs($user)->post(route('petugas.ranmor.submit', $document->id));
        
        $response->assertRedirect(route('petugas.ranmor.show', $document->id));
        $this->assertEquals('submitted', $document->fresh()->workflow_status);
    }

    public function test_admin_can_approve_ranmor()
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $admin = User::factory()->create(['role' => 'admin']);
        
        $document = RanmorDocument::create([
            'zona' => 'zona1',
            'no_pol' => 'KT-1234-AB',
            'no_lambung' => 'LB-01',
            'tanggal_periksa' => now(),
            'pengemudi' => 'Test Driver',
            'npk' => '12345',
            'workflow_status' => 'submitted',
            'created_by' => $petugas->id
        ]);

        $response = $this->actingAs($admin)->post(route('admin.ranmor.approve', $document->id));
        
        $this->assertEquals('approved', $document->fresh()->workflow_status);
        $this->assertNotNull($document->fresh()->approved_at);
    }

    public function test_admin_can_access_ranmor_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('admin.ranmor.index'));
        $response->assertStatus(200);
    }

    public function test_viewer_can_access_ranmor_index()
    {
        $viewer = User::factory()->create(['role' => 'viewer']);
        $response = $this->actingAs($viewer)->get(route('viewer.ranmor.index'));
        $response->assertStatus(200);
    }
}
