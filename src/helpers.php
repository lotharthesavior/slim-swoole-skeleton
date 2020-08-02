<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Prepares a Psr7 Response  in JSON format
 *
 * @param Response $response
 * @param string $status
 * @param string $message
 * @param array $errors
 * @param int $statusCode
 *
 * @return Response
 */
function json_response(
    Response $response,
    string $status,
    int $statusCode,
    $message = null,
    $errors = null,
    $overrideData = null
) : Response {
    $data = [
        'status' => $status,
    ];

    if ($errors) {
        $data['errors'] = $errors;
    }

    if ($message) {
        $data['message'] = $message;
    }

    if ($overrideData) {
        $data = $overrideData;
    }

    return $response->withJson($data, $statusCode);
}

/**
 * @param Request $request
 *
 * @return array
 */
function get_query_params(Request $request) : array
{
    $data = $request->getUri()->getQuery();

    $data = array_filter(explode('&', $data));

    $rearrangedData = [];
    foreach ($data as $item) {
        $item = explode('=', $item);
        $rearrangedData[$item[0]] = $item[1];
    }

    return $rearrangedData;
}
