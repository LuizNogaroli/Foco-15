<?php

namespace App\Http\Controllers;

use App\Models\FocoDraft;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'processo_id' => 'required|exists:processos,id',
            'aba' => 'required|string|max:10',
            'data' => 'required',
        ]);

        FocoDraft::updateOrCreate(
            [
                'processo_id' => $request->processo_id,
                'user_id' => $request->user()->id,
                'aba' => $request->aba,
            ],
            ['data' => $request->data]
        );

        return response()->json(['ok' => true, 'saved_at' => now()->toDateTimeString()]);
    }

    public function load(Request $request)
    {
        $request->validate([
            'processo_id' => 'required|exists:processos,id',
            'aba' => 'required|string|max:10',
        ]);

        $draft = FocoDraft::where('processo_id', $request->processo_id)
            ->where('user_id', $request->user()->id)
            ->where('aba', $request->aba)
            ->first();

        if (!$draft) {
            return response()->json(['data' => null]);
        }

        return response()->json(['data' => $draft->data, 'saved_at' => $draft->updated_at->toDateTimeString()]);
    }

    public function clear(Request $request)
    {
        $request->validate([
            'processo_id' => 'required|exists:processos,id',
            'aba' => 'required|string|max:10',
        ]);

        FocoDraft::where('processo_id', $request->processo_id)
            ->where('user_id', $request->user()->id)
            ->where('aba', $request->aba)
            ->delete();

        return response()->json(['ok' => true]);
    }

    public function cleanOld()
    {
        $limite = now()->subDays(7);
        $deleted = FocoDraft::where('updated_at', '<', $limite)->delete();

        return response()->json(['deleted' => $deleted]);
    }
}
