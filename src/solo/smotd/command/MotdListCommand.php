<?php

namespace solo\smotd\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use solo\smotd\SMotd;

class MotdListCommand extends Command{

  private $owner;

  public function __construct(SMotd $owner){
    parent::__construct("motdlist", "show all server motd", "/motdlist");
    $this->setPermission("smotd.command.list");

    $this->owner = $owner;
  }

  public function execute(CommandSender $sender, string $label, array $args) : bool{
    if(!$sender->hasPermission($this->getPermission())){
      $sender->sendMessage(SMotd::$prefix . "이 명령을 실행할 권한이 없습니다.");
      return true;
    }
    $motds = $this->owner->getAllMotd();
    $sender->sendMessage("==========[ Motd 목록 (" . count($motds) . ") ]==========");
    foreach($motds as $i => $motd){
      $sender->sendMessage("§7[" . $i . "] §f" . $motd);
    }
    return true;
  }
}
