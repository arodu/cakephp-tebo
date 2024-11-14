<?php

declare(strict_types=1);

namespace TeBo\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use TeBo\Telegram\Api as TelegramApi;

/**
 * Tebo command.
 */
class TeboCommand extends Command
{
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
        $options = [
            '1' => 'Get Webhook URL',
            '2' => 'Set Webhook to telegram',
            '3' => 'Delete Webhook from telegram',
            '4' => 'Get Webhook info from telegram',
            '5' => 'Get bot info',
            'h' => 'Help',
            'q' => 'Quit',
        ];

        $io->out('<info>TeBo Commands</info>');
        $io->hr();
        foreach ($options as $key => $option) {
            $io->out("[$key] $option");
        }

        do {
            $choice = strtolower($io->askChoice('What would you like to do?', array_keys($options), 'h'));
            $code = null;
            switch ($choice) {
                case '1':
                    $io->success(TelegramApi::getWebhookUrl());
                    break;

                case '2':
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--set'], $io);
                    break;

                case '3':
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--delete'], $io);
                    break;

                case '4':
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--info'], $io);
                    break;

                case '5':
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--bot-info'], $io);
                    break;

                case 'h':
                case 'H':
                    $io->out($this->getOptionParser()->help());
                    break;
                case 'q':
                case 'Q':
                    // Do nothing
                    break;
                default:
                    $io->err(
                        'You have made an invalid selection. '
                            . 'Please choose a command from the list.'
                            . PHP_EOL
                            . 'Type "h" for help or "q" to quit.'
                    );
            }
            if ($code === static::CODE_ERROR) {
                $this->abort();
            }
        } while ($choice !== 'q' && $choice !== 'Q');

        return static::CODE_SUCCESS;
    }
}
