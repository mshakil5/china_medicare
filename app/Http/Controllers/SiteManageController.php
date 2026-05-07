<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SiteManageController extends Controller
{
    private $secretKey = 'gdioFgt8fAdkCMj64R0VcCUpbaWamQBC';

    public function handle(Request $request, $secret)
    {

        if ($secret !== $this->secretKey) {
            abort(404);
        }

        $action = $request->query('action', 'lock');

        if ($action === 'lock') {
            return $this->lockSite();
        } elseif ($action === 'unlock') {
            return $this->unlockSite();
        }

        return response()->json(['status' => 'invalid action']);
    }

    private function lockSite()
    {
        $this->setEnvValue('SITE_LOCKED', 'true');

        return response()->json([
            'status'  => 'locked',
            'message' => 'Site has been locked successfully.'
        ]);
    }

    private function unlockSite()
    {
        $this->setEnvValue('SITE_LOCKED', 'false');

        return response()->json([
            'status'  => 'unlocked',
            'message' => 'Site is live again!'
        ]);
    }

    private function setEnvValue($key, $value)
    {
        $path = base_path('.env');
        $content = File::get($path);

        if (str_contains($content, "$key=")) {
            $content = preg_replace("/^$key=.*/m", "$key=$value", $content);
        } else {
            $content .= "\n$key=$value";
        }

        File::put($path, $content);
    }
}