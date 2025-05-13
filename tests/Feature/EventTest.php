<?php
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Event;

class EventTest extends TestCase {
    use RefreshDatabase;

    public function test_event_creation() {
        $response = $this->postJson('/api/events', [
            'title' => 'Tech Conference',
            'date' => '2025-06-15',
            'capacity' => 100
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['title' => 'Tech Conference']);
    }
}