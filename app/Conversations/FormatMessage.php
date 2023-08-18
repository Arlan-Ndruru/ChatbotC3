<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class FormatMessage extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('apakah anda ingin mengajukan permasalahan anda?')
		->addButtons([
			Button::create('Iya')->value('yes'),
			Button::create('Tidak')->value('no'),
		]);

	$this->ask($question, function (Answer $answer) {
		if ($answer->getValue() === 'yes') {
		    $this->say('Silahkan ajukan permasalahan dengan format dibawah ini!.<br>
            <br>Nama :
            <br>NIM :
            <br>Jurusan :
            <br>Fakultas :
            <br>Permasalahan : ');
		}else{
		$this->say('😒');
		$this->say('Terima kasih, jika anda berubah pikiran, silahkan ketik -> /format_pesan ');
        }
	});
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
