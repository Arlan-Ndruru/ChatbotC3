<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SalahMatkul extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Apakah Anda Tidak Dapat Menghapus Matkul Tersebut Karena Sudah Disetujui?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Iya, Sudah Disetujui')->value('yes'),
                Button::create('Tidak, Permasalahan Lain')->value('netral'),
                Button::create('Batalkan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes')
                {
                    $this->say('Silahkan Menghubungi Pembimbing Akademik (PA) yang bersangkutan untuk membantu menghapus Mata Kuliah yang Salah atau Batal untuk di Ambil');
                    $this->closing();
                }
                elseif ($answer->getValue() === 'netral') {
                    $this->askReason1();
                }
                else
                {
                    $this->Cancel();
                }
            }
        });
    }

    public function askReason1()
    {
        $question = Question::create("Apakah dikarenakan sudah lewat jadwal dari pengisian daripada Kartu Rencana Studi (KRS)?")
            ->fallback('unable to ask question')
            ->callbackId('ask_reason1')
            ->addButtons([
                Button::create('Iya')->value('yes'),
                Button::create('Tidak, Ajukan Permasalahan')->value('netral'),
                Button::create('Batalkan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer){
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes')
                {
                    $this->say('Silahkan mendatangi langsung langsung Akademik UIN SUSKA RIAU, dengan membawa surat yang ditanda tangani oleh Dekan atau Wakil Dekan Fakultas');
                    $this->closing();
                }
                elseif($answer->getValue() === 'netral'){
                    $this->askReason2();
                }
                else
                {
                    $this->Cancel();
                }
            }
        });
    }

    public function askReason2()
    {
        $question = Question::create("Ajukan Permasalahan?")
            ->fallback('unable to ask question')
            ->callbackId('ask_reason1')
            ->addButtons([
                Button::create('Iya')->value('yes'),
                Button::create('Ajukan Manual')->value('/Format_Pesan'),
            ]);

        return $this->ask($question, function (Answer $answer){
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->askName();
                } else {
                    $this->say('Silahkan mengirimkan permasalahan menggunakan Format Pesan yang disediakan. /Format_Pesan');
                }
            }
        });

    }

    protected $Name;
    protected $NIM;
    protected $Jurusan;
    protected $Fakultas;
    protected $Matkul;
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
        $this->ask('NIM Anda?', function(Answer $answer) {
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
        $this->ask('Nama Mata Kuliah Yang dihapus?', function(Answer $answer) {
            $this->Matkul = $answer->getText();
            $this->say('Nama : '.$this->Name.'
NIM : '.$this->NIM.'
Jurusan : '.$this->Jurusan.'
Fakultas : '.$this->Fakultas.'
Permasalahan : Menghapus Mata Kuliah '.$this->Matkul);
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

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Salah_Matkul <i>- untuk mengajukan Permasalahan Terkait Kesalahan Mata Kuliah</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
