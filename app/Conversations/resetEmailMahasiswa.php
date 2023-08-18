<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class resetEmailMahasiswa extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("Apakah anda dapat mengakses Email UIN anda?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Iya')->value('yes'),
                Button::create('Tidak')->value('netral'),
                Button::create('Batalkan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes')
                {
                    $this->say('Anda memilih :<b> Anda dapat mengakses Email anda</b>', ['parse_mode' => 'HTML']);
                    $this->say('Langkah Pertama, <i> Untuk mereset password Email. Kunjungi <a>https://accounts.google.com/v3/signin/identifier?dsh=S1242004984%3A1687250913724446&authuser=0&continue=https%3A%2F%2Fmyaccount.google.com%2F&ec=GAlAwAE&hl=in&service=accountsettings&flowName=GlifWebSignIn&flowEntry=AddSession</a></i>', ['parse_mode' => 'HTML']);

                    $this->say('Kedua, <b> Masukkan email </b>anda dan <b>klik selanjutnya</b>, Seperti gambar dibawah ini!', ['parse_mode' => 'HTML']);

                    $attachment = new Image('https://live.staticflickr.com/65535/52988191681_bbe7bf94de_h.jpg');
                    $message = OutgoingMessage::create('Gambar memasukkan email')
                    ->withAttachment($attachment);
                    $this->say($message);

                    $this->Solution();

                }
                elseif ($answer->getValue() === 'netral') {
                    $this->say('Silahkan Ajukan Permasalahan Karena Anda <pre> ingin mereset password Email UIN tetapi tidak dapat mengakses Email</pre>', ['parse_mode' => 'HTML']);
                    $this->askName();
                }
                else
                {
                    $this->Cancel();
                }
            }
        });
    }

    public function Solution()
    {
        $question = Question::create('Sudah dilakukan?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Ketiga, <b>Klik Lupa Sandi?</b>. Seperti Gambar dibawah ini!', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988649573_3478f183a1_b.jpg');
                    $message = OutgoingMessage::create('Klik lupa sandi')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->say('Keempat, Kemudian pilih kirim kode Verifikasi di Email. Seperti Gambar dibawah ini.', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988331894_57c8da94fa_h.jpg');
                    $message = OutgoingMessage::create('Dalam Kotak Hijau')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->Solution2();
            }
            else{
                $this->Cancel();
            }
        });
    }

    public function Solution2()
    {
        $question = Question::create('Sudah dilakukan?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Kelima, Masukkan Kode yang didapatkan dari Email anda. Seperti Gambar dibawah ini!', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988649553_1c21be553a_h.jpg');
                    $message = OutgoingMessage::create('Klik Berikutnya')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->say('Keenam, Anda dapat men-klik <b> Perbarui sandi </b> untuk mereset password. Seperti Gambar dibawah ini!.', ['parse_mode' => 'HTML']);

                $attachment = new Image('https://live.staticflickr.com/65535/52988649543_c0f86e0506_h.jpg');
                    $message = OutgoingMessage::create('Dalam Kotak Hijau')
                    ->withAttachment($attachment);
                $this->say($message);

                $this->askReason2();
            }
            else{
                $this->Cancel();
            }
        });
    }

    public function askReason2()
    {
        $question = Question::create('Sudah dilakukan?')
		->addButtons([
			Button::create('Sudah')->value('yes'),
			Button::create('Tidak bisa')->value('netral'),
			Button::create('Batalkan')->value('no'),
		]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->say('Anda memilih :<b> Anda sudah melakukan langkah sebelumnya</b>', ['parse_mode' => 'HTML']);
                $this->say('Terakhir, Masukkan Password Yang baru dan klik <b> Simpan Sandi</b>. Seperti Gambar dibawah ini!', ['parse_mode' => 'HTML']);
                $attachment = new Image('https://live.staticflickr.com/65535/52988561250_5beb4f2525_h.jpg');
                $message = OutgoingMessage::create('Dalam Kotak Hijau')
                    ->withAttachment($attachment);
                $this->say($message);
                $this->Closing();
            }
            elseif ($answer->getValue() === 'netral') {
                $this->say('Anda memilih :<b> Terdapat Langkah yang Tidak bisa dilakukan</b>', ['parse_mode' => 'HTML']);
                $this->say('Silahkan Ajukan Permasalahan', ['parse_mode' => 'HTML']);
                $this->askName();
            }
            else{
                $this->say('Terima kasih, proses dibatalkan', ['parse_mode'=>'HTML']);
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
                Button::create('Tidak')->value('netral'),
                Button::create('Masih Menunggu Balasan')->value('no'),
            ]);

        return $this->ask($question, function (Answer $answer){
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'yes') {
                    $this->say('Permasalahan Teratasi. Senang Dapat Membantu :)');
                }
                elseif ($answer->getValue() === 'netral') {
                    $this->say('Silahkan Mengajukan Permasalahan');
                    $this->askName();
                }
                else {
                    $this->say('Akan dibalas secepatnya');
                    $this->say('Atau Silahkan Datang ke Bagian C3 PTIPD UIN SUSKA RIAU dengan membawa KTM Asli');
                }
            }
        });
    }

    public function Cancel()
    {

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Reset_Mahasiswa_Email <i>- untuk mengajukan Permasalahan Reset Password Gmail Mahasiswa</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
