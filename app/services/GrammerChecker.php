<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GrammerChecker
{

    function check($markdownText)
    {
        $response = Http::asForm()->post('https://api.languagetool.org/v2/check', [
            'text' => $markdownText,
            'language' => 'en-US'
        ]);
        // dd($response);
        $data = '';
        if ($response->successful()) {
            $data = $response->json();
        } else {
            return response()->json([
                'message' => 'Grammar check failed'
            ], 400);
        }

        foreach ($data['matches'] as $match) {
            return response()->json(
                [
                    'message' => $match['message'],
                    'shortMessage' => $match['shortMessage'],
                    'suggestions' => array_map(fn($r) => $r['value'], $match['replacements']),
                    'offset' => $match['offset'],
                    'length' => $match['length'],
                    'context' => $match['context']['text'],
                    'ruleDescription' => $match['rule']['description'],
                    'errorType' => $match['type']['typeName'],
                ]
            );
        }

        // return response()->json([
        //     'message' => 'succefully',
        //     'data' => $data,
        // ]);
    }
}
