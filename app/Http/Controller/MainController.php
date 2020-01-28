<?php

namespace App\Http\Controller;

use App\Service\DailyFlowService;

class MainController extends ApiController
{
    protected function ___post()
    {
        $content = $this->getJsonData('content', '');
        if ($content) {
            $item = $this->get(DailyFlowService::class)->createNew([
                'content' => $content,
            ]);
            $item->save();
            return [
                'status' => true,
            ];
        }
        return [
            'status' => false,
        ];
    }

    protected function ___put()
    {
        $id = $this->request->attributes->get('id');
        $content = $this->getJsonData('content', '');
        if ($item = $this->get(DailyFlowService::class)->find($id)) {
            $item->content = $content;
            $item->save();
            return [
                'status' => true,
            ];
        }
        return [
            'status' => false,
        ];
    }

    protected function ___delete()
    {
        $id = $this->request->attributes->get('id');
        if ($item = $this->get(DailyFlowService::class)->find($id)) {
            $item->delete();
        }
        return [
            'status' => true,
        ];
    }

    protected function ___get()
    {
        $page = max(1, intval($this->getQueryParam('page', '1')));
        $items = $this->get(DailyFlowService::class)->paginate(10, ['*'], 'page', $page);
        return [
            'status' => true,
            'meta' => [
                'total' => $items->total(),
                'lastPage' => $items->lastPage(),
                'perPage' => $items->perPage(),
                'currentPage' => $items->currentPage(),
            ],
            'data' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'content' => $item->content,
                ];
            })->all(),
        ];
    }
}
