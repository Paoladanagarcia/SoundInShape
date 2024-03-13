<?php


final class ClubController
{
    #[Route('/admin/clubs')]
    public function showOneOrManyClubs()
    {
        if (!empty($_GET['id'])) {
            $this->manager_club($_GET['id']);
            return;
        }

        require_once 'model/db-club.php';
        $clubs = get_all_clubs();

        $GLOBALS['clubs'] = $clubs;
        require_view('view/admin/clubs_view.php');
        unset($GLOBALS['clubs']);
    }

    public function manager_club($club_id)
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You must be logged in as an admin to do this');
        }

        require_once 'model/db-club.php';
        $club = get_club($club_id);

        $GLOBALS['club'] = $club;
        require_view('view/admin/club_manage.php');
        unset($GLOBALS['club']);
    }

    #[Route('/admin/clubs/add')]
    public function addClub()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You must be logged in as an admin to do this');
        }

        require_view('view/admin/club_add.php');
    }

    #[Route('/admin/clubs/add-post')]
    #[Method('POST')]
    public function postClub()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You must be logged in as an admin to do this');
        }

        require_once 'controller/functions/validateFormData.php';
        list($club_data, $errors) = validateFormData(
            [
                'name'          => htmlspecialchars($_POST['name']),
                'nb_rooms'      => htmlspecialchars($_POST['nb_rooms']),
                'opening_hour'  => htmlspecialchars($_POST['opening_hour']),
                'closing_hour'  => htmlspecialchars($_POST['closing_hour'])
            ],
            [
                'name'          => 'required|' . FORM_RULES['name'],
                'nb_rooms'      => 'required|numeric|min:1',
                'opening_hour'  => 'required|' . FORM_RULES['time'],
                'closing_hour'  => 'required|' . FORM_RULES['time']
            ]
        );

        if ($errors) {
            echo 'validation error';
            return JSONResponse('error', $errors);
        }

        require_once 'model/db-club.php';
        if (!create_club($club_data)) {
            // echo 'sql error';
            return JSONResponse('error', 'Club not created');
        } else {
            // echo 'true success';
            return JSONResponse('success', 'Club created', url('/admin/clubs'));
        }
    }

    #[Route('/post-manage-club')]
    #[Method('POST')]
    public function post_manage_club()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You must be logged in as an admin to do this');
        }

        require_once 'model/db-club.php';
        $club_id = htmlspecialchars($_POST['club_id']);
        $name = htmlspecialchars($_POST['name']);
        $nb_rooms = htmlspecialchars($_POST['nb_rooms']);
        $opening_hour = htmlspecialchars($_POST['opening_hour']);
        $closing_hour = htmlspecialchars($_POST['closing_hour']);

        if (!update_club($club_id, $name, $nb_rooms, $opening_hour, $closing_hour)) {
            return JSONResponse('error', 'No update was made');
        } else {
            return JSONResponse('success', 'Club updated', url('/admin/clubs'));
        }
    }

    #[Route('/delete-club')]
    #[Method('POST')]
    public function deleteClub()
    {
        if (!is_admin_logged()) {
            return JSONResponse('error', 'You must be logged in as an admin to do this');
        }

        require_once 'model/db-club.php';
        $club_id = (int)htmlspecialchars($_POST['club_id']);

        if (!delete_club($club_id)) {
            return JSONResponse('error', 'Club not deleted');
        } else {
            return JSONResponse('success', 'Club deleted', url('/admin/clubs'));
        }
    }
}
