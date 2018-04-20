<?php
require 'vendor/autoload.php';
use PhpSlackBot\Bot;
use PhpSlackBot\Command\PokerPlanningCommand;
use RainyBot\Command\TimestampCommand;

$config_file = __DIR__ . '/config.php';

if (!file_exists($config_file)) {
    echo "There is no config file.\nYou should use 'cp config.example.php config.php' to create it and fill in your bot token.\n";
    exit;
}
$config = require(__DIR__ . '/config.php');

$bot = new Bot();
$bot->setToken($config['token']);
$bot->loadCommand(new TimestampCommand());
$bot->loadInternalCommands(); // This loads example commands
$bot->run();

