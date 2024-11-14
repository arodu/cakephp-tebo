<?php

declare(strict_types=1);

namespace TeBo\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use TeBo\Telegram\Api as TelegramApi;
use TeBo\Utility\Bot;

/**
 * TeboWebhook command.
 */
class TeboCommandListCommand extends Command
{
    use FormatPrintTrait;

    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'tebo help';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        $parser->addOptions([
            'build' => [
                'short' => 'b',
                'help' => 'Build bot command list',
                'boolean' => true,
            ],
            'get' => [
                'short' => 'g',
                'help' => 'Get bot command list from Bot API',
                'boolean' => true,
            ],
            'set' => [
                'short' => 's',
                'help' => 'Set bot command list to Bot API',
                'boolean' => true,
            ],
            'delete' => [
                'short' => 'd',
                'help' => 'Delete bot command list to Bot API',
                'boolean' => true,
            ],
        ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        if ($args->getOption('get')) {
            $data = TelegramApi::getMyCommands();
            $this->printCommands($data['result'], $io);
        } elseif ($args->getOption('set')) {
            $data = TelegramApi::setMyCommands(['commands' => json_encode(Bot::getCommandDescriptionList())]);
            $this->formatPrint($data, $io);
        } elseif ($args->getOption('build')) {
            $result = Bot::getCommandDescriptionList();
            $this->printCommands($result, $io);
        } elseif ($args->getOption('delete')) {
            $this->formatPrint(TelegramApi::deleteMyCommands(), $io);
        } else {
            $io->out($this->getOptionParser()->help());
        }

        return static::CODE_SUCCESS;
    }

    protected function printCommands(array $commands, ConsoleIo $io)
    {
        foreach ($commands as $command) {
            $io->out("\t" . $command['command'] . ': ' . $command['description']);
        }
    }
}
