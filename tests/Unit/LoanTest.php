<?php

use App\Models\User;
use App\Models\Loan;
use App\Models\Role;
use App\Notifications\LoanApprovalRequestNotification;
use App\Notifications\LoanApprovedNotification;
use App\Notifications\LoanDeclinedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can create, edit, approve, view, list, delete and decline a loan request', function () {

    Notification::fake();

    $user = User::factory()->create();
    $attributes = [
        [
        'user_id' => $user->id,
        'loan_amount' => 100000,
        'status' => 'pending',
        'loan_type' => 'days',
        'duration' => 30,
        ],
        [
            'user_id' => $user->id,
            'loan_amount' => 200000,
            'status' => 'pending',
            'loan_type' => 'days',
            'duration' => 20,
        ],
    ];

    foreach($attributes as $attribute){
        $response = $this->actingAs($user)
        ->postJson('/api/v1/loan/create', $attribute);
    }
    

    Notification::send($user, new LoanApprovalRequestNotification($user));
    Notification::assertSentTo($user, LoanApprovalRequestNotification::class);

    $response->assertStatus(200);

    $responseUpdate = $this->actingAs($user)
        ->putJson('/api/v1/loan/update/' . $response['data']['id'], $attribute);

    $responseUpdate->assertStatus(200)->assertJson(['message' =>  __('settings.model_updated', ['model' => 'loan request'])]);

    $new_user = User::factory()->create();
    $role = Role::factory()->create();
    $user_role = $new_user->attachRole($role);
    
    $responseDecline = $this->actingAs($new_user)
        ->postJson('/api/v1/loan/decline', ['id' => 1]);

    Notification::send($user, new LoanDeclinedNotification($user));
    Notification::assertSentTo($user, LoanDeclinedNotification::class);

    $responseDecline->assertStatus(200);

    $responseApprove = $this->actingAs($new_user)
        ->postJson('/api/v1/loan/approve', ['id' => $response['data']['id']]);

    Notification::send($user, new LoanApprovedNotification($user));
    Notification::assertSentTo($user, LoanApprovedNotification::class);

    $responseApprove->assertStatus(200);

    $responseView = $this->actingAs($user)
        ->getJson('/api/v1/loan/view/' . $response['data']['id']);

    $responseView->assertStatus(200);

    $responseList = $this->actingAs($user)
        ->getJson('/api/v1/loan/list');

    $responseList->assertStatus(200);

    $responseDelete = $this->actingAs($user)
        ->deleteJson('/api/v1/loan/delete/1');

    $responseDelete->assertStatus(200);
});
