<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\AuthService;
use App\Http\Controllers\Api\AuthController;
use App\Requests\Auth\LoginRequest;
use App\Constants\ApiConstants;
use App\Constants\AuthConstants;
use App\Exceptions\AuthenticationException as ExceptionsAuthenticationException;
use App\Models\Account;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Exceptions\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $authService;
    protected $authController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        
        // Mock AuthService
        $this->authService = Mockery::mock(AuthService::class);
        
        // Inject mock into controller
        $this->authController = new AuthController($this->authService);
    }

    /** @test */
    public function it_logs_in_a_user_successfully()
    {
        // Fake account data
        $account = Account::factory()->make([
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test Account',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'enabled' => true,
        ]);
        $account->exists = true;

        // Mock LoginRequest
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('all')->andReturn([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Mock authentication response
        $this->authService->shouldReceive('authenticate')
            ->once()
            ->with($request)
            ->andReturn([
              ApiConstants::SUCCESS => true,
              ApiConstants::CODE => 200,
              ApiConstants::DATA => 'fake-token',
              ApiConstants::MESSAGE => $account,
            ]);

        Gate::shouldReceive('authorize')
        ->once()
        ->with('canLogin', $account)
        ->andReturn(true); // Allow authorization

        // Call loginAction
        $response = $this->authController->loginAction($request);
        $responseData = $response->getData(true);

        // Assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey(ApiConstants::MESSAGE, $responseData);
        $this->assertArrayHasKey(ApiConstants::DATA, $responseData);
        $this->assertEquals('fake-token', $responseData[ApiConstants::DATA]);
    }

    /** @test */
    public function it_fails_login_with_incorrect_credentials()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('all')->andReturn([
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Simulate authentication failure
        $this->authService->shouldReceive('authenticate')
            ->once()
            ->with($request)
            ->andThrow(new AuthenticationException(AuthConstants::INVALID_CREDENTIALS));

        $this->expectException(AuthenticationException::class);

        // Call loginAction
        $this->authController->loginAction($request);
    }

    /** @test */
    public function it_fails_login_when_fields_are_missing()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('all')->andReturn([
            'email' => '', // Missing email
            'password' => '',
        ]);

        // Simulate validation failure
        $this->authService->shouldReceive('authenticate')
            ->once()
            ->with($request)
            ->andThrow(ValidationException::withMessages([
              'email' => ['Email is required.'],
              'password' => ['Password is required.'],
          ]));

        $this->expectException(ValidationException::class);

        // Call loginAction
        $this->authController->loginAction($request);
    }

    /** @test */
    public function it_fails_login_if_user_is_disabled()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('all')->andReturn([
            'email' => 'disabled@example.com',
            'password' => 'password',
        ]);

        // Simulate disabled account
        $this->authService->shouldReceive('authenticate')
            ->once()
            ->with($request)
            ->andThrow(new AuthenticationException('This action is unauthorized.'));

        $this->expectException(AuthenticationException::class);

        // Call loginAction
        $this->authController->loginAction($request);
    }

    /** @test */
    public function test_user_can_logout_successfully()
    {
        // Create a real user with Sanctum authentication
        $user = Account::factory()->create();

        // Authenticate the user with Sanctum
        Sanctum::actingAs($user);

        $request = new Request();

        // Call logoutAction
        $response = $this->authController->logoutAction($request);

        // Assertions
        $response->assertStatus(200)
                ->assertJson(['message' => 'Logged out successfully']);

        // Ensure the token is deleted
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => Account::class,
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
