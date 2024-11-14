<?php
declare(strict_types=1);

namespace TeBo\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use TeBo\Telegram\Api as TelegramApi;

/**
 * TeboWebhook command.
 */
class TeboWebhookCommand extends Command
{
    use FormatPrintTrait;

    /**
     * @inheritDoc
     */
    public static function defaultName(): string
    {
        return 'tebo webhook';
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
            'set' => [
                'short' => 's',
                'help' => 'Specify a url and receive incoming updates via an outgoing webhook',
                'boolean' => true,
            ],
            'delete' => [
                'short' => 'd',
                'help' => 'Remove webhook integration on telegram',
                'boolean' => true,
            ],
            'info' => [
                'short' => 'i',
                'help' => 'Get current webhook status',
                'boolean' => true,
            ],
            'bot-info' => [
                'short' => 't',
                'help' => 'Get bot info',
                'boolean' => true,
            ],
            'url' => [
                'short' => 'u',
                'help' => 'Define a manual URL with option --set'
            ]
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
        if ($args->getOption('set')) {
            $url = $args->getOption('url');
            if (empty($url)) {
                $url = TelegramApi::getWebhookUrl();
            }
            $this->formatPrint(TelegramApi::setWebhook(['url' => $url]), $io);
        
        } elseif ($args->getOption('delete')) {
            $this->formatPrint(TelegramApi::deleteWebhook(), $io);
        
        } elseif ($args->getOption('info')) {
            $this->formatPrint(TelegramApi::getWebhookInfo(), $io);

        } elseif ($args->getOption('bot-info')) {
            $this->formatPrint(TelegramApi::getMe(), $io);
        
        } else {
            $io->out($this->getOptionParser()->help());
        }

        return static::CODE_SUCCESS;
    }
}
