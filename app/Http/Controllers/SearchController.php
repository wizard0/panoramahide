<?php

namespace App\Http\Controllers;

use App\Models\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SearchController extends Controller
{
    const COOKIE = 'search_params';

    public function __invoke(Request $request)
    {
        $extend = $request->get('extend');
        $params = $request->all();

        if (!isset($params['type'])) {
            $params['type'] = 'any';
        }

        $searchDBResult = UserSearch::search($params);
        $search = $searchDBResult->paginate(10);
        $rowCount = $search->total();

        foreach ($search as $s) {
            if ($s->found && $s->found != '') {
                $found = $this->getFoundString($request->get('q'), $s->found);
                if ($found) {
                    $s->found = $found[0];
                    $s->{'length'} = is_iterable($found) ? count($found) : 0;
                }
            }
        }

        return view('search.index', compact('search', 'extend', 'rowCount', 'params'));
    }

    /**
     * @param string $seek
     * @param string $found
     *
     * @return string|null|array sentences from article where query word (q) was found
     */
    private function getFoundString($seek, $found)
    {
        $seek = strtolower($seek);
        preg_match_all("/[a-z ]*{$seek}[a-z ]*\./i", $found, $matches);
        return $matches[0];
    }

    public function saveSearch(Request $request)
    {
        $userSearch = UserSearch::create([
            'user_id' => Auth::id(),
            'search_params' => json_encode($request->get('data'))
        ]);

        return json_encode(['success' => true, 'ID' => $userSearch->id]);
    }

    public function deleteSearch(Request $request)
    {
        $id = $request->get('id');

        $ids = [];
        if ($id == 'all') {
            Auth::user()->searches()->each(function ($item, $key) {
                $item->delete();
                $ids[] = $item->id;
            });
            Cookie::forget('search_params');
        } else {
            UserSearch::where('id', $id)->delete();
            $ids[] = $id;
        }

        return json_encode(['success' => true, 'ids' => $ids]);
    }
}
