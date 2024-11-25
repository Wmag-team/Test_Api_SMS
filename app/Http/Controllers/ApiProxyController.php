<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * Class ApiProxyController
 * Контроллер для проксирования запросов к внешнему API.
 *
 * @package App\Http\Controllers
 */
class ApiProxyController extends Controller
{
    /**
     * Базовый URL внешнего API.
     *
     * @var string
     */
    private string $baseUrl = 'https://postback-sms.com/api/';

    /**
     * Выполнение запроса к внешнему API.
     *
     * @param string $action Действие, выполняемое API.
     * @param array $params Параметры запроса.
     * @return array Ответ API в формате массива.
     */
    private function makeRequest(string $action, array $params = []): array
    {
        $client = new Client();
        $params['token'] = $params['token'] ?? env('TEST_API_TOKEN');
        $response = $client->get($this->baseUrl, [
            'query' => array_merge(['action' => $action], $params),
        ]);

        return json_decode($response->getBody(), true);
    }


    /**
     * Получить номер для активации.
     *
     * @param Request $request HTTP-запрос.
     * @return \Illuminate\Http\JsonResponse JSON-ответ.
     */
    public function getNumber(Request $request)
    {
        $params = $request->only(['country', 'service', 'rent_time', 'token']);
        return response()->json($this->makeRequest('getNumber', $params));
    }

    /**
     * Получить SMS по ID активации.
     *
     * @param Request $request HTTP-запрос.
     * @return \Illuminate\Http\JsonResponse JSON-ответ.
     */
    public function getSms(Request $request)
    {
        $params = $request->only(['activation', 'token']);
        return response()->json($this->makeRequest('getSms', $params));
    }

    /**
     * Отменить активацию номера.
     *
     * @param Request $request HTTP-запрос.
     * @return \Illuminate\Http\JsonResponse JSON-ответ.
     */
    public function cancelNumber(Request $request)
    {
        $params = $request->only(['activation', 'token']);
        return response()->json($this->makeRequest('cancelNumber', $params));
    }

    /**
     * Получить статус активации.
     *
     * @param Request $request HTTP-запрос.
     * @return \Illuminate\Http\JsonResponse JSON-ответ.
     */
    public function getStatus(Request $request)
    {
        $params = $request->only(['activation', 'token']);
        return response()->json($this->makeRequest('getStatus', $params));
    }
}
