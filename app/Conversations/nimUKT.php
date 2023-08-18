<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class nimUKT extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Apakah anda ingin mengajukan Permasalahan NIM saat ingin membayar UKT?")
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
            $this->askJurusan();
        });
    }

    public function askJurusan()
    {
        $this->ask('Jurusan Anda?', function(Answer $answer) {
            $this->Jurusan = $answer->getText();
            $this->askFakultas();
        });
    }

    public function askFakultas()
    {
        $this->ask('Fakultas Anda?', function(Answer $answer) {
            $this->Fakultas = $answer->getText();
            $this->askDelete();
        });
    }

    public function askDelete()
    {
        $this->ask('Ajukan Permasalahan?', function(Answer $answer) {
            $this->Permasalahan = $answer->getText();
            $this->askKTM();
        });
    }

    public function askKTM()
    {
        $this->ask('Lampirkan Foto KTM anda?', function(Answer $answer) {
        $this->say('Nama : '.$this->Name.'
NIM : '.$this->NIM.'
Jurusan : '.$this->Jurusan.'
Fakultas : '.$this->Fakultas.'
Permasalahan : '.$this->Permasalahan);
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

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /NIM_NF_UKT <i>- untuk mengajukan Permasalahan NIM saat membayar UKT</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
