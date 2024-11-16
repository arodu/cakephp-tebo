<?php
declare(strict_types=1);

namespace TeBo\Utility;

use Cake\Utility\Hash;

class CallbackData
{
    public static function parse(string $data): array
    {
        $result = [];
        parse_str($data, $result);

        return is_array($result) ? $result : [];
    }

    public static function stringify(string $action, array $options = []): string
    {
        $result = Hash::merge(compact('action'), $options);

        return http_build_query($result);
    }
}
