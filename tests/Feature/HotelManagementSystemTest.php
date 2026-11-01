<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelManagementSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login view loads successfully.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login Form');
        $response->assertSee('Lyheng@gmail.com');
    }

    /**
     * Test register view loads successfully.
     */
    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register Form');
        $response->assertSee('please input your name');
    }

    /**
     * Test user can authenticate and access dashboard.
     */
    public function test_user_can_login_and_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // standard UserFactory password
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));

        $dashResponse = $this->actingAs($user)->get(route('dashboard'));
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Angkor Hotel');
    }

    /**
     * Test Room Types CRUD and relationships.
     */
    public function test_room_types_crud_and_relational_link(): void
    {
        $user = User::factory()->create();

        // 1. Create Room Type
        $categoryData = [
            'type_name' => 'Royal Presidential Penthouse',
            'manager_id' => 'MGR-999 (David King)',
            'location_id' => 'Sky Tower 77',
            'base_price' => 750.00,
            'capacity' => 6,
            'description' => 'Flagship private penthouse with panoramic views.',
        ];

        $response = $this->actingAs($user)->post(route('room-types.store'), $categoryData);
        $response->assertRedirect(route('room-types.index'));
        $this->assertDatabaseHas('room_types', ['type_name' => 'Royal Presidential Penthouse']);

        $roomType = RoomType::where('type_name', 'Royal Presidential Penthouse')->first();
        $this->assertNotNull($roomType);

        // 2. Index listing
        $listResponse = $this->actingAs($user)->get(route('room-types.index'));
        $listResponse->assertStatus(200);
        $listResponse->assertSee('Royal Presidential Penthouse');

        // 3. Update
        $updateResponse = $this->actingAs($user)->put(route('room-types.update', $roomType->type_id), array_merge($categoryData, [
            'type_name' => 'Royal Penthouse Updated',
            'base_price' => 850.00,
        ]));
        $updateResponse->assertRedirect(route('room-types.index'));
        $this->assertDatabaseHas('room_types', ['type_name' => 'Royal Penthouse Updated']);
    }

    /**
     * Test Rooms CRUD with search, filters and foreign key relation.
     */
    public function test_rooms_crud_and_filtering(): void
    {
        $user = User::factory()->create();

        $type = RoomType::firstOrCreate([
            'type_name' => 'Deluxe Suite Test',
        ], [
            'base_price' => 200.00,
            'capacity' => 2,
        ]);

        // 1. Create Room
        $roomData = [
            'room_number' => 'TEST-901',
            'type_id' => $type->type_id,
            'floor' => 'Floor 9',
            'status' => 'Available',
            'price_per_night' => 210.00,
            'bed_type' => '1 King Bed',
            'description' => 'Luxury suite with sunset view',
        ];

        $createResponse = $this->actingAs($user)->post(route('rooms.store'), $roomData);
        $createResponse->assertRedirect(route('rooms.index'));
        $this->assertDatabaseHas('rooms', ['room_number' => 'TEST-901', 'type_id' => $type->type_id]);

        $room = Room::where('room_number', 'TEST-901')->first();
        $this->assertEquals($type->type_name, $room->roomType->type_name);

        // 2. Search & Filter test
        $searchResponse = $this->actingAs($user)->get(route('rooms.index', ['search' => 'TEST-901']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('TEST-901');

        $filterResponse = $this->actingAs($user)->get(route('rooms.index', ['type_id' => $type->type_id]));
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('TEST-901');

        // 3. Delete Room
        $deleteResponse = $this->actingAs($user)->delete(route('rooms.destroy', $room->room_id));
        $deleteResponse->assertRedirect(route('rooms.index'));
        $this->assertDatabaseMissing('rooms', ['room_id' => $room->room_id]);
    }

    /**
     * Test admin can view, add, edit, and remove staff users.
     */
    public function test_admin_can_add_and_remove_users(): void
    {
        $admin = User::factory()->create();

        // 1. View Users Index
        $indexResponse = $this->actingAs($admin)->get(route('users.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Staff & User Management', false);

        // 2. Add New User
        $userData = [
            'name' => 'Receptionist Sophea',
            'email' => 'sophea@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $storeResponse = $this->actingAs($admin)->post(route('users.store'), $userData);
        $storeResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'sophea@gmail.com', 'name' => 'Receptionist Sophea']);

        $newUser = User::where('email', 'sophea@gmail.com')->first();
        $this->assertNotNull($newUser);

        // 3. Edit User
        $updateResponse = $this->actingAs($admin)->put(route('users.update', $newUser->id), [
            'name' => 'Receptionist Sophea Updated',
            'email' => 'sophea.updated@gmail.com',
        ]);
        $updateResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'sophea.updated@gmail.com']);

        // 4. Remove User
        $deleteResponse = $this->actingAs($admin)->delete(route('users.destroy', $newUser->id));
        $deleteResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $newUser->id]);

        // 5. Cannot delete self
        $selfDeleteResponse = $this->actingAs($admin)->delete(route('users.destroy', $admin->id));
        $selfDeleteResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
