<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class FormatMessages extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create('Komfirmasi untuk Mengajukan Permasalahan sesuai Format Pesan?')
		->addButtons([
			Button::create('Ya')->value('yes'),
			Button::create('Cuma Lihat')->value('netral'),
			Button::create('Batalkan')->value('no'),
		]);

        $this->ask($question, function (Answer $answer) {
            if($answer->getValue() === 'yes'){
                $this->sendMessage();
            }
            elseif ($answer->getValue() === 'netral') {
                $this->say('<b>Terima Kasih</b>, <i>Silahkan ajukan permasalahan dengan format dibawah ini!</i>.<pre>
Nama :
NIM/NIK/NIP :
Jurusan :
Fakultas :
Permasalahan : </pre>
<i>*Untuk mengosongkan jawaban balas dengan : - (Tanda hubung)</i>',['parse_mode' => 'HTML']);
                $this->askReason();
            }
            else{
                $this->Cancel();
            }
	});
    }

//     protected $sendProblem;

//     public function sendProblem()
//     {
//         $this->ask('Silahkan Ajukan Permasalahan sesuai Format Pesan', function(Answer $answer) {
//             $this->sendProblem = $answer->getText();
//             $this->say($this->sendProblem.'
// Akan Diproses berdasarkan data yang diberikan. Terima Kasih');
//             $this->closing();
//         });
//     }

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
                    $this->say('Terima Kasih Kembali, Senang Dapat Membantu :)');
                } else {
                    $this->say('Akan dibalas secepatnya');
                    $this->say('Atau Silahkan Mendatangi C3 PTIPD UIN SUSKA RIAU');
                }
            }
        });
    }

    public function Cancel()
    {

        $this->say('<b>Proses Dibatalkan</b>. <pre>Jika berubah pikiran, Ketik </pre> /Format_Pesan <i>- untuk mengajukan Permasalahan Menggunakan Format Pesan</i>', ['parse_mode' => 'HTML']);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
