<?php

namespace App\Http\Controllers\API;

use App\ExperiencePeriod;
use App\Framework;
use App\Http\Controllers\Controller;
use App\Language;
use App\OtherTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    /**
     * スキル(言語、FW,ツール)取得。
     *
     * @return \Illuminate\Http\Response
     */
    public function getSkills()
    {
        $experiencePeriods = ExperiencePeriod::get();

        $languages = Language::get();
        $frameworks = Framework::get();
        $otherTools = OtherTool::get();

        return response()->json([
            'experiencePeriods' => $experiencePeriods,
            'languages' => $languages,
            'frameworks' => $frameworks,
            'otherTools' => $otherTools,
        ]);
    }
}
