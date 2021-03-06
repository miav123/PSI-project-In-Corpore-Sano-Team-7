<?php

/*
 *  Mia Vucinic 0224/2019
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RegistrovaniKorisnikModel;
use App\Models\KorisnikModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

/**
 * Usercontroller - controller class that manages users for admin.
 * @version 1.0
 * @author Mia Vucinic
 */
class Usercontroller extends BaseController
{
    /**
     * Function that lists all users.
     * @return void
     */
    public function allusers() {

        $data = [];

        $modelUser = new KorisnikModel();
        $modelRegUser = new RegistrovaniKorisnikModel();
        $usersDB = $modelRegUser->findAll();

        $users = array();

        foreach ($usersDB as $regUser) {

            $user = $modelUser->where('id_kor', $regUser['id_kor'])->findAll()[0];

            if($user && !$user['izbrisan']) {
                $users[] = [
                    'id' => $regUser['id_kor'],
                    'username' => $user['kor_ime'],
                    'points' => $regUser['bodovi'],
                    'imageURL' => $regUser['url_profilne_slike']
                ];
            }
        }

        $data['users'] = $users;

        echo view('templates/header-admin/header.php');
        echo view('admin/users.php', $data);
        echo view('templates/footer/footer.php');

    }

    /**
     * Function that deletes user with given id.
     * @param $id
     * @return void
     * @throws ReflectionException
     */
    public function deleteuser($id)
    {
        if(array_key_exists('deletebtn', $_POST)) {
            $modelUser = new KorisnikModel();
            $user = $modelUser->find($id);
            if($user) {
                $user['izbrisan'] = 1;
                $modelUser->save($user);
            }
        }
    }

}
