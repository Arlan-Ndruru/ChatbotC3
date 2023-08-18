<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class ResetIraise extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Pastikan Hal ini? Mengingat username dan bisa mengakses Email')
		->addButtons([
			Button::create('Ya, saya Ingat')->value('yes'),
			Button::create('Tidak')->value('no'),
			Button::create('Batalkan')->value('cancel'),
		]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda dapat mengakses Email anda</b>', ['parse_mode' => 'HTML']);
                $this->say('Langkah Pertama, Untuk mereset password. Kunjungi <a>https://iraisenew.uin-suska.ac.id/beranda/reset_password</a> Akan masuk ke halaman seperti gambar dibawah ini', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52989029040_daceaef938_h.jpg');
                    $message = OutgoingMessage::create('Tampilan Reset Password Iraise')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->askReason1();

            }
            elseif ($answer->getValue() === 'no') {
                $this->say('Terima kasih, Silahkan Kunjungi PTIPD dengan membawa KTM sebagai berkas Vallidasi', ['parse_mode'=>'HTML']);
            }
            else{
                $this->Cancel();
            }
        });
    }

    // public function askReason1()
        // {
        //     $question = Question::create('Sudah kunjungi?')
        // 	->addButtons([
        // 		Button::create('Sudah')->value('yes'),
        // 		Button::create('Batalkan')->value('no'),
        // 	]);
        //     $this->ask($question, function (Answer $answer) {
        //         if ($answer->getValue() === 'yes') {
        //             $this->say('Lanjut, klik Lupa password. yang ada pada halaman atau ikuti link berikut <a>https://iraisenew.uin-suska.ac.id/beranda/reset_password</a>', ['parse_mode' => 'HTML']);
        //             //? say with IMG
        //             // $attachment = new Image('URL');
        //             // $message = OutgoingMessage::create('Ini logonya')
        //             // ->withAttachment($attachment);
        //             // $this->say($message);
        //             $this->askReason2();
        //         }
        //         else{
        //             $this->say('Terima kasih, proses dibatalkan', ['parse_mode'=>'HTML']);
        //         }
        //     });
    // }
    public function askReason1()
    {
        $question = Question::create('Sudah?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Kedua, Silahkan masukkan username dan input jawaban.Kemudian klik Send Reset Link to Email yang ada pada halaman. Perhatikan Gambar berikut!', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988061422_3d3155a3a4_h.jpg');
                    $message = OutgoingMessage::create('Tampilan Reset Password Iraise')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->askReason2();
            }
            else{
                $this->say('Terima kasih, proses dibatalkan', ['parse_mode'=>'HTML']);
            }
        });
    }
    public function askReason2()
    {
        $question = Question::create('Sudah?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Ketiga, Akan Muncul Pop Up yang menyatakan link untuk reset akan dikirim melalui Email UIN. Seperti Gambar berikut!', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988800014_47002b473d_c.jpg');
                    $message = OutgoingMessage::create('Tampilan Pop Up  Berhasil!')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->say('Terakhir, Buka Email UIN Suska Riau Anda. Lakukan Peresetan Password menggunakan link yang diberikan', ['parse_mode' => 'HTML']);
                $this->askReason3();;
            }
            else{
                $this->say('Terima kasih, proses dibatalkan', ['parse_mode'=>'HTML']);
            }
        });
    }
    public function askReason3()
    {
        $question = Question::create('Demikian proses reset password Akun Iraise!')
		->addButtons([
			Button::create('Terima Kasih')->value('yes'),
			Button::create('Maaf, Tidak Berhasil')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Permasalahan Diselesaikan. Terima Kasih Kembali, Senang dapat membantu :)', ['parse_mode' => 'HTML']);
            }
            else{
                $this->say('Silahkan Datang ke Bagian C3 PTIPD UIN SUSKA RIAU dengan Membawa KTM Asli', ['parse_mode'=>'HTML']);
                $this->ajukanPesan();
            }
        });
    }

    public function ajukanPesan()
    {
        $question = Question::create('Atau Ajukan Permasalahan?')
		->addButtons([
			Button::create('Iya')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Untuk mengajukan permasalahan terkait reset akun Iraise</b>', ['parse_mode' => 'HTML']);
                $this->askName();
            }
            else{
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
        $this->ask('Nama Lengkap Anda?', function(Answer $answer) {
            $this->Name = $answer->getText();
            $this->askNIM();
        });
    }

    public function askNIM()
    {
        $this->ask('NIM Anda? Atau Email yang ingin direset', function(Answer $answer) {
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
        $this->say('Terima Kasih, Akan Diproses Secepatnya berdasarkan Data Tersebut.');
        $this->askReason3();
        });
    }

    public function Cancel()
    {

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Reset_Iraise <i>- untuk mengajukan Permasalahan Reset Password Iraise Mahasiswa</i>', ['parse_mode' => 'HTML']);
    }


    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
