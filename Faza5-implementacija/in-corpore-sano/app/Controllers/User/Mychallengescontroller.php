<?php

/* Tijana Mitrovic 2019/0001 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\IzazovModel;
use App\Models\MojiIzazoviModel;
use App\Models\KorisnikModel;

/**
 * MyChallengesController - controller class that manages my challenges for registered user.
 * @version 1.0
 * @author Tijana Mitrovic
 */

class MyChallengesController extends BaseController
{
    /**
     * Function that lists all challenges for registered user.
     * @return void
     */

    public function mychallenges() {
        $data = [];

        $modelChallenge = new IzazovModel();

        $modelMyChallenge = new MojiIzazoviModel();
        $mychallengesDB = $modelMyChallenge->where('id_kor', session('id'))->findAll();

        $modelUser = new KorisnikModel();

        $mychallenges = array();

        foreach ($mychallengesDB as $mychallenge) {
            if(!$mychallenge['propusteno']){
                $challenge = $modelChallenge->where('id_izazov', $mychallenge['id_izazov'])->findAll()[0];
                $user = $modelUser->where('id_kor', $challenge['id_tren'])->findAll()[0];
            
                $mychallenges[] = [
                    'i' => $mychallenge['id_veze'],
                    'id' => $challenge['id_izazov'],
                    'type' => $challenge['tip_izazova'],
                    'title' => $challenge['naziv'],
                    'trainer' => $user['kor_ime'],
                    'description' => $challenge['opis'],
                    'points' => $challenge['br_poena'],
                    'level' => $challenge['nivo'],
                    'completedDays' => $mychallenge['dana_uzastopno_ispunjeno'],
                    'missedDays' => $mychallenge['propusteno'],
                    'percent' => round(($mychallenge['dana_uzastopno_ispunjeno']*100)/$challenge['trajanje_u_danima'], 2)
                ];
            }      
        }

        $data['mychallenges'] = $mychallenges;

        echo view('templates/header-user/header-nicepage.php');
        echo view('user/my-challenges.php', $data);
        echo view('templates/footer/footer-nicepage.php');
    }

    /**
     * Function that leaves challenge with given id.
     * @param $i
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */

    public function leavechallenge($i)
    {
        if(array_key_exists('leavebtn', $_POST)) {
            $model = new MojiIzazoviModel();
            $model->delete(['id_veze'=>$i]);
        }
        return redirect()->to('user/my-challenges');
    }
}