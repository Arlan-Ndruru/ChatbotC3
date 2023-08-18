<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class helpDeskIraise extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Apa Permasalahan Anda Terkait Iraise?')
		->addButtons([
			Button::create('Permasalahan Data di Iraise')->value('1'),
			Button::create('Permasalahan Status Bayar')->value('2'),
			Button::create('Permasalahan Nilai')->value('3'),
			Button::create('Permasalahan Wisuda')->value('4'),
			Button::create('Permasalahan Lainnya terkait Iraise')->value('5'),
			Button::create('Batalkan')->value('0'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '1')
            {
                $this->say('Silahkan Mengajukan Permasalahan Data di Iraise',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='2')
            {
                $this->say('Silahkan Mengajukan Permasalahan Status Bayar di Iraise',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='3')
            {
                $this->say('Silahkan Mengajukan Permasalahan Nilai di Iraise',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='4')
            {
                $this->say('Silahkan Mengajukan Permasalahan terkait Wisuda di Iraise',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='5')
            {
                $this->say('Silahkan Mengajukan Permasalahan lainnya di Iraise',['parse_mode' => 'HTML']);
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
                $this->say('Anda memilih <b>Mulai Pengajuan</b>',['parse_mode' => 'HTML']);
                $this->say('<i>Silahkan Ikuti Langkah Berikut</i>!',['parse_mode' => 'HTML']);
                $this->askName();
            }
            elseif ($answer->getValue() === '2') {
                $this->say('Anda memilih <b>Kembali ke Menu</b>',['parse_mode' => 'HTML']);
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

    public function askName()
    {
        $this->ask('Nama Lengkap?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->Name = $value;
            $this->askNIM();
        });
    }

    public function askNIM()
    {
        $this->ask('NIM anda?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->NIM = $value;
            $this->askJurusan();
        });
    }

    public function askJurusan()
    {
        $this->ask('Jurusan anda?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->Jurusan = $value;
            $this->askFakultas();
        });
    }

    public function askFakultas()
    {
        $this->ask('Fakultas anda?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->Fakultas = $value;
            $this->askProblem();
        });
    }

    public function askProblem()
    {
        $this->ask('Permasalahan yang dihadapi?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->Permasalahan = $value;
            $this->askKTM();
        });
    }

    public function askKTM()
    {
        $this->ask('Uploud KTM anda?', function (Answer $answer)
        {
            $value = $answer->getText();
            if (trim($value) === '') {
                return $this->repeat('Tolong Isi dengan benar');
            }
            $this->say('Nama : '.$this->Name.'
NIM : '.$this->NIM.'
Jurusan : '.$this->Jurusan.'
Fakultas : '.$this->Fakultas.'
Permasalahan : '.$this->Permasalahan);
        $this->say('Terima Kasih, Akan Diproses Secepatnya berdasarkan Data Tersebut.');
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
                $this->say('Anda memilih <b>Kembali ke Menu</b>',['parse_mode' => 'HTML']);
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
        $this->say('Terima kasih, Proses Dibatalkan.  <i>Jika anda berubah pikiran, silahkan ketik</i> <b> /Helpdesk_Permasalahan_Iraise </b> - <i> untuk melihat Pengajuan Permasalahan terkait Iraise</i>', ['parse_mode'=>'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
