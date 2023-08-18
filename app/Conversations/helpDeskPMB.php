<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class helpDeskPMB extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Apa Permasalahan Anda Terkait Penerimaan Mahasiswa Baru?')
		->addButtons([
			Button::create('Permasalahan Pembayaran Registrasi')->value('1'),
			Button::create('Permasalahan Merubah Jurusan')->value('2'),
			Button::create('Permasalahan Lainnya terkait PMB')->value('3'),
			Button::create('Batalkan')->value('0'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '1')
            {
                $this->say('Silahkan Mengajukan Permasalahan Pembayaran Registrasi',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='2')
            {
                $this->say('Silahkan Mengajukan Permasalahan Merubah Jurusan',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='3')
            {
                $this->say('Silahkan Mengajukan Permasalahan Lainnya terkait PMB',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            else
            {
                $this->Cancel();
            }
        });
    }

    public function askProblem1()
    {
        $question = Question::create('Mulai Pengajuan?')
		->addButtons([
			Button::create('Mulai')->value('1'),
			Button::create('Kembali')->value('2'),
			Button::create('Batalkan')->value('0'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '1')
            {
                $this->say('<i>Perhatikan petunjuk</i> !',['parse_mode' => 'HTML']);
                $this->sendMessage();
            }
            elseif ($answer->getValue() === '2') {
                $this->askReason();
            }
            else
            {
                $this->Cancel();
            }
        });
    }

    protected $Name;
    protected $NIM;
    protected $Jurusan;
    protected $Fakultas;
    protected $Permasalahan;

    public function sendMessage()
    {
        $this->say('Silahkan jawab pertanyaan berikut! Balas - (tanda hubung) untuk melewati atau mengosongkan pertanyaan');
        $this->ask('Nama Lengkap Anda?', function(Answer $answer) {
            $this->Name = $answer->getText();
            $this->askNIM();
        });
    }

    public function askNIM()
    {
        $this->ask('NIM/NIP/NIK Anda?', function(Answer $answer) {
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
            $this->askProblem();
        });
    }
    public function askProblem()
    {
        $this->ask('Permasalahan yang ingin diajukan?', function(Answer $answer) {
            $this->Permasalahan = $answer->getText();
            $this->say('Nama : '.$this->Name.'
NIM/NIK/NIP : '.$this->NIM.'
Jurusan : '.$this->Jurusan.'
Fakultas : '.$this->Fakultas.'
Permasalahan : '.$this->Permasalahan);
            $this->say('Akan Diproses Secepatnya, Berdasarkan Data Tersebut');
            $this->closing();
        });
    }

    public function Closing()
    {
        $question = Question::create('Permasalahan Berhasil Diajukan?')
		->addButtons([
			Button::create('Terima Kasih')->value('1'),
			Button::create('Menu Pilihan')->value('2'),
			Button::create('Batalkan')->value('0')
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '1')
            {
                $this->say('<i>Terima Kasih Kembali</i>!',['parse_mode' => 'HTML']);
            }
            elseif ($answer->getValue() === '2') {
                $this->askReason();
            }
            else
            {
                $this->Cancel();
            }
        });
    }

    public function Cancel()
    {
        $this->say('Terima kasih, Proses Dibatalkan.  <i>Jika anda berubah pikiran, silahkan ketik</i> <b> //Helpdesk_PenerimaanMABA </b> - <i> untuk melihat Pengajuan Permasalahan Penerimaan Mahasiswa Baru</i>', ['parse_mode'=>'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
