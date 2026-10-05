<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Support\PageViewRecorder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CvController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse
    {
        $profile = Profile::current();
        $cv = $profile->getFirstMedia('cv');

        abort_if($cv === null, 404);

        PageViewRecorder::record($request, path: '/cv');

        return response()->file($cv->getPath(), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="CV-'.Str::slug($profile->display_name, '-').'.pdf"',
        ]);
    }
}
