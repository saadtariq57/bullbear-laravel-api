<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

echo "Recent posts with engagement summary (last 12)\n";
echo str_repeat('=', 60) . "\n";

$posts = \App\Models\Post::with(['user:id,name,type','reactions','comments'])
    ->where('active', 1)
    ->orderByDesc('created_at')
    ->limit(12)
    ->get();

foreach ($posts as $p) {
    $age = \Carbon\Carbon::now()->diffInMinutes($p->created_at);
    $isReal = ($p->user && $p->user->type !== 'bot');
    echo 'ID:' . $p->id
        . ' | Age:' . $age . 'm'
        . ' | User:' . ($p->user ? $p->user->name : '-')
        . ' | Type:' . ($isReal ? 'real' : 'bot')
        . ' | React:' . $p->reactions->count()
        . ' | Comm:' . $p->comments->count()
        . "\n";
}

echo "\nSimulating API selection with multiple bots (x10)\n";
echo str_repeat('=', 60) . "\n";

$controller = new \App\Http\Controllers\AutomationController();
$botIds = [800,801,802,803,804,805,806,807,808,809];
$realPicked = 0; $total = 0;

foreach ($botIds as $botId) {
    $request = new \Illuminate\Http\Request();
    $request->merge(['bot_user_id' => $botId]);
    $response = $controller->getRandomPostWeighted($request);
    $data = json_decode($response->getContent(), true);
    if ($data && !empty($data['success'])) {
        $postId = $data['data']['post']['id'] ?? null;
        $isReal = $data['data']['is_real_user'] ?? false;
        $window = $data['data']['window'] ?? 'unknown';
        $age = $data['data']['post_age_minutes'] ?? null;
        echo 'Bot ' . $botId . ' -> Post ' . $postId . ' (' . ($isReal ? 'Real' : 'Bot') . ', ' . $window . ', age ' . $age . "m)\n";
        $realPicked += $isReal ? 1 : 0;
        $total++;
    } else {
        echo 'Bot ' . $botId . ' -> ERROR: ' . ($data['error'] ?? 'Unknown') . "\n";
    }
}

echo "\nReal-user selection rate: " . ($total ? number_format(($realPicked/$total)*100, 1) : '0.0') . "% (".$realPicked."/".$total.")\n";
echo "Done.\n";


