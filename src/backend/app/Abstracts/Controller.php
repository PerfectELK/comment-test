<?php

namespace App\Abstracts;

use App\Core\Response;

class Controller {

    private const VALIDATE_RULES_ARR = [
        'email',
        'string',
    ];

    protected function validate(
        array $data,
        array $rules
    ): ?Response
    {
        $validationErrors = [
            'errors' => []
        ];
        foreach ($rules as $key => $item) {
            foreach (self::VALIDATE_RULES_ARR as $rule) {
                if (mb_strpos($item, $rule) === 0) {
                    $from = null;
                    $to = null;
                    $fromTo = explode(':', $item);
                    if (count($fromTo) > 1) {
                        $fromTo = explode('-', $fromTo[1]);
                        $from = (int) $fromTo[0];
                        if (count($fromTo) > 1) {
                            $to = (int) $fromTo[1];
                        }
                    }

                    $isValid = $this->$rule($data[$key], $from, $to);
                    if (!$isValid) {
                        $validationErrors['errors'][$key] = "field {$key} is not valid";
                    }
                }
            }
        }

        if (count($validationErrors['errors'])) {
            return (new Response())->json($validationErrors);
        }

        return null;
    }

    private function email(
        string $value,
        ?int $from = null,
        ?int $to = null
    ): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($from !== null && mb_strlen($value) < $from) {
            return false;
        }

        if ($to !== null && mb_strlen($value) > $to) {
            return false;
        }

        return true;
    }

    private function string(
        string $value,
        ?int $from = null,
        ?int $to = null
    ): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if ($from !== null && mb_strlen($value) < $from) {
            return false;
        }

        if ($to !== null && mb_strlen($value) > $to) {
            return false;
        }

        return true;
    }

}
