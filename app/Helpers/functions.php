<?php

use Illuminate\Validation\ValidationException;

function jsonPagination($status = 200, $paginate) {
    $result = array(
        'pagination' => null,
        'items'      => null
    );
    if ($paginate) {
        $pagination = $paginate->toArray();
        $result['items'] = $pagination['data'];
        unset($pagination['data']);
        unset($pagination['path']);
        unset($pagination['first_page_url']);
        unset($pagination['last_page_url']);
        unset($pagination['next_page_url']);
        unset($pagination['prev_page_url']);
        $result['pagination'] = $pagination;
    }
    return response($result);
}

function jsonSuccess($status = 200, $data) {
    $result = [
        'status' => 'success',
    ];

    if (isset($data)) {
        $result['data'] = $data;
    }
    return response($result, $status);
}

function jsonFailure($status = 500, $e) {
    $result = [
        'status' => 'failure',
    ];

    if (is_a($e, ValidationException::class)) {
        $result = [
            'message'   => 'Validation Failed',
            'errors'    => [],
        ];
        $errors = $e->errors();
        foreach ($errors as $field => $error) {
            foreach ($error as $key => $value) {
                array_push($result['errors'], [
                    'field'   => $field,
                    'message' => $value
                ]);
            }
        }
    } else if (is_string($e)) {
        $result['message'] = $e;
    } elseif (is_array($e)) {
        $result['errors'] = $e;
    }
    return response($result, $status);
}