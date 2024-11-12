<?php

declare(strict_types=1);

namespace TeBo\Command;

use Cake\Console\ConsoleIo;

trait FormatPrintTrait
{
    /**
     * @param array $data
     * @param ConsoleIo $io
     * @return void
     */
    public function formatPrint(array $data, ConsoleIo $io)
    {
        if ($data['ok'] === false) {
            $io->error($data['description']);
            return;
        }

        $io->success('Success');
        if (is_array($data['result'])) {
            foreach ($data['result'] as $key => $value) {
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }
                $io->out($key . ': ' . $value);
            }
        } elseif (isset($data['description'])) {
            $io->out($data['description']);
        }
    }
}
