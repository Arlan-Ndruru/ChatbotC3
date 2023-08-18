<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class resetPresensia extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Apakah anda ingin mengajukan Reset Presensia Pegawai?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Iya')->value('yes'),
                Button::create('Batalkan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes')
                {
                    $this->say('Anda memilih : <b>Mulai pengajuan reset presensia pegawai</b>',['parse_mode' => 'HTML']);
                    $this->askName();
                }
                else
                {
                    $this->Cancel();
                }
            }
        });
    }

    protected $Name;
    protected $NIM;
    protected $Email;
    protected $Permasalahan;

    public function askName()
    {
        $this->ask('Nama Lengkap Anda?', function(Answer $answer) {
            $this->Name = $answer->getText();
            $this->askNIM();
        });
    }

    public function askNIM()
    {
        $this->ask('NIK/NIP Anda?', function(Answer $answer) {
            $this->NIM = $answer->getText();
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Email Anda?', function(Answer $answer) {
            $this->Email = $answer->getText();
            $this->say('Nama : '.$this->Name.'
NIK/NIP : '.$this->NIM.'
Email : '.$this->Email.'
Permasalahan : Permintaan Untuk Mereset Presensia');
            $this->say('Akan Diproses Secepatnya, Berdasarkan Data Tersebut');
            $this->closing();
        });
    }

    public function closing()
    {
        $question = Question::create("Apakah Permasalahan Teratasi?")
            ->fallback('unable to ask question')
            ->callbackId('ask_reason2')
            ->addButtons([
                Button::create('Iya, Terima Kasih')->value('yes'),
                Button::create('Masih Menunggu Balasan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer){
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->say('Senang Dapat Membantu, see you');
                } else {
                    $this->say('Akan dibalas secepatnya');
                }
            }
        });
    }

    public function Cancel()
    {

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Reset_Presensia <i>- untuk mengajukan Permasalahan Reset Presensia Pegawai</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
