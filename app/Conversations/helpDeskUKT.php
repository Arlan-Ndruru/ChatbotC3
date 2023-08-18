<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class helpDeskUKT extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Apa Permasalahan Anda Terkait Keringan UKT?')
		->addButtons([
			Button::create('Permasalahan Status Pembayaran')->value('1'),
			Button::create('Permasalahan Jumlah UKT Belum Berubah')->value('2'),
			Button::create('Permasalahan Lainnya terkait Keringanan UKT')->value('3'),
			Button::create('Batalkan')->value('0'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === '1')
            {
                $this->say('Silahkan Mengajukan Permasalahan Status Pembayaran',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='2')
            {
                $this->say('Silahkan Mengajukan Permasalahan Jumlah UKT Belum Berubah',['parse_mode' => 'HTML']);
                $this->askProblem1();
            }
            elseif ($answer->getValue()=='3')
            {
                $this->say('Silahkan Mengajukan Permasalahan Lainnya terkait Keringanan UKT',['parse_mode' => 'HTML']);
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
                $this->say('<i>Silahkan Ikuti Langkah Berikut</i>!',['parse_mode' => 'HTML']);
                $this->askName();
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
        $this->say('Terima kasih, Proses Dibatalkan.  <i>Jika anda berubah pikiran, silahkan ketik</i> <b> //Helpdesk_Keringanan_UKT </b> - <i> untuk melihat Pengajuan Permasalahan terkait Keringanan UKT</i>', ['parse_mode'=>'HTML']);
    }

    // public function askReason1()
        // {
        //     $question = Question::create('Apakah Permasalahan Sudah terjawab?')
        //     ->addButtons([
        //         Button::create('Teratasi')->value('yes'),
        //         Button::create('Belum')->value('no'),
        //     ]);

        //     $this->ask($question, function(Answer $answer) {
        //         if ($answer->getValue() === 'yes') {
        //             $this->say('Terima Kasih, Senang bisa membantu. Wassalamualaikum.');
        //         } else {
        //             $this->say('Maaf, Untuk saat ini, Mengatasinya dengan mengajukan permohonan terlambat pengisian KRS, lalu silahkan mendatangi langsung Kantor Bagian Akademik Universitas, dengan membawa surat yang di tanda tangani oleh Dekan atau Wakil Dekan fakultas. Terima Kasih',['parse_mode' => 'HTML']);
        //         }

        //     });
    // }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
