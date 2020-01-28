<?php

namespace App\Http\Controller;

use App\Service\DailyFlowService;
use DateTime;

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
        $date = DateTime::createFromFormat('Y-m-d', $this->getQueryParam('date', null));
        if (!$date) {
            $date = new DateTime();
        }
        $date = $date->format('Y-m-d');
        $range = ["$date 00:00:00", "$date 23:59:59"];
        $items = $this->get(DailyFlowService::class)->orderBy('id', 'desc')->whereBetween('created_at', $range)->get();
        return [
            'status' => true,
            'data' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'content' => $item->content,
                ];
            })->all(),
        ];
    }
}
