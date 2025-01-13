<?php

namespace App\Http\Controllers;

use App\Traits\ZoomTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ZoomController extends Controller
{
    use ZoomTrait;

    public function redirectToZoom()
    {
        Session::put('zoom_rediret_after_callback_url', url()->previous());
        return redirect()->away($this->authorizeZoom());
    }

    public function handleZoomCallback(Request $request)
    {
        $code = $request->query('code');
        $response = $this->handleCallback($code);
        
        if ($response) {
            return redirect(session('zoom_rediret_after_callback_url'))->with('success', 'Zoom authorized successfully!');
        }
        
        return redirect(session('zoom_rediret_after_callback_url'))->with('error', 'Fail to connect with zoom!');
    }
}
