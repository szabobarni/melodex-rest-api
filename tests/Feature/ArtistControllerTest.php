<?php

namespace Tests\Feature;

 
use App\Models\Artist;
use App\Models\User;  // azokhoz a végpontok, amelyeknél felhasználó hitelesítés kell
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    /*public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
    public function test_index_returns_all_artists()
    {
        Artist::factory()->create(['name' => 'Taylor Swift','nationality' => 'American','is_band' => 'no']);
        Artist::factory()->create(['name' => 'Frank Ocean','nationality' => 'American','is_band' => 'no']);

        $response = $this->getJson('/api/artist');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Taylor Swift','nationality' => 'American','is_band' => 'no'])
            ->assertJsonFragment(['name' => 'Frank Ocean','nationality' => 'American','is_band' => 'no']);
    } 
    public function test_store_creates_new_artist()
    {
		$user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/artist', [
            'name' => 'Lady Gaga',
            'nationality' => 'American',
            'image' => 'nemnemnemasd',
            'description' => '1111111sfdsfsdfa',
            'is_band' => 'no'
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Lady Gaga','nationality' => 'American','image' => 'nemnemnemasd','description' => '1111111sfdsfsdfa','is_band' => 'no']);
		
        $this->assertDatabaseHas('artists', ['name' => 'Lady Gaga','nationality' => 'American','image' => 'nemnemnemasd','description' => '1111111sfdsfsdfa','is_band' => 'no']);
    }
    public function test_update_modifies_existing_artist()
    {
        $artist = Artist::factory()->create(['name' => 'Bad Bunny','nationality' => 'Puerorican','is_band' => 'no']);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/artist/{$artist->id}", [
            'name' => 'Lajos','nationality' => 'Hungarian','is_band' => 'no'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Lajos','nationality' => 'Hungarian','is_band' => 'no']);

        $this->assertDatabaseHas('artists', ['id' => $artist->id, 'name' => 'Lajos','nationality' => 'Hungarian','is_band' => 'no']);
    }
    public function test_update_returns_404_for_missing_artist()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->patchJson('/api/artist/999', [
            'name' => 'Mollas'
        ]);

        $response->assertStatus(404)->assertJsonFragment(['message' => "Artist (999) not found!"]);
    }
    public function test_delete_removes_artist()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $artist = Artist::factory()->create(['name' => 'Taylor Swift','nationality' => 'American','is_band' => 'no']);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->deleteJson("/api/artist/{$artist->id}");

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Artist deleted successfully']);

        $this->assertDatabaseMissing('artists', ['id' => $artist->id]);
    } 
}
