<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// We update any users that have role 5 (patient) but have a branch (pharmacy ID)
// Wait, branch is also used for doctors and staff, but patients usually don't have branch set unless it's a mistake.
// Pharmacy explicitly has branch = pharmacy_id. Staff has branch = branch_id.
// It's safer to just update the specific user or all users where role = 5 and email domain is pharmacy or something.
// Actually, let's just update the most recently created user if it has role 5.
$user = \App\Models\User::orderBy('id', 'desc')->first();
if ($user && $user->role == 5 && $user->branch) {
    $user->role = 6;
    $user->save();
    echo "Fixed latest user role to 6!";
} else {
    echo "No fix needed or latest user is not role 5.";
}
