<?php

declare(strict_types=1);

namespace TeBo\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use TeBo\Utility\Bot;

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

        $parser->setDescription('Provides an interactive menu for Tebo webhook management.');

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
            '1' => 'Show Default Webhook URL',
            '2' => 'Set Webhook',
            '3' => 'Delete Webhook',
            '4' => 'Get Webhook Info',
            '5' => 'Get Bot Info',
            'q' => 'Quit',
        ];
        $choice = null;
        do {

            $io->out('<info>TeBo Interactive Menu</info>');
            $io->hr();
            foreach ($options as $key => $option) {
                $io->out("  <info>[$key]</info> $option");
            }
            $io->hr();

            $choice = strtolower($io->askChoice(
                'Select an option:',
                array_keys($options)
            ));

            $code = null;
            $io->out('');

            switch ($choice) {
                case '1':
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--default-url'], $io);
                    break;

                case '2':
                    $defaultUrl = Bot::getWebhookUrl();
                    $io->out('');
                    $url = $io->ask('Enter the webhook URL (press Enter to use the default)', $defaultUrl);
                    $code = $this->executeCommand(TeboWebhookCommand::class, ['--set', '--url', $url], $io);
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

                case 'q':
                    $io->success('Exiting...');
                    break;
            }

            if ($code === static::CODE_ERROR) {
                $io->error('The sub-command failed. Aborting.');
                $this->abort();
            }

            if ($choice !== 'q') {
                $io->out('');
                $io->ask('Press Enter to continue...');
            }
        } while ($choice !== 'q');

        return static::CODE_SUCCESS;
    }
}
