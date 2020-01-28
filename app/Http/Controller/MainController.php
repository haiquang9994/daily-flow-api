<?php

namespace App\Http\Controller;

use App\Lib\TimeZone\TimeZone;
use App\Service\DailyFlowService;
use DateTime;

class MainController extends ApiController
{
    /** Action */
    public function login()
    {
        $secret = $this->getJsonData('secret', '');
        return $this->json([
            'status' => $secret === md5(env('SECRET_TOKEN')),
        ]);
    }

    protected function ___post()
    {
        $content = $this->getJsonData('content', '');
        if ($content) {
            $item = $this->get(DailyFlowService::class)->createNew([
                'content' => $content,
            ]);
            $item->save();
            $created_at = $item->created_at instanceof DateTime ?
                $this->get(TimeZone::class)->toClient($item->created_at->format('Y-m-d H:i:s'), -420) : null;
            return [
                'status' => true,
                'data' => [
                    'id' => $item->id,
                    'content' => $item->content,
                    'created_at' => $created_at,
                ],
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
        $range = [$this->get(TimeZone::class)->toServer("$date 00:00:00", -420), $this->get(TimeZone::class)->toServer("$date 23:59:59", -420)];
        $items = $this->get(DailyFlowService::class)->orderBy('id', 'desc')->whereBetween('created_at', $range)->get();
        return [
            'status' => true,
            'data' => $items->map(function ($item) {
                $created_at = $item->created_at instanceof DateTime ?
                    $this->get(TimeZone::class)->toClient($item->created_at->format('Y-m-d H:i:s'), -420) : null;
                return [
                    'id' => $item->id,
                    'content' => $item->content,
                    'created_at' => $created_at,
                ];
            })->all(),
        ];
    }
}
